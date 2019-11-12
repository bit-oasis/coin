<?php

namespace BitOasis\Coin\Address\Validators;

use Base32\Base32;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author Stanislav Fukala <stanislav.fukala@gmail.com>
 */
class AlgorandAddressValidator implements ValidationInterface {

	/** @var int */
	const NACL_PUBLIC_KEY_LENGTH = 32;
	const NACL_HASH_BYTES_LENGTH = 32;
	const ALGORAND_ADDRESS_BYTE_LENGTH = 36;
	const ALGORAND_CHECKSUM_BYTE_LENGTH = 4;
	const ALGORAND_ADDRESS_LENGTH = 58;

	/** @var string */
	protected $address;

	/**
	 * @inheritDoc
	 */
	public function __construct($address) {
		$this->address = $address;
	}

	/**
	 * @inheritDoc
	 */
	public function validate() {
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
	public function validateWithExceptions() {
		if (strlen($this->address) !== self::ALGORAND_ADDRESS_LENGTH) {
			throw new InvalidAddressException('Address has invalid length');
		}

		$decodedAddress = $this->decodeAddress();
		$checksumHash = unpack('C*', hash('sha512/256', pack('C*', ...$decodedAddress['publicKey']), true));
		$checksum = array_slice($checksumHash, self::NACL_HASH_BYTES_LENGTH - self::ALGORAND_CHECKSUM_BYTE_LENGTH, self::NACL_HASH_BYTES_LENGTH);

		if ($decodedAddress['checksum'] !== $checksum) {
			throw new InvalidAddressException('Address is invalid');
		}

		return true;
	}

	/**
	 * @return array
	 */
	protected function decodeAddress() {
		$decodedAddress = unpack('C*', Base32::decode($this->address));
		$publicKey = array_slice($decodedAddress,0, self::ALGORAND_ADDRESS_BYTE_LENGTH - self::ALGORAND_CHECKSUM_BYTE_LENGTH);
		$checksum = array_slice($decodedAddress, self::NACL_PUBLIC_KEY_LENGTH, self::ALGORAND_ADDRESS_BYTE_LENGTH);

		return [
			'publicKey' => $publicKey,
			'checksum' => $checksum,
		];
	}

}
