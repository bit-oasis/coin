<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\WaxAddressValidator;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 *
 * WAX account names follow the EOS format (a-z, 1-5 and dots, length 1 to 12), with a memo used
 * to tell apart deposits sharing one account.
 */
class WaxAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var string|null */
	protected $memo;

	/** @var Cryptocurrency */
	protected $currency;

	/** @var CryptocurrencyNetwork */
	protected $cryptocurrencyNetwork;

	/**
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @param string|null $memo
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork, $memo = null) {
		(new WaxAddressValidator($address, $memo))->validateWithExceptions();

		$this->address = $address;
		$this->currency = $currency;
		$this->cryptocurrencyNetwork = $cryptocurrencyNetwork;
		$this->memo = $memo;
	}

	/**
	 * @inheritDoc
	 */
	public function toString(): string {
		return 'Address: ' . $this->address . ($this->memo === null ? '' : (', Memo: ' . $this->memo));
	}

	/**
	 * @inheritDoc
	 */
	public function getAddress(): string {
		return $this->address;
	}

	/**
	 * @return string|null
	 */
	public function getMemo() {
		return $this->memo;
	}

	/**
	 * @inheritDoc
	 */
	public function getAdditionalId() {
		return $this->getMemo();
	}

	/**
	 * @inheritDoc
	 */
	public function supportsAdditionalId(): bool {
		return static::supportsClassAdditionalId();
	}

	/**
	 * @inheritDoc
	 */
	public function getAdditionalIdName(): ?string {
		return static::getClassAdditionalIdName();
	}

	/**
	 * @inheritDoc
	 */
	public static function supportsClassAdditionalId(): bool {
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public static function getClassAdditionalIdName(): ?string {
		return 'memo';
	}

	/**
	 * @return Cryptocurrency
	 */
	public function getCurrency(): Cryptocurrency {
		return $this->currency;
	}

	/**
	 * @return CryptocurrencyNetwork
	 */
	public function getNetwork(): CryptocurrencyNetwork {
		return $this->cryptocurrencyNetwork;
	}

	/**
	 * @inheritDoc
	 */
	public function serialize(): string {
		return static::serializeAddress($this->address, $this->memo);
	}

	/**
	 * @param string $address
	 * @param string|null $memo
	 * @return string
	 */
	public static function serializeAddress($address, $memo = null): string {
		return $address . ($memo === null ? '' : ('#' . $memo));
	}

	/**
	 * @param CryptocurrencyAddress $address
	 * @return bool
	 */
	public function equals(CryptocurrencyAddress $address): bool {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address && $this->memo === $address->memo;
	}

	/**
	 * @param $string
	 * @param Cryptocurrency $cryptocurrency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @return CryptocurrencyAddress
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork): CryptocurrencyAddress {
		$separatorPos = strpos($string, '#');
		if ($separatorPos === false) {
			$address = $string;
			$memo = null;
		} else {
			$address = substr($string, 0, $separatorPos);
			$memo = substr($string, $separatorPos + 1);
		}

		return new static($address, $cryptocurrency, $cryptocurrencyNetwork, $memo);
	}

}
