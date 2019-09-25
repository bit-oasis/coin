<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
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
		$this->tester->expectException(InvalidAddressException::class, function() use($currency) {
			new BitcoinCashAddress($this->validAddress, UnitTestUtils::getCryptocurrency($currency));
		});
	}

	/**
	 * @inheritDoc
	 */
	protected function createAddress($address) {
		return new BitcoinCashAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::BCH));
	}

	/**
	 * @param string $legacyFormat
	 * @param string $newFormat
	 * @dataProvider providerBase58ToCashAddress
	 */
	public function testLegacyAddress($legacyFormat, $newFormat) {
		$newFormatAddress = $this->createAddress($newFormat);
		$this->assertEquals($newFormatAddress->getLegacyAddress(), $legacyFormat);
	}

}
