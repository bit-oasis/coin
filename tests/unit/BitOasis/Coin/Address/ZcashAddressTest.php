<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Network\CryptocurrencyNetwork;
use UnitTestUtils;
use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class ZcashAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['t1gRHW5AYgLsNwKRTLXGcXU2wWdP3C3bEtX'],
			['t1aw8bdUeXAk4pmQtqwmh8boLwDAa1UEAYb'],
			['t3eF9X6X2dSo7MCvTjfZEzwWrVzquxRLNeY'],
			['t3YJXRu6pC4er4gsQU7R3jVnAuj4zMQCRU1'],
			['zcc7P9dbq71WTwXi148oXGSvZC6eo2ZkMi3s57qTGLzm9Bhzt3GNVo4AzNJHtEM2gSbyvsthDkmKHCWLvTJ6ysEnfpdANVa'],
			['zcWGwZU7FyUgpdrWGkeFqCEnvhLRDAVuf2ZbhW4vzNMTTR6VUgfiBGkiNbkC4e38QaPtS13RKZCriqN9VcyyKNRRQxbgnen'],
			['zcdwoGUstQfr4r9PDDUyyDc7PRcrSduXw2CfK24WopQhi2WuQMv62PBMcuMCuScGtH6fFPZCYHbCMm5qssSpMkmN2R1Jfbs'],
			['zcPqgLYtkxoqQwqUcXdZiwWmGXzTfqWUNeii1ACVihMn4riddJj52vPiC6aUbuKeVcB4Nhj8enV1jPSeSmrQ1qvYLpxfQYc'],
		];
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address) {
		$zCashAddress = new ZcashAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::ZEC),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ZCASH)
		);
		$this->assertFalse($zCashAddress->supportsAdditionalId());
		$this->assertNull($zCashAddress->getAdditionalIdName());
		$this->assertNull($zCashAddress->getAdditionalId());
	}

}
