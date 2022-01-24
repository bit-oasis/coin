<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class PolkadotAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['158empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRW1'],
			['158empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRWt'],
			['058empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRWm'],
			['1dagojg92h4t439dKLGNKhngoiwqehgOIGNOIGHpibT1TDgzS9euVZYBkgKTRWm'],
			['3o1rj0INDIAHge0i3tb08POFO9fj39h9r3hr0Hhet0ibT3r5FTTGr5gGt35r3gG'],
		];
	}

	public function providerValidate() {
		return [
			['158empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRWm'],
			['15BHM5xEZb4x92148G6JNTEntZb2fhYwNTEqWDnhDPKZNuE9']
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress($address) {
		$this->tester->expectThrowable(InvalidAddressException::class, function() use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @param string $address
	 * @dataProvider providerValidate
	 * @throws InvalidAddressException
	 */
	public function testAdditionalId(string $address) {
		$polkadotAddress = $this->createAddress($address);
		$this->assertFalse($polkadotAddress->supportsAdditionalId());
		$this->assertNull($polkadotAddress->getAdditionalIdName());
		$this->assertNull($polkadotAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return PolkadotAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): PolkadotAddress {
		return new PolkadotAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::DOT));
	}
}
