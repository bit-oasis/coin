<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\FlareAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class FlareAddressTest extends UnitTest {

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
			['0x58048528D3d3aea14Ec95eb5e98b18dE51780e27'],
			['0xAed8489F810C9a994FaBcd9544a312CBe7d65083'],
			['0x12b3079D5b65a17EFD1665d9731FB0Adb46F14e4'],
			['0xc781218e77F730A0AE19c319eCcAF561EF31b6d9'],
			['0x7ec232217a6aAEC23ca401f01b1d95Cb601FD6dB'],
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
	protected function createAddress(string $address): FlareAddress {
		return new FlareAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::FLR),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::FLARE)
		);
	}
}