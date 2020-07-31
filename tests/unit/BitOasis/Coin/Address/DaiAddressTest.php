<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class DaiAddressTest extends UnitTest {

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
			['0x0872dfa15e300496badbb4c04c939f5e515deedd'],
			['0x6fc7d7a73e712c234221e4b9e8aac42a65fefcfb'],
			['0x56178a0d5f301baf6cf3e1cd53d9863437345bf9'],
			['0xadeeb9d09b8bcee10943198fb6f6a4229bab3675'],
			['0xa0f75491720835b36edc92d06ddc468d201e9b73'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress($address) {
		$this->tester->expectException(InvalidAddressException::class, function() use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @param string $address
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address) {
		$daiAddress = $this->createAddress($address);
		$this->assertFalse($daiAddress->supportsAdditionalId());
		$this->assertNull($daiAddress->getAdditionalIdName());
		$this->assertNull($daiAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return DaiAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new DaiAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::LINK));
	}
}
