<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\CeloAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class CeloAddressTest extends UnitTest {

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
			['0xA3Ed3B33d8Fe046ADc03113175fE53b0aB9f867E'],
			['0x5dE7F44096612611E44E4dd687560581228F8C10'],
			['0xf2dD2d0a1f6D7aac7972c3e1AfC4191d1644f73D'],
			['0xA71Ba26B338738f2aB0dB6f81Cf2Da1180249084'],
			['0xB18Ae6cBADa04222C8B149dBE40926a77a960C9e'],
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
	protected function createAddress(string $address): CeloAddress {
		return new CeloAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::CELO),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::CELO)
		);
	}
}