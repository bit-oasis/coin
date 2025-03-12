<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\PolygonEcosystemTokenAddress;
use BitOasis\Coin\Address\TapAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class PolygonEcosystemTokenAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
		];
	}

	public function providerValidate(): array {
		return [
			['0x264ded7e280E6D8FB6ce497Eb3F594b9bc4Ea6CC'],
			['0xA9D1e08C7793af67e9d92fe308d5697FB81d3E43'],
			['0x5132A183E9F3CB7C848b0AAC5Ae0c4f0491B7aB2'],
			['0x21a31Ee1afC51d94C2eFcCAa2092aD1028285549'],
			['0x24e0C4746B2cDCD3944cE7F685B16Eaf74a299Aa'],
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
	protected function createAddress(string $address): PolygonEcosystemTokenAddress {
		return new PolygonEcosystemTokenAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::POL),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}

}