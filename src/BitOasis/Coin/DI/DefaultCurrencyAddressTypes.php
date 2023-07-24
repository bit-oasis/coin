<?php

namespace BitOasis\Coin\DI;

use BitOasis\Coin\Address\AaveAddress;
use BitOasis\Coin\Address\AlgorandAddress;
use BitOasis\Coin\Address\AragonNetworkAddress;
use BitOasis\Coin\Address\ArbitrumAddress;
use BitOasis\Coin\Address\AugurAddress;
use BitOasis\Coin\Address\AvalancheCChainAddress;
use BitOasis\Coin\Address\AvalancheXChainAddress;
use BitOasis\Coin\Address\AxieInfinityAddress;
use BitOasis\Coin\Address\BalancerAddress;
use BitOasis\Coin\Address\BancorAddress;
use BitOasis\Coin\Address\BandProtocolAddress;
use BitOasis\Coin\Address\BasicAttentionTokenAddress;
use BitOasis\Coin\Address\BitcoinAddress;
use BitOasis\Coin\Address\BitcoinCashAddress;
use BitOasis\Coin\Address\BitcoinGoldAddress;
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
use BitOasis\Coin\Address\DigibyteAddress;
use BitOasis\Coin\Address\DogecoinAddress;
use BitOasis\Coin\Address\ElrondEgoldAddress;
use BitOasis\Coin\Address\EnjinAddress;
use BitOasis\Coin\Address\EosAddress;
use BitOasis\Coin\Address\EthereumAddress;
use BitOasis\Coin\Address\EthereumClassicAddress;
use BitOasis\Coin\Address\EthereumPoWAddress;
use BitOasis\Coin\Address\FantomAddress;
use BitOasis\Coin\Address\FilecoinAddress;
use BitOasis\Coin\Address\FtxAddress;
use BitOasis\Coin\Address\GalaAddress;
use BitOasis\Coin\Address\GnosisAddress;
use BitOasis\Coin\Address\GraphAddress;
use BitOasis\Coin\Address\IotaAddress;
use BitOasis\Coin\Address\KyberAddress;
use BitOasis\Coin\Address\KusamaAddress;
use BitOasis\Coin\Address\LeoAddress;
use BitOasis\Coin\Address\LitecoinAddress;
use BitOasis\Coin\Address\LoopringAddress;
use BitOasis\Coin\Address\MakerAddress;
use BitOasis\Coin\Address\MoneroAddress;
use BitOasis\Coin\Address\NearAddress;
use BitOasis\Coin\Address\NeoAddress;
use BitOasis\Coin\Address\NexoAddress;
use BitOasis\Coin\Address\OceanAddress;
use BitOasis\Coin\Address\OmiseGoAddress;
use BitOasis\Coin\Address\OneInchAddress;
use BitOasis\Coin\Address\PolkadotAddress;
use BitOasis\Coin\Address\PolygonAddress;
use BitOasis\Coin\Address\QtumAddress;
use BitOasis\Coin\Address\RippleAddress;
use BitOasis\Coin\Address\ShibaInuAddress;
use BitOasis\Coin\Address\SolanaAddress;
use BitOasis\Coin\Address\StellarAddress;
use BitOasis\Coin\Address\StorjAddress;
use BitOasis\Coin\Address\SushiAddress;
use BitOasis\Coin\Address\SynthetixAddress;
use BitOasis\Coin\Address\Terra2Address;
use BitOasis\Coin\Address\TerraAddress;
use BitOasis\Coin\Address\TetherAddress;
use BitOasis\Coin\Address\TetherTronAddress;
use BitOasis\Coin\Address\TezosAddress;
use BitOasis\Coin\Address\ThetaAddress;
use BitOasis\Coin\Address\TetherGoldAddress;
use BitOasis\Coin\Address\TronAddress;
use BitOasis\Coin\Address\TrueUsdAddress;
use BitOasis\Coin\Address\UniswapAddress;
use BitOasis\Coin\Address\UsdCoinAddress;
use BitOasis\Coin\Address\VeChainAddress;
use BitOasis\Coin\Address\VergeAddress;
use BitOasis\Coin\Address\WavesAddress;
use BitOasis\Coin\Address\WrappedBitcoinAddress;
use BitOasis\Coin\Address\YearnFinanceAddress;
use BitOasis\Coin\Address\ZcashAddress;
use BitOasis\Coin\Address\ZeroXAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
final class DefaultCurrencyAddressTypes {

	const TYPES = [
		Cryptocurrency::BTC => [
			CryptocurrencyNetwork::BITCOIN => BitcoinAddress::class
		],
		Cryptocurrency::TBTC => [
			CryptocurrencyNetwork::BITCOIN => BitcoinTestnetAddress::class
		],
		Cryptocurrency::ETH => [
			CryptocurrencyNetwork::ETHEREUM => EthereumAddress::class
		],
		Cryptocurrency::ETC => [
			CryptocurrencyNetwork::ETHEREUM_CLASSIC => EthereumClassicAddress::class
		],
		Cryptocurrency::XRP => [
			CryptocurrencyNetwork::RIPPLE => RippleAddress::class
		],
		Cryptocurrency::LTC => [
			CryptocurrencyNetwork::LITECOIN => LitecoinAddress::class
		],
		Cryptocurrency::BCH => [
			CryptocurrencyNetwork::BITCOIN_CASH => BitcoinCashAddress::class
		],
		Cryptocurrency::ZEC => [
			CryptocurrencyNetwork::ZCASH => ZcashAddress::class
		],
		Cryptocurrency::XLM => [
			CryptocurrencyNetwork::STELLAR_LUMEN => StellarAddress::class
		],
		Cryptocurrency::XMR => [
			CryptocurrencyNetwork::MONERO => MoneroAddress::class
		],
		Cryptocurrency::BSV => [
			CryptocurrencyNetwork::BITCOIN => BitcoinSvAddress::class
		],
		Cryptocurrency::EOS => [
			CryptocurrencyNetwork::EOS => EosAddress::class
		],
		Cryptocurrency::OMG => [
			CryptocurrencyNetwork::ETHEREUM => OmiseGoAddress::class
		],
		Cryptocurrency::ZRX => [
			CryptocurrencyNetwork::ETHEREUM => ZeroXAddress::class
		],
		Cryptocurrency::BAT => [
			CryptocurrencyNetwork::ETHEREUM => BasicAttentionTokenAddress::class
		],
		Cryptocurrency::ALGO => [
			CryptocurrencyNetwork::ALGORAND => AlgorandAddress::class
		],
		Cryptocurrency::USDT => [
			CryptocurrencyNetwork::ETHEREUM => TetherAddress::class,
			CryptocurrencyNetwork::TRON => TetherTronAddress::class
		],
		Cryptocurrency::NEO => [
			CryptocurrencyNetwork::NEO => NeoAddress::class
		],
		Cryptocurrency::XTZ => [
			CryptocurrencyNetwork::TEZOS => TezosAddress::class
		],
		Cryptocurrency::LINK => [
			CryptocurrencyNetwork::ETHEREUM => ChainlinkAddress::class
		],
		Cryptocurrency::DAI => [
			CryptocurrencyNetwork::ETHEREUM => DaiAddress::class
		],
		Cryptocurrency::MKR => [
			CryptocurrencyNetwork::ETHEREUM => MakerAddress::class
		],
		Cryptocurrency::KNC => [
			CryptocurrencyNetwork::ETHEREUM => KyberAddress::class
		],
		Cryptocurrency::REP => [
			CryptocurrencyNetwork::ETHEREUM => AugurAddress::class
		],
		Cryptocurrency::UNI => [
			CryptocurrencyNetwork::ETHEREUM => UniswapAddress::class
		],
		Cryptocurrency::YFI => [
			CryptocurrencyNetwork::ETHEREUM => YearnFinanceAddress::class
		],
		Cryptocurrency::BAL => [
			CryptocurrencyNetwork::ETHEREUM => BalancerAddress::class
		],
		Cryptocurrency::COMP => [
			CryptocurrencyNetwork::ETHEREUM => CompoundAddress::class
		],
		Cryptocurrency::DOGE => [
			CryptocurrencyNetwork::DOGECOIN => DogecoinAddress::class
		],
		Cryptocurrency::AAVE => [
			CryptocurrencyNetwork::ETHEREUM => AaveAddress::class
		],
		Cryptocurrency::BNT => [
			CryptocurrencyNetwork::ETHEREUM => BancorAddress::class
		],
		Cryptocurrency::ENJ => [
			CryptocurrencyNetwork::ETHEREUM => EnjinAddress::class
		],
		Cryptocurrency::LRC => [
			CryptocurrencyNetwork::ETHEREUM => LoopringAddress::class
		],
		Cryptocurrency::MANA => [
			CryptocurrencyNetwork::ETHEREUM => DecentralandAddress::class
		],
		Cryptocurrency::MATIC => [
			CryptocurrencyNetwork::ETHEREUM => PolygonAddress::class
		],
		Cryptocurrency::STORJ => [
			CryptocurrencyNetwork::ETHEREUM => StorjAddress::class
		],
		Cryptocurrency::SUSHI => [
			CryptocurrencyNetwork::ETHEREUM => SushiAddress::class
		],
		Cryptocurrency::USDC => [
			CryptocurrencyNetwork::ETHEREUM => UsdCoinAddress::class
		],
		Cryptocurrency::WAVES => [
			CryptocurrencyNetwork::WAVES => WavesAddress::class
		],
		Cryptocurrency::DOT => [
			CryptocurrencyNetwork::POLKADOT => PolkadotAddress::class
		],
		Cryptocurrency::SOL => [
			CryptocurrencyNetwork::SOLANA => SolanaAddress::class
		],
		Cryptocurrency::ADA => [
			CryptocurrencyNetwork::CARDANO => CardanoAddress::class
		],
		Cryptocurrency::SHIB => [
			CryptocurrencyNetwork::ETHEREUM => ShibaInuAddress::class
		],
		Cryptocurrency::AVAX => [
//			CryptocurrencyNetwork::AVALANCHE_C => AvalancheCChainAddress::class,
			CryptocurrencyNetwork::AVALANCHE_X => AvalancheXChainAddress::class,
		],
		Cryptocurrency::FTM => [
			CryptocurrencyNetwork::FANTOM => FantomAddress::class
		],
		Cryptocurrency::WBTC => [
			CryptocurrencyNetwork::ETHEREUM => WrappedBitcoinAddress::class
		],
		Cryptocurrency::LUNA => [
			CryptocurrencyNetwork::TERRA => TerraAddress::class
		],
		Cryptocurrency::ATOM => [
			CryptocurrencyNetwork::COSMOS => CosmosAddress::class
		],
		Cryptocurrency::NEAR => [
			CryptocurrencyNetwork::NEAR => NearAddress::class
		],
		Cryptocurrency::ONE_INCH => [
			CryptocurrencyNetwork::ETHEREUM => OneInchAddress::class
		],
		Cryptocurrency::ANT => [
			CryptocurrencyNetwork::ETHEREUM => AragonNetworkAddress::class
		],
		Cryptocurrency::AXS => [
			CryptocurrencyNetwork::ETHEREUM => AxieInfinityAddress::class
		],
		Cryptocurrency::BAND => [
			CryptocurrencyNetwork::ETHEREUM => BandProtocolAddress::class
		],
		Cryptocurrency::CHZ => [
			CryptocurrencyNetwork::ETHEREUM => ChilizAddress::class
		],
		Cryptocurrency::CRV => [
			CryptocurrencyNetwork::ETHEREUM => CurveAddress::class
		],
		Cryptocurrency::FTT => [
			CryptocurrencyNetwork::ETHEREUM => FtxAddress::class
		],
		Cryptocurrency::GALA => [
			CryptocurrencyNetwork::ETHEREUM => GalaAddress::class
		],
		Cryptocurrency::GNO => [
			CryptocurrencyNetwork::ETHEREUM => GnosisAddress::class
		],
		Cryptocurrency::GRT => [
			CryptocurrencyNetwork::ETHEREUM => GraphAddress::class
		],
		Cryptocurrency::LEO => [
			CryptocurrencyNetwork::ETHEREUM => LeoAddress::class
		],
		Cryptocurrency::NEXO => [
			CryptocurrencyNetwork::ETHEREUM => NexoAddress::class
		],
		Cryptocurrency::OCEAN => [
			CryptocurrencyNetwork::ETHEREUM => OceanAddress::class
		],
		Cryptocurrency::SNX => [
			CryptocurrencyNetwork::ETHEREUM => SynthetixAddress::class
		],
		Cryptocurrency::TUSD => [
			CryptocurrencyNetwork::ETHEREUM => TrueUsdAddress::class
		],
		Cryptocurrency::DGB => [
			CryptocurrencyNetwork::DIGIBYTE => DigibyteAddress::class
		],
		Cryptocurrency::EGLD => [
			CryptocurrencyNetwork::ELRONG_EGOLD => ElrondEgoldAddress::class
		],
		Cryptocurrency::FIL => [
			CryptocurrencyNetwork::FILECOIN => FilecoinAddress::class
		],
		Cryptocurrency::IOTA => [
			CryptocurrencyNetwork::IOTA => IotaAddress::class
		],
		Cryptocurrency::KSM => [
			CryptocurrencyNetwork::KUSAMA => KusamaAddress::class
		],
		Cryptocurrency::QTUM => [
			CryptocurrencyNetwork::QTUM => QtumAddress::class
		],
		Cryptocurrency::THETA => [
			CryptocurrencyNetwork::THETA => ThetaAddress::class
		],
		Cryptocurrency::TRX => [
			CryptocurrencyNetwork::TRON => TronAddress::class
		],
		Cryptocurrency::UST => [
			CryptocurrencyNetwork::TERRA => TerraAddress::class
		],
		Cryptocurrency::VET => [
			CryptocurrencyNetwork::VE_CHAIN => VeChainAddress::class
		],
		Cryptocurrency::XVG => [
			CryptocurrencyNetwork::VERGE => VergeAddress::class
		],
		Cryptocurrency::LUNA2 => [
			CryptocurrencyNetwork::TERRA2 => Terra2Address::class
		],
		Cryptocurrency::ETHW => [
			CryptocurrencyNetwork::ETHEREUM_POW => EthereumPoWAddress::class
		],
		Cryptocurrency::XAUT => [
			CryptocurrencyNetwork::ETHEREUM => TetherGoldAddress::class
		],
		Cryptocurrency::ARB => [
			CryptocurrencyNetwork::ETHEREUM => ArbitrumAddress::class
		],
		Cryptocurrency::BTG => [
			CryptocurrencyNetwork::BITCOIN_GOLD => BitcoinGoldAddress::class
		]
	];

}
