<?php

namespace BitOasis\Coin\Address\Validators;

use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class TezosAddressValidatorTest extends UnitTest {

	public function providerValidate() {
		return [
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM', true],
			['tz1VwmmesDxud2BJEyDKUTV5T5VEP8tGBKGD', true],
			['tz1VAkGFFwTYAPbc3yekKVEFuqvYkttEHmh5', true],
			['tz1SYq214SCBy9naR6cvycQsYcUGpBqQAE8d', true],
			['tz1NwNhmgcoonfpLtUJP96a6ywjfYdhzh5By', true],
			['tz2BFTyPeYRzxd5aiBchbXN3WCZhx7BqbMBq', true],
			['KT1WYu65MYGRAa34vBzqSyWJAJz8S5YYoS9Q', true],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx', false],
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu', false],
			['tz1NwNhmgcoonfpLtUJP96a6ywjfYdhzh5Bg', false],
		];
	}

	/**
	 * @param string $address
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidate($address, $expectedValue) {
		$validator = new TezosAddressValidator($address);
		$this->assertEquals($validator->validate(), $expectedValue);
	}

}
