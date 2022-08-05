<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;
use UnitTest;
use UnitTestUtils;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class AvalancheCChainAddressTest extends UnitTest {

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
			['0x2587454da419c6cb03e1278abd9c5d99972a5580'],
			['0x0e2f1300b30faf7e9b07ae4e710fee2d27b54bad'],
			['0x2587454da419c6cb03e1278abd9c5d99972a5580'],
			['0x52cb6f7c2171e430d30b332f6d090cf5c43634bf'],
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
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId(string $address) {
		$avalancheAddress = $this->createAddress($address);
		$this->assertFalse($avalancheAddress->supportsAdditionalId());
		$this->assertNull($avalancheAddress->getAdditionalIdName());
		$this->assertNull($avalancheAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return AvalancheCChainAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): AvalancheCChainAddress {
		return new AvalancheCChainAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::AVAX),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}
}
