<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Address\Validators\Monero\BaseAddressValidator;
use BitOasis\Coin\Address\Validators\Monero\IntegratedAddressValidator;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class MoneroAddressValidator implements ValidationInterface {

	/** @var string */
	protected $address;

	/** @var string|null */
	protected $paymentId;

	/** @var BaseAddressValidator */
	protected $baseValidator;

	/** @var IntegratedAddressValidator */
	protected $integratedValidator;

	/**
	 * @param string $address
	 * @param string $paymentId
	 */
	public function __construct($address, $paymentId = null) {
		$this->address = $address;
		$this->paymentId = $paymentId;
		$this->baseValidator = new BaseAddressValidator($address, $paymentId);
		$this->integratedValidator = new IntegratedAddressValidator($address, $paymentId);
	}

	public function validate() {
		return $this->baseValidator->validate() || $this->integratedValidator->validate();
	}

	/**
	 * @return bool
	 * @throws InvalidAddressPrefixException
	 * @throws InvalidAddressException
	 */
	public function validateWithExceptions() {
		try {
			return $this->baseValidator->validateWithExceptions();
		} catch (InvalidAddressException $e) {
		}
		try {
			return $this->integratedValidator->validateWithExceptions();
		} catch (InvalidAddressPrefixException $e) {
			throw new InvalidAddressPrefixException('This is not valid monero address prefix - ' . $this->address, 0, $e);
		} catch (InvalidAddressException $e) {
			throw new InvalidAddressException('This is not valid monero address - ' . $this->address, 0, $e);
		}
	}

	/**
	 * @return bool
	 */
	public function isBaseAddress() {
		return $this->baseValidator->validate();
	}

	/**
	 * @return bool
	 */
	public function isIntegratedAddress() {
		return $this->integratedValidator->validate();
	}

}
