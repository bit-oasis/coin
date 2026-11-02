<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\WaxAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 */
class WaxAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['tooshort'],
			['way.too.long.name'],
			['UPPERCASE123'],
		];
	}

	public function providerValidate(): array {
		return [
			['wax.account1'],
			['myaccount123'],
			['abc.def.ghi1'],
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
	protected function createAddress(string $address): WaxAddress {
		return new WaxAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::WAXP),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::WAX)
		);
	}

}
