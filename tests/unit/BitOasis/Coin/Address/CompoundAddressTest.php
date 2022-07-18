<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;
use UnitTest;
use UnitTestUtils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class CompoundAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0xcffdded873554f362ac02f8fb1fO2e5ada10516f'],
			['0xcffdded873554f362ac02f8fb1f02e5ada10516g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
		];
	}

	public function providerValidate() {
		return [
			['0xcffdded873554f362ac02f8fb1f02e5ada10516f'],
			['0x87fc1313880d579039ac48db8b25428ed5f33c4a'],
			['0x70e36f6bf80a52b3b46b3af8e106cc0ed743e8e4'],
			['0x710a5ff3e2589ba854d67c2d9feb03d7dcec9124'],
			['0x3d9819210a31b4961b30ef54be2aed79b9c9cd3b'],
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
	 * @return CompoundAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new CompoundAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::COMP),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}
}
