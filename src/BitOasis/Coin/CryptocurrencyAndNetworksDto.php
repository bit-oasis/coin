<?php

namespace BitOasis\Coin;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class CryptocurrencyAndNetworksDto {

	/** @var Cryptocurrency */
	protected $cryptocurrency;

	/** @var CryptocurrencyNetwork[] */
	protected $networks = [];

	/**
	 * @param Cryptocurrency $cryptocurrency
	 * @param array|null $cryptocurrencyNetworks
	 */
	public function __construct(Cryptocurrency $cryptocurrency, array $cryptocurrencyNetworks = null) {
		$this->cryptocurrency = $cryptocurrency;

		if ($cryptocurrencyNetworks) {
			foreach ($cryptocurrencyNetworks as $network) {
				$this->addNetwork($network);
			}
		}
	}

	/**
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 */
	public function addNetwork(CryptocurrencyNetwork $cryptocurrencyNetwork) {
		$this->networks[] = $cryptocurrencyNetwork;
	}

	/**
	 * @param string $code
	 * @return bool
	 */
	public function hasNetwork(string $code): bool {
		return $this->getNetwork($code) !== null;
	}

	/**
	 * @return Cryptocurrency
	 */
	public function getCryptocurrency(): Cryptocurrency {
		return $this->cryptocurrency;
	}

	/**
	 * @return CryptocurrencyNetwork[]
	 */
	public function getNetworks(): array {
		return $this->networks;
	}

	/**
	 * @param string $code
	 * @return CryptocurrencyNetwork|null
	 */
	public function getNetwork(string $code): ?CryptocurrencyNetwork {
		foreach ($this->networks as $network) {
			if (strtolower($code) === strtolower($network->getCode())) {
				return $network;
			}
		}

		return null;
	}

}
