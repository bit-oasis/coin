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
	const LEO = 'LEO';
	const ALGO = 'ALGO';
	const USDT = 'USDT';
	const NEO = 'NEO';
	const XTZ = 'XTZ';
	const LINK = 'LINK';
	const DAI = 'DAI';
	const MKR = 'MKR';
	const KNC = 'KNC';
	const REP = 'REP';
	const UNI = 'UNI';
	const YFI = 'YFI';
	const BAL = 'BAL';
	const COMP = 'COMP';
	const SNX = 'SNX';
	const DOGE = 'DOGE';

	const USD = 'USD';
	const AED = 'AED';
	const KWD = 'KWD';
	const EUR = 'EUR';
	const SAR = 'SAR';

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
