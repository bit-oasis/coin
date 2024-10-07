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
	 * TODO: Do we need to keep cryptocurrency in address class?
	 * For any ERC20 token address and class would be the same, but currency not,
	 * Is it considered as a same address? (probably yes)
	 */
	public function getCurrency();

	/**
	 * @return CryptocurrencyNetwork
	 */
	public function getNetwork();

	/**
	 * Supports address additional ID (e.g. tag, memo, paymentId, etc.)?
	 * @return bool if TRUE, ID could be NULL anyway
	 */
	public function supportsAdditionalId();

	/**
	 * @return string|null
	 */
	public function getAdditionalIdName();

	/**
	 * @return bool
	 */
	public static function supportsClassAdditionalId();

	/**
	 * @return string|null
	 */
	public static function getClassAdditionalIdName();

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
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @return CryptocurrencyAddress
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork);

}