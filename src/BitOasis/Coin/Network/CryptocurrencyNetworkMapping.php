<?php

namespace BitOasis\Coin\Network;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\DefaultCryptocurrencyNetworkFactory;
use BitOasis\Coin\Exception\InvalidNetworkException;
use BitOasis\Coin\Exception\NetworkNotDefinedForCryptocurrency;

/**
 * Static class is holding only mappings for cryptocurrency -> network!
 */
final class CryptocurrencyNetworkMapping {

	const MAPPINGS = [
		Cryptocurrency::BTC => [
			CryptocurrencyNetwork::BITCOIN
		],
		Cryptocurrency::TBTC => [],
		Cryptocurrency::ETH => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::ETC => [
			CryptocurrencyNetwork::ETHEREUM_CLASSIC
		],
		Cryptocurrency::XRP => [
			CryptocurrencyNetwork::RIPPLE
		],
		Cryptocurrency::LTC => [
			CryptocurrencyNetwork::LITECOIN
		],
		Cryptocurrency::BCH => [
			CryptocurrencyNetwork::BITCOIN_CASH
		],
		Cryptocurrency::ZEC => [
			CryptocurrencyNetwork::ZCASH
		],
		Cryptocurrency::XLM => [
			CryptocurrencyNetwork::STELLAR_LUMEN
		],
		Cryptocurrency::EOS => [
			CryptocurrencyNetwork::EOS
		],
		Cryptocurrency::XMR => [
			CryptocurrencyNetwork::MONERO
		],
		Cryptocurrency::BSV => [
			CryptocurrencyNetwork::BITCOIN
		],
		Cryptocurrency::OMG => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::ZRX => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::BAT => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::ALGO => [
			CryptocurrencyNetwork::ALGORAND
		],
		Cryptocurrency::USDT => [
			CryptocurrencyNetwork::ETHEREUM,
		],
		Cryptocurrency::NEO => [
			CryptocurrencyNetwork::NEO
		],
		Cryptocurrency::XTZ => [
			CryptocurrencyNetwork::TEZOS
		],
		Cryptocurrency::LINK => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::DAI => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::MKR => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::KNC => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::REP => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::UNI => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::YFI => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::BAL => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::COMP => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::DOGE => [
			CryptocurrencyNetwork::DOGECOIN
		],
		Cryptocurrency::AAVE => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::BNT => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::ENJ => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::LRC => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::MANA => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::MATIC => [
			CryptocurrencyNetwork::ETHEREUM,
		],
		Cryptocurrency::STORJ => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::SUSHI => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::USDC => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::WAVES => [
			CryptocurrencyNetwork::WAVES
		],
		Cryptocurrency::DOT => [
			CryptocurrencyNetwork::POLKADOT
		],
		Cryptocurrency::SOL => [
			CryptocurrencyNetwork::SOLANA
		],
		Cryptocurrency::ADA => [
			CryptocurrencyNetwork::CARDANO
		],
		Cryptocurrency::SHIB => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::FTM => [
			CryptocurrencyNetwork::FANTOM
		],
		Cryptocurrency::WBTC => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::LUNA => [
			CryptocurrencyNetwork::TERRA
		],
		Cryptocurrency::ATOM => [
			CryptocurrencyNetwork::COSMOS
		],
		Cryptocurrency::NEAR => [
			CryptocurrencyNetwork::NEAR
		],
		Cryptocurrency::AVAX => [
			CryptocurrencyNetwork::AVALANCHE_X
		],
		Cryptocurrency::ONE_INCH => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::ANT => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::AXS => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::BAND => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::CHZ => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::CRV => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::FTT => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::GALA => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::GNO => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::GRT => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::LEO => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::NEXO => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::OCEAN => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::SNX => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::TUSD => [
			CryptocurrencyNetwork::ETHEREUM
		],
		Cryptocurrency::DGB => [
			CryptocurrencyNetwork::DIGIBYTE
		],
		Cryptocurrency::EGLD => [
			CryptocurrencyNetwork::ELRONG_EGOLD
		],
		Cryptocurrency::FIL => [
			CryptocurrencyNetwork::FILECOIN
		],
		Cryptocurrency::IOTA => [
			CryptocurrencyNetwork::IOTA
		],
		Cryptocurrency::KSM => [
			CryptocurrencyNetwork::KUSAMA
		],
		Cryptocurrency::QTUM => [
			CryptocurrencyNetwork::QTUM
		],
		Cryptocurrency::THETA => [
			CryptocurrencyNetwork::THETA
		],
		Cryptocurrency::TRX => [
			CryptocurrencyNetwork::TRON
		],
		Cryptocurrency::UST => [
			CryptocurrencyNetwork::TERRA
		],
		Cryptocurrency::VET => [
			CryptocurrencyNetwork::VE_CHAIN
		],
		Cryptocurrency::XVG => [
			CryptocurrencyNetwork::VERGE
		],
		Cryptocurrency::LUNA2 => [
			CryptocurrencyNetwork::TERRA2
		],
	];

	/**
	 * @param Cryptocurrency $cryptocurrency
	 * @return CryptocurrencyNetwork
	 * @throws NetworkNotDefinedForCryptocurrency
	 * @throws InvalidNetworkException
	 */
	public static function getDefaultNetworkForCurrency(Cryptocurrency $cryptocurrency): CryptocurrencyNetwork {
		$factory = new DefaultCryptocurrencyNetworkFactory();

		if (!isset(self::MAPPINGS[$cryptocurrency->getCode()])) {
			throw new NetworkNotDefinedForCryptocurrency('Cryptocurrency should support at least one network');
		}

		switch ($cryptocurrency->getCode()) {
			case Cryptocurrency::BTC:
			case Cryptocurrency::BSV:
				return $factory->create(CryptocurrencyNetwork::BITCOIN);
			case Cryptocurrency::ETC:
				return $factory->create(CryptocurrencyNetwork::ETHEREUM_CLASSIC);
			case Cryptocurrency::ETH:
			case Cryptocurrency::USDT:
			case Cryptocurrency::ZRX:
			case Cryptocurrency::OMG:
			case Cryptocurrency::BAT:
			case Cryptocurrency::LINK:
			case Cryptocurrency::DAI:
			case Cryptocurrency::MKR:
			case Cryptocurrency::KNC:
			case Cryptocurrency::REP:
			case Cryptocurrency::UNI:
			case Cryptocurrency::YFI:
			case Cryptocurrency::BAL:
			case Cryptocurrency::COMP:
			case Cryptocurrency::AAVE:
			case Cryptocurrency::BNT:
			case Cryptocurrency::ENJ:
			case Cryptocurrency::LRC:
			case Cryptocurrency::MANA:
			case Cryptocurrency::MATIC:
			case Cryptocurrency::STORJ:
			case Cryptocurrency::SUSHI:
			case Cryptocurrency::USDC:
			case Cryptocurrency::SHIB:
			case Cryptocurrency::WBTC:
			case Cryptocurrency::ANT:
			case Cryptocurrency::ONE_INCH:
			case Cryptocurrency::AXS:
			case Cryptocurrency::BAND:
			case Cryptocurrency::CHZ:
			case Cryptocurrency::CRV:
			case Cryptocurrency::FTT:
			case Cryptocurrency::GALA:
			case Cryptocurrency::GNO:
			case Cryptocurrency::GRT:
			case Cryptocurrency::LEO:
			case Cryptocurrency::NEXO:
			case Cryptocurrency::OCEAN:
			case Cryptocurrency::SNX:
			case Cryptocurrency::TUSD:
				return $factory->create(CryptocurrencyNetwork::ETHEREUM);
			case Cryptocurrency::THETA:
				return $factory->create(CryptocurrencyNetwork::THETA);
			case Cryptocurrency::VET:
				return $factory->create(CryptocurrencyNetwork::VE_CHAIN);
			case Cryptocurrency::XRP:
				return $factory->create(CryptocurrencyNetwork::RIPPLE);
			case Cryptocurrency::LTC:
				return $factory->create(CryptocurrencyNetwork::LITECOIN);
			case Cryptocurrency::BCH:
				return $factory->create(CryptocurrencyNetwork::BITCOIN_CASH);
			case Cryptocurrency::ZEC:
				return $factory->create(CryptocurrencyNetwork::ZCASH);
			case Cryptocurrency::XLM:
				return $factory->create(CryptocurrencyNetwork::STELLAR_LUMEN);
			case Cryptocurrency::EOS:
				return $factory->create(CryptocurrencyNetwork::EOS);
			case Cryptocurrency::XMR:
				return $factory->create(CryptocurrencyNetwork::MONERO);
			case Cryptocurrency::ALGO:
				return $factory->create(CryptocurrencyNetwork::ALGORAND);
			case Cryptocurrency::NEO:
				return $factory->create(CryptocurrencyNetwork::NEO);
			case Cryptocurrency::XTZ:
				return $factory->create(CryptocurrencyNetwork::TEZOS);
			case Cryptocurrency::DOGE:
				return $factory->create(CryptocurrencyNetwork::DOGECOIN);
			case Cryptocurrency::WAVES:
				return $factory->create(CryptocurrencyNetwork::WAVES);
			case Cryptocurrency::DOT:
				return $factory->create(CryptocurrencyNetwork::POLKADOT);
			case Cryptocurrency::SOL:
				return $factory->create(CryptocurrencyNetwork::SOLANA);
			case Cryptocurrency::ADA:
				return $factory->create(CryptocurrencyNetwork::CARDANO);
			case Cryptocurrency::FTM:
				return $factory->create(CryptocurrencyNetwork::FANTOM);
			case Cryptocurrency::LUNA:
			case Cryptocurrency::UST:
				return $factory->create(CryptocurrencyNetwork::TERRA);
			case Cryptocurrency::LUNA2:
				return $factory->create(CryptocurrencyNetwork::TERRA2);
			case Cryptocurrency::ATOM:
				return $factory->create(CryptocurrencyNetwork::COSMOS);
			case Cryptocurrency::NEAR:
				return $factory->create(CryptocurrencyNetwork::NEAR);
			case Cryptocurrency::AVAX: // TODO: Check default network for AVAX?
				return $factory->create(CryptocurrencyNetwork::AVALANCHE_X);
			case Cryptocurrency::DGB:
				return $factory->create(CryptocurrencyNetwork::DIGIBYTE);
			case Cryptocurrency::EGLD:
				return $factory->create(CryptocurrencyNetwork::ELRONG_EGOLD);
			case Cryptocurrency::FIL:
				return $factory->create(CryptocurrencyNetwork::FILECOIN);
			case Cryptocurrency::IOTA:
				return $factory->create(CryptocurrencyNetwork::IOTA);
			case Cryptocurrency::KSM:
				return $factory->create(CryptocurrencyNetwork::KUSAMA);
			case Cryptocurrency::QTUM:
				return $factory->create(CryptocurrencyNetwork::QTUM);
			case Cryptocurrency::TRX:
				return $factory->create(CryptocurrencyNetwork::TRON);
			case Cryptocurrency::XVG:
				return $factory->create(CryptocurrencyNetwork::VERGE);
		}

		throw new NetworkNotDefinedForCryptocurrency("Default Mapping for: {$cryptocurrency->getCode()} does not exist");
	}

	/**
	 * @throws NetworkNotDefinedForCryptocurrency
	 */
	public static function getDefaultNetworkCodeForCurrencyCode(string $cryptocurrencyCode): string {
		if (!isset(self::MAPPINGS[$cryptocurrencyCode])) {
			throw new NetworkNotDefinedForCryptocurrency('Cryptocurrency should support at least one network');
		}

		return self::MAPPINGS[$cryptocurrencyCode][0];
	}

	/**
	 * @throws NetworkNotDefinedForCryptocurrency
	 */
	public static function getNetworkCodesForCryptocurrency(Cryptocurrency $cryptocurrency): array {
		if ($cryptocurrency->isFiat()) {
			throw new NetworkNotDefinedForCryptocurrency('Fiat currencies cannot support network');
		}

		if (!isset(self::MAPPINGS[$cryptocurrency->getCode()])) {
			throw new NetworkNotDefinedForCryptocurrency('Cryptocurrency should support at least one network');
		}

		return self::MAPPINGS[$cryptocurrency->getCode()];
	}

}
