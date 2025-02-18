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
	 * @inheritDoc
	 */
	public function create(string $code): Cryptocurrency {
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
		$this->cryptocurrencies[Cryptocurrency::XLM] = new Cryptocurrency(Cryptocurrency::XLM, 7, 'Stellar Lumens');
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
		$this->cryptocurrencies[Cryptocurrency::KNC] = new Cryptocurrency(Cryptocurrency::KNC, 18, 'Kyber');
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
		$this->cryptocurrencies[Cryptocurrency::NEAR] = new Cryptocurrency(Cryptocurrency::NEAR, 24, 'Near Protocol');
		$this->cryptocurrencies[Cryptocurrency::ONE_INCH] = new Cryptocurrency(Cryptocurrency::ONE_INCH, 18, '1INCH');
		$this->cryptocurrencies[Cryptocurrency::ANT] = new Cryptocurrency(Cryptocurrency::ANT, 18, 'Aragon');
		$this->cryptocurrencies[Cryptocurrency::AXS] = new Cryptocurrency(Cryptocurrency::AXS, 18, 'Axie Infinity');
		$this->cryptocurrencies[Cryptocurrency::BAND] = new Cryptocurrency(Cryptocurrency::BAND, 18, 'Band Protocol');
		$this->cryptocurrencies[Cryptocurrency::CHZ] = new Cryptocurrency(Cryptocurrency::CHZ, 18, 'Chiliz');
		$this->cryptocurrencies[Cryptocurrency::CRV] = new Cryptocurrency(Cryptocurrency::CRV, 18, 'Curve');
		$this->cryptocurrencies[Cryptocurrency::FTT] = new Cryptocurrency(Cryptocurrency::FTT, 18, 'FTX Token');
		$this->cryptocurrencies[Cryptocurrency::GALA] = new Cryptocurrency(Cryptocurrency::GALA, 8, 'Gala');
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
		$this->cryptocurrencies[Cryptocurrency::KSM] = new Cryptocurrency(Cryptocurrency::KSM, 12, 'Kusama');
		$this->cryptocurrencies[Cryptocurrency::QTUM] = new Cryptocurrency(Cryptocurrency::QTUM, 8, 'QTUM');
		$this->cryptocurrencies[Cryptocurrency::THETA] = new Cryptocurrency(Cryptocurrency::THETA, 18, 'Theta Network');
		$this->cryptocurrencies[Cryptocurrency::TRX] = new Cryptocurrency(Cryptocurrency::TRX, 6, 'Tron');
		$this->cryptocurrencies[Cryptocurrency::UST] = new Cryptocurrency(Cryptocurrency::UST, 6, 'Terra USD');
		$this->cryptocurrencies[Cryptocurrency::VET] = new Cryptocurrency(Cryptocurrency::VET, 18, 'VeChain');
		$this->cryptocurrencies[Cryptocurrency::XVG] = new Cryptocurrency(Cryptocurrency::XVG, 8, 'Verge');
		$this->cryptocurrencies[Cryptocurrency::LUNA2] = new Cryptocurrency(Cryptocurrency::LUNA2, 6, 'Terra 2.0');
		$this->cryptocurrencies[Cryptocurrency::ETHW] = new Cryptocurrency(Cryptocurrency::ETHW, 18, 'EthereumPoW');
		$this->cryptocurrencies[Cryptocurrency::XAUT] = new Cryptocurrency(Cryptocurrency::XAUT, 6, 'Tether Gold');
		$this->cryptocurrencies[Cryptocurrency::ARB] = new Cryptocurrency(Cryptocurrency::ARB, 18, 'Arbitrum');
		$this->cryptocurrencies[Cryptocurrency::APE] = new Cryptocurrency(Cryptocurrency::APE, 18, 'ApeCoin');
		$this->cryptocurrencies[Cryptocurrency::SAND] = new Cryptocurrency(Cryptocurrency::SAND, 18, 'The Sandbox');
		$this->cryptocurrencies[Cryptocurrency::LDO] = new Cryptocurrency(Cryptocurrency::LDO, 18, 'Lido DAO');
		$this->cryptocurrencies[Cryptocurrency::FET] = new Cryptocurrency(Cryptocurrency::FET, 18, 'Fetch.ai');
		$this->cryptocurrencies[Cryptocurrency::XDC] = new Cryptocurrency(Cryptocurrency::XDC, 8, 'XDC Network');
		$this->cryptocurrencies[Cryptocurrency::BTG] = new Cryptocurrency(Cryptocurrency::BTG, 8, 'Bitcoin Gold');
		$this->cryptocurrencies[Cryptocurrency::RLY] = new Cryptocurrency(Cryptocurrency::RLY, 18, 'Rally');
		$this->cryptocurrencies[Cryptocurrency::RBTC] = new Cryptocurrency(Cryptocurrency::RBTC, 18, 'Rootstock Smart Bitcoin');
		$this->cryptocurrencies[Cryptocurrency::VRA] = new Cryptocurrency(Cryptocurrency::VRA, 18, 'Verasity');
		$this->cryptocurrencies[Cryptocurrency::UTK] = new Cryptocurrency(Cryptocurrency::UTK, 18, 'Utrust');
		$this->cryptocurrencies[Cryptocurrency::SGB] = new Cryptocurrency(Cryptocurrency::SGB, 18, 'Songbird');
		$this->cryptocurrencies[Cryptocurrency::BLUR] = new Cryptocurrency(Cryptocurrency::BLUR, 18, 'Blur');
		$this->cryptocurrencies[Cryptocurrency::OP] = new Cryptocurrency(Cryptocurrency::OP, 18, 'Optimism');
		$this->cryptocurrencies[Cryptocurrency::OPEN] = new Cryptocurrency(Cryptocurrency::OPEN, 8, 'Open Custody Protocol');
		$this->cryptocurrencies[Cryptocurrency::BOSON] = new Cryptocurrency(Cryptocurrency::BOSON, 18, 'BOSON');
		$this->cryptocurrencies[Cryptocurrency::FLOKI] = new Cryptocurrency(Cryptocurrency::FLOKI, 9, 'FLOKI');
		$this->cryptocurrencies[Cryptocurrency::WILD] = new Cryptocurrency(Cryptocurrency::WILD, 18, 'Wilder World');
		$this->cryptocurrencies[Cryptocurrency::SUI] = new Cryptocurrency(Cryptocurrency::SUI, 9, 'Sui');
		$this->cryptocurrencies[Cryptocurrency::SEI] = new Cryptocurrency(Cryptocurrency::SEI, 18, 'Sei Network');
		$this->cryptocurrencies[Cryptocurrency::TON] = new Cryptocurrency(Cryptocurrency::TON, 9, 'Toncoin');
		$this->cryptocurrencies[Cryptocurrency::AMPL] = new Cryptocurrency(Cryptocurrency::AMPL, 9, 'Ampleforth');
		$this->cryptocurrencies[Cryptocurrency::BEST] = new Cryptocurrency(Cryptocurrency::BEST, 8, 'Bitpanda');
		$this->cryptocurrencies[Cryptocurrency::CELO] = new Cryptocurrency(Cryptocurrency::CELO, 18, 'Celo');
		$this->cryptocurrencies[Cryptocurrency::DUSK] = new Cryptocurrency(Cryptocurrency::DUSK, 18, 'Dusk Network');
		$this->cryptocurrencies[Cryptocurrency::DVF] = new Cryptocurrency(Cryptocurrency::DVF, 18, 'Deversifi Token');
		$this->cryptocurrencies[Cryptocurrency::FCL] = new Cryptocurrency(Cryptocurrency::FCL, 18, 'Fractal');
		$this->cryptocurrencies[Cryptocurrency::FLR] = new Cryptocurrency(Cryptocurrency::FLR, 18, 'Flare');
		$this->cryptocurrencies[Cryptocurrency::FORTH] = new Cryptocurrency(Cryptocurrency::FORTH, 18, 'FORTH');
		$this->cryptocurrencies[Cryptocurrency::FUN] = new Cryptocurrency(Cryptocurrency::FUN, 8, 'FunFair');
		$this->cryptocurrencies[Cryptocurrency::HMT] = new Cryptocurrency(Cryptocurrency::HMT, 18, 'Human');
		$this->cryptocurrencies[Cryptocurrency::INJ] = new Cryptocurrency(Cryptocurrency::INJ, 18, 'Injective');
		$this->cryptocurrencies[Cryptocurrency::JUP] = new Cryptocurrency(Cryptocurrency::JUP, 6, 'Jupiter');
		$this->cryptocurrencies[Cryptocurrency::KAVA] = new Cryptocurrency(Cryptocurrency::KAVA, 18, 'KAVA');
		$this->cryptocurrencies[Cryptocurrency::MEME] = new Cryptocurrency(Cryptocurrency::MEME, 18, 'Memecoin');
		$this->cryptocurrencies[Cryptocurrency::MIM] = new Cryptocurrency(Cryptocurrency::MIM, 18, 'Magic Internet Money');
		$this->cryptocurrencies[Cryptocurrency::MLN] = new Cryptocurrency(Cryptocurrency::MLN, 18, 'Melon');
		$this->cryptocurrencies[Cryptocurrency::OGN] = new Cryptocurrency(Cryptocurrency::OGN, 18, 'Origin Protocol');
		$this->cryptocurrencies[Cryptocurrency::PAX] = new Cryptocurrency(Cryptocurrency::PAX, 18, 'Paxos');
		$this->cryptocurrencies[Cryptocurrency::PLU] = new Cryptocurrency(Cryptocurrency::PLU, 18, 'Pluton');
		$this->cryptocurrencies[Cryptocurrency::PNK] = new Cryptocurrency(Cryptocurrency::PNK, 18, 'Kleros');
		$this->cryptocurrencies[Cryptocurrency::REQ] = new Cryptocurrency(Cryptocurrency::REQ, 18, 'Request Network');
		$this->cryptocurrencies[Cryptocurrency::SIDUS] = new Cryptocurrency(Cryptocurrency::SIDUS, 18, 'SIDUS');
		$this->cryptocurrencies[Cryptocurrency::SPELL] = new Cryptocurrency(Cryptocurrency::SPELL, 18, 'SPELL');
		$this->cryptocurrencies[Cryptocurrency::STG] = new Cryptocurrency(Cryptocurrency::STG, 18, 'Stargate Finance');
		$this->cryptocurrencies[Cryptocurrency::SUKU] = new Cryptocurrency(Cryptocurrency::SUKU, 18, 'SUKU');
		$this->cryptocurrencies[Cryptocurrency::UOS] = new Cryptocurrency(Cryptocurrency::UOS, 4, 'Ultra');
		$this->cryptocurrencies[Cryptocurrency::WOO] = new Cryptocurrency(Cryptocurrency::WOO, 18, 'WOO');
		$this->cryptocurrencies[Cryptocurrency::XTP] = new Cryptocurrency(Cryptocurrency::XTP, 18, 'Tap');
		$this->cryptocurrencies[Cryptocurrency::POL] = new Cryptocurrency(Cryptocurrency::POL, 18, 'Polygon Ecosystem Token');
		$this->cryptocurrencies[Cryptocurrency::PEPE] = new Cryptocurrency(Cryptocurrency::PEPE, 18, 'Pepe');
		$this->cryptocurrencies[Cryptocurrency::BONK] = new Cryptocurrency(Cryptocurrency::BONK, 5, 'Bonk');
		$this->cryptocurrencies[Cryptocurrency::TOMI] = new Cryptocurrency(Cryptocurrency::TOMI, 18, 'Tomi');
		$this->cryptocurrencies[Cryptocurrency::TURBO] = new Cryptocurrency(Cryptocurrency::TURBO, 18, 'Turbo');
		$this->cryptocurrencies[Cryptocurrency::WBT] = new Cryptocurrency(Cryptocurrency::WBT, 8, 'WhiteBIT Coin');
		$this->cryptocurrencies[Cryptocurrency::ENA] = new Cryptocurrency(Cryptocurrency::ENA, 18, 'Ethena');
		$this->cryptocurrencies[Cryptocurrency::MEW] = new Cryptocurrency(Cryptocurrency::MEW, 5, 'Cat in a dogs world');
		$this->cryptocurrencies[Cryptocurrency::TIA] = new Cryptocurrency(Cryptocurrency::TIA, 6, 'Celestia');
		$this->cryptocurrencies[Cryptocurrency::SWEAT] = new Cryptocurrency(Cryptocurrency::SWEAT, 18, 'Sweat Economy');
		$this->cryptocurrencies[Cryptocurrency::DOP] = new Cryptocurrency(Cryptocurrency::DOP, 18, 'Data Ownership Protocol');
		$this->cryptocurrencies[Cryptocurrency::SPEC] = new Cryptocurrency(Cryptocurrency::SPEC, 18, 'Spectral');
		$this->cryptocurrencies[Cryptocurrency::AIOZ] = new Cryptocurrency(Cryptocurrency::AIOZ, 18, 'AIOZ Network');
		$this->cryptocurrencies[Cryptocurrency::GOMINING] = new Cryptocurrency(Cryptocurrency::GOMINING, 18, 'Gomining');
		$this->cryptocurrencies[Cryptocurrency::VELAR] = new Cryptocurrency(Cryptocurrency::VELAR, 6, 'Velar');
		$this->cryptocurrencies[Cryptocurrency::JUSTICE] = new Cryptocurrency(Cryptocurrency::JUSTICE, 18, 'AssangeDAO');
		$this->cryptocurrencies[Cryptocurrency::KAN] = new Cryptocurrency(Cryptocurrency::KAN, 18, 'BitKan');
		$this->cryptocurrencies[Cryptocurrency::S] = new Cryptocurrency(Cryptocurrency::S, 18, 'Sonic');
		$this->cryptocurrencies[Cryptocurrency::TOKEN] = new Cryptocurrency(Cryptocurrency::TOKEN, 9, 'TokenFI');
		$this->cryptocurrencies[Cryptocurrency::EIGEN] = new Cryptocurrency(Cryptocurrency::EIGEN, 18, 'EigenLayer');
		$this->cryptocurrencies[Cryptocurrency::JASMY] = new Cryptocurrency(Cryptocurrency::JASMY, 18, 'JasmyCoin');
		$this->cryptocurrencies[Cryptocurrency::STRK] = new Cryptocurrency(Cryptocurrency::STRK, 18, 'Starknet');
		$this->cryptocurrencies[Cryptocurrency::ATH] = new Cryptocurrency(Cryptocurrency::ATH, 18, 'Aethir');
		$this->cryptocurrencies[Cryptocurrency::BGB] = new Cryptocurrency(Cryptocurrency::BGB, 18, 'Bitget Token');
		$this->cryptocurrencies[Cryptocurrency::XEGLD] = new Cryptocurrency(Cryptocurrency::XEGLD, 18, 'MultiversX Egld');
		$this->cryptocurrencies[Cryptocurrency::KARATE] = new Cryptocurrency(Cryptocurrency::KARATE, 18, 'Karate Combat');
	}

}

