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
			// Legacy (P2PKH) and P2SH
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
			// Native SegWit v0 (bech32) - P2WPKH & P2WSH
			['bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kv8f3t4'],
			['bc1qar0srrr7xfkvy5l643lydnw9re59gtzzwf5mdq'],
			['bc1qsmkhz0mdswslqua7h25utznk2wtktl703hx7sv'],
			['bc1qwqdg6squsna38e46795at95yu9atm8azzmyvckulcc7kytlcckxswvvzej'],
			['bc1qc7slrfxkknqcq2jevvvkdgvrt8080852dfjewde450xdlk4ugp7szw5tk9'],
			// Taproot / SegWit v1 (bech32m) - P2TR (BIP341/BIP350)
			['bc1py3aw98r3s3wulz4a8886535he5996a8ty9n7u46svjdmr20vxk8sh30egc'],
			['bc1p0xlxvlhemja6c4dqv22uapctqupfhlxm9h8z3k2e72q4k9hcz7vqzk5jj0'],
			['bc1p5cyxnuxmeuwuvkwfem96lqzszd02n6xdcjrs20cac6yqjjwudpxqkedrcr'],
			['bc1p65athfyux9a6cp52w2lxkp9rpvgmy2achl2l3u6yz5sd4qz7h8dqjfsmt7'],
			['bc1pmgukpg4g0lmlvnjn0zvxxyjj4lq3esng50ax2ug7vxu07mmnsrlqnhgz73']
		];
	}

	public function providerInvalidAddress() {
		return [
			// Taproot (v1) payload carrying a bech32 checksum instead of bech32m - BIP350
			['bc1p0xlxvlhemja6c4dqv22uapctqupfhlxm9h8z3k2e72q4k9hcz7vqh2y7hd'],
			// Mixed lower/upper case (rejected before checksum verification)
			['bc1py3aw98r3s3wulz4a8886535he5996a8ty9n7u46svjdmr20vxk8sh30egX'],
			// A valid Taproot address with a single corrupted checksum character
			['bc1py3aw98r3s3wulz4a8886535he5996a8ty9n7u46svjdmr20vxk8sh30egd'],
			// Correct bech32m payload but wrong human-readable part (testnet prefix)
			['tb1py3aw98r3s3wulz4a8886535he5996a8ty9n7u46svjdmr20vxk8sh30egc'],
			// SegWit v16 with bech32 checksum instead of bech32m (BIP350)
			['BC1S0XLXVLHEMJA6C4DQV22UAPCTQUPFHLXM9H8Z3K2E72Q4K9HCZ7VQ54WELL'],
			// SegWit v0 with bech32m checksum instead of bech32 (BIP350)
			['bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kemeawh'],
			// Invalid character 'o' in the data part (BIP350 invalid test vector)
			['bc1p38j9r5y49hruaue7wxjce0updqjuyyx0kh56v8s25huc6995vvpql3jow4'],
			// Not a Bitcoin address at all
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121a'],
		];
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address) {
		$bitcoinAddress = $this->createAddress($address);
		$this->assertFalse($bitcoinAddress->supportsAdditionalId());
		$this->assertNull($bitcoinAddress->getAdditionalIdName());
		$this->assertNull($bitcoinAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testValidAddressRoundTrip($address) {
		$bitcoinAddress = $this->createAddress($address);
		$this->assertSame($address, $bitcoinAddress->toString());
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
	 * @return BitcoinAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address): BitcoinAddress {
		return new BitcoinAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::BTC),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::BITCOIN)
		);
	}

}
