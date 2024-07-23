<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\TapAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class TapAddressTest extends UnitTest {

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
			['0x62D51B3f097185d170158465C5ada48b42dA7E32'],
			['0x66AD25B5Aa3543CB7f4566851fE26DA6abab205E'],
			['0x68Ab13e336D11C8F0b8Fe654034b2141398888b4'],
			['0x74de5d4FCbf63E00296fd95d33236B9794016631'],
			['0xc041AdBd4C5E5eF418518A6Fa2542b8584Ca1d78'],
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
	protected function createAddress(string $address): TapAddress {
		return new TapAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::XTP),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}
}