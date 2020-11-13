<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidCurrencyException;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinGreaterOrEqualsTest extends UnitTest {

	public function providerGreaterOrEquals() {
		return [
			['1', '2', false],
			['1', '1', true],
			['50000000000', '20000000000', true],
			['1' . PHP_INT_MAX . '1', '1' . PHP_INT_MAX . '2', false],
			['1' . PHP_INT_MAX . '5', '1' . PHP_INT_MAX . '2', true],
			['1' . PHP_INT_MAX . '5', '1' . PHP_INT_MAX . '5', true],
		];
	}

	/**
	 * @param string $amount1
	 * @param string $amount2
	 * @param string $result
	 * @dataProvider providerGreaterOrEquals
	 */
	public function testGreaterOrEquals($amount1, $amount2, $result) {
		$currency = new Cryptocurrency('CUR', 10);
		$coin1 = Coin::fromInt($amount1, $currency);
		$coin2 = Coin::fromInt($amount2, $currency);
		$this->assertEquals($result, $coin1->greaterOrEquals($coin2));
	}

	public function testGreaterOrEqualsInvalidCurrencyCode() {
		$currency1 = new Cryptocurrency('CUR', 10);
		$currency2 = new Cryptocurrency('XXX', 10);
		$coin1 = Coin::fromInt('1', $currency1);
		$coin2 = Coin::fromInt('2', $currency2);
		$this->tester->expectThrowable(InvalidCurrencyException::class, function() use($coin1, $coin2) {
			$coin1->greaterOrEquals($coin2);
		});
	}

	public function testGreaterOrEqualsInvalidCurrencyDecimals() {
		$currency1 = new Cryptocurrency('CUR', 9);
		$currency2 = new Cryptocurrency('CUR', 10);
		$coin1 = Coin::fromInt('1', $currency1);
		$coin2 = Coin::fromInt('2', $currency2);
		$this->tester->expectThrowable(InvalidCurrencyException::class, function() use($coin1, $coin2) {
			$coin1->greaterOrEquals($coin2);
		});
	}

}
