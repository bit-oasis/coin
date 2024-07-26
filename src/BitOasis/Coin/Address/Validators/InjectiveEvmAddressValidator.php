<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Exception\InvalidAddressException;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class InjectiveEvmAddressValidator implements ValidationInterface {

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
	 * @throws InvalidAddressException
	 */
	public function validateWithExceptions(): bool {
		if (!preg_match('/^(0x)?[0-9a-f]{40}$/i', $this->address)) {
			throw new InvalidAddressException('This is not valid injective address - ' . $this->address, 0);
		}
		return true;
	}
}