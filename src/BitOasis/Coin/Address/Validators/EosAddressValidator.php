<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Utils\Base58Check\Base58Check;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;

/**
 * @author Lukas Satin <luke.satin@gmail.com>
 */
class RippleAddressValidator implements ValidationInterface {

	/** @var string */
	protected $address;

	/**
	 * @param string $address
	 */
	public function __construct($address) {
		$this->address = $address;
	}

	/**
	 * @return bool
	 */
	public function validate() {
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
	public function validateWithExceptions() {
		if (strlen($this->address) !== 12) {
			throw new InvalidAddressException('Address has invalid length');
		}

		// returns 1 if the <i>pattern</i>
		// matches given <i>subject</i>, 0 if it does not, or <b>FALSE</b>
		// if an error occurred.
		if (preg_match('/[a-z12345.]{12}/', $this->address) == 0) {
			throw new InvalidAddressException('This is not valid EOS address - ' . $this->address, 0);
		}

		return true;
	}

}
