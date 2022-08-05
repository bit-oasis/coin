<?php

namespace BitOasis\Coin\Mapping;

use BitOasis\Coin\Address\CryptocurrencyAddressFactory;
use BitOasis\Coin\Coin;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\CryptocurrencyNetworkFactory;
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

	const ASSOCIATION_CRYPTOCURRENCY = 'cryptocurrency';
	const ASSOCIATION_CRYPTOCURRENCY_NETWORK = 'cryptocurrencyNetwork';

	const ASSOCIATION_CONFIGS = [
		self::ASSOCIATION_CRYPTOCURRENCY => [
			'className' => Cryptocurrency::class,
			'default' => 'cryptocurrency',
			'forcedKey' => 'cryptocurrencyCode', // Not used now. Can be use as forced key from entity: example: {type="cryptocurrencyAddress", cryptocurrencyCode="BTC"}, if we want to force BTC for cryptocurrencyAddress field
			'mappingClassKey' => 'cryptocurrencyClass',
			'mappingAssociationKey' => 'cryptocurrencyAssociation',
		],
		self::ASSOCIATION_CRYPTOCURRENCY_NETWORK => [
			'className' => CryptocurrencyNetwork::class,
			'default' => 'cryptocurrencyNetwork',
			'forcedKey' => 'cryptocurrencyNetworkCode', // Forced key used for forcing address field to use specific network (forced network key): example: {type="cryptocurrencyAddress", cryptocurrencyNetworkCode="Bitcoin"}, This will tell to hydrator to use Bitcoin instead of looking for cryptocurrency_network_id in the table
			'mappingClassKey' => 'cryptocurrencyNetworkClass',
			'mappingAssociationKey' => 'cryptocurrencyNetworkAssociation',
			'forcedCodeKey' => 'cryptocurrencyNetworkForcedCode'
		]
	];

	/** @var null|string[] */
	protected $entityNamespaces = null;

	/** @var CacheProvider */
	protected $cache;

	/** @var CryptocurrencyAddressFactory */
	protected $cryptocurrencyAddressFactory;

	/** @var CryptocurrencyNetworkFactory */
	protected $cryptocurrencyNetworkFactory;

	/** @var EntityManager */
	protected $entityManager;

	/** @var Reader */
	protected $annotationReader;

	/** @var array */
	protected $coinFieldsCache = [];

	/** @var array */
	protected $networkFieldsCache = [];

	public function __construct($entityNamespaces, CacheProvider $cache, CryptocurrencyAddressFactory $cryptocurrencyAddressFactory, CryptocurrencyNetworkFactory $cryptocurrencyNetworkFactory, Reader $annotationReader, EntityManager $entityManager) {
		$this->entityNamespaces = $entityNamespaces;
		$this->cache = $cache;
		$this->cache->setNamespace(get_called_class());
		$this->cryptocurrencyAddressFactory = $cryptocurrencyAddressFactory;
		$this->cryptocurrencyNetworkFactory = $cryptocurrencyNetworkFactory;
		$this->entityManager = $entityManager;
		$this->annotationReader = $annotationReader;
	}

	public function getSubscribedEvents() {
		return array(
			Events::loadClassMetadata => 'loadClassMetadata',
		);
	}

	public function postLoad($entity, LifecycleEventArgs $args) {
		$fieldsCryptocurrencyMap = $this->getEntityCoinFields($entity);
		$fieldsNetworkMap = $this->getEntityCryptocurrencyNetworkFields($entity);

		if (empty($fieldsCryptocurrencyMap)) {
			return;
		}

		foreach ($fieldsCryptocurrencyMap as $currencyAssoc => $currencyMeta) {
			foreach ($currencyMeta['fields'] as $coinField => $coinClass) {
				$value = $coinClass->getFieldValue($entity, $coinField);
				if ($value instanceof Coin || $value instanceof CryptocurrencyAddress || $value === NULL) {
					continue;
				}

				$currency = $currencyMeta['class']->getFieldValue($entity, $currencyAssoc);
				if (!$currency instanceof Cryptocurrency) {
					throw new \InvalidArgumentException('Invalid Cryptocurrency value for Coin class!');
				}

				if ($coinClass->getFieldMapping($coinField)['type'] === CoinType::COIN) {
					$coinClass->setFieldValue($entity, $coinField, Coin::fromInt($value, $currency));
				} else if ($coinClass->getFieldMapping($coinField)['type'] === CryptocurrencyAddressType::CRYPTOCURRENCY_ADDRESS) {
					if (!isset($fieldsNetworkMap[$coinField])) {
						throw new \InvalidArgumentException('Invalid CryptocurrencyNetwork value for CryptocurrencyAddress class!');
					}

					$forceCodeKey = self::ASSOCIATION_CONFIGS[self::ASSOCIATION_CRYPTOCURRENCY_NETWORK]['forcedCodeKey'];
					$associationKey = self::ASSOCIATION_CONFIGS[self::ASSOCIATION_CRYPTOCURRENCY_NETWORK]['mappingAssociationKey'];

					$network = $fieldsNetworkMap[$coinField][$forceCodeKey] !== null
						? $this->cryptocurrencyNetworkFactory->create($fieldsNetworkMap[$coinField][$forceCodeKey])
						: $fieldsNetworkMap[$coinField]['class']->getFieldValue($entity, $fieldsNetworkMap[$coinField][$associationKey]);

					$coinClass->setFieldValue($entity, $coinField, $this->cryptocurrencyAddressFactory->deserialize($value, $currency, $network));
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

		if (!$this->shouldBeEntityMetadataChecked($class->getName())) {
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

		if (!$this->buildFieldsForCoin($class)) {
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
		$associationConfigs = self::ASSOCIATION_CONFIGS[self::ASSOCIATION_CRYPTOCURRENCY];

		if (isset($this->coinFieldsCache[$class->name])) {
			return $this->coinFieldsCache[$class->name];
		}

		$cacheKey = $class->getName() . '-' . self::ASSOCIATION_CRYPTOCURRENCY;

		if ($this->cache->contains($cacheKey)) {
			$coinFields = Json::decode($this->cache->fetch($cacheKey), Json::FORCE_ARRAY);
		} else {
			$coinFields = $this->buildFieldsForCoin($class);
			$this->cache->save($cacheKey, $coinFields ? Json::encode($coinFields) : FALSE);
		}

		$fieldsMap = [];
		$classKey = $associationConfigs['mappingClassKey'];
		$assocKey = $associationConfigs['mappingAssociationKey'];

		if (is_array($coinFields) && !empty($coinFields)) {
			foreach ($coinFields as $field => $mapping) {
				if (!isset($fieldsMap[$mapping[$assocKey]])) {
					$fieldsMap[$mapping[$assocKey]] = array(
						'class' => $this->entityManager->getClassMetadata($mapping[$classKey]),
						'fields' => array($field => $this->entityManager->getClassMetadata($mapping['fieldClass'])),
					);

					continue;
				}

				$fieldsMap[$mapping[$assocKey]]['fields'][$field] = $this->entityManager->getClassMetadata($mapping['fieldClass']);
			}
		}

		return $this->coinFieldsCache[$class->getName()] = $fieldsMap;
	}

	protected function getEntityCryptocurrencyNetworkFields($entity) {
		$class = $this->entityManager->getClassMetadata(get_class($entity));

		if (isset($this->networkFieldsCache[$class->name])) {
			return $this->networkFieldsCache[$class->name];
		}

		$cacheKey = $class->getName() . '-' . self::ASSOCIATION_CRYPTOCURRENCY_NETWORK;

		if ($this->cache->contains($cacheKey)) {
			$networkFields = Json::decode($this->cache->fetch($cacheKey), Json::FORCE_ARRAY);
		} else {
			$networkFields = $this->buildFieldsForNetwork($class);
			$this->cache->save($cacheKey, $networkFields ? Json::encode($networkFields) : FALSE);
		}

		$res = [];

		if (is_array($networkFields) && !empty($networkFields)) {
			// Cache cannot handle the class itself
			// That's why we need to load class name from cache and create the metadata every time
			foreach ($networkFields as $field => $mapping) {
				$res[$field] = $mapping;
				$res[$field]['class'] = $this->entityManager->getClassMetadata($mapping['class']);
			}
		}

		return $this->networkFieldsCache[$class->getName()] = $res;
	}

	protected function shouldBeEntityMetadataChecked($className) {
		if ($this->entityNamespaces === null) {
			return true;
		}
		foreach ($this->entityNamespaces as $namespace) {
			if (strpos($className, $namespace) === 0) {
				return true;
			}
		}
		return false;
	}

	protected function buildFieldsForNetwork(ClassMetadata $class): array {
		$networkFields = [];
		$associationConfigs = self::ASSOCIATION_CONFIGS[self::ASSOCIATION_CRYPTOCURRENCY_NETWORK];

		foreach ($class->getFieldNames() as $fieldName) {
			$mapping = $class->getFieldMapping($fieldName);
			if ($mapping['type'] !== CryptocurrencyAddressType::CRYPTOCURRENCY_ADDRESS) {
				continue;
			}

			$classRefl = $class->isInheritedField($fieldName) ? new \ReflectionClass($mapping['declared']) : $class->getReflectionClass();
			$property = $classRefl->getProperty($fieldName);
			$column = $this->annotationReader->getPropertyAnnotation($property, 'Doctrine\ORM\Mapping\Column');

			$forcedNetworkCode = $column->options[$associationConfigs['forcedKey']] ?? null;

			if ($forcedNetworkCode) {
				$associationName = $associationConfigs['default'];
			} else {
				if (empty($column->options[self::ASSOCIATION_CRYPTOCURRENCY_NETWORK])) {
					if ($class->hasAssociation(self::ASSOCIATION_CRYPTOCURRENCY_NETWORK)) {
						$associationName = $associationConfigs['default'];
					} else {
						throw MetadataException::missingReference($property, self::ASSOCIATION_CRYPTOCURRENCY_NETWORK);
					}
				} else {
					$associationName = $column->options[self::ASSOCIATION_CRYPTOCURRENCY_NETWORK];
				}

				if (!$class->hasAssociation($associationName)) {
					throw MetadataException::invalidReference($property, self::ASSOCIATION_CRYPTOCURRENCY_NETWORK, $associationConfigs['className']);
				}
			}

			$networkFields[$fieldName] = [
				'class' => $classRefl->getName(),
				$associationConfigs['mappingAssociationKey'] => $associationName,
				$associationConfigs['forcedCodeKey'] => $forcedNetworkCode
			];
		}

		return $networkFields;
	}

	protected function buildFieldsForCoin(ClassMetadata $class): array {
		$coinFields = [];
		$association = self::ASSOCIATION_CRYPTOCURRENCY;
		$associationConfigs = self::ASSOCIATION_CONFIGS[$association];

		foreach ($class->getFieldNames() as $fieldName) {
			$mapping = $class->getFieldMapping($fieldName);
			if (!in_array($mapping['type'], [CoinType::COIN, CryptocurrencyAddressType::CRYPTOCURRENCY_ADDRESS], true)) {
				continue;
			}

			$classRefl = $class->isInheritedField($fieldName) ? new \ReflectionClass($mapping['declared']) : $class->getReflectionClass();
			$property = $classRefl->getProperty($fieldName);
			$column = $this->annotationReader->getPropertyAnnotation($property, 'Doctrine\ORM\Mapping\Column');

			if (empty($column->options[$association])) {
				if ($class->hasAssociation($association)) {
					$column->options[$association] = $associationConfigs['default'];
				} else {
					throw MetadataException::missingReference($property, $association);
				}
			}

			$associationName = $column->options[$association];
			if (!$class->hasAssociation($associationName)) {
				throw MetadataException::invalidReference($property, $association, $associationConfigs['className']);
			}

			$coinFields[$fieldName] = [
				'fieldClass' => $classRefl->getName(),
				$associationConfigs['mappingClassKey'] => $class->isInheritedAssociation($associationName) ? $class->associationMappings[$associationName]['declared'] : $class->getName(),
				$associationConfigs['mappingAssociationKey'] => $associationName,
			];
		}

		return $coinFields;
	}

	protected static function hasRegisteredListener(ClassMetadata $class, $eventName, $listenerClass) {
		if (!isset($class->entityListeners[$eventName])) {
			return false;
		}

		foreach ($class->entityListeners[$eventName] as $listener) {
			if ($listener['class'] === $listenerClass && $listener['method'] === $eventName) {
				return true;
			}
		}

		return false;
	}

}
