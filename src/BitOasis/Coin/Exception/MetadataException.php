<?php

namespace BitOasis\Coin\Exception;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 * @author Filip Procházka <filip@prochazka.su>
 */
class MetadataException extends \LogicException {

	public static function missingReference(\ReflectionProperty $refl, string $association) {
		$property = $refl->getDeclaringClass()->getName() . '::$' . $refl->getName();
		return new static("Property $property is missing reference to $association field. You can specify it using @ORM\\Column(options={\"$association\":\"fieldName\"})");
	}

	public static function invalidReference(\ReflectionProperty $refl, $association, $associationClass) {
		$property = $refl->getDeclaringClass()->getName() . '::$' . $refl->getName();
		return new static("Property $property has invalid $association reference in it's Column options. It must be a valid association to $associationClass entity.");
	}

}
