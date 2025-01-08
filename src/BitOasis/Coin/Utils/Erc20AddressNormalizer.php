<?php

namespace BitOasis\Coin\Utils;

use Nette\Utils\Strings;

/**
 * @author Robert Mkrtchyan <robert.mkrtchyan@bitoasis.net>
 */
class Erc20AddressNormalizer {

	const ADDRESS_PREFIX = '0x';

	/**
	 * Adds 0x prefix if it's missing.
	 * @see ETHValidator which allows addresses without 0x prefix to be passed
	 *
	 * @param string $address
	 * @return string
	 */
	public static function normalize(string $address): string {
		if (Strings::startsWith($address, self::ADDRESS_PREFIX)) {
			return $address;
		}

		return self::ADDRESS_PREFIX . $address;
	}

}