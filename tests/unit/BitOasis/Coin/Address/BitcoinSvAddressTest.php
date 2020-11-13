<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use UnitTestUtils;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class BitcoinSvAddressTest extends BaseBitcoinCashAddressTest {

	/** @var string */
	private $validAddress = 'bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a';

	public function providerInvalidCurrency() {
		return [
			[Cryptocurrency::BCH],
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
			new BitcoinSvAddress($this->validAddress, UnitTestUtils::getCryptocurrency($currency));
		});
	}

	/**
	 * @inheritDoc
	 */
	protected function createAddress($address) {
		return new BitcoinSvAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::BSV));
	}

}
