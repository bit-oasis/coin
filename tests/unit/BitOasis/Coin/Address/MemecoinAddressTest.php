<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\MemecoinAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class MemecoinAddressTest extends UnitTest {

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
			['0x71a41517Fe65890fE835d67fce17a9747112696C'],
			['0xE6f3494E839F3D3Fb36c407eB35cd85D90Dc3704'],
			['0x6cC5F688a315f3dC28A7781717a9A798a59fDA7b'],
			['0x7Ec0b470f826b168C2baEfd0e2912cb343512006'],
			['0x33D003deB7C69E272aeF9893407CedF0F6b6f462'],
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
	protected function createAddress(string $address): MemecoinAddress {
		return new MemecoinAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::MEME),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}
}