<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\DivisionByZeroException;
use BitOasis\Coin\Exception\InvalidCurrencyException;
use BitOasis\Coin\Exception\InvalidNumberException;
use Zend\Math\BigInteger\Adapter\AdapterInterface;
use Zend\Math\BigInteger\BigInteger;
use Zend\Math\Exception\RuntimeException;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class Coin extends BigInteger {

	/** @var mixed */
	protected $amount;

	/** @var Cryptocurrency */
	protected $currency;

	/**
	 * Coin constructor.
	 * @param $amount
	 * @param Cryptocurrency $currency
	 */
	protected function __construct($amount, Cryptocurrency $currency) {
		$this->amount = $amount;
		$this->currency = $currency;
	}

	/**
	 * @return Cryptocurrency
	 */
	public function getCurrency() {
		return $this->currency;
	}

	/**
	 * @return Cryptocurrency
	 */
	public function getCryptocurrency() {
		return $this->currency;
	}

	/**
	 * @param $amount
	 * @param Cryptocurrency $currency
	 * @return static
	 * @throws InvalidNumberException
	 */
	public static function fromFloat($amount, Cryptocurrency $currency) {
		if(is_string($amount) && preg_match('#^[+-]?(\d*[.])?\d+$#', $amount)) {
			$stringAmount = $amount;
		} else if((!is_string($amount) && is_numeric($amount)) || (is_string($amount) && preg_match('#^[+-]?([1-9]?\.?\d+)[eE][+-]?(\d+)$#', $amount))) {
			$stringAmount = sprintf('%.' . $currency->getDecimals() . 'F', $amount);
		} else {
			throw new InvalidNumberException('Amount is not valid float number!');
		}
		return new static(self::getDefaultAdapter()->mul(self::getDefaultAdapter()->init($stringAmount, 10), $currency->getSubunitsInUnit()), $currency);
	}

	/**
	 * @param $amount
	 * @param Cryptocurrency $currency
	 * @return static
	 * @throws InvalidNumberException
	 */
	public static function fromInt($amount, Cryptocurrency $currency) {
		if(!is_numeric($amount) || !preg_match('/^-?(0|[1-9]\d*)$/', $amount)) {
			throw new InvalidNumberException('Initial value is not an integer value!');
		}
		return new static(self::getDefaultAdapter()->init($amount, 10), $currency);
	}

	/**
	 * @param Cryptocurrency $currency
	 * @return static
	 */
	public static function zero(Cryptocurrency $currency) {
		return new static(self::getDefaultAdapter()->init(0, 10), $currency);
	}

	/**
	 * @return float
	 */
	public function toFloat() {
		return (float)$this->toFloatString();
	}

	/**
	 * Get number as int (satoshi for example)
	 * In most cases use toIntString() instead
	 * @return int
	 * @throws InvalidNumberException
	 */
	public function toInt() {
		if($this->isPositive()) {
			if($this->getAdapter()->comp($this->amount, PHP_INT_MAX) > 0) {
				throw new InvalidNumberException('Amount is too large to be converted to int (' . $this->toIntString() . ')');
			}
		} else {
			if($this->getAdapter()->comp($this->amount, PHP_INT_MIN) < 0) {
				throw new InvalidNumberException('Amount is too large to be converted to int (' . $this->toIntString() . ')');
			}
		}
	    return (int)$this->amount;
	}

	/**
	 * Return value as float string
	 * @return string
	 */
	public function toDecimalString() {
		return $this->toFloatString();
	}

	/**
	 * Return value as float string
	 * @return string
	 */
	protected function toFloatString() {
		$sign = (strpos($this->amount, '-') === 0) ? '-' : '';
		$absAmount = ltrim($this->amount, '-+');
		$paddedAmount = $sign . str_pad($absAmount, $this->currency->getDecimals() + 1, '0', STR_PAD_LEFT);
		$stringAmount = substr_replace($paddedAmount, '.', -$this->currency->getDecimals(), 0);
		return rtrim(rtrim($stringAmount, '0'), '.');
	}

	/**
	 * Get number as string (satoshi for example)
	 * @return string
	 */
	public function toIntString() {
	    return $this->amount;
	}

	/**
	 * @param Coin $amount
	 * @return Coin
	 * @throws InvalidCurrencyException
	 */
	public function add(Coin $amount) {
		$this->validateCurrency($amount->currency);
	    return $this->copyWithAmount($this->getAdapter()->add($this->amount, $amount->amount));
	}

	/**
	 * @param Coin $amount
	 * @return Coin
	 * @throws InvalidCurrencyException
	 */
	public function sub(Coin $amount) {
		$this->validateCurrency($amount->currency);
	    return $this->copyWithAmount($this->getAdapter()->sub($this->amount, $amount->amount));
	}

	/**
	 * @param string|int|float $amount
	 * @return Coin
	 * @throws InvalidNumberException
	 */
	public function mul($amount) {
	    return $this->copyWithAmount($this->getAdapter()->mul($this->amount, $this->initializeNumericAmount($amount)));
	}

	/**
	 * @param string|int|float $amount
	 * @return Coin
	 * @throws InvalidNumberException
	 * @throws DivisionByZeroException
	 */
	public function div($amount) {
		try {
			return $this->copyWithAmount($this->getAdapter()->div($this->amount, $this->initializeNumericAmount($amount)));
		} catch (\Zend\Math\BigInteger\Exception\DivisionByZeroException $e) {
			throw new DivisionByZeroException($e->getMessage());
		}
	}

	/**
	 * @return Coin
	 */
	public function negated() {
		return $this->copyWithAmount($this->getAdapter()->mul($this->amount, -1));
	}

	/**
	 * @return Coin
	 */
	public function abs() {
		return $this->copyWithAmount($this->getAdapter()->abs($this->amount));
	}
	
	/**
	 * @param int $decimals
	 * @return Coin
	 * @throws InvalidNumberException
	 */
	public function floor($decimals = 0) {
		if ($decimals >= $this->currency->getDecimals()) {
			return $this->copyWithAmount($this->amount);
		}
		
		$trimLength = $this->currency->getDecimals() - $decimals;
		$amount = $this->toIntString();
		$originalLength = strlen($amount);
		if ($originalLength <= $trimLength) {
			return $this->copyWithAmount(0);
		}
		
		$trimmed = substr_replace($amount, '', -$trimLength);
		$padded = str_pad($trimmed, $originalLength, '0');
		return $this->copyWithAmount($padded);
	}

	/**
	 * @return bool
	 */
	public function isPositive() {
		return $this->getAdapter()->comp($this->amount, 0) > 0;
	}

	/**
	 * @return bool
	 */
	public function isNegative() {
		return $this->getAdapter()->comp($this->amount, 0) < 0;
	}

	/**
	 * @return bool
	 */
	public function isZero() {
		return $this->getAdapter()->comp($this->amount, 0) === 0;
	}

	/**
	 * @param Coin $coin
	 * @return bool
	 * @throws InvalidCurrencyException
	 */
	public function equals(Coin $coin) {
		if(!$this->currency->equals($coin->currency)) {
			return false; // todo: this or throw exception? Or do method named "same"?
		}
		return $this->getAdapter()->comp($this->amount, $coin->amount) === 0;
	}

	/**
	 * @param Coin $coin
	 * @return bool
	 * @throws InvalidCurrencyException
	 */
	public function greaterThan(Coin $coin) {
	    $this->validateCurrency($coin->currency);
		return $this->getAdapter()->comp($this->amount, $coin->amount) > 0;
	}

	/**
	 * @param Coin $coin
	 * @return bool
	 * @throws InvalidCurrencyException
	 */
	public function lessThan(Coin $coin) {
	    $this->validateCurrency($coin->currency);
		return $this->getAdapter()->comp($this->amount, $coin->amount) < 0;
	}

	/**
	 * @param Coin $coin
	 * @return bool
	 * @throws InvalidCurrencyException
	 */
	public function greaterOrEquals(Coin $coin) {
	    $this->validateCurrency($coin->currency);
		return $this->getAdapter()->comp($this->amount, $coin->amount) >= 0;
	}

	/**
	 * @param Coin $coin
	 * @return bool
	 * @throws InvalidCurrencyException
	 */
	public function lessOrEquals(Coin $coin) {
	    $this->validateCurrency($coin->currency);
		return $this->getAdapter()->comp($this->amount, $coin->amount) <= 0;
	}

	/**
	 * @param Coin $coin
	 * @return Coin
	 * @throws InvalidCurrencyException
	 */
	public function min(Coin $coin) {
	    $this->validateCurrency($coin->currency);
		return $this->getAdapter()->comp($this->amount, $coin->amount) < 0 ? $this : $coin;
	}

	/**
	 * @param Coin $coin
	 * @return Coin
	 * @throws InvalidCurrencyException
	 */
	public function max(Coin $coin) {
	    $this->validateCurrency($coin->currency);
		return $this->getAdapter()->comp($this->amount, $coin->amount) > 0 ? $this : $coin;
	}

	public static function __callStatic($method, $args) {
	}

	/**
	 * @param Cryptocurrency $currency
	 * @throws InvalidCurrencyException
	 */
	protected function validateCurrency(Cryptocurrency $currency) {
		if(!$this->currency->equals($currency)) {
			throw new InvalidCurrencyException("Can't process different currencies!");
		}
	}

	/**
	 * @param $amount
	 * @return string
	 * @throws InvalidNumberException
	 */
	protected function initializeNumericAmount($amount) {
		if(!is_numeric($amount)) {
			throw new InvalidNumberException("Parameter can't be converted to number");
		}
		return $amount;
	}

	/**
	 * @param string|int
	 * @return static
	 */
	protected function copyWithAmount($value) {
		return new static($value, $this->currency);
	}

	/**
	 * @return \Zend\Math\BigInteger\Adapter\AdapterInterface
	 */
	public function getAdapter() {
	    return self::getDefaultAdapter();
	}

	/**
	 * Determine and return available adapter
	 *
	 * @return AdapterInterface
	 * @throws RuntimeException
	 */
	public static function getAvailableAdapter() {
		if (extension_loaded('bcmath')) {
			return static::factory('Bcmath');
		}
		throw new RuntimeException('Big integer math support is not detected');
	}

}