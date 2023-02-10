<?php

namespace BitOasis\Coin\DI;

use Davefu\KdybyContributteBridge\DI\Helper\MappingHelper;
use BitOasis\Coin\Address\CryptocurrencyAddressFactory;
use BitOasis\Coin\CryptocurrencyNetworkProvider;
use BitOasis\Coin\DefaultCryptocurrencyNetworkFactory;
use BitOasis\Coin\Mapping\CoinObjectHydrationListener;
use Kdyby;
use Kdyby\Events\DI\EventsExtension;
use Nette\DI\CompilerExtension;


/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinExtension extends CompilerExtension {

	/** @var array */
	public $defaults = [
		'cache' => 'filesystem',
		'entityNamespaces' => null,
		'addressHandlers' => DefaultCurrencyAddressTypes::TYPES
	];

	public function loadConfiguration() {
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('cryptocurrencyAddressFactory'))
			->setClass(CryptocurrencyAddressFactory::class, [$config['addressHandlers']]);
		$builder->addDefinition($this->prefix('cryptocurrencyNetworkFactory'))
			->setClass(DefaultCryptocurrencyNetworkFactory::class, []);
		$builder->addDefinition($this->prefix('cryptocurrencyNetworkProvider'))
			->setClass(CryptocurrencyNetworkProvider::class, [CryptocurrencyNetworkProvider::fromAddressMap($config['addressHandlers'])]);
		$builder->addDefinition($this->prefix('coinHydrationListener'))
			->setClass(CoinObjectHydrationListener::class, [$config['entityNamespaces'], Kdyby\DoctrineCache\DI\Helpers::processCache($this, $config['cache'], 'coin')])
			->addTag(EventsExtension::TAG_SUBSCRIBER);
	}

	public function beforeCompile(): void {
		MappingHelper::of($this)
			->addXml('BitOasis\Coin', __DIR__ . '/metadata');
	}
}
