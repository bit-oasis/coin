<?php

namespace BitOasis\Coin;

use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinIsZeroTest extends UnitTest {

	public function providerIsZero() {
	    return [
	    	['1', false],
	    	['-1', false],
	    	[PHP_INT_MAX . '999', false],
	    	['-' . PHP_INT_MAX . '999', false],
		    ['0', true],
	    ];
	}

	/**
	 * @param string $amount
	 * @param string $result
	 * @dataProvider providerIsZero
	 */
	public function testIsZero($amount, $result) {
		$currency = new Cryptocurrency('CUR', 10);
	    $coin = Coin::fromInt($amount, $currency);
	    $this->assertEquals($result, $coin->isZero());
	}

}