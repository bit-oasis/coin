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
class BitcoinGoldAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['ARr4egtrQcX1P1SWkmbC89vjmZHPSSTZFm1'],
			['BTsyw4LnrwfnrLnfHuQnSttrRFZYyvJoAC'],
			['CTYjfZbtrJbV8AdmYxV5DQVPugArDqc9kD'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['AUxLE7WSMaBAKFokG4k61eqTqxvb9pwxd'],
		];
	}

	public function providerValidate() {
		return [
			['ARr4egtrQcX1P1SWkmbC89vjmZHPSSTZFm'],
			['AHtf9mEmpkxj4XfaZPZxtAPmbV77T416ix'],
			['GTsyw4LnrwfnrLnfHuQnSttrRFZYyvJoAC'],
			['AGHc8mfD8QDUmaTA4nDh1Qj2ct7foNoUH4'],
			['GPkdCuBkRgZVUUxQ1qpacDmnqdLGkZcReP'],
			['GTYjfZbtrJbV8AdmYxV5DQVPugArDqc9kD'],
			['AUxLE7WSMaBAKFokG4k61eqTqxvb9pwxdA'],
			['AXmaa2Q8Ya9KMTZFVHdQ3iPib9mGmTB68o'],
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
	public function testAdditionalId($address) {
		$createdAddress = $this->createAddress($address);
		$this->assertFalse($createdAddress->supportsAdditionalId());
		$this->assertNull($createdAddress->getAdditionalIdName());
		$this->assertNull($createdAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return BitcoinGoldAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new BitcoinGoldAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::BTG),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::BITCOIN_GOLD)
		);
	}
}
