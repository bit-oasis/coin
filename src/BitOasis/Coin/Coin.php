<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\DivisionByZeroException;
use BitOasis\Coin\Exception\InvalidCurrencyException;
use BitOasis\Coin\Exception\InvalidNumberException;
use Laminas\Math\BigInteger\Adapter\AdapterInterface;
use Laminas\Math\BigInteger\BigInteger;
use Laminas\Math\Exception\RuntimeException;

use function is_numeric;
use function ltrim;
use function preg_match;
use function rtrim;
use function strlen;
use function strpos;
use function str_pad;
use function substr;
use function substr_replace;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class Coin extends BigInteger {

	/** @var mixed */
	protected $amount;
	protected Cryptocurrency $currency;

	/**
	 * Coin constructor.
	 * @param mixed $amount
	 * @param Cryptocurrency $currency
	 */
	protected function __construct($amount, Cryptocurrency $currency) {
		$this->amount = $amount;
		$this->currency = $currency;
	}

	public function getCurrency(): Cryptocurrency {
		return $this->currency;
	}

	public function getCryptocurrency(): Cryptocurrency {
		return $this->currency;
	}

	/**
	 * @param mixed $amount
	 * @param Cryptocurrency $currency
	 * @throws InvalidNumberException
	 */
	public static function fromFloat($amount, Cryptocurrency $currency): self {
		$stringAmount = static::convertNumericAmountToDecimalString($amount, $currency->getDecimals());
		if ($stringAmount === null) {
			throw new InvalidNumberException('Amount is not valid float number!');
		}

		return new static(self::getDefaultAdapter()->mul(self::getDefaultAdapter()->init($stringAmount, 10), $currency->getSubunitsInUnit()), $currency);
	}

	/**
	 * @param int|string $amount
	 * @param Cryptocurrency $currency
	 * @throws InvalidNumberException
	 */
	public static function fromInt($amount, Cryptocurrency $currency): self {
		if(!is_numeric($amount) || !preg_match('/^-?(0|[1-9]\d*)$/', (string)$amount)) {
			throw new InvalidNumberException('Initial value is not an integer value!');
		}

		return new static(self::getDefaultAdapter()->init((string)$amount, 10), $currency);
	}

	public static function zero(Cryptocurrency $currency): self {
		return new static(self::getDefaultAdapter()->init('0', 10), $currency);
	}

	public function toFloat(): float {
		return (float)$this->toFloatString();
	}

	/**
	 * Get number as int (satoshi for example)
	 * In most cases use toIntString() instead
	 * @throws InvalidNumberException
	 */
	public function toInt(): int {
		if($this->isPositive()) {
			if($this->getAdapter()->comp($this->amount, (string)PHP_INT_MAX) > 0) {
				throw new InvalidNumberException('Amount is too large to be converted to int (' . $this->toIntString() . ')');
			}
		} else {
			if($this->getAdapter()->comp($this->amount, (string)PHP_INT_MIN) < 0) {
				throw new InvalidNumberException('Amount is too large to be converted to int (' . $this->toIntString() . ')');
			}
		}

		return (int)$this->amount;
	}

	/**
	 * Return value as float string
	 */
	public function toDecimalString(): string {
		return $this->toFloatString();
	}

	/**
	 * Return value as float string
	 */
	protected function toFloatString(): string {
		if ($this->currency->getDecimals() === 0) {
			return $this->amount;
		}

		$sign = (strpos($this->amount, '-') === 0) ? '-' : '';
		$absAmount = ltrim($this->amount, '-+');
		$paddedAmount = $sign . str_pad($absAmount, $this->currency->getDecimals() + 1, '0', STR_PAD_LEFT);
		$stringAmount = substr_replace($paddedAmount, '.', -$this->currency->getDecimals(), 0);

		return rtrim(rtrim($stringAmount, '0'), '.');
	}

	/**
	 * Get number as string (satoshi for example)
	 */
	public function toIntString(): string {
		return $this->amount;
	}

	/**
	 * @throws InvalidCurrencyException
	 */
	public function add(Coin $amount): self {
		$this->validateCurrency($amount->currency);
		return $this->copyWithAmount($this->getAdapter()->add($this->amount, $amount->amount));
	}

	/**
	 * @throws InvalidCurrencyException
	 */
	public function sub(Coin $amount): Coin {
		$this->validateCurrency($amount->currency);
		return $this->copyWithAmount($this->getAdapter()->sub($this->amount, $amount->amount));
	}

	/**
	 * @param string|int|float $amount
	 * @throws InvalidNumberException
	 */
	public function mul($amount): self {
		return $this->copyWithAmount($this->getAdapter()->mul($this->amount, $this->initializeNumericAmount($amount)));
	}

	/**
	 * @param string|int|float $amount
	 * @throws InvalidNumberException
	 * @throws DivisionByZeroException
	 */
	public function div($amount): self {
		try {
			return $this->copyWithAmount($this->getAdapter()->div($this->amount, $this->initializeNumericAmount($amount)));
		} catch (\Laminas\Math\BigInteger\Exception\DivisionByZeroException $e) {
			throw new DivisionByZeroException($e->getMessage());
		}
	}

	public function negated(): self {
		return $this->copyWithAmount($this->getAdapter()->mul($this->amount, '-1'));
	}

	public function abs(): self {
		return $this->copyWithAmount($this->getAdapter()->abs($this->amount));
	}
	
	/**
	 * @throws InvalidNumberException
	 */
	public function floor(int $decimals = 0): self {
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

	public function round(int $decimals = 0): self {
		if ($decimals >= $this->currency->getDecimals()) {
			return $this->copyWithAmount($this->amount);
		}
		
		$sign = (strpos($this->amount, '-') === 0) ? '-' : '';
		$absAmount = ltrim($this->amount, '-+');
		$originalLength = strlen($absAmount);
		$trimLength = $this->currency->getDecimals() - $decimals;
		if ($originalLength < $trimLength) {
			return $this->copyWithAmount(0);
		}
		
		$trimmed = substr_replace($absAmount, '', -$trimLength);
		if ((int)substr($absAmount, -$trimLength, 1) >= 5) {
			$trimmedLength = strlen($trimmed);
			$trimmed = (string)$this->getAdapter()->add($trimmed, '1');
			if ($trimmedLength !== strlen($trimmed)) {
				$originalLength++;
			}
		}
		if (strlen($trimmed) === 0) {
			return $this->copyWithAmount(0);
		}
		$padded = $sign . str_pad($trimmed, $originalLength, '0');
		return $this->copyWithAmount($padded);
	}

	public function isPositive(): bool {
		return $this->getAdapter()->comp($this->amount, '0') > 0;
	}

	public function isNegative(): bool {
		return $this->getAdapter()->comp($this->amount, '0') < 0;
	}

	public function isZero(): bool {
		return $this->getAdapter()->comp($this->amount, '0') === 0;
	}

	/**
	 * @throws InvalidCurrencyException
	 */
	public function equals(Coin $coin): bool {
		if(!$this->currency->equals($coin->currency)) {
			return false; // todo: this or throw exception? Or do method named "same"?
		}
		return $this->getAdapter()->comp($this->amount, $coin->amount) === 0;
	}

	/**
	 * @throws InvalidCurrencyException
	 */
	public function greaterThan(Coin $coin): bool {
		$this->validateCurrency($coin->currency);
		return $this->getAdapter()->comp($this->amount, $coin->amount) > 0;
	}

	/**
	 * @throws InvalidCurrencyException
	 */
	public function lessThan(Coin $coin): bool {
		$this->validateCurrency($coin->currency);
		return $this->getAdapter()->comp($this->amount, $coin->amount) < 0;
	}

	/**
	 * @throws InvalidCurrencyException
	 */
	public function greaterOrEquals(Coin $coin): bool {
		$this->validateCurrency($coin->currency);
		return $this->getAdapter()->comp($this->amount, $coin->amount) >= 0;
	}

	/**
	 * @throws InvalidCurrencyException
	 */
	public function lessOrEquals(Coin $coin): bool {
		$this->validateCurrency($coin->currency);
		return $this->getAdapter()->comp($this->amount, $coin->amount) <= 0;
	}

	/**
	 * @throws InvalidCurrencyException
	 */
	public function min(Coin $coin): self {
		$this->validateCurrency($coin->currency);
		return $this->getAdapter()->comp($this->amount, $coin->amount) < 0 ? $this : $coin;
	}

	/**
	 * @throws InvalidCurrencyException
	 */
	public function max(Coin $coin): self {
		$this->validateCurrency($coin->currency);
		return $this->getAdapter()->comp($this->amount, $coin->amount) > 0 ? $this : $coin;
	}

	public static function __callStatic($method, $args) {
	}

	/**
	 * @throws InvalidCurrencyException
	 */
	protected function validateCurrency(Cryptocurrency $currency): void {
		if(!$this->currency->equals($currency)) {
			throw new InvalidCurrencyException("Can't process different currencies!");
		}
	}

	/**
	 * @param mixed $amount
	 * @throws InvalidNumberException
	 */
	protected function initializeNumericAmount($amount): string {
		$stringAmount = static::convertNumericAmountToDecimalString($amount);
		if($stringAmount === null) {
			throw new InvalidNumberException("Parameter can't be converted to number");
		}

		return $stringAmount;
	}

	/**
	 * @param mixed $amount
	 * @param int|null $maxDecimals
	 * @return string|null if $amount is not numeric
	 */
	protected static function convertNumericAmountToDecimalString($amount, int $maxDecimals = null): ?string {
		$stringAmount = null;
		if (is_string($amount) && preg_match('#^[+-]?(\d*[.])?\d+$#', $amount)) {
			$stringAmount = $amount;
		} else if ((!is_string($amount) && is_numeric($amount))) {
			$stringAmount = $amount = (string)$amount;
		}
		if (is_string($amount) && preg_match('#^[+-]?([1-9]?\.?\d+)[eE][+-]?(\d+)$#', $amount)) {
			list ($significand, $exponent) = explode('e', strtolower($amount));
			$decimalPointInSignificandPos = strrpos($significand, '.');
			$decimals = max(0, (-(int)$exponent) + ($decimalPointInSignificandPos === false ? 0 : (strlen($significand) - $decimalPointInSignificandPos - 1)));
			if ($maxDecimals !== null) {
				$decimals = min($maxDecimals, $decimals);
			}
			$stringAmount = sprintf('%.' . $decimals . 'F', $amount);
		}

		return $stringAmount;
	}

	/**
	 * @param string|int $value
	 */
	protected function copyWithAmount($value): self {
		return new static($value, $this->currency);
	}

	public function getAdapter(): AdapterInterface {
		return self::getDefaultAdapter();
	}

	/**
	 * Determine and return available adapter
	 *
	 * @throws RuntimeException
	 */
	public static function getAvailableAdapter(): AdapterInterface {
		if (\extension_loaded('bcmath')) {
			return static::factory('Bcmath');
		}

		throw new RuntimeException('Big integer math support is not detected');
	}

}
