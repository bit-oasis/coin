<?php

namespace BitOasis\Coin;

use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinEqualsTest extends UnitTest {

	public function providerEquals() {
		return [
			['1', '1', true],
			['1', '0', false],
			['-123', '-123', true],
			['-123', '123', false],
			['1' . PHP_INT_MAX . '1', '1' . PHP_INT_MAX . '1', true],
			['1' . PHP_INT_MAX . '1', '1' . PHP_INT_MAX . '2', false],
		];
	}

	/**
	 * @param string $amount1
	 * @param string $amount2
	 * @param string $result
	 * @dataProvider providerEquals
	 */
	public function testEquals($amount1, $amount2, $result) {
		$currency = new Cryptocurrency('CUR', 10);
		$coin1 = Coin::fromInt($amount1, $currency);
		$coin2 = Coin::fromInt($amount2, $currency);
		$this->assertEquals($result, $coin1->equals($coin2));
	}

	public function testEqualsDifferentCurrencyCode() {
		$currency1 = new Cryptocurrency('CUR', 10);
		$currency2 = new Cryptocurrency('XXX', 10);
		$coin1 = Coin::fromInt('1', $currency1);
		$coin2 = Coin::fromInt('2', $currency2);
		$this->assertFalse($coin1->equals($coin2));
	}

	public function testEqualsDifferentCurrencyDecimals() {
		$currency1 = new Cryptocurrency('CUR', 9);
		$currency2 = new Cryptocurrency('CUR', 10);
		$coin1 = Coin::fromInt('1', $currency1);
		$coin2 = Coin::fromInt('2', $currency2);
		$this->assertFalse($coin1->equals($coin2));
	}

}
