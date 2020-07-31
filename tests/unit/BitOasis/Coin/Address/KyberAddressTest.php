<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class KyberAddressTest extends UnitTest {

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
			['0xc65982dd578cef84b73e4e11ed1284f318344979'],
			['0xdfa17e18d55dd067b635e3b255a5f412a5aa4b4a'],
			['0xa47c755d4e6401c755c4b8fcd788da19bc477104'],
			['0x065b1caa807c9e525b438651330d26bc80cf3b97'],
			['0x191d8baf1fdf55cffaacd8ce19d48c55eaa1f37a'],
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
		$kyberAddress = $this->createAddress($address);
		$this->assertFalse($kyberAddress->supportsAdditionalId());
		$this->assertNull($kyberAddress->getAdditionalIdName());
		$this->assertNull($kyberAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return KyberAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new KyberAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::LINK));
	}
}
