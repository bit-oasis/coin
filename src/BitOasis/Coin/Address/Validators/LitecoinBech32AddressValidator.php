<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Utils\Bech32\Bech32;
use BitOasis\Coin\Utils\Bech32\Bech32Exception;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;

class LitecoinBech32AddressValidator extends Bech32AddressValidator
{

	/**
	 * @param string $address
	 * @param mixed $tag
	 */
	public function __construct($address, $tag = null)
	{
		$this->prefix = 'ltc';
		$this->label = 'Litecoin';

		parent::__construct($address, $tag);
	}

	/**
	 * @return bool
	 * @throws InvalidAddressException
	 */
	public function validateWithExceptions(): bool
	{
		try {
			// check to see if its decodable by Bech32, if not throws exception
			$decoded = Bech32::decode($this->address);

			// check to see if its prefix is ltc, if not throws exception
			if ($decoded[0] !== $this->prefix) {
				throw new InvalidArgumentException();
			}

			$this->validateTag();

			//if decodable by Bech32 and prefix is 'ltc' then return true
			return true;
		} catch (InvalidArgumentException|Bech32Exception $e) {
			throw new InvalidAddressException('This is not valid ' . $this->label . ' address - ' . $this->address, 0, $e);
		}
	}


}
