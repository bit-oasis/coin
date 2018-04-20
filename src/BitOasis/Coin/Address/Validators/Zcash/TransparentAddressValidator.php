<?php

namespace BitOasis\Coin\Address\Validators\Zcash;

use BitOasis\Coin\Utils\Base58Check\Base58Check;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class TransparentAddressValidator implements ValidationInterface {

	/** @var array */
	protected $base58PrefixToHexVersion = [
		't1' => '1CB8', //transparent P2PKH
		't3' => '1CBD', //transparent P2SH
	];

	/** @var string */
	protected $address;

	public function __construct($address) {
		$this->address = $address;
	}

	public function validate() {
		try {
			$this->validateWithExceptions();
			return true;
		} catch (InvalidAddressException $e) {
		}
		return false;
	}

	/**
	 * @return bool
	 * @throws InvalidAddressException
	 * @throws InvalidAddressPrefixException
	 */
	public function validateWithExceptions() {
		try {
			$decodedAddress = Base58Check::decodeAddress($this->address, null, Base58Check::ZEC_TRANSPARENT_ADDRESS);
			if (!in_array($decodedAddress->getHexVersionUpper(), $this->base58PrefixToHexVersion)) {
				throw new InvalidAddressPrefixException('This is not valid zcash transparent address prefix - ' . $this->address);
			}
			return true;
		} catch (InvalidArgumentException $e) {
			throw new InvalidAddressException('This is not valid zcash transparent address - ' . $this->address);
		}
	}

}
