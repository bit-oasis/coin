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
class TronAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['TP61mgmnHsG7tqghrsdczgJTzWN7P3vooF'],
			['TXdrjCBei8ooxbdX1czFpni1s746GnBWaa'],
			['TA9FnQrLGdgLW6cwBKue9DyqSBz1UNzUMR'],
			['TTd9qHyjqiUkfTxe3gotbuTMpjU8LEbpkN'],
			['TQwh1ZDBdqMKDtGWEeDdrRUUbtgaVL1Se2'],
			['TCGVFGDd62LSrfZEaz3M3fYifWWdSDHRL8'],
		];
	}

	public function providerInvalid() {
		return [
			['DQwh1ZDBdqMKDtGWEeDdrRUUbtgaVL1Se2'],
			['aTTd9qHyjqiUkfTxe3gotbuTMpjU8LEbpkN'],
			['TTd9qHyjqiUkfTxe3gotbuTMpjU8LEbpkNa'],
			['TXdrjCBei8ooxbdX1czFpni1s746GnBWa'],
			['TP61mgmnHsG7tqgArsdczgJTzWN7P3vooF'],
			['TP61mgmnHsG7tqghrBdczgJTzWN7P3vooF'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalid
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
	public function testAdditionalId($address) {
		$address = $this->createAddress($address);
		$this->assertFalse($address->supportsAdditionalId());
		$this->assertNull($address->getAdditionalIdName());
		$this->assertNull($address->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return TronAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): TronAddress {
		return new TronAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::TRX),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::TRON)
		);
	}

}
