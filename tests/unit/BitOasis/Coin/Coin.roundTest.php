<?php

namespace BitOasis\Coin;

use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class CoinRoundTest extends UnitTest {
	
	public function providerFloor() {
		return [
			['0', 10, '0'],
			['1111', 10, '1111'],
			['1111', 11, '1111'],
			['1111', 0, '0'],
			['1111111111', 0, '0'],
			['5111111111', 0, '10000000000'],
			['11111111111', 0, '10000000000'],
			['15111111111', 0, '20000000000'],
			['95111111111', 0, '100000000000'],
			['11111111111', 1, '11000000000'],
			['11511111111', 1, '12000000000'],
			['19511111111', 1, '20000000000'],
			['-10000000000', 0, '-10000000000'],
			['-15000000000', 0, '-20000000000'],
			['-95000000000', 0, '-100000000000'],
			['-123', 9, '-120'],
			['-125', 9, '-130'],
			['-195', 9, '-200'],
			['11500000000876', -2, '12000000000000'],
			['11400000000876', -2, '11000000000000'],
			['11500000000000', -2, '12000000000000'],
			['11400000000000', -2, '11000000000000'],
			[PHP_INT_MAX . '1', 9, PHP_INT_MAX . '0'],
			[PHP_INT_MAX . '05', 9, PHP_INT_MAX . '10'],
			[PHP_INT_MAX . '095', 9, PHP_INT_MAX . '100'],
			[PHP_INT_MAX . '1', -PHP_INT_MAX, '0'],
			[PHP_INT_MAX . '5', -PHP_INT_MAX, '0'],
			[PHP_INT_MAX . '1', PHP_INT_MAX, PHP_INT_MAX . '1'],
			[PHP_INT_MAX . '5', PHP_INT_MAX, PHP_INT_MAX . '5'],
		];
	}
	
	/**
	 * @param string $amount
	 * @param int $decimals
	 * @param string $result
	 * @dataProvider providerFloor
	 */
	public function testRound($amount, $decimals, $result) {
		$currency = new Cryptocurrency('CUR', 10);
		$coin = Coin::fromInt($amount, $currency);
		$this->assertEquals($result, $coin->round($decimals)->toIntString());
	}

}