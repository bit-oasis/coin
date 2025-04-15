<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;
use UnitTestUtils;
use UnitTest;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class ArbitrumAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
		];
	}

	public function providerValidate() {
		return [
			['0xad2cc05dbde36e3b21fe4692e432be3074adb729']
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
	public function testAdditionalId(string $address) {
		$addressObject = $this->createAddress($address);
		$this->assertFalse($addressObject->supportsAdditionalId());
		$this->assertNull($addressObject->getAdditionalIdName());
		$this->assertNull($addressObject->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return ArbitrumAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new ArbitrumAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::ARB),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ARBITRUM)
		);
	}

}
