<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;
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
			['35iMHbUZeTssxBodiHwEEkb32jpBfVueEL'],
			['bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kv8f3t4'],
			['bc1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq'],
			['bc1qsmkhz0mdswslqua7h25utznk2wtktl703hx7sv'],
			['bc1qwqdg6squsna38e46795at95yu9atm8azzmyvckulcc7kytlcckxswvvzej'],
			['bc1qc7slrfxkknqcq2jevvvkdgvrt8080852dfjewde450xdlk4ugp7szw5tk9'],
		];
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address) {
		$bitcoinAddress = new BitcoinAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::BTC),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::BITCOIN)
		);
		$this->assertFalse($bitcoinAddress->supportsAdditionalId());
		$this->assertNull($bitcoinAddress->getAdditionalIdName());
		$this->assertNull($bitcoinAddress->getAdditionalId());
	}

}
