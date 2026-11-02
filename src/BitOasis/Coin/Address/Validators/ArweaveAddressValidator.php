<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Exception\InvalidAddressException;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 *
 * Arweave addresses are the base64url (no padding) encoding of a 32-byte SHA-256 hash, i.e. 43
 * characters from [A-Za-z0-9_-].
 */
class ArweaveAddressValidator implements ValidationInterface {

	const LENGTH = 43;
	const PATTERN = '/^[A-Za-z0-9_-]{43}$/';

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
		if (strlen($this->address) !== static::LENGTH || !preg_match(static::PATTERN, $this->address)) {
			throw new InvalidAddressException('This is not valid arweave address - ' . $this->address, 0);
		}

		return true;
	}
}
