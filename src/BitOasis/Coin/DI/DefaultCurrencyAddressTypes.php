<?php

namespace BitOasis\Coin\DI;

use BitOasis\Coin\Address\AlgorandAddress;
use BitOasis\Coin\Address\AvalancheXChainAddress;
use BitOasis\Coin\Address\BitcoinAddress;
use BitOasis\Coin\Address\BitcoinCashAddress;
use BitOasis\Coin\Address\BitcoinGoldAddress;
use BitOasis\Coin\Address\BitcoinSvAddress;
use BitOasis\Coin\Address\CardanoAddress;
use BitOasis\Coin\Address\CeloAddress;
use BitOasis\Coin\Address\CosmosAddress;
use BitOasis\Coin\Address\DigibyteAddress;
use BitOasis\Coin\Address\DogecoinAddress;
use BitOasis\Coin\Address\ElrondEgoldAddress;
use BitOasis\Coin\Address\EosAddress;
use BitOasis\Coin\Address\EthereumAddress;
use BitOasis\Coin\Address\EthereumClassicAddress;
use BitOasis\Coin\Address\FantomAddress;
use BitOasis\Coin\Address\FilecoinAddress;
use BitOasis\Coin\Address\FlareAddress;
use BitOasis\Coin\Address\InjectiveAddress;
use BitOasis\Coin\Address\IotaAddress;
use BitOasis\Coin\Address\KavaAddress;
use BitOasis\Coin\Address\KusamaAddress;
use BitOasis\Coin\Address\LitecoinAddress;
use BitOasis\Coin\Address\MoneroAddress;
use BitOasis\Coin\Address\NearAddress;
use BitOasis\Coin\Address\NeoAddress;
use BitOasis\Coin\Address\PolkadotAddress;
use BitOasis\Coin\Address\QtumAddress;
use BitOasis\Coin\Address\RippleAddress;
use BitOasis\Coin\Address\SeiAddress;
use BitOasis\Coin\Address\SolanaAddress;
use BitOasis\Coin\Address\SongbirdAddress;
use BitOasis\Coin\Address\StellarAddress;
use BitOasis\Coin\Address\SuiAddress;
use BitOasis\Coin\Address\Terra2Address;
use BitOasis\Coin\Address\TerraAddress;
use BitOasis\Coin\Address\TezosAddress;
use BitOasis\Coin\Address\ThetaAddress;
use BitOasis\Coin\Address\ToncoinAddress;
use BitOasis\Coin\Address\TronAddress;
use BitOasis\Coin\Address\VeChainAddress;
use BitOasis\Coin\Address\VergeAddress;
use BitOasis\Coin\Address\WavesAddress;
use BitOasis\Coin\Address\XdcNetworkAddress;
use BitOasis\Coin\Address\ZcashAddress;
use BitOasis\Coin\CryptocurrencyNetwork;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
final class DefaultCurrencyAddressTypes {

	const NETWORKS_ADDRESS_MAP = [
		CryptocurrencyNetwork::BITCOIN => BitcoinAddress::class,
		CryptocurrencyNetwork::BITCOIN_SV => BitcoinSvAddress::class,
		CryptocurrencyNetwork::BITCOIN_CASH => BitcoinCashAddress::class,
		CryptocurrencyNetwork::ETHEREUM => EthereumAddress::class,
		CryptocurrencyNetwork::ETHEREUM_CLASSIC => EthereumClassicAddress::class,
		CryptocurrencyNetwork::RIPPLE => RippleAddress::class,
		CryptocurrencyNetwork::LITECOIN => LitecoinAddress::class,
		CryptocurrencyNetwork::ZCASH => ZcashAddress::class,
		CryptocurrencyNetwork::STELLAR_LUMEN => StellarAddress::class,
		CryptocurrencyNetwork::MONERO => MoneroAddress::class,
		CryptocurrencyNetwork::EOS => EosAddress::class,
		CryptocurrencyNetwork::ALGORAND => AlgorandAddress::class,
		CryptocurrencyNetwork::TRON => TronAddress::class,
		CryptocurrencyNetwork::NEO => NeoAddress::class,
		CryptocurrencyNetwork::TEZOS => TezosAddress::class,
		CryptocurrencyNetwork::DOGECOIN => DogecoinAddress::class,
		CryptocurrencyNetwork::WAVES => WavesAddress::class,
		CryptocurrencyNetwork::POLKADOT => PolkadotAddress::class,
		CryptocurrencyNetwork::SOLANA => SolanaAddress::class,
		CryptocurrencyNetwork::CARDANO => CardanoAddress::class,
		CryptocurrencyNetwork::AVALANCHE_C => EthereumAddress::class,
		CryptocurrencyNetwork::AVALANCHE_X => AvalancheXChainAddress::class,
		CryptocurrencyNetwork::FANTOM => FantomAddress::class,
		CryptocurrencyNetwork::COSMOS => CosmosAddress::class,
		CryptocurrencyNetwork::NEAR => NearAddress::class,
		CryptocurrencyNetwork::DIGIBYTE => DigibyteAddress::class,
		CryptocurrencyNetwork::ELRONG_EGOLD => ElrondEgoldAddress::class,
		CryptocurrencyNetwork::FILECOIN => FilecoinAddress::class,
		CryptocurrencyNetwork::IOTA => IotaAddress::class,
		CryptocurrencyNetwork::KUSAMA => KusamaAddress::class,
		CryptocurrencyNetwork::QTUM => QtumAddress::class,
		CryptocurrencyNetwork::THETA => ThetaAddress::class,
		CryptocurrencyNetwork::TERRA => TerraAddress::class,
		CryptocurrencyNetwork::VE_CHAIN => VeChainAddress::class,
		CryptocurrencyNetwork::VERGE => VergeAddress::class,
		CryptocurrencyNetwork::TERRA2 => Terra2Address::class,
		CryptocurrencyNetwork::ETHEREUM_POW => EthereumAddress::class,
		CryptocurrencyNetwork::BITCOIN_GOLD => BitcoinGoldAddress::class,
		CryptocurrencyNetwork::SUI => SuiAddress::class,
		CryptocurrencyNetwork::SEI => SeiAddress::class,
		CryptocurrencyNetwork::XDC_NETWORK => XdcNetworkAddress::class,
		CryptocurrencyNetwork::TON => ToncoinAddress::class,
		CryptocurrencyNetwork::CELO => CeloAddress::class,
		CryptocurrencyNetwork::FLARE => FlareAddress::class,
		CryptocurrencyNetwork::INJECTIVE => InjectiveAddress::class,
		CryptocurrencyNetwork::KAVA => KavaAddress::class,
		CryptocurrencyNetwork::SONGBIRD => SongbirdAddress::class
	];
}
