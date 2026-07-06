<?php

namespace BitOasis\Coin\Utils\Bech32;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class Bech32 {

	const GENERATOR = [0x3b6a57b2, 0x26508e6d, 0x1ea119fa, 0x3d4233dd, 0x2a1462b3];
	const CHARSET = 'qpzry9x8gf2tvdw0s3jn54khce6mua7l';
	const MAX_BECH_LENGTH = 110;

	/** Encoding names returned by decode(). */
	const ENCODING_BECH32 = 'bech32';
	const ENCODING_BECH32M = 'bech32m';

	/** polyMod checksum constants - 1 for bech32 (BIP173), 0x2bc830a3 for bech32m (BIP350). */
	const CHECKSUM_BECH32 = 1;
	const CHECKSUM_BECH32M = 0x2bc830a3;

	const CHARKEY_KEY = [
		-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
		-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
		-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
		15, -1, 10, 17, 21, 20, 26, 30,  7,  5, -1, -1, -1, -1, -1, -1,
		-1, 29, -1, 24, 13, 25,  9,  8, 23, -1, 18, 22, 31, 27, 19, -1,
		1,  0,  3, 16, 11, 28, 12, 14,  6,  4,  2, -1, -1, -1, -1, -1,
		-1, 29, -1, 24, 13, 25,  9,  8, 23, -1, 18, 22, 31, 27, 19, -1,
		1,  0,  3, 16, 11, 28, 12, 14,  6,  4,  2, -1, -1, -1, -1, -1
	];

	/**
	 * Validates a bech32/bech32m string and returns [$hrp, $dataChars, $encoding]
	 * if the conversion was successful. An exception is thrown on invalid data.
	 *
	 * By default only bech32 (BIP173) checksums are accepted so existing callers
	 * keep their behaviour. Pass a list containing self::ENCODING_BECH32M to also
	 * accept bech32m (BIP350) - required for SegWit v1+ (e.g. Taproot) addresses.
	 *
	 * @param string $sBech - the bech32/bech32m encoded string
	 * @param string[] $allowedEncodings - encodings to accept (defaults to bech32 only)
	 * @return array - returns [$hrp, $dataChars, $encoding]
	 * @throws Bech32Exception
	 */
	public static function decode($sBech, array $allowedEncodings = [self::ENCODING_BECH32]) {
		$length = strlen($sBech);
		if ($length > self::MAX_BECH_LENGTH) {
			throw new Bech32Exception('Bech32 string cannot exceed ' . self::MAX_BECH_LENGTH . ' characters in length');
		}

		$self = new static();

		return $self->decodeRaw($sBech, $allowedEncodings);
	}

	/**
	 * @param int[] $values
	 * @param int $numValues
	 * @return int
	 */
	private function polyMod(array $values, $numValues) {
		$chk = 1;
		for ($i = 0; $i < $numValues; $i++) {
			$top = $chk >> 25;
			$chk = ($chk & 0x1ffffff) << 5 ^ $values[$i];

			for ($j = 0; $j < 5; $j++) {
				$value = (($top >> $j) & 1) ? self::GENERATOR[$j] : 0;
				$chk ^= $value;
			}
		}

		return $chk;
	}

	/**
	 * Expands the human readable part into a character array for checksumming.
	 * @param string $hrp
	 * @param int $hrpLen
	 * @return int[]
	 */
	private function hrpExpand($hrp, $hrpLen) {
		$expand1 = [];
		$expand2 = [];
		for ($i = 0; $i < $hrpLen; $i++) {
			$o = \ord($hrp[$i]);
			$expand1[] = $o >> 5;
			$expand2[] = $o & 31;
		}

		return \array_merge($expand1, [0], $expand2);
	}

	/**
	 * Verifies the checksum given $hrp and $convertedDataChars and returns the
	 * detected encoding (self::ENCODING_BECH32 or self::ENCODING_BECH32M), or
	 * null when the checksum matches neither.
	 *
	 * @param string $hrp
	 * @param int[] $convertedDataChars
	 * @return string|null
	 */
	private function getCheckSumEncoding($hrp, array $convertedDataChars) {
		$expandHrp = $this->hrpExpand($hrp, \strlen($hrp));
		$r = \array_merge($expandHrp, $convertedDataChars);
		$poly = $this->polyMod($r, \count($r));
		if ($poly === self::CHECKSUM_BECH32) {
			return self::ENCODING_BECH32;
		}
		if ($poly === self::CHECKSUM_BECH32M) {
			return self::ENCODING_BECH32M;
		}
		return null;
	}

	/**
	 * @param string $sBech - the bech32/bech32m encoded string
	 * @param string[] $allowedEncodings - encodings to accept
	 * @return array - returns [$hrp, $dataChars, $encoding]
	 * @throws Bech32Exception
	 */
	private function decodeRaw($sBech, array $allowedEncodings) {
		$length = \strlen($sBech);
		if ($length < 8) {
			throw new Bech32Exception("Bech32 string is too short");
		}

		$chars = array_values(unpack('C*', $sBech));

		$haveUpper = false;
		$haveLower = false;
		$positionOne = -1;

		for ($i = 0; $i < $length; $i++) {
			$x = $chars[$i];
			if ($x < 33 || $x > 126) {
				throw new Bech32Exception('Out of range character in bech32 string');
			}

			if ($x >= 0x61 && $x <= 0x7a) {
				$haveLower = true;
			}

			if ($x >= 0x41 && $x <= 0x5a) {
				$haveUpper = true;
				$x = $chars[$i] = $x + 0x20;
			}

			// find location of last '1' character
			if ($x === 0x31) {
				$positionOne = $i;
			}
		}

		if ($haveUpper && $haveLower) {
			throw new Bech32Exception('Data contains mixture of higher/lower case characters');
		}

		if ($positionOne === -1) {
			throw new Bech32Exception("Missing separator character");
		}

		if ($positionOne < 1) {
			throw new Bech32Exception("Empty HRP");
		}

		if (($positionOne + 7) > $length) {
			throw new Bech32Exception('Too short checksum');
		}

		$hrp = \pack("C*", ...\array_slice($chars, 0, $positionOne));

		$data = [];
		for ($i = $positionOne + 1; $i < $length; $i++) {
			$data[] = ($chars[$i] & 0x80) ? -1 : self::CHARKEY_KEY[$chars[$i]];
		}

		$encoding = $this->getCheckSumEncoding($hrp, $data);
		if ($encoding === null || !in_array($encoding, $allowedEncodings, true)) {
			throw new Bech32Exception('Invalid bech32 checksum');
		}

		return [$hrp, array_slice($data, 0, -6), $encoding];
	}

}