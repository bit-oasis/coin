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
		$this->cryptocurrencies[Cryptocurrency::DOGE] = new Cryptocurrency(Cryptocurrency::DOGE, 8, 'Dogecoin');
		$this->cryptocurrencies[Cryptocurrency::AAVE] = new Cryptocurrency(Cryptocurrency::AAVE, 18, 'Aave');
		$this->cryptocurrencies[Cryptocurrency::BNT] = new Cryptocurrency(Cryptocurrency::BNT, 18, 'Bancor');
		$this->cryptocurrencies[Cryptocurrency::ENJ] = new Cryptocurrency(Cryptocurrency::ENJ, 18, 'Enjin Coin');
		$this->cryptocurrencies[Cryptocurrency::LRC] = new Cryptocurrency(Cryptocurrency::LRC, 18, 'Loopring');
		$this->cryptocurrencies[Cryptocurrency::MANA] = new Cryptocurrency(Cryptocurrency::MANA, 18, 'Decentraland');
		$this->cryptocurrencies[Cryptocurrency::MATIC] = new Cryptocurrency(Cryptocurrency::MATIC, 18, 'Polygon (Matic)');
		$this->cryptocurrencies[Cryptocurrency::STORJ] = new Cryptocurrency(Cryptocurrency::STORJ, 8, 'Storj');
		$this->cryptocurrencies[Cryptocurrency::SUSHI] = new Cryptocurrency(Cryptocurrency::SUSHI, 18, 'Sushi');
		$this->cryptocurrencies[Cryptocurrency::USDC] = new Cryptocurrency(Cryptocurrency::USDC, 6, 'USD Coin');
		$this->cryptocurrencies[Cryptocurrency::WAVES] = new Cryptocurrency(Cryptocurrency::WAVES, 8, 'Waves');
		$this->cryptocurrencies[Cryptocurrency::DOT] = new Cryptocurrency(Cryptocurrency::DOT, 10, 'Polkadot');
		$this->cryptocurrencies[Cryptocurrency::SOL] = new Cryptocurrency(Cryptocurrency::SOL, 9, 'Solana');
		$this->cryptocurrencies[Cryptocurrency::ADA] = new Cryptocurrency(Cryptocurrency::ADA, 6, 'Cardano');
		$this->cryptocurrencies[Cryptocurrency::SHIB] = new Cryptocurrency(Cryptocurrency::SHIB, 18, 'Shiba Inu');
		$this->cryptocurrencies[Cryptocurrency::AVAX] = new Cryptocurrency(Cryptocurrency::AVAX, 9, 'Avalanche');
		$this->cryptocurrencies[Cryptocurrency::FTM] = new Cryptocurrency(Cryptocurrency::FTM, 18, 'Fantom');
		$this->cryptocurrencies[Cryptocurrency::WBTC] = new Cryptocurrency(Cryptocurrency::WBTC, 8, 'Wrapped Bitcoin');
		$this->cryptocurrencies[Cryptocurrency::LUNA] = new Cryptocurrency(Cryptocurrency::LUNA, 6, 'Terra');
		$this->cryptocurrencies[Cryptocurrency::ATOM] = new Cryptocurrency(Cryptocurrency::ATOM, 6, 'Cosmos');
		$this->cryptocurrencies[Cryptocurrency::NEAR] = new Cryptocurrency(Cryptocurrency::NEAR, 18, 'Near Protocol');
		$this->cryptocurrencies[Cryptocurrency::ONE_INCH] = new Cryptocurrency(Cryptocurrency::ONE_INCH, 18, '1INCH');
		$this->cryptocurrencies[Cryptocurrency::AMPL] = new Cryptocurrency(Cryptocurrency::AMPL, 18, 'Ampleforth');
		$this->cryptocurrencies[Cryptocurrency::ANT] = new Cryptocurrency(Cryptocurrency::ANT, 18, 'Aragon Network');
		$this->cryptocurrencies[Cryptocurrency::AXS] = new Cryptocurrency(Cryptocurrency::AXS, 18, 'Axie Infinity');
		$this->cryptocurrencies[Cryptocurrency::BAND] = new Cryptocurrency(Cryptocurrency::BAND, 18, 'Band Protocol');
		$this->cryptocurrencies[Cryptocurrency::CHZ] = new Cryptocurrency(Cryptocurrency::CHZ, 18, 'Chiliz');
		$this->cryptocurrencies[Cryptocurrency::CRV] = new Cryptocurrency(Cryptocurrency::CRV, 18, 'Curve');
		$this->cryptocurrencies[Cryptocurrency::FTT] = new Cryptocurrency(Cryptocurrency::FTT, 18, 'FTX Token');
		$this->cryptocurrencies[Cryptocurrency::GALA] = new Cryptocurrency(Cryptocurrency::GALA, 18, 'Gala');
		$this->cryptocurrencies[Cryptocurrency::GNO] = new Cryptocurrency(Cryptocurrency::GNO, 18, 'Gnosis');
		$this->cryptocurrencies[Cryptocurrency::GRT] = new Cryptocurrency(Cryptocurrency::GRT, 18, 'The Graph');
		$this->cryptocurrencies[Cryptocurrency::LEO] = new Cryptocurrency(Cryptocurrency::LEO, 18, 'UNUS SED LEO');
		$this->cryptocurrencies[Cryptocurrency::NEXO] = new Cryptocurrency(Cryptocurrency::NEXO, 18, 'Nexo');
		$this->cryptocurrencies[Cryptocurrency::OCEAN] = new Cryptocurrency(Cryptocurrency::OCEAN, 18, 'Ocean Protocol');
		$this->cryptocurrencies[Cryptocurrency::SNX] = new Cryptocurrency(Cryptocurrency::SNX, 18, 'Synthetix');
		$this->cryptocurrencies[Cryptocurrency::TUSD] = new Cryptocurrency(Cryptocurrency::TUSD, 18, 'TrueUSD');
		$this->cryptocurrencies[Cryptocurrency::DGB] = new Cryptocurrency(Cryptocurrency::DGB, 8, 'Digibyte');
		$this->cryptocurrencies[Cryptocurrency::EGLD] = new Cryptocurrency(Cryptocurrency::EGLD, 18, 'Elrond eGold');
		$this->cryptocurrencies[Cryptocurrency::FIL] = new Cryptocurrency(Cryptocurrency::FIL, 18, 'Filecoin');
		$this->cryptocurrencies[Cryptocurrency::IOTA] = new Cryptocurrency(Cryptocurrency::IOTA, 8, 'IOTA');
		$this->cryptocurrencies[Cryptocurrency::KSM] = new Cryptocurrency(Cryptocurrency::KSM, 10, 'Kusama');
	}

}

