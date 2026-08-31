<?php

namespace BitOasis\Coin\Mapping;

use BitOasis\Coin\Address\CryptocurrencyAddressFactory;
use BitOasis\Coin\Coin;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\CryptocurrencyNetworkFactory;
use BitOasis\Coin\Types\CoinType;
use BitOasis\Coin\Types\CryptocurrencyAddressType;
use Codeception\Util\Stub;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Cache\CacheProvider;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\UnitOfWork;
use Doctrine\Persistence\Mapping\RuntimeReflectionService;
use UnitTest;

/**
 * @author Robert Mkrtchyan <robert.mkrtchyan@bitoasis.net>
 */
class CoinObjectHydrationListenerTest extends UnitTest {

	/** @var RecordingUnitOfWork */
	private $unitOfWork;

	/** @var array */
	private $originalEntityData = [];

	/** @var array */
	private $capturedOids = [];

	/** @var EntityManagerInterface */
	private $entityManager;

	protected function _before() {
		parent::_before();
		// A real UnitOfWork subclass rather than a Stub: Codeception 4's Stub clones object
		// arguments, which would defeat the very identity assertion these tests make.
		$this->unitOfWork = (new \ReflectionClass(RecordingUnitOfWork::class))->newInstanceWithoutConstructor();
		$this->originalEntityData = &$this->unitOfWork->originalData;
		$this->capturedOids = &$this->unitOfWork->oids;
		$this->entityManager = Stub::makeEmpty(EntityManagerInterface::class, ['getUnitOfWork' => $this->unitOfWork]);
	}

	public function testPostLoadSyncsOriginalDataForCoinFieldSoTheEntityIsNotLeftDirty() {
		$entity = $this->createEntity('12345');

		$this->createListener()->postLoad($entity, new PostLoadEventArgs($entity, $this->entityManager));

		$this->assertInstanceOf(Coin::class, $entity->amount);
		$this->assertEquals('12345', $entity->amount->toIntString());
		$this->assertArrayHasKey('amount', $this->originalEntityData);
		$this->assertSame(
			$entity->amount,
			$this->originalEntityData['amount'],
			'Doctrine\'s original data snapshot must hold the very same value object instance, otherwise ' .
			'computeChangeSet() compares a string against an object and reports the entity dirty on every flush.'
		);
		$this->assertSame([spl_object_id($entity)], $this->capturedOids);
	}

	public function testPostLoadSyncsOriginalDataForCryptocurrencyAddressField() {
		$entity = $this->createEntity(null);
		$entity->address = '1BoatSLRHtKNngkdXEeobR76b53LETtpyT';
		$address = Stub::makeEmpty(CryptocurrencyAddress::class);

		$this->createListener($address)->postLoad($entity, new PostLoadEventArgs($entity, $this->entityManager));

		$this->assertSame($address, $entity->address);
		$this->assertArrayHasKey('address', $this->originalEntityData);
		$this->assertSame($address, $this->originalEntityData['address']);
	}

	public function testPostLoadDoesNotTouchOriginalDataForNullFields() {
		$entity = $this->createEntity(null);

		$this->createListener()->postLoad($entity, new PostLoadEventArgs($entity, $this->entityManager));

		$this->assertNull($entity->amount);
		$this->assertSame([], $this->originalEntityData);
	}

	public function testPostLoadDoesNotTouchOriginalDataForAlreadyHydratedField() {
		$entity = $this->createEntity(null);
		$entity->amount = Coin::fromInt('12345', $entity->cryptocurrency);
		$alreadyHydrated = $entity->amount;

		$this->createListener()->postLoad($entity, new PostLoadEventArgs($entity, $this->entityManager));

		$this->assertSame($alreadyHydrated, $entity->amount);
		$this->assertSame([], $this->originalEntityData);
	}

	private function createEntity($amount): CoinHydrationFixture {
		$entity = new CoinHydrationFixture();
		$entity->amount = $amount;
		$entity->cryptocurrency = new Cryptocurrency('BTC', 8, 'Bitcoin');
		$entity->cryptocurrencyNetwork = new CryptocurrencyNetwork('Bitcoin', 'Bitcoin');

		return $entity;
	}

	private function createListener(?CryptocurrencyAddress $deserializedAddress = null): TestableCoinObjectHydrationListener {
		$listener = new TestableCoinObjectHydrationListener(
			null,
			new NullCacheProvider(),
			Stub::makeEmpty(CryptocurrencyAddressFactory::class, ['deserialize' => $deserializedAddress]),
			Stub::makeEmpty(CryptocurrencyNetworkFactory::class),
			Stub::makeEmpty(Reader::class),
			$this->entityManager
		);
		$listener->setMetadata(self::createMetadata());

		return $listener;
	}

	private static function createMetadata(): ClassMetadata {
		$reflectionService = new RuntimeReflectionService();
		$metadata = new ClassMetadata(CoinHydrationFixture::class);
		$metadata->initializeReflection($reflectionService);
		$metadata->mapField(['fieldName' => 'amount', 'type' => CoinType::COIN]);
		$metadata->mapField(['fieldName' => 'address', 'type' => CryptocurrencyAddressType::CRYPTOCURRENCY_ADDRESS]);
		$metadata->mapField(['fieldName' => 'cryptocurrency', 'type' => 'string']);
		$metadata->mapField(['fieldName' => 'cryptocurrencyNetwork', 'type' => 'string']);
		$metadata->wakeupReflection($reflectionService);

		return $metadata;
	}

}

/**
 * The listener only calls setNamespace() on the cache in these tests, because the field maps are
 * supplied directly by TestableCoinObjectHydrationListener.
 */
class NullCacheProvider extends CacheProvider {

	protected function doFetch($id) {
		return false;
	}

	protected function doContains($id) {
		return false;
	}

	protected function doSave($id, $data, $lifeTime = 0) {
		return true;
	}

	protected function doDelete($id) {
		return true;
	}

	protected function doFlush() {
		return true;
	}

	protected function doGetStats() {
		return null;
	}

}

class RecordingUnitOfWork extends UnitOfWork {

	/** @var array */
	public $originalData = [];

	/** @var array */
	public $oids = [];

	public function setOriginalEntityProperty($oid, $property, $value) {
		$this->originalData[$property] = $value;
		$this->oids[] = $oid;
	}

}

/**
 * Builds the field maps by hand so the test drives the real postLoad() loop without having to
 * construct a fully mapped Doctrine association graph.
 */
class TestableCoinObjectHydrationListener extends CoinObjectHydrationListener {

	/** @var ClassMetadata */
	private $metadata;

	public function setMetadata(ClassMetadata $metadata): void {
		$this->metadata = $metadata;
	}

	protected function getEntityCoinFields($entity, ClassMetadata $class = NULL) {
		return [
			self::ASSOCIATION_CRYPTOCURRENCY => [
				'class' => $this->metadata,
				'fields' => [
					'amount' => $this->metadata,
					'address' => $this->metadata,
				],
			],
		];
	}

	protected function getEntityCryptocurrencyNetworkFields($entity) {
		$configs = self::ASSOCIATION_CONFIGS[self::ASSOCIATION_CRYPTOCURRENCY_NETWORK];

		return [
			'address' => [
				'class' => $this->metadata,
				$configs['mappingAssociationKey'] => self::ASSOCIATION_CRYPTOCURRENCY_NETWORK,
				$configs['forcedCodeKey'] => null,
			],
		];
	}

}

class CoinHydrationFixture {

	public $amount;

	public $address;

	public $cryptocurrency;

	public $cryptocurrencyNetwork;

}
