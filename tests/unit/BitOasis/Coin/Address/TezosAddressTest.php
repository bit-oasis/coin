<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;
use UnitTestUtils;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class TezosAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['tz2BFTyPeYRzxd5aiBchbXN3WCZhx7BqbMBq'],
			['KT1WYu65MYGRAa34vBzqSyWJAJz8S5YYoS9Q'],
		];
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address) {
		$neoAddress = new TezosAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::XTZ),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::TEZOS)
		);
		$this->assertFalse($neoAddress->supportsAdditionalId());
		$this->assertNull($neoAddress->getAdditionalIdName());
		$this->assertNull($neoAddress->getAdditionalId());
	}

}
