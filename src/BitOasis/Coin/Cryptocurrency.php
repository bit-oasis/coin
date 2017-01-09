<?php

namespace BitOasis\Coin;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class Cryptocurrency {

	const BTC = 'BTC';
	const TBTC = 'TBTC';
	const ETH = 'ETH';

	/** @var string */
	protected $code;

	/** @var int */
	protected $decimals;

	/** @var string|null */
	protected $name;

	/**
	 * Cryptocurrency constructor.
	 * @param string $code
	 * @param int $decimals
	 * @param string|null $name
	 */
	public function __construct($code, $decimals, $name = null) {
		$this->code = $code;
		$this->decimals = $decimals;
		$this->name = $name;
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
	 * @return null|string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param Cryptocurrency $currency
	 * @return bool
	 */
	public function equals(Cryptocurrency $currency) {
		return $this->code === $currency->code && $this->decimals === $currency->decimals;
	}

}