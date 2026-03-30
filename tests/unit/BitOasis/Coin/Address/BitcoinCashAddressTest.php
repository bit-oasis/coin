<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use UnitTestUtils;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class BitcoinCashAddressTest extends BaseBitcoinCashAddressTest {

	/** @var string */
	private $validAddress = 'bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a';

	public function providerInvalidCurrency() {
		return [
			[Cryptocurrency::BSV],
			[Cryptocurrency::BTC],
			[Cryptocurrency::TBTC],
			[Cryptocurrency::LTC],
		];
	}

	/**
	 * @param string $currency
	 * @dataProvider providerInvalidCurrency
	 */
	public function testInvalidCurrency($currency) {
		$this->tester->expectThrowable(InvalidAddressException::class, function() use($currency) {
			new BitcoinCashAddress(
				$this->validAddress,
				UnitTestUtils::getCryptocurrency($currency),
				UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::BITCOIN)
			);
		});
	}

	/**
	 * @param $address string
	 * @return BitcoinCashAddress
	 */
	protected function createAddress($address) {
		return new BitcoinCashAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::BCH),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::BITCOIN)
		);
	}

	/**
	 * @param string $oldFormat
	 * @param string $newFormat
	 * @dataProvider providerBase58ToCashAddress
	 */
	public function testOldFormatAddress($oldFormat, $newFormat) {
		$newFormatAddress = $this->createAddress($newFormat);
		$this->assertEquals($newFormatAddress->getOldFormatAddress(), $oldFormat);
	}

	/**
	 * @param string $oldFormat
	 * @param string $newFormat
	 * @dataProvider providerBase58ToCashAddress
	 */
	public function testNewFormatAddress($oldFormat, $newFormat) {
		$oldFormatAddress = $this->createAddress($oldFormat);
		$this->assertEquals($oldFormatAddress->getNewFormatAddress(), $newFormat);
	}

}
