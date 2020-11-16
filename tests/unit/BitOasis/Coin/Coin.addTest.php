<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidCurrencyException;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinAddTest extends UnitTest {

	public function providerAdd() {
		return [
			['1', '2', '3'],
			['10000000000', '20000000000', '30000000000'],
			['9223372036854775808', '9223372036854775809', '18446744073709551617'],
			['1238653253678137672091236734256123', '-1238653253678137672091236734256124', '-1'],
			['1' . PHP_INT_MAX . '1', '1', '1' . PHP_INT_MAX . '2']
		];
	}

	/**
	 * @param string $amount1
	 * @param string $amount2
	 * @param string $result
	 * @dataProvider providerAdd
	 */
	public function testAdd($amount1, $amount2, $result) {
		$currency = new Cryptocurrency('CUR', 10);
		$coin1 = Coin::fromInt($amount1, $currency);
		$coin2 = Coin::fromInt($amount2, $currency);
		$this->assertEquals($result, $coin1->add($coin2)->toIntString());
	}

	public function testAddInvalidCurrencyCode() {
		$currency1 = new Cryptocurrency('CUR', 10);
		$currency2 = new Cryptocurrency('XXX', 10);
		$coin1 = Coin::fromInt('1', $currency1);
		$coin2 = Coin::fromInt('2', $currency2);
		$this->tester->expectThrowable(InvalidCurrencyException::class, function() use($coin1, $coin2) {
			$coin1->add($coin2);
		});
	}

	public function testAddInvalidCurrencyDecimals() {
		$currency1 = new Cryptocurrency('CUR', 9);
		$currency2 = new Cryptocurrency('CUR', 10);
		$coin1 = Coin::fromInt('1', $currency1);
		$coin2 = Coin::fromInt('2', $currency2);
		$this->tester->expectThrowable(InvalidCurrencyException::class, function() use($coin1, $coin2) {
			$coin1->add($coin2);
		});
	}

}
