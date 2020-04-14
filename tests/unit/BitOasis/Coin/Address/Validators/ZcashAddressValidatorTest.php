<?php

namespace BitOasis\Coin\Address\Validators;

use UnitTest;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class ZcashAddressValidatorTest extends UnitTest {

	public function providerValidate() {
		return [
			['t1gRHW5AYgLsNwKRTLXGcXU2wWdP3C3bEtX', true],
			['t1aw8bdUeXAk4pmQtqwmh8boLwDAa1UEAYb', true],
			['t3eF9X6X2dSo7MCvTjfZEzwWrVzquxRLNeY', true],
			['t3YJXRu6pC4er4gsQU7R3jVnAuj4zMQCRU1', true],
			['zcc7P9dbq71WTwXi148oXGSvZC6eo2ZkMi3s57qTGLzm9Bhzt3GNVo4AzNJHtEM2gSbyvsthDkmKHCWLvTJ6ysEnfpdANVa', true],
			['zcWGwZU7FyUgpdrWGkeFqCEnvhLRDAVuf2ZbhW4vzNMTTR6VUgfiBGkiNbkC4e38QaPtS13RKZCriqN9VcyyKNRRQxbgnen', true],
			['zcdwoGUstQfr4r9PDDUyyDc7PRcrSduXw2CfK24WopQhi2WuQMv62PBMcuMCuScGtH6fFPZCYHbCMm5qssSpMkmN2R1Jfbs', true],
			['zcPqgLYtkxoqQwqUcXdZiwWmGXzTfqWUNeii1ACVihMn4riddJj52vPiC6aUbuKeVcB4Nhj8enV1jPSeSmrQ1qvYLpxfQYc', true],
			['t1gRHW5AYgLsNwKRTLXGcXU2wWdP3C3bEtP', false],
			['t3eF9X6X2dSo7MCvTjfZEzwWrVzquxRLNeC', false],
			['1QLbGuc3WGKKKpLs4pBp9H6jiQ2MgPkXRp', false],
			['3CDJNfdWX8m2NwuGUV3nhXHXEeLygMXoAj', false],
			['LbTjMGN7gELw4KbeyQf6cTCq859hD18guE', false],
			['zcc7P9dbq71WTwXi148oXGSvZC6eo2ZkMi3s57qTGLzm9Bhzt3GNVo4AzNJHtEM2gSbyvsthDkmKHCWLvTJ6ysEnfpdANVB', false],
			['zcWGwZU7FyUgpdrWGkeFqCEnvhLRDAVuf2ZbhW4vzNMTTR6VUgfiBGkiNbkC4e38QaPtS13RKZCriqN9VcyyKNRRQxbgneC', false],
		];
	}

	/**
	 * @param string $address
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidate($address, $expectedValue) {
		$validator = new ZcashAddressValidator($address);
		$this->assertEquals($validator->validate(), $expectedValue);
	}

	/**
	 * @param string $address
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidateWithException($address, $expectedValue) {
		if ($expectedValue === true) {
			$validator = new ZcashAddressValidator($address);
			$validator->validateWithExceptions();
		}
	}

	/**
	 * @param string $address
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidateWithExceptionInvalidAddress($address, $expectedValue) {
		if ($expectedValue === false) {
			$validator = new ZcashAddressValidator($address);
			$this->tester->expectException(InvalidAddressException::class, function() use($validator) {
				$validator->validateWithExceptions();
			});
		}
	}

}
