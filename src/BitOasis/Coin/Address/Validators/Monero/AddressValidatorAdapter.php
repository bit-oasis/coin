<?php

namespace BitOasis\Coin\Address\Validators\Monero;

use BitOasis\Coin\Utils\CryptoNote\CryptoNote;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class AddressValidatorAdapter implements ValidationInterface {

	/** @var array */
	protected $base58PrefixToHexVersion = [];

	/** @var string */
	protected $address;

	/** @var string|null */
	protected $paymentId;

	public function __construct($address, $paymentId = null) {
		$this->address = $address;
		$this->paymentId = $paymentId === '' ? null : $paymentId;
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
			$this->validatePaymentId();
			$decodedAddress = CryptoNote::decodeAddress($this->address);
			if (!in_array($decodedAddress->getHexVersionUpper(), $this->base58PrefixToHexVersion)) {
				throw new InvalidAddressPrefixException('This is not valid monero address prefix - ' . $this->address);
			}
			return true;
		} catch (InvalidArgumentException $e) {
			throw new InvalidAddressException('This is not valid monero address - ' . $this->address);
		}
	}

	/**
	 * @return bool
	 * @throws InvalidAddressException
	 */
	protected function validatePaymentId() {
		if ($this->paymentId !== null && (!ctype_xdigit($this->paymentId) || strlen($this->paymentId) !== 64)) {
			throw new InvalidAddressException('This is not valid monero payment ID - ' . $this->paymentId);
		}
		return true;
	}

}
