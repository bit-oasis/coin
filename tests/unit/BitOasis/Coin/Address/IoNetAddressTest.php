<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\IoNetAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author shawki.alassi <shawki.alassi@bitoasis.net>
 */
class IoNetAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['158empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRW1'],
			['158empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRWt'],
			['058empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRWm'],
			['1dagojg92h4t439dKLGNKhngoiwqehgOIGNOIGHpibT1TDgzS9euVZYBkgKTRWm'],
		];
	}

	public function providerValidate(): array {
		return [
			['9U1wkWJHp8mcM8ym1XLWXMA59joVQkVmEFmzMHDJUs5N'],
			['BBqy6gAVMzRH1S7y9XvBNaS3axRovqe2VgNrgwYc3mYM'],
			['4qWht7gPqJSZtXkKFPG2F1SiU3rF9mLyGGkBpc65x89A'],
			['F5yjFizPn67RYothrP6bCDzGDRhvp4AZdbR8zRafmccE'],
			['4sSqDkbxEcJmiP4J1NqQja98KSwux3KR8XtLQSUyLECY'],
		];
	}

	/**
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress(string $address): void {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address): void {
			$this->createAddress($address);
		});
	}

	/**
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testValidAddress(string $address): void {
		$this->assertNotNull($this->createAddress($address));
	}

	/**
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): IoNetAddress {
		return new IoNetAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::IO),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::SOLANA)
		);
	}

}
