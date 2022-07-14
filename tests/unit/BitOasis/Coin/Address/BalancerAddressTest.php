<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Network\CryptocurrencyNetwork;
use UnitTest;
use UnitTestUtils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class BalancerAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0xa70d458a4d9bcOe6571565faee18a48da5c0d593'],
			['0xa70d458a4d9bc0e6571565faee18a48da5c0d59g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
		];
	}

	public function providerValidate() {
		return [
			['0xa70d458a4d9bc0e6571565faee18a48da5c0d593'],
			['0x9b9d8e45958d73ba8bb4f18cdc0f8b269eb16a42'],
			['0xc9d86956cff0cab4c9fae35534c7273fd8353646'],
			['0x3e66b66fd1d0b02fda6c811da9e0547970db2f21'],
			['0xe867be952ee17d2d294f2de62b13b9f4af521e9a'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress($address) {
		$this->tester->expectThrowable(InvalidAddressException::class, function() use ($address) {
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
	 * @return BalancerAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new BalancerAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::BAL),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}
}
