<?php

namespace BitOasis\Coin;

use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinIsPositiveTest extends UnitTest {

	public function providerIsPositive() {
	    return [
	    	['1', true],
	    	['-1', false],
	    	[PHP_INT_MAX . '999', true],
	    	['-' . PHP_INT_MAX . '999', false],
		    ['0', false],
	    ];
	}

	/**
	 * @param string $amount
	 * @param string $result
	 * @dataProvider providerIsPositive
	 */
	public function testIsPositive($amount, $result) {
		$currency = new Cryptocurrency('CUR', 10);
	    $coin = Coin::fromInt($amount, $currency);
	    $this->assertEquals($result, $coin->isPositive());
	}

}