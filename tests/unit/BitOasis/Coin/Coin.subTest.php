<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidCurrencyException;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinSubTest extends UnitTest {

	public function providerSub() {
	    return [
	    	['1', '2', '-1'],
	    	['30000000000', '10000000000', '20000000000'],
	    	['30000000000', '-10000000000', '40000000000'],
	    	['-30000000000', '-10000000000', '-20000000000'],
	    	['9223372036854775809', '9223372036854775808', '1'],
	    	['1238653253678137672091236734256123', '1238653253678137672091236734256124', '-1'],
	    ];
	}

	/**
	 * @param string $amount1
	 * @param string $amount2
	 * @param string $result
	 * @dataProvider providerSub
	 */
	public function testSub($amount1, $amount2, $result) {
		$currency = new Cryptocurrency('CUR', 10);
	    $coin1 = Coin::fromInt($amount1, $currency);
	    $coin2 = Coin::fromInt($amount2, $currency);
	    $this->assertEquals($result, $coin1->sub($coin2)->toIntString());
	}

	public function testSubInvalidCurrencyCode() {
		$currency1 = new Cryptocurrency('CUR', 10);
		$currency2 = new Cryptocurrency('XXX', 10);
	    $coin1 = Coin::fromInt('1', $currency1);
	    $coin2 = Coin::fromInt('2', $currency2);
	    $this->tester->expectException(InvalidCurrencyException::class, function() use($coin1, $coin2) {
		    $coin1->sub($coin2);
	    });
	}

	public function testSubInvalidCurrencyDecimals() {
		$currency1 = new Cryptocurrency('CUR', 9);
		$currency2 = new Cryptocurrency('CUR', 10);
	    $coin1 = Coin::fromInt('1', $currency1);
	    $coin2 = Coin::fromInt('2', $currency2);
	    $this->tester->expectException(InvalidCurrencyException::class, function() use($coin1, $coin2) {
		    $coin1->sub($coin2);
	    });
	}

}