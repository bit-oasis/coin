<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\WinkLinkAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author shawki.alassi <shawki.alassi@bitoasis.net>
 */
class WinkLinkAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['DQwh1ZDBdqMKDtGWEeDdrRUUbtgaVL1Se2'],
			['aTTd9qHyjqiUkfTxe3gotbuTMpjU8LEbpkN'],
			['TTd9qHyjqiUkfTxe3gotbuTMpjU8LEbpkNa'],
			['TXdrjCBei8ooxbdX1czFpni1s746GnBWa'],
			['TP61mgmnHsG7tqgArsdczgJTzWN7P3vooF'],
		];
	}

	public function providerValidate(): array {
		return [
			['TP61mgmnHsG7tqghrsdczgJTzWN7P3vooF'],
			['TXdrjCBei8ooxbdX1czFpni1s746GnBWaa'],
			['TA9FnQrLGdgLW6cwBKue9DyqSBz1UNzUMR'],
			['TTd9qHyjqiUkfTxe3gotbuTMpjU8LEbpkN'],
			['TQwh1ZDBdqMKDtGWEeDdrRUUbtgaVL1Se2'],
		];
	}

	/**
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress(string $address): void {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address): void {
			$this->createAddress($address);
		});
	}

	/**
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testValidAddress(string $address): void {
		$this->assertNotNull($this->createAddress($address));
	}

	/**
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): WinkLinkAddress {
		return new WinkLinkAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::WIN),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::TRON)
		);
	}

}
