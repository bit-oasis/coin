<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\NetworkNotDefinedForCryptocurrency;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 * @deprecated DO NOT USE!
 */
final class CryptocurrencyNetworkProvider implements ICryptocurrencyNetworkProvider {

	/** @var array[] where key = cryptocurrency and value = array of networks */
	protected $cryptocurrencyToNetworkMap;

	/** @var CryptocurrencyNetworkFactory */
	protected $cryptocurrencyNetworkFactory;

	public function __construct(array $cryptocurrencyToNetworkMap, CryptocurrencyNetworkFactory $cryptocurrencyNetworkFactory) {
		$this->cryptocurrencyToNetworkMap = $cryptocurrencyToNetworkMap;
		$this->cryptocurrencyNetworkFactory = $cryptocurrencyNetworkFactory;
	}

	public static function fromAddressMap(array $addressMap): array {
		$cryptocurrencyToNetworkMap = [];

		foreach ($addressMap as $cryptocurrency => $map) {
			foreach ($map as $network => $addressHandler) {
				$cryptocurrencyToNetworkMap[$cryptocurrency][] = $network;
			}
		}

		return $cryptocurrencyToNetworkMap;
	}

	public function hasAnyNetwork(string $cryptocurrencyCode): bool {
		return isset($this->cryptocurrencyToNetworkMap[$cryptocurrencyCode]) && !empty($this->cryptocurrencyToNetworkMap[$cryptocurrencyCode]);
	}

	public function isNetworkSupportedForCryptocurrency(string $cryptocurrencyCode, string $networkCode): bool {
		return $this->hasAnyNetwork($cryptocurrencyCode) && in_array($networkCode, $this->cryptocurrencyToNetworkMap[$cryptocurrencyCode]);
	}

	/**
	 * @inheritDoc
	 */
	public function getDefaultNetworkForCurrency(Cryptocurrency $cryptocurrency): CryptocurrencyNetwork {
		if (!$this->hasAnyNetwork($cryptocurrency->getCode())) {
			throw new NetworkNotDefinedForCryptocurrency('Cryptocurrency should support at least one network');
		}

		return $this->cryptocurrencyNetworkFactory->create($this->cryptocurrencyToNetworkMap[$cryptocurrency->getCode()][0]);
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

}