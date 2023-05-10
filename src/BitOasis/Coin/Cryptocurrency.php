<?php

namespace BitOasis\Coin;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class Cryptocurrency {

	const BTC = 'BTC';
	const TBTC = 'TBTC';
	const ETH = 'ETH';
	const ETC = 'ETC';
	const XRP = 'XRP';
	const LTC = 'LTC';
	const BCH = 'BCH';
	const ZEC = 'ZEC';
	const XLM = 'XLM';
	const EOS = 'EOS';
	const XMR = 'XMR';
	const BSV = 'BSV';
	const OMG = 'OMG';
	const ZRX = 'ZRX';
	const BAT = 'BAT';
	const ALGO = 'ALGO';
	const USDT = 'USDT';
	const NEO = 'NEO';
	const XTZ = 'XTZ';
	const LINK = 'LINK';

	// 2020
	const DAI = 'DAI';
	const MKR = 'MKR';
	const KNC = 'KNC';
	const REP = 'REP';
	const UNI = 'UNI';
	const YFI = 'YFI';
	const BAL = 'BAL';
	const COMP = 'COMP';
	const DOGE = 'DOGE';
	const AAVE = 'AAVE';
	const BNT = 'BNT';
	const ENJ = 'ENJ';
	const LRC = 'LRC';
	const MANA = 'MANA';
	const MATIC = 'MATIC';
	const STORJ = 'STORJ';
	const SUSHI = 'SUSHI';
	const USDC = 'USDC';
	const WAVES = 'WAVES';

	// 2022 Jan
	const DOT = 'DOT';
	const SOL = 'SOL';
	const ADA = 'ADA';
	const SHIB = 'SHIB';
	const AVAX = 'AVAX';
	const FTM = 'FTM';
	const WBTC = 'WBTC';
	const LUNA = 'LUNA';
	const ATOM = 'ATOM';
	const NEAR = 'NEAR';

	// 2022 Apr
	const ONE_INCH = '1INCH';
	const ANT = 'ANT';
	const AXS = 'AXS';
	const BAND = 'BAND';
	const CHZ = 'CHZ';
	const CRV = 'CRV';
	const DGB = 'DGB';
	const EGLD = 'EGLD';
	const FIL = 'FIL';
	const FTT = 'FTT';
	const GALA = 'GALA';
	const GNO = 'GNO';
	const GRT = 'GRT';
	const IOTA = 'IOTA';
	const KSM = 'KSM';
	const LEO = 'LEO';
	const NEXO = 'NEXO';
	const OCEAN = 'OCEAN';
	const QTUM = 'QTUM';
	const SNX = 'SNX';
	const THETA = 'THETA';
	const TRX = 'TRX';
	const TUSD = 'TUSD';
	const UST = 'UST';
	const VET = 'VET';
	const XVG = 'XVG';

	// May 2022
	const LUNA2 = 'LUNA2';

	// Sep 2022
	const ETHW = 'ETHW';

	// MAR 2023
	const XAUT = 'XAUT';
	const ARB = 'ARB';

	// Fiat
	const USD = 'USD';
	const AED = 'AED';
	const KWD = 'KWD';
	const EUR = 'EUR';
	const SAR = 'SAR';
	const TRY = 'TRY';
	const OMR = 'OMR';
	const BHD = 'BHD';
	const QAR = 'QAR';

	/** @var string */
	protected $code;

	/** @var int */
	protected $decimals;

	/** @var string|null */
	protected $name;

	/** @var bool */
	protected $isFiat;

	/**
	 * Cryptocurrency constructor.
	 * @param string $code
	 * @param int $decimals
	 * @param string|null $name
	 * @param bool $isFiat
	 */
	public function __construct($code, $decimals, $name = null, $isFiat = false) {
		$this->code = $code;
		$this->decimals = (int)$decimals;
		$this->name = $name;
		$this->isFiat = (bool)$isFiat;
		if ($this->decimals < 0) {
			throw new \InvalidArgumentException('Decimals must be non negative number!');
		}
	}

	/**
	 * @return string
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @return int
	 */
	public function getDecimals() {
		return $this->decimals;
	}

	/**
	 * @return string
	 */
	public function getSubunitsInUnit() {
		return '1' . str_repeat('0', $this->decimals);
	}
	
	/**
	 * @return null|string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return bool
	 */
	public function isFiat() {
		return $this->isFiat;
	}

	/**
	 * @return bool
	 */
	public function isCrypto() {
		return !$this->isFiat;
	}

	/**
	 * @param Cryptocurrency $currency
	 * @return bool
	 */
	public function equals(Cryptocurrency $currency) {
		return $this->code === $currency->code && $this->decimals === $currency->decimals;
	}

}
