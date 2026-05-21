<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\SeiCosmosAddressValidator;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ETH as ETHValidator;

/**
 * @author Robert Mkrtchyan <robert.mkrtchyan@bitoasis.net>
 *
 * SEI is Cosmos-EVM compatible blockchain, which means from the same PK both Cosmos based and EVM based addresses are derived and used on the same CHAIN!
 */
class SeiAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var int|string|null */
	protected $tag;

	/** @var Cryptocurrency */
	protected $currency;

	/** @var CryptocurrencyNetwork */
	protected $cryptocurrencyNetwork;

	/**
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @param int|string|null $tag
	 * @throws InvalidAddressException
	 */
	public function __construct(string $address, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork, $tag = null) {
		$this->address = $address;
		$this->currency = $currency;
		$this->cryptocurrencyNetwork = $cryptocurrencyNetwork;
		$this->tag = $tag;

		$this->validateAddress();
	}

	public function toString(): string {
		if ($this->isEvmAddress()) {
			return $this->address;
		}

		return 'Address: ' . $this->address . ($this->tag === null ? '' : (', Memo: ' . $this->tag));
	}

	public function getCurrency(): Cryptocurrency {
		return $this->currency;
	}

	public function getNetwork(): CryptocurrencyNetwork {
		return $this->cryptocurrencyNetwork;
	}

	public function serialize(): string {
		if ($this->isEvmAddress()) {
			return $this->address;
		}

		return $this->address . ($this->tag === null ? '' : ('#' . $this->tag));
	}

	public static function deserialize($string, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork): SeiAddress {
		$addressParts = explode('#', $string);
		return new static($addressParts[0], $cryptocurrency, $cryptocurrencyNetwork, isset($addressParts[1]) ? (int)$addressParts[1] : null);
	}

	public function equals(CryptocurrencyAddress $address): bool {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address && $this->tag === $address->tag;
	}

	public function getAddress(): string {
		return $this->address;
	}

	/**
	 * @inheritDoc
	 */
	public function getAdditionalId() {
		return $this->tag;
	}

	/**
	 * @inheritDoc
	 */
	public function supportsAdditionalId(): bool {
		return !$this->isEvmAddress();
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

	public static function getClassAdditionalIdName(): string {
		return 'memo';
	}

	public function isEvmAddress(): bool {
		try {
			$this->validateEvmAddress();
			return true;
		} catch (InvalidAddressException $ex) {
			return false;
		}
	}

	/**
	 * @throws InvalidAddressException
	 */
	private function validateEvmAddress(): void {
		if ($this->tag !== null) {
			throw new InvalidAddressException("Tag is not supported on EVM based {$this->currency->getName()} address");
		}

		if (!(new ETHValidator($this->address))->validate()) {
			throw new InvalidAddressException("'{$this->address}' is not valid {$this->currency->getName()} address");
		};
	}

	/**
	 * @throws InvalidAddressException
	 */
	private function validateCosmosAddress(): void {
		(new SeiCosmosAddressValidator($this->address, $this->tag))->validateWithExceptions();
	}

	/**
	 * @throws InvalidAddressException
	 */
	private function validateAddress() {
		if ($this->isEvmAddress()) {
			return;
		}

		$this->validateCosmosAddress();
	}
}