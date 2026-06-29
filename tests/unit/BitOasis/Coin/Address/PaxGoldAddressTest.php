<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\PaxGoldAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 */
class PaxGoldAddressTest extends UnitTest {

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
			['0x45804880De22913dAFE09f4980848ECE6EcbAf78'],
			['0x2260FAC5E5542a773Aa44fBCfeDf7C193bc2C599'],
			['0xC02aaA39b223FE8D0A0e5C4F27eAD9083C756Cc2'],
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
	 * @return PaxGoldAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address): PaxGoldAddress {
		return new PaxGoldAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::PAXG),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}
}
