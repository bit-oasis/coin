<?php

namespace BitOasis\Coin\Types;

use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CryptocurrencyAddressType extends Type {

	const CRYPTOCURRENCY_ADDRESS = 'cryptocurrencyAddress';
	const FIELD_LENGTH = 256;

	/**
	 * {@inheritdoc}
	 */
	public function getName() {
		return self::CRYPTOCURRENCY_ADDRESS;
	}

	/**
	 * Gets the SQL declaration snippet for a field of this type.
	 *
	 * @param array $fieldDeclaration The field declaration.
	 * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
	 *
	 * @return string
	 */
	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
		return $platform->getStringTypeDeclarationSQL(['length' => self::FIELD_LENGTH]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform) {
		return $value;
	}

	/**
	 * {@inheritdoc}
	 */
	public function convertToDatabaseValue($value, AbstractPlatform $platform) {
		if($value instanceof CryptocurrencyAddress) {
			$address = $value->serialize();
			if(strlen($address) > self::FIELD_LENGTH) {
				throw new InvalidAddressException('Serialized address is too long - ' . $address);
			}
			return $address;
		}
		return $value;
	}

}