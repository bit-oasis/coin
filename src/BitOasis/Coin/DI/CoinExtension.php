<?php

namespace BitOasis\Coin\DI;

use BitOasis\Coin\Address\CryptocurrencyAddressFactory;
use BitOasis\Coin\CryptocurrencyNetworkProvider;
use BitOasis\Coin\DefaultCryptocurrencyNetworkFactory;
use BitOasis\Coin\Mapping\CoinObjectHydrationListener;
use Davefu\KdybyContributteBridge\Cache\Helpers as CacheHelpers;
use Davefu\KdybyContributteBridge\DI\Helper\MappingHelper;
use Kdyby\Events\DI\EventsExtension;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use stdClass;


/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 *
 * @property-read stdClass $config
 */
class CoinExtension extends CompilerExtension {

	public function getConfigSchema(): Schema {
		return Expect::structure([
			'cache' => Expect::string('filesystem'),
			'entityNamespaces' => Expect::arrayOf('string')->nullable()->default(null),
			'addressHandlers' => Expect::arrayOf(Expect::arrayOf('string', 'string'), 'string')->default(DefaultCurrencyAddressTypes::TYPES),
		]);
	}

	public function loadConfiguration() {
		$config = $this->config;
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('cryptocurrencyAddressFactory'))
			->setFactory(CryptocurrencyAddressFactory::class, [$config->addressHandlers]);
		$builder->addDefinition($this->prefix('cryptocurrencyNetworkFactory'))
			->setFactory(DefaultCryptocurrencyNetworkFactory::class, []);
		$builder->addDefinition($this->prefix('cryptocurrencyNetworkProvider'))
			->setFactory(CryptocurrencyNetworkProvider::class, [CryptocurrencyNetworkProvider::fromAddressMap($config->addressHandlers)]);
		$builder->addDefinition($this->prefix('coinHydrationListener'))
			->setFactory(CoinObjectHydrationListener::class, [$config->entityNamespaces, CacheHelpers::processCache($this, $config->cache, 'coin')])
			->addTag(EventsExtension::TAG_SUBSCRIBER);
	}

	public function beforeCompile(): void {
		MappingHelper::of($this)
			->addXml('BitOasis\Coin', __DIR__ . '/metadata');
	}
}
