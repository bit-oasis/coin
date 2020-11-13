<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class MakerAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x95151e4615c5c0924b918c85ad8d8a94d6644ab'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
		];
	}

	public function providerValidate() {
		return [
			['0x4cdbc07091c7b9b0afaa70748609ad82906e69b5'],
			['0x8b83093a2a1ac30b074e3eab79bfd248a4ad8166'],
			['0xc4e926957e11ab9bb18039f8fd873dec62b393f2'],
			['0x9b3367f80216ce2dabf96cfbc6cafc9d91a0a50c'],
			['0x3c02290922a3618a4646e3bbca65853ea45fe7c6'],
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
		$makerAddress = $this->createAddress($address);
		$this->assertFalse($makerAddress->supportsAdditionalId());
		$this->assertNull($makerAddress->getAdditionalIdName());
		$this->assertNull($makerAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return MakerAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new MakerAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::LINK));
	}
}
