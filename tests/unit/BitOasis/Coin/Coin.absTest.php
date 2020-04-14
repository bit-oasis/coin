<?php

namespace BitOasis\Coin;

use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinAbsTest extends UnitTest {

	public function providerAbs() {
		return [
			['1', '1'],
			['-1', '1'],
			[PHP_INT_MAX . '999', PHP_INT_MAX . '999'],
			['-' . PHP_INT_MAX . '999', PHP_INT_MAX . '999'],
		];
	}

	/**
	 * @param string $amount
	 * @param string $result
	 * @dataProvider providerAbs
	 */
	public function testAdd($amount, $result) {
		$currency = new Cryptocurrency('CUR', 10);
		$coin = Coin::fromInt($amount, $currency);
		$this->assertEquals($result, $coin->abs()->toIntString());
	}

}
