<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidCurrencyException;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class DefaultCryptocurrencyFactory implements CryptocurrencyFactory {

	/** @var Cryptocurrency[]  */
	protected $cryptocurrencies = [];

	public function __construct() {
		$this->addDefaultCryptocurrencies();
	}

	public function addCryptocurrency(Cryptocurrency $cryptocurrency) {
	    $this->cryptocurrencies[$cryptocurrency->getCode()] = $cryptocurrency;
	}

	public function setCryptocurrencies(array $cryptocurrencies) {
		$this->cryptocurrencies = $cryptocurrencies;
	}

	/**
	 * @param $code
	 * @return Cryptocurrency
	 * @throws InvalidCurrencyException
	 */
	public function create($code) {
		if (!isset($this->cryptocurrencies[$code])) {
			throw new InvalidCurrencyException('Cryptocurrency ' . $code . ' not defined');
		}
		return $this->cryptocurrencies[$code];
	}

	protected function addDefaultCryptocurrencies() {
		$this->cryptocurrencies[Cryptocurrency::BTC] = new Cryptocurrency(Cryptocurrency::BTC, 8, 'Bitcoin');
		$this->cryptocurrencies[Cryptocurrency::TBTC] = new Cryptocurrency(Cryptocurrency::TBTC, 8, 'Bitcoin Testnet');
		$this->cryptocurrencies[Cryptocurrency::BCH] = new Cryptocurrency(Cryptocurrency::BCH, 8, 'Bitcoin Cash');
		$this->cryptocurrencies[Cryptocurrency::BSV] = new Cryptocurrency(Cryptocurrency::BSV, 8, 'Bitcoin SV');
		$this->cryptocurrencies[Cryptocurrency::ETH] = new Cryptocurrency(Cryptocurrency::ETH, 18, 'Ethereum');
		$this->cryptocurrencies[Cryptocurrency::ETC] = new Cryptocurrency(Cryptocurrency::ETC, 18, 'Ethereum Classic');
		$this->cryptocurrencies[Cryptocurrency::LTC] = new Cryptocurrency(Cryptocurrency::LTC, 8, 'Litecoin');
		$this->cryptocurrencies[Cryptocurrency::XLM] = new Cryptocurrency(Cryptocurrency::XLM, 7, 'Stellar Lumen');
		$this->cryptocurrencies[Cryptocurrency::XMR] = new Cryptocurrency(Cryptocurrency::XMR, 12, 'Monero');
		$this->cryptocurrencies[Cryptocurrency::XRP] = new Cryptocurrency(Cryptocurrency::XRP, 6, 'Ripple');
		$this->cryptocurrencies[Cryptocurrency::ZEC] = new Cryptocurrency(Cryptocurrency::ZEC, 8, 'Zcash');
		$this->cryptocurrencies[Cryptocurrency::EOS] = new Cryptocurrency(Cryptocurrency::EOS, 4, 'EOS');
		$this->cryptocurrencies[Cryptocurrency::OMG] = new Cryptocurrency(Cryptocurrency::OMG, 18, 'OmiseGO');
	}

}

