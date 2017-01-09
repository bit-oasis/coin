<?php

namespace BitOasis\Coin\Mapping;

use BitOasis\Coin\Address\CryptocurrencyAddressFactory;
use BitOasis\Coin\Coin;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidCurrencyException;
use BitOasis\Coin\Exception\MetadataException;
use BitOasis\Coin\Types\CoinType;
use BitOasis\Coin\Types\CryptocurrencyAddressType;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Cache\CacheProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Events as ORMEvents;
use Doctrine\ORM\Mapping\ClassMetadata;
use Kdyby;
use Kdyby\Doctrine\Events;
use Nette\Utils\Json;


/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 *
 * @author Filip Procházka <filip@prochazka.su>
 * @license https://github.com/Kdyby/DoctrineMoney/blob/master/license.md
 */
class CoinObjectHydrationListener implements Kdyby\Events\Subscriber {

	/** @var null|string[] */
	protected $entityNamespaces = null;

	/** @var \Doctrine\Common\Cache\CacheProvider */
	protected $cache;

	/** @var CryptocurrencyAddressFactory */
	protected $cryptocurrencyAddressFactory;

	/** @var \Doctrine\ORM\EntityManager */
	protected $entityManager;

	/** @var \Doctrine\Common\Annotations\Reader */
	protected $annotationReader;

	/** @var array */
	protected $coinFieldsCache = [];

	public function __construct($entityNamespaces, CacheProvider $cache, CryptocurrencyAddressFactory $cryptocurrencyAddressFactory, Reader $annotationReader, EntityManager $entityManager) {
		$this->entityNamespaces = $entityNamespaces;
		$this->cache = $cache;
		$this->cache->setNamespace(get_called_class());
		$this->cryptocurrencyAddressFactory = $cryptocurrencyAddressFactory;
		$this->entityManager = $entityManager;
		$this->annotationReader = $annotationReader;
	}

	public function getSubscribedEvents() {
		return array(
			Events::loadClassMetadata => 'loadClassMetadata',
		);
	}

	public function postLoad($entity, LifecycleEventArgs $args) {
		if (!$fieldsMap = $this->getEntityCoinFields($entity)) {
			return;
		}
		/** @var mixed $currencyMeta */
		/** @var ClassMetadata $coinClass */
		foreach ($fieldsMap as $currencyAssoc => $currencyMeta) {
			foreach ($currencyMeta['fields'] as $coinField => $coinClass) {
				$value = $coinClass->getFieldValue($entity, $coinField);
				if ($value instanceof Coin || $value instanceof CryptocurrencyAddress || $value === NULL) {
					continue;
				}

				$currency = $currencyMeta['class']->getFieldValue($entity, $currencyAssoc);
				if (!$currency instanceof Cryptocurrency) {
					throw new \InvalidArgumentException('Invalid Cryptocurrency value for Coin class!');
				}

				if($coinClass->getFieldMapping($coinField)['type'] === CoinType::COIN) {
					$coinClass->setFieldValue($entity, $coinField, Coin::fromInt($value, $currency));
				} else {
					$coinClass->setFieldValue($entity, $coinField, $this->cryptocurrencyAddressFactory->deserialize($value, $currency));
				}
			}
		}
	}

	public function preFlush($entity, PreFlushEventArgs $args) {
		if (!$fieldsMap = $this->getEntityCoinFields($entity)) {
			return;
		}
		/** @var mixed $currencyMeta */
		foreach ($fieldsMap as $currencyAssoc => $currencyMeta) {
			$fieldCurrencies = [];
			$currency = $currencyMeta['class']->getFieldValue($entity, $currencyAssoc);
			/** @var string $coinField */
			/** @var ClassMetadata $coinClass */
			foreach ($currencyMeta['fields'] as $coinField => $coinClass) {
				$amount = $coinClass->getFieldValue($entity, $coinField);
				if ($amount === NULL) {
					continue;
				}

				if (!$amount instanceof Coin && !$amount instanceof CryptocurrencyAddress) {
					throw new InvalidCurrencyException('Coin field has invalid value!'); // todo: change exception
				}

				if ($currency instanceof Cryptocurrency && $amount->getCurrency()->getCode() !== $currency->getCode()) {
					if (count($currencyMeta['fields']) === 1) {
						$currencyMeta['class']->setFieldValue($entity, $currencyAssoc, $amount->getCurrency());

						continue 2;
					}
				}

				$fieldCurrencies[$amount->getCurrency()->getCode()][] = $coinField;
			}

			if (count($fieldCurrencies) > 1) {
				$conflicts = array();
				foreach ($fieldCurrencies as $code => $fields) {
					if ($currency instanceof Cryptocurrency && $code === $currency->getCode()) {
						continue;
					}

					$conflicts[] = "[" . implode(', ', $fields) . "] have currency $code";
				}

				throw new InvalidCurrencyException(
					'The following fields ' . implode(' and fields ', $conflicts) . ', ' .
					"but the relation $currencyAssoc of given entity expects them to have currency $currency."
				);
			}
		}
	}

	public function loadClassMetadata(LoadClassMetadataEventArgs $args) {
		$class = $args->getClassMetadata();
		if (!$class instanceof ClassMetadata || $class->isMappedSuperclass || !$class->getReflectionClass()->isInstantiable()) {
			return;
		}

		if(!$this->shouldBeEntityMetadataChecked($class->getName())) {
			return;
		}

		$currencyMetadata = $class->getName() === Cryptocurrency::class ? $class : $this->entityManager->getClassMetadata(Cryptocurrency::class);
		$idColumn = $currencyMetadata->getSingleIdentifierColumnName();

		foreach ($class->getAssociationNames() as $assocName) {
			if ($class->getAssociationTargetClass($assocName) !== Cryptocurrency::class) {
				continue;
			}

			$mapping = $class->getAssociationMapping($assocName);
			foreach ($mapping['joinColumns'] as &$join) {
				$join['referencedColumnName'] = $idColumn;
			}

			$class->setAssociationOverride($assocName, $mapping);
		}

		if (!$this->buildCoinFields($class)) {
			return;
		}

		if (!self::hasRegisteredListener($class, ORMEvents::postLoad, get_called_class())) {
			$class->addEntityListener(ORMEvents::postLoad, get_called_class(), ORMEvents::postLoad);
		}

		if (!self::hasRegisteredListener($class, ORMEvents::preFlush, get_called_class())) {
			$class->addEntityListener(ORMEvents::preFlush, get_called_class(), ORMEvents::preFlush);
		}
	}

	protected function getEntityCoinFields($entity, ClassMetadata $class = NULL) {
		$class = $class ?: $this->entityManager->getClassMetadata(get_class($entity));

		if (isset($this->coinFieldsCache[$class->name])) {
			return $this->coinFieldsCache[$class->name];
		}

		if ($this->cache->contains($class->getName())) {
			$coinFields = Json::decode($this->cache->fetch($class->getName()), Json::FORCE_ARRAY);

		} else {
			$coinFields = $this->buildCoinFields($class);
			$this->cache->save($class->getName(), $coinFields ? Json::encode($coinFields) : FALSE);
		}

		$fieldsMap = array();
		if (is_array($coinFields) && !empty($coinFields)) {
			foreach ($coinFields as $field => $mapping) {
				if (!isset($fieldsMap[$mapping['cryptocurrencyAssociation']])) {
					$fieldsMap[$mapping['cryptocurrencyAssociation']] = array(
						'class' => $this->entityManager->getClassMetadata($mapping['cryptocurrencyClass']),
						'fields' => array($field => $this->entityManager->getClassMetadata($mapping['fieldClass'])),
					);

					continue;
				}

				$fieldsMap[$mapping['cryptocurrencyAssociation']]['fields'][$field] = $this->entityManager->getClassMetadata($mapping['fieldClass']);
			}
		}

		return $this->coinFieldsCache[$class->getName()] = $fieldsMap;
	}

	protected function shouldBeEntityMetadataChecked($className) {
		if($this->entityNamespaces === null) {
			return true;
		}
		foreach($this->entityNamespaces as $namespace) {
			if(strpos($className, $namespace) === 0) {
				return true;
			}
		}
		return false;
	}


	protected function buildCoinFields(ClassMetadata $class) {
		$coinFields = array();

		foreach ($class->getFieldNames() as $fieldName) {
			$mapping = $class->getFieldMapping($fieldName);
			if (!in_array($mapping['type'], [CoinType::COIN, CryptocurrencyAddressType::CRYPTOCURRENCY_ADDRESS], true)) {
				continue;
			}

			$classRefl = $class->isInheritedField($fieldName) ? new \ReflectionClass($mapping['declared']) : $class->getReflectionClass();
			$property = $classRefl->getProperty($fieldName);
			$column = $this->annotationReader->getPropertyAnnotation($property, 'Doctrine\ORM\Mapping\Column');

			if (empty($column->options['cryptocurrency'])) {
				if ($class->hasAssociation('cryptocurrency')) {
					$column->options['cryptocurrency'] = 'cryptocurrency'; // default association name

				} else {
					throw MetadataException::missingCurrencyReference($property);
				}
			}

			$currencyAssoc = $column->options['cryptocurrency'];
			if (!$class->hasAssociation($currencyAssoc)) {
				throw MetadataException::invalidCurrencyReference($property);
			}

			$coinFields[$fieldName] = [
				'fieldClass' => $classRefl->getName(),
				'cryptocurrencyClass' => $class->isInheritedAssociation($currencyAssoc) ? $class->associationMappings[$currencyAssoc]['declared'] : $class->getName(),
				'cryptocurrencyAssociation' => $currencyAssoc,
			];
		}

		return $coinFields;
	}


	protected static function hasRegisteredListener(ClassMetadata $class, $eventName, $listenerClass) {
		if (!isset($class->entityListeners[$eventName])) {
			return FALSE;
		}

		foreach ($class->entityListeners[$eventName] as $listener) {
			if ($listener['class'] === $listenerClass && $listener['method'] === $eventName) {
				return TRUE;
			}
		}

		return FALSE;
	}

}
