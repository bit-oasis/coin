<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class NearAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
			['efbad19288fe961664f70b03b122541b46244cb287557e26b17c2b0926c6c61b1'],
			['1efbad19288fe961664f70b03b122541b46244cb287557e26b17c2b0926c6c61b'],
			['efbad19288fe961664f70b03b122541b46244cb287557e26b17c2b0926c6c61t'],
		];
	}

	public function providerValidate() {
		return [
			// Any hex string with 64 length
			['efbad19288fe961664f70b03b122541b46244cb287557e26b17c2b0926c6c61b'],
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
		$nearAddress = $this->createAddress($address);
		$this->assertFalse($nearAddress->supportsAdditionalId());
		$this->assertNull($nearAddress->getAdditionalIdName());
		$this->assertNull($nearAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return NearAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new NearAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::NEAR));
	}
}
