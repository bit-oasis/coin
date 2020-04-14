<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidNumberException;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class ToDecimalStringTest extends UnitTest {

	public function providerFromInt() {
		return [
			[100, '1', 2],
			[123, '1.23', 2],
			[1, '0.01', 2],
			[-1, '-0.01', 2],
			[0, '0', 0],
			[1, '1', 0],
			[-1, '-1', 0],
			[-123, '-123', 0],
			[123, '123', 0],
		];
	}

	/**
	 * @param int $intAmount
	 * @param string $result
	 * @param int $decimals
	 * @dataProvider providerFromInt
	 */
	public function testToDecimalString($intAmount, $result, $decimals) {
		$currency = new Cryptocurrency('CUR', $decimals);
		$coin = Coin::fromInt($intAmount, $currency);
		$this->assertEquals($result, $coin->toDecimalString());
	}

}
