<?php

namespace BitOasis\Coin\Address\Validators;

use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class NeoAddressValidatorTest extends UnitTest {

	public function providerValidate() {
		return [
			['AKxnTpwQzZNLaGpK1WhUSucM9G5e71e19Y', true],
			['AH9oFBoQn88AUXfZsjmLPBiiZ27FoQGrbC', true],
			['ATKQ2f3iHtojSrzXkESavZ1qyhLeoPX2fA', true],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx', false],
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu', false],
		];
	}

	/**
	 * @param string $address
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidate($address, $expectedValue) {
		$validator = new NeoAddressValidator($address);
		$this->assertEquals($validator->validate(), $expectedValue);
	}

}
