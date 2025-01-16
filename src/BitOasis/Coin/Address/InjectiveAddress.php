<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\InjectiveBech32AddressValidator;
use BitOasis\Coin\Address\Validators\InjectiveEvmAddressValidator;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class InjectiveAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var string|null */
	protected $memo;

	/** @var Cryptocurrency */
	protected $currency;

	/** @var CryptocurrencyNetwork */
	protected $cryptocurrencyNetwork;

	/**
	 * @throws InvalidAddressException
	 */
	public function __construct(string $address, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork, string $memo = null) {
		if (!$this->isValid($address, $memo)) {
			throw new InvalidAddressException('This is not valid injective address - ' . $address . ($memo === null ? '' : ('#' . $memo)));
		}
		$this->address = $address;
		$this->memo = $memo;
		$this->currency = $currency;
		$this->cryptocurrencyNetwork = $cryptocurrencyNetwork;
	}

	/**
	 * @inheritDoc
	 */
	public function getAddress(): string {
		return $this->address;
	}

	public function getMemo(): ?string {
		return $this->memo;
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
	public function serialize(): string {
		return $this->address . ($this->memo === null ? '' : ('#' . $this->memo));
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
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public static function getClassAdditionalIdName(): ?string {
		return 'memo';
	}

	/**
	 * @inheritDoc
	 */
	public function getAdditionalId() {
		return $this->getMemo();
	}

	public function equals(CryptocurrencyAddress $address): bool {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address;
	}

	/**
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork): CryptocurrencyAddress {
		$addressParts = explode('#', $string);
		return new static($addressParts[0], $cryptocurrency, $cryptocurrencyNetwork, $addressParts[1] ?? null);
	}

	public function isValid(string $address, ?string $memo): bool {
		// TODO: Move memo part validation inside validators
		return $this->isValidBech32Address($address) || $this->isValidEvmAddress($address) && $memo === null;
	}

	private function isValidBech32Address(string $address): bool {
		return (new InjectiveBech32AddressValidator($address))->validate();
	}

	private function isValidEvmAddress(string $address): bool {
		return (new InjectiveEvmAddressValidator($address))->validate();
	}
}