<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class YearnFinanceAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x2fdbadf3c4d5a8666bcO6645b8358ab803996e28'],
			['0x2fdbadf3c4d5a8666bc06645b8358ab803996e2g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
		];
	}

	public function providerValidate() {
		return [
			['0x2fdbadf3c4d5a8666bc06645b8358ab803996e28'],
			['0x61e1e88434b545c92ad7d40620d3af3d3c65abab'],
			['0xb5eb8ff26b8df6265e68e4636ebd600c8283eb50'],
			['0x088ee5007c98a9677165d78dd2109ae4a3d04d0c'],
			['0xba37b002abafdd8e89a1995da52740bbc013d992'],
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
	 * @return YearnFinanceAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new YearnFinanceAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::YFI));
	}
}
