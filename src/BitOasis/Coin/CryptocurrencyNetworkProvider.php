<?php

namespace BitOasis\Coin;

use BitOasis\Coin\DI\DefaultCurrencyAddressTypes;
use BitOasis\Coin\Exception\NetworkNotDefinedForCryptocurrency;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
final class CryptocurrencyNetworkProvider implements ICryptocurrencyNetworkProvider {

	/** @var array[] where key = cryptocurrency and value = array of networks */
	protected $cryptocurrencyToNetworkMap;

	/** @var DefaultCryptocurrencyNetworkFactory */
	protected $defaultCryptocurrencyNetworkFactory;

	public function __construct(DefaultCryptocurrencyNetworkFactory $defaultCryptocurrencyNetworkFactory) {
		$this->loadMapping();
		$this->defaultCryptocurrencyNetworkFactory = $defaultCryptocurrencyNetworkFactory;
	}

	public function hasAnyNetwork(string $cryptocurrencyCode): bool {
		return isset($this->cryptocurrencyToNetworkMap[$cryptocurrencyCode]) && !empty($this->cryptocurrencyToNetworkMap[$cryptocurrencyCode]);
	}

	public function isNetworkSupportedForCryptocurrency(string $cryptocurrencyCode, string $networkCode): bool {
		return $this->hasAnyNetwork($cryptocurrencyCode) && array_search($networkCode, $this->cryptocurrencyToNetworkMap[$cryptocurrencyCode], true) !== false;
	}

	/**
	 * @inheritDoc
	 */
	public function getDefaultNetworkForCurrency(Cryptocurrency $cryptocurrency): CryptocurrencyNetwork {
		if (!$this->hasAnyNetwork($cryptocurrency->getCode())) {
			throw new NetworkNotDefinedForCryptocurrency('Cryptocurrency should support at least one network');
		}

		return $this->defaultCryptocurrencyNetworkFactory->create($this->cryptocurrencyToNetworkMap[$cryptocurrency->getCode()][0]);
	}

	/**
	 * @inheritDoc
	 */
	public function getDefaultNetworkCodeForCurrencyCode(string $cryptocurrencyCode): string {
		if (!$this->hasAnyNetwork($cryptocurrencyCode)) {
			throw new NetworkNotDefinedForCryptocurrency('Cryptocurrency should support at least one network');
		}

		return reset($this->cryptocurrencyToNetworkMap[$cryptocurrencyCode]);
	}

	/**
	 * @inheritDoc
	 */
	public function getNetworkCodesForCryptocurrency(Cryptocurrency $cryptocurrency): array {
		if ($cryptocurrency->isFiat()) {
			throw new NetworkNotDefinedForCryptocurrency('Fiat currencies cannot support network');
		}

		if (!$this->hasAnyNetwork($cryptocurrency->getCode())) {
			throw new NetworkNotDefinedForCryptocurrency('Cryptocurrency should support at least one network');
		}

		return $this->cryptocurrencyToNetworkMap[$cryptocurrency->getCode()];
	}

	private function loadMapping(): void {
		foreach (DefaultCurrencyAddressTypes::TYPES as $cryptocurrency => $map) {
			foreach ($map as $network => $addressHandler) {
				$this->cryptocurrencyToNetworkMap[$cryptocurrency][] = $network;
			}
		}
	}

}
