<?php

namespace BitOasis\Coin\Utils\Base58Check;

use BitOasis\Coin\Utils\Hashes;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class Base58CheckOptions {

	/** @var int */
	protected $versionLength;

	/** @var int */
	protected $hashLength;

	/** @var callable */
	protected $checksumHashFunction;

	/**
	 * @param int $versionLength
	 * @param int $hashLength
	 * @param callable $checksumHashFunction function(string $value) : string
	 * @throws InvalidArgumentException
	 */
	public function __construct($versionLength = 1, $hashLength = 20, callable $checksumHashFunction = null) {
		Base58DecodedAddress::validateLengths($versionLength, $hashLength);
		
		$this->versionLength = $versionLength;
		$this->hashLength = $hashLength;
		$this->checksumHashFunction = $checksumHashFunction === null ? [Hashes::class, 'sha256x2'] : $checksumHashFunction;
	}

	/**
	 * @return int
	 */
	public function getVersionLength() {
		return $this->versionLength;
	}

	/**
	 * @return int
	 */
	public function getHashLength() {
		return $this->hashLength;
	}

	/**
	 * @return callable
	 */
	public function getChecksumHashFunction() {
		return $this->checksumHashFunction;
	}

	/**
	 * @param int $versionLength
	 * @throws InvalidArgumentException
	 */
	public function setVersionLength($versionLength) {
		Base58DecodedAddress::validateLengths($versionLength, $this->hashLength);
		$this->versionLength = $versionLength;
	}

	/**
	 * @param int $hashLength
	 * @throws InvalidArgumentException
	 */
	public function setHashLength($hashLength) {
		Base58DecodedAddress::validateLengths($this->versionLength, $hashLength);
		$this->hashLength = $hashLength;
	}

	/**
	 * @param callable $checksumHashFunction function(string $value) : string
	 */
	public function setChecksumHashFunction(callable $checksumHashFunction) {
		$this->checksumHashFunction = $checksumHashFunction;
	}

}
