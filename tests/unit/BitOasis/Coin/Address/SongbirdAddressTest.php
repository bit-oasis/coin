<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\SongbirdAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class SongbirdAddressTest extends UnitTest {

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
			['0x39838abf66af299401030e1B82be7848301FbB94'],
			['0xc7d556372A50F8DC9B9f30895348c50E6e3Ce447'],
			['0x1967F7997982fA30E478423bb456FA0ED6222222'],
			['0x403f549D4B48BE214b7b40E661D553531406cA18'],
			['0xA174D46EF49D7d4a0328f9910222689E9eAb2f45'],
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
	protected function createAddress(string $address): SongbirdAddress {
		return new SongbirdAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::SGB),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::SONGBIRD)
		);
	}

}