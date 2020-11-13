<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidNumberException;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CoinFromFloatTest extends UnitTest {

	public function providerFromFloat() {
		return [
			[1, '10000000000', 10],
			['-1', '-10000000000', 10],
			[PHP_INT_MAX . '999', PHP_INT_MAX . '9990000000000', 10],
			[PHP_INT_MAX . '999.9999999999', PHP_INT_MAX . '9999999999999', 10],
			[0, '0', 10],
			[0.0, '0', 10],
			['0', '0', 10],
			['1000', '10000000000000', 10],
			[1000, '10000000000000', 10],
			['-.1', '-1000000000', 10],
			['.0123456789', '123456789', 10],
			['.01234567899', '123456789', 10],
			[0xF, '150000000000', 10],
			[1.23e-8, '123', 10],
			['1.23e-8', '123', 10],
			['+1.23e-8', '123', 10],
			['1.23e1', '123000000000', 10],
			['-1.23e-8', '-123', 10],
			['1.230000000019e1', '123000000002', 10],
			['-1.230000000019e1', '-123000000002', 10],
			['090', '900000000000', 10], // restrict leading zero?
			[0.04, '40000000000000000', 18],
			['0.05', '50000000000000000', 18],
			[4e-2, '40000000000000000', 18],
			['5e-2', '50000000000000000', 18],
			['0.050000000000000001', '500000000000000010', 19],
			// Float size too small
			// [0.050000000000000001, '500000000000000010', 19],
			// [5.0000000000000001e-2, '500000000000000010', 19],
			// Might be fixed by parsing string directly
			// ['5.0000000000000001e-2', '500000000000000010', 19],
		];
	}

	/**
	 * @param string $amount
	 * @param string $result
	 * @param int $decimals
	 * @dataProvider providerFromFloat
	 */
	public function testFromFloat($amount, $result, $decimals) {
		$currency = new Cryptocurrency('CUR', $decimals);
		$coin = Coin::fromFloat($amount, $currency);
		$this->assertEquals($result, $coin->toIntString(), "Original amount: " . $amount . ' (' . gettype($amount) . ')');
	}

	public function testFromFloatZeroDecimals() {
		$currency = new Cryptocurrency('ZER', 0);
		$coin = Coin::fromFloat('1.0', $currency);
		$this->assertEquals('1', $coin->toIntString());
	}

	public function providerFromFloatNotNumber() {
		return [
			['asd'],
			['999s99'],
			[new \stdClass()],
			[Coin::fromFloat('1', new Cryptocurrency('CUR', 10))],
			['1 000'],
			['1,000'],
			['0xaa'],
			[' 1'],
		];
	}

	/**
	 * @param $amount
	 * @dataProvider providerFromFloatNotNumber
	 */
	public function testFromFloatNotNumber($amount) {
		$currency = new Cryptocurrency('CUR', 10);
		$this->tester->expectException(InvalidNumberException::class, function() use($amount, $currency) {
			Coin::fromFloat($amount, $currency);
		});
	}

}
