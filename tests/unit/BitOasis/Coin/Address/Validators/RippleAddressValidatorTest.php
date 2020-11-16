<?php

namespace BitOasis\Coin\Address\Validators;

use UnitTest;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class RippleAddressValidatorTest extends UnitTest {

	public function providerValidate() {
		return [
			['rEr3hxu5aim5tDWwH7H8BK47K91tR8c7FM', null, true],
			['rKiCet8SdvWxPXnAgYarFUXMh1zCPz432Y', null, true],
			['rLW9gnQo7BQhU6igk5keqYnH3TVrCxGRzm', 3140149957, true],
			['rLW9gnQo7BQhU6igk5keqYnH3TVrCxGRzm', 4294967295, true],
			['rLW9gnQo7BQhU6igk5keqYnH3TVrCxGRzm', 4294967296, false],
			['rLW9gnQo7BQhU6igk5keqYnH3TVrCxGRzm', -3140149957, false],
			['rLW9gnQo7BQhU6igk5keqYnH3TVrCxGRzm', 31401499570, false],
			['rLW9gnQo7BQhU6igK5KeqYnH3TVrCxGRzm', null, false],
			['rLW9gnQo7BQhU6igk5keqYnH3TVrCxGRzz', null, false],
			['rLW9gnQo7BQhU6Igk5keqYnH3TVrCxGRzm', null, false],
			['rLW9gnQo7BQhU6lgk5keqYnH3TVrCxGRzm', null, false],
		];
	}

	/**
	 * @param string $address
	 * @param $tag
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidate($address, $tag, $expectedValue) {
		$validator = new RippleAddressValidator($address, $tag);
		$this->assertEquals($validator->validate(), $expectedValue);
	}

	/**
	 * @param string $address
	 * @param $tag
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidateWithExceptions($address, $tag, $expectedValue) {
		if ($expectedValue === true) {
			$validator = new RippleAddressValidator($address, $tag);
			$this->assertEquals($validator->validateWithExceptions(), $expectedValue);
		}
	}

	/**
	 * @param string $address
	 * @param $tag
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidateWithExceptionsInvalidAddress($address, $tag, $expectedValue) {
		if ($expectedValue === false) {
			$validator = new RippleAddressValidator($address, $tag);
			$this->tester->expectThrowable(InvalidAddressException::class, function() use($validator) {
				$validator->validateWithExceptions();
			});
		}
	}

}
