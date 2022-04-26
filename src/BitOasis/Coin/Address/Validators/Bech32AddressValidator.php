<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Utils\Bech32\Bech32;
use BitOasis\Coin\Utils\Bech32\Bech32Exception;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
abstract class Bech32AddressValidator implements ValidationInterface {

	/** @var string */
	protected $address;

	/** @var mixed */
	protected $tag;

	/** @var string */
	protected $prefix = 'NONE';

	/** @var int */
	protected $bech32DecodedLength = 32;

	/** @var string */
	protected $label = 'NONE';

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
	public function validateWithExceptions(): bool {
		try {
			$decoded = Bech32::decode($this->address);

			if ($decoded[0] !== $this->prefix) {
				throw new InvalidArgumentException();
			}

			if (count($decoded[1]) !== $this->bech32DecodedLength) {
				throw new InvalidArgumentException();
			}

			$this->validateTag();
			return true;
		} catch (InvalidArgumentException $e) {
			throw new InvalidAddressException('This is not valid ' . $this->label .  ' address - ' . $this->address, 0, $e);
		} catch (Bech32Exception $e) {
			throw new InvalidAddressException('This is not valid ' . $this->label .  ' address - ' . $this->address, 0, $e);
		}
	}

	/**
	 * @return bool
	 * @throws InvalidAddressException
	 */
	protected function validateTag() {
		$tag = $this->tag;

		if ($tag !== null && (strlen($tag) < 1 || strlen($tag) > 256)) {
			throw new InvalidAddressException('This is not valid ' . $this->label .  ' tag - ' . $tag);
		}
		return true;
	}
}
