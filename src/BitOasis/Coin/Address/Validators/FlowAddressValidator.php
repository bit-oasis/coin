<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Exception\InvalidAddressException;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 *
 * Flow addresses are an 8-byte account identifier, rendered as "0x" followed by 16 hex chars.
 * The "0x" prefix and the letter case are not part of the identifier, so both are optional on
 * input and normalized away by {@see self::normalize()}.
 *
 * Addresses are code words of a [64,45,7] linear code, which makes every mainnet address carry
 * its own checksum: addresses of the other Flow networks (testnet, emulator) are code words of
 * the same code shifted by a per-network constant, so they fail the mainnet check.
 */
class FlowAddressValidator implements ValidationInterface {

	const PREFIX = '0x';
	const PATTERN = '/^(?:0x)?[0-9a-f]{16}$/i';

	/** Columns of the parity-check matrix of the linear code, see onflow/flow-go model/flow/address.go */
	const PARITY_CHECK_MATRIX_COLUMNS = [
		0x00001, 0x00002, 0x00004, 0x00008,
		0x00010, 0x00020, 0x00040, 0x00080,
		0x00100, 0x00200, 0x00400, 0x00800,
		0x01000, 0x02000, 0x04000, 0x08000,
		0x10000, 0x20000, 0x40000, 0x7328d,
		0x6689a, 0x6112f, 0x6084b, 0x433fd,
		0x42aab, 0x41951, 0x233ce, 0x22a81,
		0x21948, 0x1ef60, 0x1deca, 0x1c639,
		0x1bdd8, 0x1a535, 0x194ac, 0x18c46,
		0x1632b, 0x1529b, 0x14a43, 0x13184,
		0x12942, 0x118c1, 0x0f812, 0x0e027,
		0x0d00e, 0x0c83c, 0x0b01d, 0x0a831,
		0x0982b, 0x07034, 0x0682a, 0x05819,
		0x03807, 0x007d2, 0x00727, 0x0068e,
		0x0067c, 0x0059d, 0x004eb, 0x003b4,
		0x0036a, 0x002d9, 0x001c7, 0x0003f,
	];

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
		if (!preg_match(static::PATTERN, $this->address)) {
			throw new InvalidAddressException('This is not valid flow address - ' . $this->address, 0);
		}

		if (!$this->isMainnetCodeWord(substr(static::normalize($this->address), 2))) {
			throw new InvalidAddressException('This is not valid flow mainnet address - ' . $this->address, 0);
		}

		return true;
	}

	/**
	 * Canonical form of a valid address: the "0x" prefix followed by 16 lower-case hex chars.
	 *
	 * @param string $address
	 * @return string
	 */
	public static function normalize(string $address): string {
		$hex = strtolower($address);

		return static::PREFIX . (strpos($hex, static::PREFIX) === 0 ? substr($hex, 2) : $hex);
	}

	/**
	 * Multiplies the address by the parity-check matrix over GF(2); mainnet code words give zero.
	 * The address is walked hex char by hex char so that it never has to be held in a PHP int,
	 * whose sign bit would get in the way.
	 *
	 * @param string $hex 16 lower-case hex chars
	 * @return bool
	 */
	protected function isMainnetCodeWord(string $hex): bool {
		if (ltrim($hex, '0') === '') {
			return false;
		}

		$parity = 0;
		for ($nibble = 0; $nibble < 16; $nibble++) {
			$value = hexdec($hex[15 - $nibble]);
			for ($bit = 0; $bit < 4; $bit++) {
				if (($value >> $bit) & 1) {
					$parity ^= static::PARITY_CHECK_MATRIX_COLUMNS[$nibble * 4 + $bit];
				}
			}
		}

		return $parity === 0;
	}

}
