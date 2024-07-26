<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\JupiterAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class JupiterAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['158empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRW1'],
			['158empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRWt'],
			['058empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRWm'],
			['1dagojg92h4t439dKLGNKhngoiwqehgOIGNOIGHpibT1TDgzS9euVZYBkgKTRWm'],
			['3o1rj0INDIAHge0i3tb08POFO9fj39h9r3hr0Hhet0ibT3r5FTTGr5gGt35r3gG'],
			['2to3kfM6w5Z16CTbLj8N8mcxQsQKHPmNEGYTAyMPKAoX'],
			['4yhAARGVmryMueZ39XHLi1wvdgQ1rc6vBRQKfLeiczeZ']
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
	public function testAdditionalId(string $address): void {
		$createdAddress = $this->createAddress($address);
		$this->assertFalse($createdAddress->supportsAdditionalId());
		$this->assertNull($createdAddress->getAdditionalIdName());
		$this->assertNull($createdAddress->getAdditionalId());
	}

	/**
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): JupiterAddress {
		return new JupiterAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::JUP),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::SOLANA)
		);
	}

}