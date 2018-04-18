<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Address\Validators\Zcash\TransparentAddressValidator;
use BitOasis\Coin\Address\Validators\Zcash\ShieldedAddressValidator;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class ZcashAddressValidator implements ValidationInterface {

	/** @var string */
	protected $address;

	/** @var TransparentAddressValidator */
	protected $transparentValidator;

	/** @var ShieldedAddressValidator */
	protected $shieldedValidator;

	public function __construct($address) {
		$this->address = $address;
		$this->transparentValidator = new TransparentAddressValidator($address);
		$this->shieldedValidator = new ShieldedAddressValidator($address);
	}

	public function validate() {
		return $this->transparentValidator->validate() || $this->shieldedValidator->validate();
	}

	/**
	 * @return bool
	 * @throws InvalidAddressPrefixException
	 * @throws InvalidAddressException
	 */
	public function validateWithExceptions() {
		try {
			return $this->transparentValidator->validateWithExceptions();
		} catch (InvalidAddressException $e) {
		}
		try {
			return $this->shieldedValidator->validateWithExceptions();
		} catch (InvalidAddressPrefixException $e) {
			throw new InvalidAddressPrefixException('This is not valid zcash address prefix - ' . $this->address, 0, $e);
		} catch (InvalidAddressException $e) {
			throw new InvalidAddressException('This is not valid zcash address - ' . $this->address, 0, $e);
		}
	}

	/**
	 * @return bool
	 */
	public function isTransparentAddress() {
		return $this->transparentValidator->validate();
	}

	/**
	 * @return bool
	 */
	public function isShieldedAddress() {
		return $this->shieldedValidator->validate();
	}

}
