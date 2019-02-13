<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author Lukas Satin <luke.satin@gmail.com>
 */
class EosAddressValidator implements ValidationInterface {

	/** @var string */
	protected $address;

	/** @var string */
	protected $memo;

	/**
	 * @param string $address
	 * @param string $memo
	 */
	public function __construct($address, $memo = null) {
		$this->address = $address;
		$this->memo = $memo;
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
		if ($this->memo !== null && !mb_check_encoding($this->memo, 'UTF-8')) {
			throw new InvalidAddressException('Memo is not valid UTF-8 string');
		}
		if (strlen($this->memo) > 256) {
			throw new InvalidAddressException('Memo is too long');
		}
		/** Less strict comparison is intentional here */
		if (preg_match('/[a-z12345.]{12}/', $this->address) == 0) {
			throw new InvalidAddressException('This is not valid EOS address - ' . $this->address, 0);
		}

		return true;
	}

}
