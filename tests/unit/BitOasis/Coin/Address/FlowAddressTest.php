<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\FlowAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 */
class FlowAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			// Invalid: missing "0x" prefix
			['f919ee77447b7497'],
			// Invalid: length is not 8 bytes
			['0xf919ee77447b74'],
			// Invalid: contains non-hex characters
			['0xf919ee77447b74g7'],
		];
	}

	public function providerValidate() {
		return [
			['0xf919ee77447b7497'],
			['0x1654653399040a61'],
			['0xe467b9dd11fa00df'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress($address) {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address) {
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
	 * @return FlowAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new FlowAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::FLOW),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::FLOW)
		);
	}
}
