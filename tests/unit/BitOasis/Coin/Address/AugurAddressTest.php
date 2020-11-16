<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class AugurAddressTest extends UnitTest {

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
			['0xfa103c21ea2df71dfb92b0652f8b1d795e51cdef'],
			['0x9799b475dec92bd99bbdd943013325c36157f383'],
			['0xb50f74390506fb87b7847e6f6e562db9c7f741ae'],
			['0x514910771af9ca656af840dff83e8264ecf986ca'],
			['0xe929bcd423ccdce094ed5a4f2ab092070655f0e2'],
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
	 * @return AugurAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new AugurAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::REP));
	}
}
