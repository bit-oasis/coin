<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Utils\Bech32\Bech32;
use BitOasis\Coin\Utils\Bech32\Bech32Exception;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class AvalancheBech32AddressValidator extends Bech32AddressValidator {

	/** @var string|null */
	protected $networkPrefix;

	public function __construct($address, $tag = null, $networkPrefix = null) {
		$this->networkPrefix = $networkPrefix;

		$this->prefix = 'avax';
		$this->label = 'Avalanche-' . $networkPrefix;

		parent::__construct($address, $tag);
	}

	public function validateWithExceptions(): bool {
		try {
			if ($this->networkPrefix === null) {
				$addressWithoutNetworkPrefix = $this->address;
				$prefix = null;
			} else if (strpos($this->address, '-') === false) {
				throw new InvalidArgumentException();
			} else{
				[$prefix, $addressWithoutNetworkPrefix] = explode('-', $this->address);
			}

			if ($prefix !== $this->networkPrefix) {
				throw new InvalidAddressException("$prefix is  not valid network prefix for $this->label address: $this->address");
			}

			$decoded = Bech32::decode($addressWithoutNetworkPrefix);

			if ($decoded[0] !== $this->prefix) {
				throw new InvalidArgumentException();
			}

			if (!in_array(count($decoded[1]), $this->bech32DecodedLengths)) {
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

}
