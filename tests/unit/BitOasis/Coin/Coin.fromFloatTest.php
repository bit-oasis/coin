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
			[1, '10000000000'],
			['-1', '-10000000000'],
			[PHP_INT_MAX . '999', PHP_INT_MAX . '9990000000000'],
			[PHP_INT_MAX . '999.9999999999', PHP_INT_MAX . '9999999999999'],
			[0, '0'],
			[0.0, '0'],
			['0', '0'],
			['1000', '10000000000000'],
			[1000, '10000000000000'],
			['-.1', '-1000000000'],
			['.0123456789', '123456789'],
			['.01234567899', '123456789'],
			[0xF, '150000000000'],
			[1.23e-8, '123'],
			['1.23e-8', '123'],
			['+1.23e-8', '123'],
			['1.23e1', '123000000000'],
			['-1.23e-8', '-123'],
			['1.230000000019e1', '123000000002'],
			['-1.230000000019e1', '-123000000002'],
			['090', '900000000000'], // restrict leading zero?
		];
	}

	/**
	 * @param string $amount
	 * @param string $result
	 * @dataProvider providerFromFloat
	 */
	public function testFromFloat($amount, $result) {
		$currency = new Cryptocurrency('CUR', 10);
		$coin = Coin::fromFloat($amount, $currency);
		$this->assertEquals($result, $coin->toIntString());
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
