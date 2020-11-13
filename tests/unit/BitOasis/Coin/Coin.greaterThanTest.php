<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidCurrencyException;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinGreaterThanTest extends UnitTest {

	public function providerGreaterThan() {
		return [
			['1', '2', false],
			['1', '1', false],
			['50000000000', '20000000000', true],
			['1' . PHP_INT_MAX . '1', '1' . PHP_INT_MAX . '2', false],
			['1' . PHP_INT_MAX . '5', '1' . PHP_INT_MAX . '2', true],
		];
	}

	/**
	 * @param string $amount1
	 * @param string $amount2
	 * @param string $result
	 * @dataProvider providerGreaterThan
	 */
	public function testGreaterThan($amount1, $amount2, $result) {
		$currency = new Cryptocurrency('CUR', 10);
		$coin1 = Coin::fromInt($amount1, $currency);
		$coin2 = Coin::fromInt($amount2, $currency);
		$this->assertEquals($result, $coin1->greaterThan($coin2));
	}

	public function testGreaterThanInvalidCurrencyCode() {
		$currency1 = new Cryptocurrency('CUR', 10);
		$currency2 = new Cryptocurrency('XXX', 10);
		$coin1 = Coin::fromInt('1', $currency1);
		$coin2 = Coin::fromInt('2', $currency2);
		$this->tester->expectThrowable(InvalidCurrencyException::class, function() use($coin1, $coin2) {
			$coin1->greaterThan($coin2);
		});
	}

	public function testGreaterThanInvalidCurrencyDecimals() {
		$currency1 = new Cryptocurrency('CUR', 9);
		$currency2 = new Cryptocurrency('CUR', 10);
		$coin1 = Coin::fromInt('1', $currency1);
		$coin2 = Coin::fromInt('2', $currency2);
		$this->tester->expectThrowable(InvalidCurrencyException::class, function() use($coin1, $coin2) {
			$coin1->greaterThan($coin2);
		});
	}

}
