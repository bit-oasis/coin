<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Exception\InvalidAddressException;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 *
 * WAX account name: 1 to 12 characters of a-z, 1-5 and dots. Dots only separate name parts, so a
 * name can neither start nor end with one nor have two in a row - trailing dots are dropped when
 * the name is encoded on chain, which would make such a name just another spelling of a shorter
 * one. Names shorter than 12 characters are premium names or accounts created under a suffix
 * owned by someone else, such as the ".wam" names handed out by the WAX Cloud Wallet.
 */
class WaxAddressValidator implements ValidationInterface {

	const MAX_LENGTH = 12;
	const MAX_MEMO_LENGTH = 256;
	const PATTERN = '/^[a-z1-5](?:[a-z1-5]|\.(?=[a-z1-5])){0,11}$/';

	/** @var string */
	protected $address;

	/** @var string|null */
	protected $memo;

	/**
	 * @param string $address
	 * @param string|null $memo
	 */
	public function __construct($address, $memo = null) {
		$this->address = $address;
		$this->memo = $memo;
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
		if (!is_string($this->address)) {
			throw new InvalidAddressException('WAX address must be a string, ' . gettype($this->address) . ' given');
		}
		if ($this->address === '' || strlen($this->address) > static::MAX_LENGTH) {
			throw new InvalidAddressException('Address has invalid length');
		}
		if ($this->memo !== null && !mb_check_encoding($this->memo, 'UTF-8')) {
			throw new InvalidAddressException('Memo is not valid UTF-8 string');
		}
		if ($this->memo !== null && strlen($this->memo) > static::MAX_MEMO_LENGTH) {
			throw new InvalidAddressException('Memo is too long');
		}
		if (!preg_match(static::PATTERN, $this->address)) {
			throw new InvalidAddressException('This is not valid WAX address - ' . $this->address, 0);
		}

		return true;
	}

}
