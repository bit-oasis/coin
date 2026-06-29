<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\BnbAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 */
class BnbAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['0xcffdded873554f362ac02f8fb1fO2e5ada10516f'],
			['0xcffdded873554f362ac02f8fb1f02e5ada10516g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
		];
	}

	public function providerValidate(): array {
		return [
			['0xB8c77482e45F1F44dE1745F52C74426C631bDD52'],
			['0x0E09FaBB73Bd3Ade0a17ECC321fD13a19e81cE82'],
			['0x55d398326f99059fF775485246999027B3197955'],
			['0xbb4CdB9CBd36B01bD1cBaEBF2De08d9173bc095c'],
			['0xd8dA6BF26964aF9D7eEd9e03E53415D37aA96045'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress($address): void {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address): void {
		$createdAddress = $this->createAddress($address);
		$this->assertFalse($createdAddress->supportsAdditionalId());
		$this->assertNull($createdAddress->getAdditionalIdName());
		$this->assertNull($createdAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return BnbAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address): BnbAddress {
		return new BnbAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::BNB),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::BNB_SMART_CHAIN)
		);
	}
}
