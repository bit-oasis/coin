<?php

namespace BitOasis\Coin\Address\Validators;

use Base32\Base32;
use BitOasis\Coin\Exception\InvalidAddressException;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class StellarAddressValidator implements ValidationInterface {

	const VERSION_BYTES = [
		'ed25519PublicKey' =>  6 << 3, // G
		'ed25519SecretSeed' => 18 << 3, // S
		'preAuthTx' => 19 << 3, // T
		'sha256Hash' => 23 << 3  // X
	];

	/** @var string */
	protected $address;

	/** @var string */
	protected $memo;

	public function __construct($address, $memo = null) {
		$this->address = $address;
		$this->memo = $memo;
	}

	/**
	 * @return bool
	 */
	public function validate() {
		try {
			$this->validateWithExceptions();
		} catch (InvalidAddressException $e) {
			return false;
		}
		return true;
	}

	/**
	 * @throws InvalidAddressException
	 */
	public function validateWithExceptions() {
		if (!is_string($this->address) || strlen($this->address) !== 56) {
			throw new InvalidAddressException('Address has invalid length');
		}

		$decoded = Base32::decode($this->address);
		$versionByte = ord($decoded[0]);
		$payload = substr($decoded, 0,-2);
		$decodedData = substr($payload, 1);
		$checksum = substr($decoded, -2);

		if ($this->address !== Base32::encode($decoded)) {
			throw new InvalidAddressException('Invalid encoded address string');
		}

		$expectedVersion = self::VERSION_BYTES['ed25519PublicKey'];

		if ($versionByte !== $expectedVersion) {
			throw new InvalidAddressException("Invalid address version byte. expected $expectedVersion, got $versionByte");
		}

		$expectedChecksum = $this->crc16Pack($payload);
		if ($expectedChecksum !== $checksum) {
			throw new InvalidAddressException('Invalid address checksum');
		}

		if (strlen($decodedData) !== 32) {
			throw new InvalidAddressException('Decoded address has invalid length');
		}

		if ($this->memo !== null && strlen($this->memo) > 28) {
			throw new InvalidAddressException('Memo is too long');
		}

		return true;
	}

	protected function crc16Pack($binaryString) {
		$crc = 0x0000;
		$polynomial = 0x1021;
		foreach (str_split($binaryString) as $byte) {
			$byte = ord($byte);
			for ($i = 0; $i < 8; $i++) {
				$bit = (($byte >> (7 - $i) & 1) === 1);
				$c15 = (($crc >> 15 & 1) === 1);
				$crc <<= 1;
				if ($c15 ^ $bit) {
					$crc ^= $polynomial;
				}
			}
		}
		return pack('v', $crc & 0xffff);
	}

}