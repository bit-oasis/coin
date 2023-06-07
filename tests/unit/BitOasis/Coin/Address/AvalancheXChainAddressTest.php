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
class AvalancheXChainAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['P-avax1sw7saga5uzml24zzswpzfp5gz7l2atu0xy0nhq'],
			['X-avax1sw7saga5uzml24zzswpzfp5gz7l2atu0xy0nh'],
			['X-avaq1sw7saga5uzml24zzswpzfp5gz7l2atu0xy0nhq'],
		];
	}

	public function providerValidate() {
		return [
			['X-avax1sw7saga5uzml24zzswpzfp5gz7l2atu0xy0nhq'],
			['X-avax1pue5luvh6klhjkq8zk5zltxk84asvcnznsauxa'],
			['X-avax14q4xtd4d6y8ys6v44zva7w0vcsxhz38thw3dnm'],
			['X-avax1s8vx8dml4r7d9vkta7ls5843nsch98alslzyx7'],
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
	 * @return AvalancheXChainAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): AvalancheXChainAddress {
		return new AvalancheXChainAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::AVAX),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::AVALANCHE_X)
		);
	}
}
