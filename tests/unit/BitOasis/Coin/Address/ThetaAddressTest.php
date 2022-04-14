<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class ThetaAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0xc011a73ee8576fb46f5e1c5751ca3b9feOaf2a6f'],
			['0xc011a73ee8576fb46f5e1c5751ca3b9fe0af2a6g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
		];
	}

	public function providerValidate() {
		return [
			['0xc011a73ee8576fb46f5e1c5751ca3b9fe0af2a6f'],
			['0x43ae24960e5534731fc831386c07755a2dc33d47'],
			['0xa1d7b2d891e3a1f9ef4bbc5be20630c2feb1c470'],
			['0x5b26743c4bac45c96f2bf395b9e491c0fe06798c'],
			['0xc9d86956cff0cab4c9fae35534c7273fd8353646'],
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
	 * @dataProvider providerValidate
	 * @throws InvalidAddressException
	 */
	public function testAdditionalId($address) {
		$createdAddress = $this->createAddress($address);
		$this->assertFalse($createdAddress->supportsAdditionalId());
		$this->assertNull($createdAddress->getAdditionalIdName());
		$this->assertNull($createdAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return ThetaAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new ThetaAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::THETA));
	}

}
