<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Exception\InvalidAddressException;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class SuiAddressValidator implements ValidationInterface {

	const HEX_BYTE_LENGTH = 32;
	const PREFIX = "0x";

	/** @var string */
	protected $address;

	public function __construct($address) {
		$this->address = $address;
	}

	/**
	 * @inheritDoc
	 */
	public function validate(): bool {
		try {
			return $this->validateWithExceptions();
		} catch (InvalidAddressException $e) {
		}
		return false;
	}

	/**
	 * @return bool
	 * @throws InvalidAddressException
	 */
	public function validateWithExceptions(): bool {
		if (substr($this->address, 0, 2) !== static::PREFIX) {
			throw new InvalidAddressException('This is not valid sui address - ' . $this->address, 0);
		}

		$addressWithoutPrefix = substr($this->address, 2);

		if (!\ctype_xdigit($addressWithoutPrefix) || strlen($addressWithoutPrefix) % 2 !== 0) {
			throw new InvalidAddressException('This is not valid sui address - ' . $this->address, 0);
		}

		$binaryData = hex2bin($addressWithoutPrefix);
		if (strlen($binaryData) !== static::HEX_BYTE_LENGTH) {
			throw new InvalidAddressException('This is not valid sui address - ' . $this->address, 0);
		}

		return true;
	}
}