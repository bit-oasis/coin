<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class ChainllinkAddressTest extends UnitTest {

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
			['0x95151e4615c5c0924b918c85ad8d8a94d6644ab3'],
			['0x2d4fff556a7a3c960cfa795241870c751dbf5655'],
			['0xeee64c90c4321df841b34efbca2cd9ef10328295'],
			['0x514910771af9ca656af840dff83e8264ecf986ca'],
			['0x95151e4615c5c0924b918c85ad8d8a94d6644ab3'],
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
		$chainlinkAddress = $this->createAddress($address);
		$this->assertFalse($chainlinkAddress->supportsAdditionalId());
		$this->assertNull($chainlinkAddress->getAdditionalIdName());
		$this->assertNull($chainlinkAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return ChainlinkAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new ChainlinkAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::LINK));
	}

}
