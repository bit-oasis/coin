<?php

namespace BitOasis\Coin\Types;

use BitOasis\Coin\Coin;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DecimalType;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinType extends DecimalType {

	const COIN = 'coin';

	/**
	 * {@inheritdoc}
	 */
	public function getName() {
		return self::COIN;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
		$fieldDeclaration['precision'] = 40;
		$fieldDeclaration['scale'] = 0;
		return $platform->getDecimalTypeDeclarationSQL($fieldDeclaration);
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
		if($value instanceof Coin) {
			return $value->toIntString();
		}
		return $value;
	}

}