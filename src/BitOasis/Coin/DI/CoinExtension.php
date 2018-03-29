<?php

namespace BitOasis\Coin\DI;

use BitOasis\Coin\Address\BitcoinAddress;
use BitOasis\Coin\Address\BitcoinTestnetAddress;
use BitOasis\Coin\Address\CryptocurrencyAddressFactory;
use BitOasis\Coin\Address\EthereumAddress;
use BitOasis\Coin\Address\LitecoinAddress;
use BitOasis\Coin\Address\RippleAddress;
use BitOasis\Coin\Address\BitcoinCashAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Mapping\CoinObjectHydrationListener;
use BitOasis\Coin\Types\CoinType;
use BitOasis\Coin\Types\CryptocurrencyAddressType;
use Kdyby;
use Kdyby\Events\DI\EventsExtension;
use Nette\PhpGenerator as Code;
use Kdyby\Doctrine\DI\IDatabaseTypeProvider;
use Kdyby\Doctrine\DI\IEntityProvider;
use Nette\DI\CompilerExtension;


/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinExtension extends CompilerExtension implements IDatabaseTypeProvider, IEntityProvider {

	/** @var array */
	public $defaults = [
		'cache' => 'default',
		'entityNamespaces' => null,
		'addressHandlers' => [
			Cryptocurrency::BTC => BitcoinAddress::class,
			Cryptocurrency::TBTC => BitcoinTestnetAddress::class,
			Cryptocurrency::ETH => EthereumAddress::class,
			Cryptocurrency::XRP => RippleAddress::class,
			Cryptocurrency::LTC => LitecoinAddress::class,
			Cryptocurrency::BCH => BitcoinCashAddress::class,
		],
	];

	public function loadConfiguration() {
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('cryptocurrencyAddressFactory'))
			->setClass(CryptocurrencyAddressFactory::class, [$config['addressHandlers']]);
		$builder->addDefinition($this->prefix('coinHydrationListener'))
			->setClass(CoinObjectHydrationListener::class, [$config['entityNamespaces'], Kdyby\DoctrineCache\DI\Helpers::processCache($this, $config['cache'], 'coin')])
			->addTag(EventsExtension::TAG_SUBSCRIBER);
	}

	/**
	 * Returns array of typeName => typeClass.
	 *
	 * @return array
	 */
	public function getDatabaseTypes() {
		return [
			CoinType::COIN => CoinType::class,
			CryptocurrencyAddressType::CRYPTOCURRENCY_ADDRESS => CryptocurrencyAddressType::class,
		];
	}

	/**
	 * Returns associative array of Namespace => mapping definition
	 *
	 * @return array
	 */
	public function getEntityMappings() {
		return ['BitOasis\Coin' => (object)['value' => 'yaml', 'attributes' => __DIR__ . '/metadata']];
	}

}
