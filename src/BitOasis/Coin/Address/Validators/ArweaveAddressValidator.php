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
	const HASH_BYTE_LENGTH = 32;

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

		if ($this->decode($this->address) === null) {
			throw new InvalidAddressException('This is not valid arweave address - ' . $this->address, 0);
		}

		return true;
	}

	/**
	 * 43 base64url chars hold 258 bits, so the last char has two bits left over that the 32-byte
	 * hash does not fill. Only the encoding that leaves them zero is the address of the wallet -
	 * the other three decode to the same hash and must not be accepted as separate addresses.
	 *
	 * @param string $address
	 * @return string|null decoded hash, or null if the address is not canonically encoded
	 */
	protected function decode(string $address): ?string {
		$decoded = base64_decode(strtr($address, '-_', '+/'), true);
		if ($decoded === false || strlen($decoded) !== static::HASH_BYTE_LENGTH) {
			return null;
		}

		$reEncoded = rtrim(strtr(base64_encode($decoded), '+/', '-_'), '=');

		return $reEncoded === $address ? $decoded : null;
	}
}
