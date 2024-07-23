<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\RequestNetworkAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class RequestNetworkAddressTest extends UnitTest {

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
			['0x05CFC8D3CA36BC774963C3999efD8a1E38F5b40b'],
			['0x4a7d4BE868e0b811ea804fAF0D3A325c3A29a9ad'],
			['0xaB782bc7D4a2b306825de5a7730034F8F63ee1bC'],
			['0xE37e799D5077682FA0a244D46E5649F71457BD09'],
			['0xDFd5293D8e347dFe59E90eFd55b2956a1343963d'],
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
	protected function createAddress(string $address): RequestNetworkAddress {
		return new RequestNetworkAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::REQ),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}
}