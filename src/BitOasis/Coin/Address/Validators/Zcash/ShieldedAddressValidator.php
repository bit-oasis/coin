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
class ShieldedAddressValidator implements ValidationInterface {

	/** @var array */
	protected $base58PrefixToHexVersion = [
		'zc' => '169A', //shielded address
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
			$decodedAddress = Base58Check::decodeAddress($this->address, null, Base58Check::ZEC_SHIELDED_ADDRESS);
			if (!in_array($decodedAddress->getHexVersionUpper(), $this->base58PrefixToHexVersion)) {
				throw new InvalidAddressPrefixException('This is not valid zcash address prefix - ' . $this->address);
			}
			return true;
		} catch (InvalidArgumentException $e) {
			throw new InvalidAddressException('This is not valid zcash address - ' . $this->address);
		}
	}

}
