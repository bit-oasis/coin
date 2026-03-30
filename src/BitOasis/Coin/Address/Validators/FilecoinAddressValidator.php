<?php

namespace BitOasis\Coin\Address\Validators;

use Base32\Base32;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Utils\Hashes;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class FilecoinAddressValidator implements ValidationInterface {

	const DECODE_OFFSET = 2;
	const CHECKSUM_LENGTH = 4;
	const PREFIX = 'f';

	const ADDRESS_LENGTHS = [
		'secp256k1Type' => 41,
		'actorType' => 41,
		'blsType' => 86
	];

	protected $address;

	public function __construct($address) {
		$this->address = $address;
	}

	/**
	 * @return bool
	 * @throws InvalidAddressException
	 */
	public function validate() {
		$prefix = substr($this->address, 0, 1);

		if ($prefix !== self::PREFIX) {
			throw new InvalidAddressException('Address has invalid prefix');
		}

		if (!in_array(strlen($this->address), self::ADDRESS_LENGTHS)) {
			if ($this->isValidIdAddress()) {
				return true;
			}

			throw new InvalidAddressException('Address has invalid length');
		}

		$decoded = $this->decodeAddress();
		$publicKey = $decoded['publicKey'];
		$checksum = $decoded['checksum'];

		array_unshift($publicKey, $this->address[1]);

		$st = pack('C*', ...$publicKey);

		try {
			$newCheckSum = array_values(unpack('C*', Hashes::blake2b32($st)));
		} catch (\SodiumException $e) {
			throw new InvalidAddressException('Address has invalid characters');
		}

		if ($checksum !== $newCheckSum) {
			throw new InvalidAddressException('Invalid checksum');
		}

		return true;
	}

	protected function decodeAddress(): array {
		$decodedRawAddress = unpack('C*', Base32::decode(substr($this->address, self::DECODE_OFFSET)));
		$publicKey = array_slice($decodedRawAddress,0, count($decodedRawAddress) - self::CHECKSUM_LENGTH);
		$checksum = array_slice($decodedRawAddress, count($decodedRawAddress) - self::CHECKSUM_LENGTH, self::CHECKSUM_LENGTH);

		return [
			'publicKey' => $publicKey,
			'checksum' => $checksum,
		];
	}

	protected function isValidIdAddress(): bool {
		$id = substr($this->address, 1);

		return is_numeric($id);
	}

}
