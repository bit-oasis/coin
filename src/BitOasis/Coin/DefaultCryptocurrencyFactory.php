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
		$this->cryptocurrencies[Cryptocurrency::ZRX] = new Cryptocurrency(Cryptocurrency::ZRX, 18, '0x');
		$this->cryptocurrencies[Cryptocurrency::BAT] = new Cryptocurrency(Cryptocurrency::BAT, 18, 'Basic Attention Token');
		$this->cryptocurrencies[Cryptocurrency::LEO] = new Cryptocurrency(Cryptocurrency::LEO, 18, 'LEO Token');
		$this->cryptocurrencies[Cryptocurrency::ALGO] = new Cryptocurrency(Cryptocurrency::ALGO, 6, 'Algorand');
		$this->cryptocurrencies[Cryptocurrency::USDT] = new Cryptocurrency(Cryptocurrency::USDT, 6, 'Tether');
		$this->cryptocurrencies[Cryptocurrency::NEO] = new Cryptocurrency(Cryptocurrency::NEO, 0, 'NEO');
		$this->cryptocurrencies[Cryptocurrency::XTZ] = new Cryptocurrency(Cryptocurrency::XTZ, 6, 'Tezos');
		$this->cryptocurrencies[Cryptocurrency::LINK] = new Cryptocurrency(Cryptocurrency::LINK, 18, 'Chainlink');
		$this->cryptocurrencies[Cryptocurrency::DAI] = new Cryptocurrency(Cryptocurrency::DAI, 18, 'Dai');
		$this->cryptocurrencies[Cryptocurrency::MKR] = new Cryptocurrency(Cryptocurrency::MKR, 18, 'Maker');
		$this->cryptocurrencies[Cryptocurrency::KNC] = new Cryptocurrency(Cryptocurrency::LINK, 18, 'Kyber');
		$this->cryptocurrencies[Cryptocurrency::REP] = new Cryptocurrency(Cryptocurrency::REP, 18, 'Augur');
		$this->cryptocurrencies[Cryptocurrency::UNI] = new Cryptocurrency(Cryptocurrency::UNI, 18, 'Uniswap');
		$this->cryptocurrencies[Cryptocurrency::YFI] = new Cryptocurrency(Cryptocurrency::YFI, 18, 'Yearn Finance');
		$this->cryptocurrencies[Cryptocurrency::BAL] = new Cryptocurrency(Cryptocurrency::BAL, 18, 'Balancer');
		$this->cryptocurrencies[Cryptocurrency::COMP] = new Cryptocurrency(Cryptocurrency::COMP, 18, 'Compound');
		$this->cryptocurrencies[Cryptocurrency::SNX] = new Cryptocurrency(Cryptocurrency::SNX, 18, 'Synthetix');
		$this->cryptocurrencies[Cryptocurrency::DOGE] = new Cryptocurrency(Cryptocurrency::DOGE, 8, 'Dogecoin');
	}

}

