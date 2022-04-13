<?php

namespace BitOasis\Coin\DI;

use BitOasis\Coin\Address\AaveAddress;
use BitOasis\Coin\Address\AlgorandAddress;
use BitOasis\Coin\Address\AmpleforthAddress;
use BitOasis\Coin\Address\AragonNetworkAddress;
use BitOasis\Coin\Address\AugurAddress;
use BitOasis\Coin\Address\AvalancheCChainAddress;
use BitOasis\Coin\Address\AxieInfinityAddress;
use BitOasis\Coin\Address\BalancerAddress;
use BitOasis\Coin\Address\BancorAddress;
use BitOasis\Coin\Address\BandProtocolAddress;
use BitOasis\Coin\Address\BasicAttentionTokenAddress;
use BitOasis\Coin\Address\BitcoinAddress;
use BitOasis\Coin\Address\BitcoinCashAddress;
use BitOasis\Coin\Address\BitcoinSvAddress;
use BitOasis\Coin\Address\BitcoinTestnetAddress;
use BitOasis\Coin\Address\CardanoAddress;
use BitOasis\Coin\Address\ChainlinkAddress;
use BitOasis\Coin\Address\ChilizAddress;
use BitOasis\Coin\Address\CompoundAddress;
use BitOasis\Coin\Address\CosmosAddress;
use BitOasis\Coin\Address\CurveAddress;
use BitOasis\Coin\Address\DaiAddress;
use BitOasis\Coin\Address\DecentralandAddress;
use BitOasis\Coin\Address\DogecoinAddress;
use BitOasis\Coin\Address\EnjinAddress;
use BitOasis\Coin\Address\EosAddress;
use BitOasis\Coin\Address\EthereumAddress;
use BitOasis\Coin\Address\EthereumClassicAddress;
use BitOasis\Coin\Address\FantomERC20Address;
use BitOasis\Coin\Address\FtxAddress;
use BitOasis\Coin\Address\KyberAddress;
use BitOasis\Coin\Address\LitecoinAddress;
use BitOasis\Coin\Address\LoopringAddress;
use BitOasis\Coin\Address\MakerAddress;
use BitOasis\Coin\Address\MoneroAddress;
use BitOasis\Coin\Address\NearAddress;
use BitOasis\Coin\Address\NeoAddress;
use BitOasis\Coin\Address\OmiseGoAddress;
use BitOasis\Coin\Address\OneInchAddress;
use BitOasis\Coin\Address\PolkadotAddress;
use BitOasis\Coin\Address\PolygonAddress;
use BitOasis\Coin\Address\RippleAddress;
use BitOasis\Coin\Address\ShibaInuAddress;
use BitOasis\Coin\Address\SolanaAddress;
use BitOasis\Coin\Address\StellarAddress;
use BitOasis\Coin\Address\StorjAddress;
use BitOasis\Coin\Address\SushiAddress;
use BitOasis\Coin\Address\SynthetixAddress;
use BitOasis\Coin\Address\TerraAddress;
use BitOasis\Coin\Address\TetherAddress;
use BitOasis\Coin\Address\TezosAddress;
use BitOasis\Coin\Address\UniswapAddress;
use BitOasis\Coin\Address\UsdCoinAddress;
use BitOasis\Coin\Address\WavesAddress;
use BitOasis\Coin\Address\WrappedBitcoinAddress;
use BitOasis\Coin\Address\YearnFinanceAddress;
use BitOasis\Coin\Address\ZcashAddress;
use BitOasis\Coin\Address\ZeroXAddress;
use BitOasis\Coin\Cryptocurrency;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
final class DefaultCurrencyAddressTypes {

	const TYPES = [
		Cryptocurrency::BTC => BitcoinAddress::class,
		Cryptocurrency::TBTC => BitcoinTestnetAddress::class,
		Cryptocurrency::ETH => EthereumAddress::class,
		Cryptocurrency::ETC => EthereumClassicAddress::class,
		Cryptocurrency::XRP => RippleAddress::class,
		Cryptocurrency::LTC => LitecoinAddress::class,
		Cryptocurrency::BCH => BitcoinCashAddress::class,
		Cryptocurrency::ZEC => ZcashAddress::class,
		Cryptocurrency::XLM => StellarAddress::class,
		Cryptocurrency::XMR => MoneroAddress::class,
		Cryptocurrency::BSV => BitcoinSvAddress::class,
		Cryptocurrency::EOS => EosAddress::class,
		Cryptocurrency::OMG => OmiseGoAddress::class,
		Cryptocurrency::ZRX => ZeroXAddress::class,
		Cryptocurrency::BAT => BasicAttentionTokenAddress::class,
		Cryptocurrency::ALGO => AlgorandAddress::class,
		Cryptocurrency::USDT => TetherAddress::class,
		Cryptocurrency::NEO => NeoAddress::class,
		Cryptocurrency::XTZ => TezosAddress::class,
		Cryptocurrency::LINK => ChainlinkAddress::class,
		Cryptocurrency::DAI => DaiAddress::class,
		Cryptocurrency::MKR => MakerAddress::class,
		Cryptocurrency::KNC => KyberAddress::class,
		Cryptocurrency::REP => AugurAddress::class,
		Cryptocurrency::UNI => UniswapAddress::class,
		Cryptocurrency::YFI => YearnFinanceAddress::class,
		Cryptocurrency::BAL => BalancerAddress::class,
		Cryptocurrency::COMP => CompoundAddress::class,
		Cryptocurrency::SNX => SynthetixAddress::class,
		Cryptocurrency::DOGE => DogecoinAddress::class,
		Cryptocurrency::AAVE => AaveAddress::class,
		Cryptocurrency::BNT => BancorAddress::class,
		Cryptocurrency::ENJ => EnjinAddress::class,
		Cryptocurrency::LRC => LoopringAddress::class,
		Cryptocurrency::MANA => DecentralandAddress::class,
		Cryptocurrency::MATIC => PolygonAddress::class,
		Cryptocurrency::STORJ => StorjAddress::class,
		Cryptocurrency::SUSHI => SushiAddress::class,
		Cryptocurrency::USDC => UsdCoinAddress::class,
		Cryptocurrency::WAVES => WavesAddress::class,
		Cryptocurrency::DOT => PolkadotAddress::class,
		Cryptocurrency::SOL => SolanaAddress::class,
		Cryptocurrency::ADA => CardanoAddress::class,
		Cryptocurrency::SHIB => ShibaInuAddress::class,
		Cryptocurrency::AVAX => AvalancheCChainAddress::class,
		Cryptocurrency::FTM => FantomERC20Address::class,
		Cryptocurrency::WBTC => WrappedBitcoinAddress::class,
		Cryptocurrency::LUNA => TerraAddress::class,
		Cryptocurrency::ATOM => CosmosAddress::class,
		Cryptocurrency::NEAR => NearAddress::class,
		Cryptocurrency::ONE_INCH => OneInchAddress::class,
		Cryptocurrency::AMPL => AmpleforthAddress::class,
		Cryptocurrency::ANT => AragonNetworkAddress::class,
		Cryptocurrency::AXS => AxieInfinityAddress::class,
		Cryptocurrency::BAND => BandProtocolAddress::class,
		Cryptocurrency::CHZ => ChilizAddress::class,
		Cryptocurrency::CRV => CurveAddress::class,
		Cryptocurrency::FTT => FtxAddress::class,
	];

}
