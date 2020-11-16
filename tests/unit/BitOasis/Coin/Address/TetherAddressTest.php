<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTestUtils;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class TetherAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x395be1c1eb316f82781'],
		];
	}

	public function providerValidate() {
		return [
			['0x395be1c1eb316f82781462c4c028893e51d8b2a5'],
			['0x7f01a23db00e522f8871f3e56d669467eed10368'],
			['0xe68c6524d1f486822976be1a539f4ad75f518ad1'],
			['0xeafa188ac12e331b52e585ea6298f8138e23c0e6'],
			['0x2cab63e02d5b490e5f4a5d1b0d5189420ea54b2d'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress($address) {
		$this->tester->expectThrowable(InvalidAddressException::class, function() use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @param string $address
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address) {
		$tetherAddress = $this->createAddress($address);
		$this->assertFalse($tetherAddress->supportsAdditionalId());
		$this->assertNull($tetherAddress->getAdditionalIdName());
		$this->assertNull($tetherAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return TetherAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new TetherAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::USDT));
	}

}
