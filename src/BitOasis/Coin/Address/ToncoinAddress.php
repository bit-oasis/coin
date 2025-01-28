<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\ToncoinAddressValidator;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class ToncoinAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/** @var CryptocurrencyNetwork */
	protected $cryptocurrencyNetwork;

	/**
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		if (!$this->isValid($address)) {
			throw new InvalidAddressException('This is not valid toncoin address - ' . $address);
		}
		$this->address = $address;
		$this->currency = $currency;
		$this->cryptocurrencyNetwork = $cryptocurrencyNetwork;
	}

	/**
	 * @inheritDoc
	 */
	public function getAddress(): string {
		return $this->address;
	}

	/**
	 * @inheritDoc
	 */
	public function toString(): string {
		return $this->address;
	}

	/**
	 * @inheritDoc
	 */
	public function serialize(): string {
		return $this->address;
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
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public static function getClassAdditionalIdName(): ?string {
		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function getAdditionalId() {
		return null;
	}

	/**
	 * @param CryptocurrencyAddress $address
	 * @return bool
	 */
	public function equals(CryptocurrencyAddress $address): bool {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address;
	}

	/**
	 * @param $string
	 * @param Cryptocurrency $cryptocurrency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @return CryptocurrencyAddress
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork): CryptocurrencyAddress {
		return new static($string, $cryptocurrency, $cryptocurrencyNetwork);
	}

	/**
	 * @param string $address
	 * @return bool
	 */
	public function isValid(string $address): bool {
		return (new ToncoinAddressValidator($address))->validate();
	}

}