<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Exception\InvalidAddressException;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ETH as ETHValidator;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class XdcNetworkAddressValidator implements ValidationInterface {

	const NEW_ADDRESSES_PREFIX = "xdc";

	/** @var string */
	protected $address;

	public function __construct($address) {
		$this->address = $address;
	}

	/**
	 * @inheritDoc
	 */
	public function validate(): bool {
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
	public function validateWithExceptions(): bool {
		if ($this->isValidERC20Address()) {
			return true;
		}

		if (substr($this->address, 0, strlen(static::NEW_ADDRESSES_PREFIX)) !== static::NEW_ADDRESSES_PREFIX) {
			throw new InvalidAddressException('This is not valid xdc network address - ' . $this->address, 0);
		}

		return true;
	}

	/**
	 * @return bool
	 */
	private function isValidERC20Address(): bool {
		return (new ETHValidator($this->address))->validate();
	}
}