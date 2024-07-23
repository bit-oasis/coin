<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\InjectiveAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class InjectiveAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
			['inj19za42zcxjewgn8wny65t44ey2l3muh62pa6wyja'],
			['inj1y9vkk3ga59gq96amj9np7l67nuhnwg6rv4a06'],
			['ing1wtlqvv3zy7v9j6eyzyulvgafzqnp8hzy7ar4az'],
		];
	}

	public function providerValidate(): array {
		return [
			['inj19za42zcxjewgn8wny65t44ey2l3muh62pa6wyj'],
			['inj1y9vkk3ga59gq96amj9np7l67nuhnwg6rv4a06j'],
			['inj1wtlqvv3zy7v9j6eyzyulvgafzqnp8hzy7ar4az'],
			['0x3eaDb84Db9317f6cFc21D7203D3dB854F16200ca'],
			['0xf5213a6a2f0890321712520b8048D9886c1A9900'],
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
	protected function createAddress(string $address): InjectiveAddress {
		return new InjectiveAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::INJ),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::INJECTIVE)
		);
	}
}