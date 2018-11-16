<?php

namespace BitOasis\Coin\Address\Validators\BitcoinCash;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;
use BitOasis\Coin\Exception\AddressMixedCaseException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
interface AddressValidator extends ValidationInterface {

	/**
	 * @return boolean only true or exception is thrown
	 * @throws InvalidAddressException
	 * @throws InvalidAddressPrefixException
	 * @throws AddressMixedCaseException
	 */
	public function validateWithExceptions();

	/**
	 * @return bool
	 */
	public function isBase58Address();

	/**
	 * @return bool
	 */
	public function isCashAddress();

	/**
	 * @param bool $cashAddressAllowed
	 */
	public function setCashAddressAllowed($cashAddressAllowed);

	/**
	 * @return bool
	 */
	public function isCashAddressAllowed();

}
