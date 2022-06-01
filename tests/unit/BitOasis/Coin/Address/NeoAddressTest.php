<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTestUtils;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class NeoAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['AKxnTpwQzZNLaGpK1WhUSucM9G5e71e19Y'],
			['AH9oFBoQn88AUXfZsjmLPBiiZ27FoQGrbC'],
			['ATKQ2f3iHtojSrzXkESavZ1qyhLeoPX2fA'],
			['NiTwToAuoKwE5DPLTnyvEYXuSGLuGpMJ6T'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerValidate
	 * @throws InvalidAddressException
	 */
	public function testAdditionalId($address) {
		$neoAddress = new NeoAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::NEO));
		$this->assertFalse($neoAddress->supportsAdditionalId());
		$this->assertNull($neoAddress->getAdditionalIdName());
		$this->assertNull($neoAddress->getAdditionalId());
	}

}
