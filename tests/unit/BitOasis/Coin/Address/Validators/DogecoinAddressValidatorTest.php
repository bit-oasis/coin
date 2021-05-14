<?php

namespace BitOasis\Coin\Address\Validators;

use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class DogecoinAddressValidatorTest extends UnitTest {

	public function providerValidate() {
		return [
			['DJtCUTgitjdxXTUQK78BVm93AmrfFLAiWy', true],
			['DJtCUTgitjdxXTUQK78BVm94AmrfFLAiWy', false],
			['DJtCUTgitjdxXTUQK78BVm93AmrfFLAiWz', false],
			['DCu92sq6BUC2eDZUWkFnng8h28HM33WDpW', true],
			['AFiDLLoAx9JSgNJCnLhrQ14wq2FQTjD7J6', true],
			['A7DC5S9VjuHXpCAXWohuLNza9BxeuCWNWG', true],
			['9y992i9uQjr3PJFS1EPmVrd6FahsJjhuk3', true],
			['9yVEnEEbXLE1HPsM59yhQeVo8f4hPgJTXa', true],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx', false],
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu', false],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx', false],
			['MFWg1wVLhorAwDEtCTGtjHvCBvQZpEv6dm', false],
			['LP8A3cjNAXsMBQvy9s4ptavo7owhS2XPr1', false],
			['Qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', false],
			['t1gRHW5AYgLsNwKRTLXGcXU2wWdP3C3bEtX', false],
			['rLW9gnQo7BQhU6lgk5keqYnH3TVrCxGRzm', false],
		];
	}

	/**
	 * @param string $address
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidate($address, $expectedValue) {
		$validator = new DogecoinAddressValidator($address);
		$this->assertEquals($validator->validate(), $expectedValue);
	}
}
