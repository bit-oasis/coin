<?php


namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidAddressException;

interface CryptocurrencyAddress {

	/**
	 * @return string simple address without additional ID
	 */
	public function getAddress();

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
	 * Supports address additional ID (e.g. tag, memo, paymentId, etc.)?
	 * @return bool if TRUE, ID could be NULL anyway
	 */
	public function supportsAdditionalId();

	/**
	 * @return bool
	 */
	public static function hasAdditionalId();

	/**
	 * @return string|null
	 */
	public static function getAdditionalIdName();

	/**
	 * Get additional address identifier (e.g. tag, memo, paymentId, etc.)
	 * @return mixed
	 */
	public function getAdditionalId();

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