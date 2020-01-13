<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use UnitTestUtils;
use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class BitcoinAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['3A2rCJHyoMuYnowLHkvuvMgU7WLSRwZKL9'],
			['37qvZetB6pbbZYTdWV6hYn4MX3P5E6UjUh'],
			['3KwSLET9P3WZNKAjXRTKQYo7w4tZ8qEUaC'],
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu'],
			['1KXrWXciRDZUpQwQmuM1DbwsKDLYAYsVLR'],
			['16w1D5WRVKJuZUsSRzdLp9w3YGcgoxDXb'],
			['3CWFddi6m4ndiGyKqzYvsFYagqDLPVMTzC'],
			['3LDsS579y7sruadqu11beEJoTjdFiFCdX4'],
			['31nwvkZwyPdgzjBJZXfDmSWsC4ZLKpYyUw'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address) {
		$bitcoinAddress = new BitcoinAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::BTC));
		$this->assertFalse($bitcoinAddress->supportsAdditionalId());
		$this->assertNull($bitcoinAddress->getAdditionalIdName());
		$this->assertNull($bitcoinAddress->getAdditionalId());
	}

}
