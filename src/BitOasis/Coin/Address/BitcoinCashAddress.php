<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;
use BitOasis\Coin\Address\Validators\BitcoinCashAddressValidator;
use StephenHill\Base58;
use CashAddr\CashAddress;
use CashAddr\Exception\CashAddressException;
use CashAddr\Exception\Base32Exception;

/**
 * @author David Fiedor <davefu@seznam.cz>
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class BitcoinCashAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/** @var BitcoinCashAddressValidator */
	protected $validator;

	/** @var array */
	protected $cashAddressToBase58Prefixes = [
		'pubkeyhash' => 0x00,
		'scripthash' => 0x05,
	];

	/**
	 * BitcoinCashAddress constructor.
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param bool $cashAddressAllowed
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, $cashAddressAllowed = true) {
		$this->validateAddress($address, $cashAddressAllowed);
		$this->address = $address;
		$this->currency = $currency;
		$this->validator = $this->createValidator($address);
	}

	public function toString() {
	    return $this->address;
	}

	/**
	 * @return Cryptocurrency
	 */
	public function getCurrency() {
		return $this->currency;
	}

	/**
	 * @return string
	 */
	public function serialize() {
		return $this->address;
	}

	/**
	 * @param CryptocurrencyAddress $address
	 * @return bool
	 */
	public function equals(CryptocurrencyAddress $address) {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address;
	}
	
	/**
	 * @param $string
	 * @param Cryptocurrency $cryptocurrency
	 * @return CryptocurrencyAddress
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency) {
		return new static($string, $cryptocurrency);
	}

	/**
	 * @return \static
	 * @throws InvalidAddressPrefixException
	 */
	public function toBase58() {
		if ($this->validator->isBase58Address()) {
			return $this;
		}
		
		try {
			list($prefix, $scriptType, $binaryHash) = CashAddress::decode($this->toFullAddressString());
			if ($prefix !== BitcoinCashAddressValidator::PREFIX_MAINNET) {
				throw new InvalidAddressPrefixException("Cannot convert CashAddress with prefix '$prefix'");
			}
			
			$payload = pack('C', $this->cashAddressToBase58Prefixes[$scriptType]) . $binaryHash;
			$hash = hash('sha256', $payload, true);
			$hash = hash('sha256', $hash, true);
			$hash = $payload . substr($hash, 0, 4);
			
			$base58 = new Base58();
			$base58BHash = $base58->encode($hash);
			
			return new static($base58BHash, $this->currency, false);
		} catch (CashAddressException $e) {
			$this->throwInvalidAddressException($e);
		} catch (Base32Exception $e) {
			$this->throwInvalidAddressException($e);
		}
	}

	/**
	 * @return \static
	 */
	public function toCashAddress() {
		if ($this->validator->isCashAddress()) {
			return $this;
		}
		
		$base58 = new Base58();
		$payload = $base58->decode($this->address);
		
		$version = unpack('C', substr($payload, 0, 1));
		$hash = substr($payload, 1, -4);
		$base58ToCashAddressPrefixes = array_flip($this->cashAddressToBase58Prefixes);
		$cashAddress = CashAddress::encode(BitcoinCashAddressValidator::PREFIX_MAINNET, $base58ToCashAddressPrefixes[reset($version)], $hash);
		
		return new static($cashAddress, $this->currency);
	}

	/**
	 * Force prefix for CashAddress. If address is not CassAddress same as {@see toString}.
	 * @return string
	 */
	public function toFullAddressString() {
		$prefix = $this->getCashAddressPrefixWithSeparator();
		if ($this->validator->isCashAddress() && substr($this->address, 0, strlen($prefix)) !== $prefix) {
			return $prefix . $this->address;
		}
		
		return $this->toString();
	}

	/**
	 * Force CashAddress without prefix. If address is not CassAddress same as {@see toString}.
	 * @return string
	 */
	public function toShortAddressString() {
		$prefix = $this->getCashAddressPrefixWithSeparator();
		if ($this->validator->isCashAddress()) {
			return str_replace($prefix, '', $this->address);
		}
		
		return $this->toString();
	}

	/**
	 * @return string
	 */
	protected function getCashAddressPrefixWithSeparator() {
		return BitcoinCashAddressValidator::PREFIX_MAINNET . BitcoinCashAddressValidator::BASE32_SEPARATOR;
	}

	/**
	 * @param $address
	 * @param bool $cashAddressAllowed
	 * @return bool
	 */
	private function isValid($address, $cashAddressAllowed = true) {
		return $this->crateValidator($address, $cashAddressAllowed)
			->validate();
	}

	/**
	 * @param $address
	 * @param bool $cashAddressAllowed
	 * @return bool
	 * @throws InvalidAddressException
	 */
	private function validateAddress($address, $cashAddressAllowed = true) {
		return $this->createValidator($address, $cashAddressAllowed)
			->validateWithExceptions();
	}

	/**
	 * @param string $address
	 * @param bool $cashAddressAllowed
	 * @return BitcoinCashAddressValidator
	 */
	private function createValidator($address, $cashAddressAllowed = true) {
		$validator = new BitcoinCashAddressValidator($address);
		$validator->setCashAddressAllowed($cashAddressAllowed);
		return $validator;
	}

	/**
	 * @param \Exception $e
	 * @throws InvalidAddressException
	 */
	protected function throwInvalidAddressException(\Exception $e) {
		throw new InvalidAddressException($e->getMessage(), 0, $e);
	}

}