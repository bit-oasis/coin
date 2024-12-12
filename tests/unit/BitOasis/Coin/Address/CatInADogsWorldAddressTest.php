<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\CatInADogsWorldAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class CatInADogsWorldAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['158empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRW1'],
			['158empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRWt'],
			['058empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRWm'],
			['1dagojg92h4t439dKLGNKhngoiwqehgOIGNOIGHpibT1TDgzS9euVZYBkgKTRWm'],
			['3o1rj0INDIAHge0i3tb08POFO9fj39h9r3hr0Hhet0ibT3r5FTTGr5gGt35r3gG'],
			['DSgwK2mZUmJHaZqBKrcC2SSadRtoUFgv1qdaZPUifp'],
		];
	}

	public function providerValidate() {
		return [
			['5Q544fKrFoe6tsEbD7S8EmxGTJYAKtTVhAW5Q5pge4j1'],
			['ob2htHLoCu2P6tX7RrNVtiG1mYTas8NGJEVLaFEUngk'],
			['CapuXNQoDviLvU1PxFiizLgPNQCxrsag1uMeyk6zLVps'],
			['DnojLjr7pMCTnLrKfcBe9fqYWsBF9THXsJZNkTUcP8p7']
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress(string $address) {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId(string $address) {
		$createdAddress = $this->createAddress($address);
		$this->assertFalse($createdAddress->supportsAdditionalId());
		$this->assertNull($createdAddress->getAdditionalIdName());
		$this->assertNull($createdAddress->getAdditionalId());
	}

	/**
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): CatInADogsWorldAddress {
		return new CatInADogsWorldAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::MEW),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::SOLANA)
		);
	}
}