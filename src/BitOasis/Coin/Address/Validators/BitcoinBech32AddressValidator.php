<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Utils\Bech32\Bech32;
use BitOasis\Coin\Utils\Bech32\Bech32Exception;

class BitcoinBech32AddressValidator extends Bech32AddressValidator {

	public function __construct($address, $tag = null) {
		$this->prefix = 'bc';
		$this->bech32DecodedLengths = [33, 53];
		$this->label = 'Bitcoin';
		$this->allowedEncodings = [Bech32::ENCODING_BECH32, Bech32::ENCODING_BECH32M];

		parent::__construct($address, $tag);
	}

	/**
	 * Bitcoin native SegWit addresses use two checksum variants (BIP350):
	 *  - witness version 0 (P2WPKH/P2WSH, `bc1q...`) must be bech32
	 *  - witness version 1-16 (e.g. Taproot/P2TR, `bc1p...`) must be bech32m
	 *
	 * @param array $decoded - [$hrp, $dataChars, $encoding]
	 * @throws Bech32Exception
	 */
	protected function validateDecodedAddress(array $decoded): void {
		Bech32::validateSegwitDataPart($decoded[1], $decoded[2]);
	}

}
