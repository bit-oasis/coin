<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidNumberException;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinFromIntTest extends UnitTest {

	public function providerFromInt() {
	    return [
	    	[1, '1'],
	    	['-1', '-1'],
		    [-1, '-1'],
	    	[PHP_INT_MAX . '999', PHP_INT_MAX . '999'],
		    [0, '0'],
		    [0.0, '0'],
		    ['0', '0'],
		    ['1000', '1000'],
		    [1000, '1000'],
	    ];
	}

	/**
	 * @param string $amount
	 * @param string $result
	 * @dataProvider providerFromInt
	 */
	public function testFromInt($amount, $result) {
		$currency = new Cryptocurrency('CUR', 10);
	    $coin = Coin::fromInt($amount, $currency);
	    $this->assertEquals($result, $coin->toIntString());
	}

	public function providerFromIntNotNumber() {
		return [
			['asd'],
			['999s99'],
			[new \stdClass()],
			[Coin::fromInt('1', new Cryptocurrency('CUR', 10))],
			[1.9],
			['0.0'],
			['+3'],
			['1 000'],
			['1,000'],
			[' 1'],
			['01'],
		];
	}

	/**
	 * @param $amount
	 * @dataProvider providerFromIntNotNumber
	 */
	public function testFromIntNotNumber($amount) {
		$currency = new Cryptocurrency('CUR', 10);
		$this->tester->expectException(InvalidNumberException::class, function() use($amount, $currency) {
			Coin::fromInt($amount, $currency);
		});
	}

}