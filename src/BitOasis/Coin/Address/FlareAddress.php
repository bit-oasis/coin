<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\FlareAddressValidator;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class FlareAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/** @var CryptocurrencyNetwork */
	protected $cryptocurrencyNetwork;

	/**
	 * @throws InvalidAddressException
	 */
	public function __construct(string $address, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		if (!$this->isValid($address)) {
			throw new InvalidAddressException('This is not valid flare address - ' . $address);
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

	public function getCurrency(): Cryptocurrency {
		return $this->currency;
	}

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

	public function equals(CryptocurrencyAddress $address): bool {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address;
	}

	/**
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork): CryptocurrencyAddress {
		return new static($string, $cryptocurrency, $cryptocurrencyNetwork);
	}

	public function isValid(string $address): bool {
		return (new FlareAddressValidator($address))->validate();
	}
}