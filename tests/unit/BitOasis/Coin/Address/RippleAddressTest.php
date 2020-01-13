<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use UnitTestUtils;
use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class RippleAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['rEr3hxu5aim5tDWwH7H8BK47K91tR8c7FM', null],
			['rKiCet8SdvWxPXnAgYarFUXMh1zCPz432Y', null],
			['rLW9gnQo7BQhU6igk5keqYnH3TVrCxGRzm', 3140149957],
			['rLW9gnQo7BQhU6igk5keqYnH3TVrCxGRzm', 4294967295],
		];
	}

	/**
	 * @param string $address
	 * @param $tag
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address, $tag) {
		$rippleAddress = new RippleAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::XRP), $tag);
		$this->assertTrue($rippleAddress->supportsAdditionalId());
		$this->assertNotNull($rippleAddress->getAdditionalIdName());
		$this->assertEquals($tag, $rippleAddress->getAdditionalId());
		$this->assertEquals($rippleAddress->getTag(), $rippleAddress->getAdditionalId());
	}

}
