<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidNumberException;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinMulTest extends UnitTest {

	public function providerMul() {
		return [
			['3', '2', '6'],
			['-321', '123', '-39483'],
			['100000000000000000000', '100000000000000000000', '10000000000000000000000000000000000000000'],
			['-100000000000000000000', '100000000000000000001', '-10000000000000000000100000000000000000000'],
			['10', '1.1', '11'],
			['10', '1.19', '11'],
		];
	}

	/**
	 * @param string $amount1
	 * @param string $amount2
	 * @param string $result
	 * @dataProvider providerMul
	 */
	public function testMul($amount1, $amount2, $result) {
		$currency = new Cryptocurrency('CUR', 10);
		$coin = Coin::fromInt($amount1, $currency);
		$this->assertEquals($result, $coin->mul($amount2)->toIntString());
	}

	public function providerMulNotNumber() {
		return [
			['asd'],
			['999s99'],
			[new \stdClass()],
			[Coin::fromInt('1', new Cryptocurrency('CUR', 10))],
		];
	}

	/**
	 * @param $multiplier
	 * @dataProvider providerMulNotNumber
	 */
	public function testMulNotNumber($multiplier) {
		$currency = new Cryptocurrency('CUR', 10);
		$coin = Coin::fromInt('1', $currency);
		$this->tester->expectThrowable(InvalidNumberException::class, function() use($coin, $multiplier) {
			$coin->mul($multiplier);
		});
	}


}
