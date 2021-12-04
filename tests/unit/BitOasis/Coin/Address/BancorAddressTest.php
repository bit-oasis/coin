<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class BancorAddressTest extends UnitTest {

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
			['0x21a31ee1afc51d94c2efccaa2092ad1028285549'],
			['0x1f573d6fb3f13d689ff844b4ce37794d79a7ff1c'],
			['0xb4cc7d02a8390f0d3ee4ae618de462a06377aaf6'],
			['0x74de5d4fcbf63e00296fd95d33236b9794016631'],
			['0x1938a448d105d26c40a52a1bfe99b8ca7a745ad0'],
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
		$augurAddress = $this->createAddress($address);
		$this->assertFalse($augurAddress->supportsAdditionalId());
		$this->assertNull($augurAddress->getAdditionalIdName());
		$this->assertNull($augurAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return BancorAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new BancorAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::BNT));
	}
}
