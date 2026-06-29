<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\TheSandboxAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 */
class TheSandboxAddressTest extends UnitTest {

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
			['0x3845badAde8e6dFF049820680d1F14bD3903a5d0'],
			['0xA57Bd00134B2850B2a1c55860c9e9ea100fDd6CF'],
			['0x4a220E6096B25EADb88358cb44068A3248254675'],
			['0x6B175474E89094C44Da98b954EedeAC495271d0F'],
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
	 * @return TheSandboxAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address): TheSandboxAddress {
		return new TheSandboxAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::SAND),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}
}
