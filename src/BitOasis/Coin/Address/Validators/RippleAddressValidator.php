<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Utils\Base58Check\Base58Check;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class RippleAddressValidator implements ValidationInterface {

	/** @var string */
	protected $address;

	/** @var mixed */
	protected $tag;

	/** @var string */
	protected $charset = 'rpshnaf39wBUDNEGHJKLM4PQRST7VWXYZ2bcdeCg65jkm8oFqi1tuvAxyz';

	/**
	 * @param string $address
	 * @param mixed $tag
	 */
	public function __construct($address, $tag = null) {
		$this->address = $address;
		$this->tag = $tag;
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
		try {
			Base58Check::decodeAddress($this->address, $this->charset);
			$this->validateTag();
			return true;
		} catch (InvalidArgumentException $e) {
			throw new InvalidAddressException('This is not valid ripple address - ' . $this->address, 0, $e);
		}
	}

	/**
	 * @return bool
	 * @throws InvalidAddressException
	 */
	protected function validateTag() {
		$tag = $this->tag;
		if ($tag !== null && (!is_numeric($tag) || (int)$tag != $tag || (int)$tag < 0 || (int)$tag > 4294967295)) {
			throw new InvalidAddressException('This is not valid ripple tag - ' . $tag);
		}
		return true;
	}

}
