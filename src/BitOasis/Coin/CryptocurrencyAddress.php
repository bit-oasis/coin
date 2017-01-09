<?php


namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidAddressException;

interface CryptocurrencyAddress {

	/**
	 * @return string
	 */
	public function toString();

	/**
	 * @return string
	 */
	public function serialize();

	/**
	 * @return Cryptocurrency
	 */
	public function getCurrency();

	/**
	 * @param CryptocurrencyAddress $address
	 * @return bool
	 */
	public function equals(CryptocurrencyAddress $address);

	/**
	 * @param $string
	 * @param Cryptocurrency $cryptocurrency
	 * @return CryptocurrencyAddress
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency);

}