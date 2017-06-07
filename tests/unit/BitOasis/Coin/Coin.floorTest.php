<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidNumberException;
use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class CoinFloorTest extends UnitTest {
	
	public function providerFloor() {
		return [
			['1111', 10, '1111'],
			['1111', 11, '1111'],
			['1111', 0, '0'],
			['1111111111', 0, '0'],
			['11111111111', 0, '10000000000'],
			['11111111111', 1, '11000000000'],
			[PHP_INT_MAX . '1', 9, PHP_INT_MAX . '0'],
		];
	}
	
	/**
	 * @param string $amount
	 * @param int $decimals
	 * @param string $result
	 * @dataProvider providerFloor
	 */
	public function testFloor($amount, $decimals, $result) {
		$currency = new Cryptocurrency('CUR', 10);
	    $coin = Coin::fromInt($amount, $currency);
	    $this->assertEquals($result, $coin->floor($decimals)->toIntString());
	}
	
	public function testNegativeDecimals() {
		$currency = new Cryptocurrency('CUR', 10);
	    $coin = Coin::fromInt('1', $currency);
	    $this->tester->expectException(InvalidNumberException::class, function() use($coin) {
		    $coin->floor(-1);
	    });
	}
}