<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\DivisionByZeroException;
use BitOasis\Coin\Exception\InvalidNumberException;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinDivTest extends UnitTest {

	public function providerDiv() {
		return [
			['1000', '100', '10'],
			['-321', '321', '-1'],
			['9', '10', '0'],
			['10', '3.3', '3'],
			['10', '3.4', '2'],
			[PHP_INT_MAX . '990', PHP_INT_MAX . '99', '10'],
			['273300000000', 2.5115026822848646e-5, '10881931439999846'],
//Since scientific notation in string is more precise than in float (due to rounding), it won't return same result.
//			['273300000000', '2.5115026822848646e-5', '10881931439999846'],
			['273300000000', 2.5115026822849e-5, '10881931439999846'],
			['273300000000', '2.5115026822849e-5', '10881931439999846'],
			['273300000000', 0.04, '6832500000000'],
			['273300000000', '0.05', '5466000000000'],
			['273300000000', 4e-2, '6832500000000'],
			['273300000000', '5e-2', '5466000000000'],
			['273300000000', '0.050000000000000001', '5465999999999'],
		];
	}

	/**
	 * @param string $amount1
	 * @param string $amount2
	 * @param string $result
	 * @dataProvider providerDiv
	 */
	public function testDiv($amount1, $amount2, $result) {
		$currency = new Cryptocurrency('CUR', 10);
		$coin = Coin::fromInt($amount1, $currency);
		$this->assertEquals($result, $coin->div($amount2)->toIntString());
	}

	public function testDivisionByZero() {
		$currency = new Cryptocurrency('CUR', 10);
		$coin = Coin::fromInt('1', $currency);
		$this->tester->expectThrowable(DivisionByZeroException::class, function() use($coin) {
			$coin->div('0');
		});
	}

	public function providerDivNotNumber() {
		return [
			['asd'],
			['999s99'],
			[new \stdClass()],
			[Coin::fromInt('1', new Cryptocurrency('CUR', 10))],
		];
	}

	/**
	 * @param $divisor
	 * @dataProvider providerDivNotNumber
	 */
	public function testDivNotNumber($divisor) {
		$currency = new Cryptocurrency('CUR', 10);
		$coin = Coin::fromInt('1', $currency);
		$this->tester->expectThrowable(InvalidNumberException::class, function() use($coin, $divisor) {
			$coin->div($divisor);
		});
	}

}
