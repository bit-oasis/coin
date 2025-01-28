<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Utils\Base64Url;
use BitOasis\Coin\Utils\Crc16\Crc16;
use BitOasis\Coin\Utils\Crc16\Crc16Parameters;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class ToncoinAddressValidator implements ValidationInterface {

	const ACCOUNT_ID_BYTE_LENGTH = 32;
	const USER_FRIENDLY_ADDRESS_BYTE_LENGTH = 36;
	const USER_FRIENDLY_ADDRESS_FORMAT_PREFIX = ['E', 'U'];

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
		if ($this->isRawFormat($this->address)) {
			$this->validateRawFormat($this->address);
			$userFriendlyFormat = $this->toUserFriendlyFormat($this->address);
			$this->validateUserFriendlyFormat($userFriendlyFormat);
		} else {
			$this->validateUserFriendlyFormat($this->address);
			$rawFormat = $this->toRawFormat($this->address);
			$this->validateRawFormat($rawFormat);
		}
		return true;
	}

	/**
	 * @param string $address
	 * @return bool
	 */
	public function isRawFormat(string $address): bool {
		return count(explode(':', $address)) === 2;
	}

	/**
	 * @param string $address
	 * @return void
	 * @throws InvalidAddressException
	 */
	public function validateRawFormat(string $address) {
		$parts = explode(':', $address);
		if (count($parts) !== 2) {
			throw new InvalidAddressException('This is not valid toncoin address - ' . $this->address, 0);
		}

		list($workchain, $accountId) = $parts;

		if (!is_numeric($workchain) || (int)$workchain < -128 || (int)$workchain > 127) {
			throw new InvalidAddressException('This is not valid toncoin address - ' . $this->address, 0);
		}

		if (!\ctype_xdigit($accountId) || strlen($accountId) % 2 !== 0) {
			throw new InvalidAddressException('This is not valid toncoin address - ' . $this->address, 0);
		}

		$binaryData = hex2bin($accountId);
		if (strlen($binaryData) !== static::ACCOUNT_ID_BYTE_LENGTH) {
			throw new InvalidAddressException('This is not valid toncoin address - ' . $this->address, 0);
		}
	}

	/**
	 * @param string $address
	 * @return void
	 * @throws InvalidAddressException
	 */
	public function validateUserFriendlyFormat(string $address) {
		if (!in_array($address[0], static::USER_FRIENDLY_ADDRESS_FORMAT_PREFIX)) {
			throw new InvalidAddressException('This is not valid toncoin address - ' . $this->address, 0);
		}

		if (strlen(Base64Url::decode($address)) !== static::USER_FRIENDLY_ADDRESS_BYTE_LENGTH) {
			throw new InvalidAddressException('This is not valid toncoin address - ' . $this->address, 0);
		}

		$decoded = Base64Url::decode($address, true);
		if ($decoded === false) {
			throw new InvalidAddressException('This is not valid toncoin address - ' . $this->address, 0);
		}

		$checksum = ord($decoded[34]) << 8 | ord($decoded[35]);
		$checksumData = substr($decoded, 0, 34);
		if ($checksum !== $this->calculateChecksum($checksumData)) {
			throw new InvalidAddressException('This is not valid toncoin address - ' . $this->address, 0);
		}

	}

	/**
	 * @param string $address
	 * @return string
	 */
	public function toRawFormat(string $address): string {
		$decoded = Base64Url::decode($address, true);
		$workchain = ord($decoded[1]);
		if ($workchain > 127) {
			$workchain -= 256;
		}
		$accountId = substr($decoded, 2, 32);
		return $workchain . ":" . bin2hex($accountId);
	}

	/**
	 * @param string $address
	 * @return string
	 */
	public function toUserFriendlyFormat(string $address): string {
		sscanf($address, "%d:%[a-f0-9]", $workchain, $accountId);
		$address = str_repeat(chr(0), 36);
		$address = substr_replace($address, chr(0b00010001) . chr($workchain) . hex2bin($accountId), 0, 34);
		$checksum = $this->calculateChecksum(chr(0b00010001) . chr($workchain) . hex2bin($accountId));
		$address[34] = chr($checksum >> 8);
		$address[35] = chr($checksum & 0xFF);
		return Base64Url::encode($address);;
	}

	/**
	 * @param string $buffer
	 * @return int
	 */
	public function calculateChecksum(string $buffer): int {
		$crc16 = new Crc16();
		$crcTable = $crc16->makeTable(Crc16Parameters::fromArray(Crc16Parameters::CRC16_XMODEM));
		return $crc16->checksum($buffer, $crcTable);
	}
}