<?php

namespace BitOasis\Coin\Exception;

use BitOasis\Coin\Cryptocurrency;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 * @author Filip Procházka <filip@prochazka.su>
 */
class MetadataException extends \LogicException {

	public static function missingCurrencyReference(\ReflectionProperty $refl) {
		$property = $refl->getDeclaringClass()->getName() . '::$' . $refl->getName();
		return new static("Property $property is missing reference to cryptocurrency field. You can specify it using @ORM\\Column(options={\"cryptocurrency\":\"fieldName\"})");
	}



	public static function invalidCurrencyReference(\ReflectionProperty $refl) {
		$property = $refl->getDeclaringClass()->getName() . '::$' . $refl->getName();
		return new static("Property $property has invalid currency reference in it's Column options. It must be a valid association to " . Cryptocurrency::class . " entity.");
	}

}
