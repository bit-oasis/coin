<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\MantleAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;
use UnitTest;
use UnitTestUtils;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 */
class MantleAddressTest extends UnitTest {

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
			['0xaDb74Ac098e134629FaF252dCAcabC787286270E'],
			['0x5628a59dF0ECAC3f3171f877A94bEb26BA6DFAa0'],
			['0xddfabcdc4d8ffc6d5beaf154f18b778f892a0740'],
			['0x2587454da419c6cb03e1278abd9c5d99972a5580'],
			['0xf670b75e7558eb509744d3d44ad433021f577c01'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress(string $address) {
		$this->tester->expectThrowable(InvalidAddressException::class, function() use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @param string $address
	 * @dataProvider providerValidate
	 * @throws InvalidAddressException
	 */
	public function testAdditionalId(string $address) {
		$mantleAddress = $this->createAddress($address);
		$this->assertFalse($mantleAddress->supportsAdditionalId());
		$this->assertNull($mantleAddress->getAdditionalIdName());
		$this->assertNull($mantleAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return MantleAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): MantleAddress {
		return new MantleAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::MNT),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}
}
