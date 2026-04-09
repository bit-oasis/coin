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
	public function __construct($address, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork, ?string $memo = null) {
		if (!$this->isValid($address, $memo)) {
			throw new InvalidAddressException('This is not valid toncoin address - ' . $address);
		}
		$this->address = $address;
		$this->currency = $currency;
		$this->cryptocurrencyNetwork = $cryptocurrencyNetwork;
		$this->memo = $memo;
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
		return 'Address: ' . $this->address . ($this->memo === null ? '' : (', Memo: ' . $this->memo));
	}

	/**
	 * @inheritDoc
	 */
	public function serialize(): string {
		return $this->address . ($this->memo === null ? '' : ('#' . $this->memo));
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

	public function getMemo(): ?string {
		return $this->memo;
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

	/**
	 * @param CryptocurrencyAddress $address
	 * @return bool
	 */
	public function equals(CryptocurrencyAddress $address): bool {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address && $this->memo === $address->memo;
	}

	/**
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork): CryptocurrencyAddress {
		$addressParts = explode('#', $string);
		return new static($addressParts[0], $cryptocurrency, $cryptocurrencyNetwork, $addressParts[1] ?? null);
	}

	public function isValid(string $address, ?string $memo = null): bool {
		return (new ToncoinAddressValidator($address, $memo))->validate();
	}

}