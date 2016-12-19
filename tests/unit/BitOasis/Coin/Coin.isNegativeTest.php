<?php

namespace BitOasis\Coin;

use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinIsNegativeTest extends UnitTest {

	public function providerIsNegative() {
	    return [
	    	['1', false],
	    	['-1', true],
	    	[PHP_INT_MAX . '999', false],
	    	['-' . PHP_INT_MAX . '999', true],
		    ['0', false],
	    ];
	}

	/**
	 * @param string $amount
	 * @param string $result
	 * @dataProvider providerIsNegative
	 */
	public function testIsNegative($amount, $result) {
		$currency = new Cryptocurrency('CUR', 10);
	    $coin = Coin::fromInt($amount, $currency);
	    $this->assertEquals($result, $coin->isNegative());
	}

}