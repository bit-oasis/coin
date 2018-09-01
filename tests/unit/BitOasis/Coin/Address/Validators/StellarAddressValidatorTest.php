<?php

namespace BitOasis\Coin\Address\Validators;

use UnitTest;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class StellarAddressValidatorTest extends UnitTest {

	public function providerValidate() {
		return [
			['GAWPTHY6233GRWZZ7JXDMVXDUDCVQVVQ2SXCSTG3R3CNP5LQPDAHNBKL', '9296673e8b7048a159', true],
			['GAWPTHY6233GRWZZ7JXDMVXDUDCVQVVQ2SXCSTG3R3CNP5LQPDAHNBKL', '9296673e8b7048a159a34321234a', true],
			['GAWPTHY6233GRWZZ7JXDMVXDUDCVQVVQ2SXCSTG3R3CNP5LQPDAHNBKL', '9296673e8b7048a159a34321234a9', false],
			['GAWPTHY6233GRWZZ7JXDMVXDUDCVQVVQ2SXCSTG3R3CNP5LQPDAHNBKL', '↝↝↝↝↝↝↝↝↝', true],
			['GAWPTHY6233GRWZZ7JXDMVXDUDCVQVVQ2SXCSTG3R3CNP5LQPDAHNBKL', '↝↝↝↝↝↝↝↝↝a', true],
			['GAWPTHY6233GRWZZ7JXDMVXDUDCVQVVQ2SXCSTG3R3CNP5LQPDAHNBKL', '↝↝↝↝↝↝↝↝↝↝', false],
			['GB3RMPTL47E4ULVANHBNCXSXM2ZA5JFY5ISDRERPCXNJUDEO73QFZUNK', null, true],
			['GAWPTHY6233GRWZZ7JXDMVXDUDCVQVVQ2SXCSTG3R3CNP5LQPDAHNBKL', null, true],
			['rLW9gnQo7BQhU6igk5keqYnH3TVrCxGRzm', null, false],
			['47CL7FiNtW417VjzWt9Zse8Z8URhaHaA2L9jJq6rrLtDhiYK9PfbCavhhMKws9xEdKHBeGcQtJmPt4uEMivooNztC5UkHLD', null, false],
			['t3eF9X6X2dSo7MCvTjfZEzwWrVzquxRLNeC', null, false],
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu', null, false],
		];
	}

	/**
	 * @param string $address
	 * @param $memo
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidate($address, $memo, $expectedValue) {
		$validator = new StellarAddressValidator($address, $memo);
		$this->assertEquals($expectedValue, $validator->validate());
	}

	/**
	 * @param string $address
	 * @param $memo
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidateWithExceptions($address, $memo, $expectedValue) {
		if ($expectedValue === true) {
			$validator = new StellarAddressValidator($address, $memo);
			$this->assertEquals($expectedValue, $validator->validateWithExceptions());
		}
	}

	/**
	 * @param string $address
	 * @param $memo
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidateWithExceptionsInvalidAddress($address, $memo, $expectedValue) {
		if ($expectedValue === false) {
			$validator = new StellarAddressValidator($address, $memo);
			$this->tester->expectException(InvalidAddressException::class, function() use($validator) {
				$validator->validateWithExceptions();
			});
		}
	}

}
