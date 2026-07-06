<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Utils\Bech32\Bech32;
use BitOasis\Coin\Utils\Bech32\Bech32Exception;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;

class BitcoinBech32AddressValidator extends Bech32AddressValidator {

	public function __construct($address, $tag = null) {
		$this->prefix = 'bc';
		$this->bech32DecodedLengths = [33, 53];
		$this->label = 'Bitcoin';

		parent::__construct($address, $tag);
	}

	/**
	 * Bitcoin native SegWit addresses use two checksum variants (BIP350):
	 *  - witness version 0 (P2WPKH/P2WSH, `bc1q...`) must be bech32
	 *  - witness version 1-16 (e.g. Taproot/P2TR, `bc1p...`) must be bech32m
	 *
	 * @return bool
	 * @throws InvalidAddressException
	 */
	public function validateWithExceptions(): bool {
		try {
			$decoded = Bech32::decode($this->address, [Bech32::ENCODING_BECH32, Bech32::ENCODING_BECH32M]);

			if ($decoded[0] !== $this->prefix) {
				throw new InvalidArgumentException();
			}

			if (!in_array(count($decoded[1]), $this->bech32DecodedLengths, true)) {
				throw new InvalidArgumentException();
			}

			$this->validateSegwitEncoding($decoded[1], $decoded[2]);

			$this->validateTag();
			return true;
		} catch (InvalidArgumentException|Bech32Exception $e) {
			throw new InvalidAddressException('This is not valid ' . $this->label . ' address - ' . $this->address, 0, $e);
		}
	}

	/**
	 * Ensures the checksum variant matches the witness version per BIP350.
	 *
	 * @param int[] $data - decoded data chars (first element is the witness version)
	 * @param string $encoding - encoding reported by Bech32::decode()
	 * @throws InvalidArgumentException
	 */
	private function validateSegwitEncoding(array $data, string $encoding): void {
		$witnessVersion = $data[0];
		if ($witnessVersion < 0 || $witnessVersion > 16) {
			throw new InvalidArgumentException();
		}

		$expectedEncoding = $witnessVersion === 0 ? Bech32::ENCODING_BECH32 : Bech32::ENCODING_BECH32M;
		if ($encoding !== $expectedEncoding) {
			throw new InvalidArgumentException();
		}
	}

}
