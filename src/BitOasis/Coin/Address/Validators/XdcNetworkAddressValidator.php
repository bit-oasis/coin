<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

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
		return substr($this->address, 0, strlen(static::NEW_ADDRESSES_PREFIX)) === static::NEW_ADDRESSES_PREFIX;
	}

}