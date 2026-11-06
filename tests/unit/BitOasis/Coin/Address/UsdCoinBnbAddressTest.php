<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\UsdCoinBnbAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 */
class UsdCoinBnbAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['0x8AC76a51cc950d9822D68b83fE1Ad97B32Cd58Od'],
			['0x8AC76a51cc950d9822D68b83fE1Ad97B32Cd580g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
		];
	}

	public function providerValidate(): array {
		return [
			['0x8AC76a51cc950d9822D68b83fE1Ad97B32Cd580d'],
			['0x55d398326f99059fF775485246999027B3197955'],
			['0xbb4CdB9CBd36B01bD1cBaEBF2De08d9173bc095c'],
			['0x1a0a18ac4becddbd6389559687d1a73d8927e416'],
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
	 * @return UsdCoinBnbAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address): UsdCoinBnbAddress {
		return new UsdCoinBnbAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::USDC),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::BNB_SMART_CHAIN)
		);
	}
}
