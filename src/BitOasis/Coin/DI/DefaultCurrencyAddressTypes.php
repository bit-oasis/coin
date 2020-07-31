<?php

namespace BitOasis\Coin\DI;

use BitOasis\Coin\Address\AlgorandAddress;
use BitOasis\Coin\Address\AugurAddress;
use BitOasis\Coin\Address\BasicAttentionTokenAddress;
use BitOasis\Coin\Address\BitcoinAddress;
use BitOasis\Coin\Address\BitcoinCashAddress;
use BitOasis\Coin\Address\BitcoinSvAddress;
use BitOasis\Coin\Address\BitcoinTestnetAddress;
use BitOasis\Coin\Address\ChainlinkAddress;
use BitOasis\Coin\Address\DaiAddress;
use BitOasis\Coin\Address\EosAddress;
use BitOasis\Coin\Address\EthereumAddress;
use BitOasis\Coin\Address\EthereumClassicAddress;
use BitOasis\Coin\Address\KyberAddress;
use BitOasis\Coin\Address\LitecoinAddress;
use BitOasis\Coin\Address\MakerAddress;
use BitOasis\Coin\Address\MoneroAddress;
use BitOasis\Coin\Address\NeoAddress;
use BitOasis\Coin\Address\OmiseGoAddress;
use BitOasis\Coin\Address\RippleAddress;
use BitOasis\Coin\Address\StellarAddress;
use BitOasis\Coin\Address\TetherAddress;
use BitOasis\Coin\Address\TezosAddress;
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
	];

}
