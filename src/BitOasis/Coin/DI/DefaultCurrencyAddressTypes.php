<?php

namespace BitOasis\Coin\DI;

use BitOasis\Coin\Address\AaveAddress;
use BitOasis\Coin\Address\AethirAddress;
use BitOasis\Coin\Address\AiozNetworkProtocolAddress;
use BitOasis\Coin\Address\AlgorandAddress;
use BitOasis\Coin\Address\AmpleforthAddress;
use BitOasis\Coin\Address\ApeCoinAddress;
use BitOasis\Coin\Address\AragonNetworkAddress;
use BitOasis\Coin\Address\ArbitrumAddress;
use BitOasis\Coin\Address\ArtificialSuperintelligenceAllianceAddress;
use BitOasis\Coin\Address\AssangeDaoAddress;
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
use BitOasis\Coin\Address\BitgetTokenAddress;
use BitOasis\Coin\Address\BitKanAddress;
use BitOasis\Coin\Address\BitpandaAddress;
use BitOasis\Coin\Address\BlurAddress;
use BitOasis\Coin\Address\BonkAddress;
use BitOasis\Coin\Address\BosonAddress;
use BitOasis\Coin\Address\CardanoAddress;
use BitOasis\Coin\Address\CatInADogsWorldAddress;
use BitOasis\Coin\Address\CelestiaAddress;
use BitOasis\Coin\Address\CeloAddress;
use BitOasis\Coin\Address\ChainlinkAddress;
use BitOasis\Coin\Address\ChilizAddress;
use BitOasis\Coin\Address\CompoundAddress;
use BitOasis\Coin\Address\CosmosAddress;
use BitOasis\Coin\Address\CurveAddress;
use BitOasis\Coin\Address\DaiAddress;
use BitOasis\Coin\Address\DataOwnershipProtocolAddress;
use BitOasis\Coin\Address\DecentralandAddress;
use BitOasis\Coin\Address\DeversifiTokenAddress;
use BitOasis\Coin\Address\DigibyteAddress;
use BitOasis\Coin\Address\DogecoinAddress;
use BitOasis\Coin\Address\DuskNetworkAddress;
use BitOasis\Coin\Address\EigenLayerAddress;
use BitOasis\Coin\Address\ElrondEgoldAddress;
use BitOasis\Coin\Address\EnjinAddress;
use BitOasis\Coin\Address\EosAddress;
use BitOasis\Coin\Address\EthenaAddress;
use BitOasis\Coin\Address\EthereumAddress;
use BitOasis\Coin\Address\EthereumClassicAddress;
use BitOasis\Coin\Address\EthereumPoWAddress;
use BitOasis\Coin\Address\FantomAddress;
use BitOasis\Coin\Address\FilecoinAddress;
use BitOasis\Coin\Address\FlareAddress;
use BitOasis\Coin\Address\FlokiAddress;
use BitOasis\Coin\Address\ForthAddress;
use BitOasis\Coin\Address\FractalAddress;
use BitOasis\Coin\Address\FtxAddress;
use BitOasis\Coin\Address\FunFairAddress;
use BitOasis\Coin\Address\GalaAddress;
use BitOasis\Coin\Address\GnosisAddress;
use BitOasis\Coin\Address\GominingAddress;
use BitOasis\Coin\Address\GraphAddress;
use BitOasis\Coin\Address\HumanAddress;
use BitOasis\Coin\Address\InjectiveAddress;
use BitOasis\Coin\Address\IotaAddress;
use BitOasis\Coin\Address\JasmyCoinAddress;
use BitOasis\Coin\Address\JupiterAddress;
use BitOasis\Coin\Address\KarateCombatAddress;
use BitOasis\Coin\Address\KavaAddress;
use BitOasis\Coin\Address\KlerosAddress;
use BitOasis\Coin\Address\KyberAddress;
use BitOasis\Coin\Address\KusamaAddress;
use BitOasis\Coin\Address\LeoAddress;
use BitOasis\Coin\Address\LidoDaoAddress;
use BitOasis\Coin\Address\LitecoinAddress;
use BitOasis\Coin\Address\LoopringAddress;
use BitOasis\Coin\Address\MagicInternetMoneyAddress;
use BitOasis\Coin\Address\MakerAddress;
use BitOasis\Coin\Address\MelonAddress;
use BitOasis\Coin\Address\MemecoinAddress;
use BitOasis\Coin\Address\MoneroAddress;
use BitOasis\Coin\Address\NearAddress;
use BitOasis\Coin\Address\NeoAddress;
use BitOasis\Coin\Address\NexoAddress;
use BitOasis\Coin\Address\OceanAddress;
use BitOasis\Coin\Address\OmiseGoAddress;
use BitOasis\Coin\Address\OneInchAddress;
use BitOasis\Coin\Address\OptimismAddress;
use BitOasis\Coin\Address\OriginProtocolAddress;
use BitOasis\Coin\Address\PaxosAddress;
use BitOasis\Coin\Address\PepeAddress;
use BitOasis\Coin\Address\PlutonAddress;
use BitOasis\Coin\Address\PolkadotAddress;
use BitOasis\Coin\Address\PolygonAddress;
use BitOasis\Coin\Address\OpenAddress;
use BitOasis\Coin\Address\PolygonEcosystemTokenAddress;
use BitOasis\Coin\Address\QtumAddress;
use BitOasis\Coin\Address\RallyAddress;
use BitOasis\Coin\Address\RequestNetworkAddress;
use BitOasis\Coin\Address\RippleAddress;
use BitOasis\Coin\Address\StarknetAddress;
use BitOasis\Coin\Address\SonicAddress;
use BitOasis\Coin\Address\SpectralAddress;
use BitOasis\Coin\Address\SweatEconomyAddress;
use BitOasis\Coin\Address\TheSandboxAddress;
use BitOasis\Coin\Address\SeiAddress;
use BitOasis\Coin\Address\ShibaInuAddress;
use BitOasis\Coin\Address\SidusAddress;
use BitOasis\Coin\Address\SolanaAddress;
use BitOasis\Coin\Address\SongbirdAddress;
use BitOasis\Coin\Address\SpellAddress;
use BitOasis\Coin\Address\StargateFinanceAddress;
use BitOasis\Coin\Address\StellarAddress;
use BitOasis\Coin\Address\StorjAddress;
use BitOasis\Coin\Address\SuiAddress;
use BitOasis\Coin\Address\SukuAddress;
use BitOasis\Coin\Address\SushiAddress;
use BitOasis\Coin\Address\SynthetixAddress;
use BitOasis\Coin\Address\TapAddress;
use BitOasis\Coin\Address\Terra2Address;
use BitOasis\Coin\Address\TerraAddress;
use BitOasis\Coin\Address\TetherAddress;
use BitOasis\Coin\Address\TetherTronAddress;
use BitOasis\Coin\Address\TezosAddress;
use BitOasis\Coin\Address\ThetaAddress;
use BitOasis\Coin\Address\TetherGoldAddress;
use BitOasis\Coin\Address\TokenFiAddress;
use BitOasis\Coin\Address\TomiAddress;
use BitOasis\Coin\Address\ToncoinAddress;
use BitOasis\Coin\Address\TronAddress;
use BitOasis\Coin\Address\TrueUsdAddress;
use BitOasis\Coin\Address\TurboAddress;
use BitOasis\Coin\Address\UltraAddress;
use BitOasis\Coin\Address\UniswapAddress;
use BitOasis\Coin\Address\UsdCoinAddress;
use BitOasis\Coin\Address\VeChainAddress;
use BitOasis\Coin\Address\VelarAddress;
use BitOasis\Coin\Address\VerasityAddress;
use BitOasis\Coin\Address\VergeAddress;
use BitOasis\Coin\Address\WavesAddress;
use BitOasis\Coin\Address\WhiteBitAddress;
use BitOasis\Coin\Address\WilderWorldAddress;
use BitOasis\Coin\Address\WooAddress;
use BitOasis\Coin\Address\WrappedBitcoinAddress;
use BitOasis\Coin\Address\XdcNetworkAddress;
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
		],
		Cryptocurrency::LDO => [
			CryptocurrencyNetwork::ETHEREUM => LidoDaoAddress::class
		],
		Cryptocurrency::BLUR => [
			CryptocurrencyNetwork::ETHEREUM => BlurAddress::class
		],
		Cryptocurrency::OP => [
			CryptocurrencyNetwork::ETHEREUM => OptimismAddress::class
		],
		Cryptocurrency::OPEN => [
			CryptocurrencyNetwork::ETHEREUM => OpenAddress::class
		],
		Cryptocurrency::BOSON => [
			CryptocurrencyNetwork::ETHEREUM => BosonAddress::class
		],
		Cryptocurrency::FLOKI => [
			CryptocurrencyNetwork::ETHEREUM => FlokiAddress::class
		],
		Cryptocurrency::VRA => [
			CryptocurrencyNetwork::ETHEREUM => VerasityAddress::class
		],
		Cryptocurrency::WILD => [
			CryptocurrencyNetwork::ETHEREUM => WilderWorldAddress::class
		],
		Cryptocurrency::SUI => [
			CryptocurrencyNetwork::SUI => SuiAddress::class
		],
		Cryptocurrency::SEI => [
			CryptocurrencyNetwork::SEI => SeiAddress::class
		],
		Cryptocurrency::XDC => [
			CryptocurrencyNetwork::XDC_NETWORK => XdcNetworkAddress::class
		],
		Cryptocurrency::TON => [
			CryptocurrencyNetwork::TON => ToncoinAddress::class
		],
		Cryptocurrency::AMPL => [
			CryptocurrencyNetwork::ETHEREUM => AmpleforthAddress::class
		],
		Cryptocurrency::BEST => [
			CryptocurrencyNetwork::ETHEREUM => BitpandaAddress::class
		],
		Cryptocurrency::CELO => [
			CryptocurrencyNetwork::CELO => CeloAddress::class
		],
		Cryptocurrency::DUSK => [
			CryptocurrencyNetwork::ETHEREUM => DuskNetworkAddress::class
		],
		Cryptocurrency::DVF => [
			CryptocurrencyNetwork::ETHEREUM => DeversifiTokenAddress::class
		],
		Cryptocurrency::FCL => [
			CryptocurrencyNetwork::ETHEREUM => FractalAddress::class
		],
		Cryptocurrency::FLR => [
			CryptocurrencyNetwork::FLARE => FlareAddress::class
		],
		Cryptocurrency::FORTH => [
			CryptocurrencyNetwork::ETHEREUM => ForthAddress::class
		],
		Cryptocurrency::FUN => [
			CryptocurrencyNetwork::ETHEREUM => FunFairAddress::class
		],
		Cryptocurrency::HMT => [
			CryptocurrencyNetwork::ETHEREUM => HumanAddress::class
		],
		Cryptocurrency::INJ => [
			CryptocurrencyNetwork::INJECTIVE => InjectiveAddress::class
		],
		Cryptocurrency::JUP => [
			CryptocurrencyNetwork::SOLANA => JupiterAddress::class
		],
		Cryptocurrency::KAVA => [
			CryptocurrencyNetwork::KAVA => KavaAddress::class
		],
		Cryptocurrency::MEME => [
			CryptocurrencyNetwork::ETHEREUM => MemecoinAddress::class
		],
		Cryptocurrency::MIM => [
			CryptocurrencyNetwork::ETHEREUM => MagicInternetMoneyAddress::class
		],
		Cryptocurrency::MLN => [
			CryptocurrencyNetwork::ETHEREUM => MelonAddress::class
		],
		Cryptocurrency::OGN => [
			CryptocurrencyNetwork::ETHEREUM => OriginProtocolAddress::class
		],
		Cryptocurrency::PAX => [
			CryptocurrencyNetwork::ETHEREUM => PaxosAddress::class
		],
		Cryptocurrency::PLU => [
			CryptocurrencyNetwork::ETHEREUM => PlutonAddress::class
		],
		Cryptocurrency::PNK => [
			CryptocurrencyNetwork::ETHEREUM => KlerosAddress::class
		],
		Cryptocurrency::REQ => [
			CryptocurrencyNetwork::ETHEREUM => RequestNetworkAddress::class
		],
		Cryptocurrency::SGB => [
			CryptocurrencyNetwork::SONGBIRD => SongbirdAddress::class
		],
		Cryptocurrency::SIDUS => [
			CryptocurrencyNetwork::ETHEREUM => SidusAddress::class
		],
		Cryptocurrency::SPELL => [
			CryptocurrencyNetwork::ETHEREUM => SpellAddress::class
		],
		Cryptocurrency::STG => [
			CryptocurrencyNetwork::ETHEREUM => StargateFinanceAddress::class
		],
		Cryptocurrency::SUKU => [
			CryptocurrencyNetwork::ETHEREUM => SukuAddress::class
		],
		Cryptocurrency::UOS => [
			CryptocurrencyNetwork::ETHEREUM => UltraAddress::class
		],
		Cryptocurrency::WOO => [
			CryptocurrencyNetwork::ETHEREUM => WooAddress::class
		],
		Cryptocurrency::XTP => [
			CryptocurrencyNetwork::ETHEREUM => TapAddress::class
		],
		Cryptocurrency::POL => [
			CryptocurrencyNetwork::ETHEREUM => PolygonEcosystemTokenAddress::class
		],
		Cryptocurrency::APE => [
			CryptocurrencyNetwork::ETHEREUM => ApeCoinAddress::class
		],
		Cryptocurrency::FET => [
			CryptocurrencyNetwork::ETHEREUM => ArtificialSuperintelligenceAllianceAddress::class
		],
		Cryptocurrency::RLY => [
			CryptocurrencyNetwork::ETHEREUM => RallyAddress::class
		],
		Cryptocurrency::SAND => [
			CryptocurrencyNetwork::ETHEREUM => TheSandboxAddress::class
		],
		Cryptocurrency::PEPE => [
			CryptocurrencyNetwork::ETHEREUM => PepeAddress::class
		],
		Cryptocurrency::BONK => [
			CryptocurrencyNetwork::SOLANA => BonkAddress::class
		],
		Cryptocurrency::TOMI => [
			CryptocurrencyNetwork::ETHEREUM => TomiAddress::class
		],
		Cryptocurrency::TURBO => [
			CryptocurrencyNetwork::ETHEREUM => TurboAddress::class
		],
		Cryptocurrency::WBT => [
			CryptocurrencyNetwork::ETHEREUM => WhiteBitAddress::class
		],
		Cryptocurrency::ENA => [
			CryptocurrencyNetwork::ETHEREUM => EthenaAddress::class
		],
		Cryptocurrency::MEW => [
			CryptocurrencyNetwork::SOLANA => CatInADogsWorldAddress::class
		],
		Cryptocurrency::TIA => [
			CryptocurrencyNetwork::CELESTIA => CelestiaAddress::class
		],
		Cryptocurrency::SWEAT => [
			CryptocurrencyNetwork::ETHEREUM => SweatEconomyAddress::class
		],
		Cryptocurrency::DOP => [
			CryptocurrencyNetwork::ETHEREUM => DataOwnershipProtocolAddress::class
		],
		Cryptocurrency::SPEC => [
			CryptocurrencyNetwork::ETHEREUM => SpectralAddress::class
		],
		Cryptocurrency::AIOZ => [
			CryptocurrencyNetwork::ETHEREUM => AiozNetworkProtocolAddress::class
		],
		Cryptocurrency::GOMINING => [
			CryptocurrencyNetwork::ETHEREUM => GominingAddress::class
		],
		Cryptocurrency::VELAR => [
			CryptocurrencyNetwork::ETHEREUM => VelarAddress::class
		],
		Cryptocurrency::JUSTICE => [
			CryptocurrencyNetwork::ETHEREUM => AssangeDaoAddress::class
		],
		Cryptocurrency::KAN => [
			CryptocurrencyNetwork::ETHEREUM => BitKanAddress::class
		],
		Cryptocurrency::S => [
			CryptocurrencyNetwork::SONIC => SonicAddress::class
		],
		Cryptocurrency::TOKEN => [
			CryptocurrencyNetwork::ETHEREUM => TokenFiAddress::class
		],
		Cryptocurrency::EIGEN => [
			CryptocurrencyNetwork::ETHEREUM => EigenLayerAddress::class
		],
		Cryptocurrency::JASMY => [
			CryptocurrencyNetwork::ETHEREUM => JasmyCoinAddress::class
		],
		Cryptocurrency::STRK => [
			CryptocurrencyNetwork::ETHEREUM => StarknetAddress::class
		],
		Cryptocurrency::ATH => [
			CryptocurrencyNetwork::ETHEREUM => AethirAddress::class
		],
		Cryptocurrency::BGB => [
			CryptocurrencyNetwork::ETHEREUM => BitgetTokenAddress::class
		],
		Cryptocurrency::KARATE => [
			CryptocurrencyNetwork::ETHEREUM => KarateCombatAddress::class
		],
	];

}
