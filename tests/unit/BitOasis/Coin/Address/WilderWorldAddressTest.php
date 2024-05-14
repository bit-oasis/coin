<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\WilderWorldAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class WilderWorldAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
		];
	}

	public function providerValidate() {
		return [
			['0x260279F4722930B9A2B98dDfBb86b14Cb4eB10C4'],
			['0xC06b755Fb38BA5f28687080CB5A8649DD798E7aa'],
			['0x79e1748Ec8e06089d851e1053dF8F798Bfc90673'],
			['0x63756A3C3BF677BAAB9D9e06457402ED05BE8570'],
			['0x37a8f295612602f2774d331e562be9e61B83a327'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress($address) {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address) {
		$createdAddress = $this->createAddress($address);
		$this->assertFalse($createdAddress->supportsAdditionalId());
		$this->assertNull($createdAddress->getAdditionalIdName());
		$this->assertNull($createdAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return WilderWorldAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new WilderWorldAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::WILD),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}
}