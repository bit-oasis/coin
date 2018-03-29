<?php

namespace BitOasis\Coin\Address\Validators;

use CashAddr\Base32;
use CashAddr\CashAddress;
use CashAddr\Exception\CashAddressException;
use CashAddr\Exception\Base32Exception;
use Murich\PhpCryptocurrencyAddressValidation\Validation\BTC as BTCValidator;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;
use BitOasis\Coin\Exception\AddressMixedCaseException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class BitcoinCashAddressValidator implements ValidationInterface {

	const PREFIX_MAINNET = 'bitcoincash';
	const PREFIX_TESTNET = 'bchtest';
	const PREFIX_REGTEST = 'bchreg';
	const BASE32_SEPARATOR = Base32::SEPARATOR;

	/** @var string */
	protected $address;

	/** @var string */
	protected $expectedPrefix;

	/** @var BTCValidator - base58 validator */
	protected $btcValidator;

	/** @var bool */
	protected $cashAddressAllowed = true;

	/**
	 * @param string $address
	 * @param string $expectedPrefix
	 */
	public function __construct($address, $expectedPrefix = self::PREFIX_MAINNET) {
		$this->address = $address;
		$this->expectedPrefix = self::isPrefixValid($expectedPrefix) ? $expectedPrefix : self::PREFIX_MAINNET;
		$this->btcValidator = new BTCValidator($address);
	}

	/**
	 * @return boolean
	 */
	public function validate() {
		try {
			return $this->validateWithExceptions();
		} catch (InvalidAddressException $e) {
		}
		return false;
	}

	/**
	 * @return boolean only true or exception is thrown
	 * @throws InvalidAddressException
	 * @throws InvalidAddressPrefixException
	 * @throws AddressMixedCaseException
	 */
	public function validateWithExceptions() {
		if ($this->btcValidator->validate()) {
			return true;
		} else if (!$this->isCashAddressAllowed()) {
			$this->throwGeneralException();
		}
		
		if ($this->isCashAddressValid($this->address)) {
			return true;
		}
		
		$prefix = $this->expectedPrefix . self::BASE32_SEPARATOR;
		$address = $this->address;
		$addressChunks = explode(self::BASE32_SEPARATOR, $this->address);
		$addressChunksCount = count($addressChunks);

		if ($addressChunksCount === 2) {
			if ($addressChunks[0] === $this->expectedPrefix) {
				//Correct full length address
				$address = $addressChunks[1];
			} else {
				//Full length address, but prefix does not match
				throw new InvalidAddressPrefixException('This is not valid bitcoin cash prefix - ' . $this->address);
			}
		} else if ($addressChunksCount !== 1) {
			//More than one separator (or something else => explode returns always at least one item)
			$this->throwGeneralException();
		}
		
		$lowercaseHash = mb_strtolower($address, 'UTF-8');
		if ($lowercaseHash !== $address && mb_strtoupper($address, 'UTF-8') !== $address) {
			throw new AddressMixedCaseException('Address has to be only lower or upper case - ' . $this->address);
		} else {
			//preferred style
			$address = $lowercaseHash;
		}
		$address = $prefix . $address;
		
		if ($this->isCashAddressValid($address)) {
			return true;
		}
		$this->throwGeneralException();
	}

	/**
	 * @param bool $cashAddressAllowed
	 */
	public function setCashAddressAllowed($cashAddressAllowed) {
		$this->cashAddressAllowed = $cashAddressAllowed;
	}

	/**
	 * @return bool
	 */
	public function isCashAddressAllowed() {
		return $this->cashAddressAllowed;
	}

	/**
	 * @param $prefix
	 * @return bool
	 */
	protected static function isPrefixValid($prefix) {
		return in_array($prefix, [self::PREFIX_MAINNET, self::PREFIX_TESTNET, self::PREFIX_REGTEST], true);
	}

	/**
	 * @param string $address
	 * @return bool
	 */
	protected function isCashAddressValid($address) {
		try {
			$decodedAddress = CashAddress::decode($address);
			return $decodedAddress[0] === $this->expectedPrefix;
		} catch (CashAddressException $e) {
		} catch (Base32Exception $e) {
		}
		
		return false;
	}

	/**
	 * @throws InvalidAddressException
	 */
	protected function throwGeneralException() {
		throw new InvalidAddressException('This is not valid bitcoin cash address - ' . $this->address);
	}

}
