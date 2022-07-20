<?php

namespace BitOasis\Coin;

use BitOasis\Coin\DI\CoinExtension;
use BitOasis\Coin\DI\DefaultCurrencyAddressTypes;
use BitOasis\Coin\Exception\NetworkNotDefinedForCryptocurrency;
use Nette\Utils\Strings;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 *
 * Static class is holding only mappings for cryptocurrency -> network!
 */
final class CryptocurrencyNetworkProvider implements ICryptocurrencyNetworkProvider {

	/** @var array[] where key = cryptocurrency and value = array of networks */
	protected $cryptocurrencyToNetworkMap;

	/**
	 * @param array $cryptocurrencyToAddressMap
	 *
	 * @see DefaultCurrencyAddressTypes::TYPES
	 * @see CoinExtension::loadConfiguration()
	 */
	public function __construct(array $cryptocurrencyToAddressMap) {
		$this->loadMapping($cryptocurrencyToAddressMap);
	}

	public function isCryptocurrencySupportingAnyNetwork(string $cryptocurrencyCode): bool {
		return isset($this->cryptocurrencyToNetworkMap[$cryptocurrencyCode]) && !empty(isset($this->cryptocurrencyToNetworkMap[$cryptocurrencyCode]));
	}

	public function isCryptocurrencySupportingSpecificNetwork(string $cryptocurrencyCode, string $networkCode): bool {
		return $this->isCryptocurrencySupportingAnyNetwork($cryptocurrencyCode) && array_search($networkCode, $this->cryptocurrencyToNetworkMap[$cryptocurrencyCode], true) !== false;
	}

	/**
	 * @inheritDoc
	 */
	public function getDefaultNetworkForCurrency(Cryptocurrency $cryptocurrency): CryptocurrencyNetwork {
		$factory = new DefaultCryptocurrencyNetworkFactory();

		if (!$this->isCryptocurrencySupportingAnyNetwork($cryptocurrency->getCode())) {
			throw new NetworkNotDefinedForCryptocurrency('Cryptocurrency should support at least one network');
		}

		return $factory->create($this->cryptocurrencyToNetworkMap[$cryptocurrency->getCode()][0]);
	}

	/**
	 * @inheritDoc
	 */
	public function getDefaultNetworkCodeForCurrencyCode(string $cryptocurrencyCode): string {
		if (!$this->isCryptocurrencySupportingAnyNetwork($cryptocurrencyCode)) {
			throw new NetworkNotDefinedForCryptocurrency('Cryptocurrency should support at least one network');
		}

		return $this->cryptocurrencyToNetworkMap[$cryptocurrencyCode][0];
	}

	/**
	 * @inheritDoc
	 */
	public function getNetworkCodesForCryptocurrency(Cryptocurrency $cryptocurrency): array {
		if ($cryptocurrency->isFiat()) {
			throw new NetworkNotDefinedForCryptocurrency('Fiat currencies cannot support network');
		}

		if (!$this->isCryptocurrencySupportingAnyNetwork($cryptocurrency->getCode())) {
			throw new NetworkNotDefinedForCryptocurrency('Cryptocurrency should support at least one network');
		}

		return $this->cryptocurrencyToNetworkMap[$cryptocurrency->getCode()];
	}

	private function loadMapping($cryptocurrencyToAddressMap): void {
		foreach ($cryptocurrencyToAddressMap as $cryptocurrency => $map) {
			foreach ($map as $network => $addressHandler) {
				$this->cryptocurrencyToNetworkMap[$cryptocurrency][] = $network;
			}
		}
	}

}
