<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class CardanoAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['DdzFFzCqrht1mN73kqE59Vtmdj816DZmcqmhaTdi3Qi4EGqzd4PcyoSV7rSfDSPW5EoNe1FjW7io4YKrsrT6HiQV8P8f8fpAzdALxUx'],
			['dzFFzCqrht1mN73kqE59Vtmdj816DZmcqmhaTdi3Qi4EGqzd4PcyoSV7rSfDSPW5EoNe1FjW7io4YKrsrT6HiQV8P8f8fpAzdALxUxT'],
			['DdzFFzCqrht1mN73kqDEC9Vtmdj816DZmcqmhaTdi3Qi4EGqzd4PcyoSV7rSfDSPW5EoNe1FjW7io4YKrsrT6HiQV8P8f8fpAzdALxUxT'],
			['DdzFFzCqrht1mN73kqE59Vtmdj816DZmcqmhaTdi3Qi4EGqzd4PcyoSV7rSfDSPW5EoNe1FjW7io4YKrsrT6HiQV8P8f8fpAzdALxUxt'],
			['DdzFFzCqrht1mN73kqE59Vtmdj816DZmcqmhaTdi3Qi4EGqzd4PcyoSV7rSfDSPW5EoNe1FjW7io4YKrsrT6HiQV8P8f8fpAzdALxxxT'],
			['DdzFFzCqrht1mN73kqE59Vtmdj816DZmcqmhaTdi3Qi4EGqzd4PcyoSV7rSfDSPW5EoNe1FjW7io4YKrsrT6HiQV8P8f8fpGzdALxUxT']
		];
	}

	public function providerValidate() {
		return [
			['DdzFFzCqrht1mN73kqE59Vtmdj816DZmcqmhaTdi3Qi4EGqzd4PcyoSV7rSfDSPW5EoNe1FjW7io4YKrsrT6HiQV8P8f8fpAzdALxUxT'],
			['DdzFFzCqrht1q7xBcjXUiqzFo6Js9DdJfLVXPgYjim9XAxzQyatPpQKX1tBUUFCJp6whBxuMQMpeCXm7hiMqn4jg5W375PkURj48yqKR'],
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
		$cardanoAddress = $this->createAddress($address);
		$this->assertFalse($cardanoAddress->supportsAdditionalId());
		$this->assertNull($cardanoAddress->getAdditionalIdName());
		$this->assertNull($cardanoAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return CardanoAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): CardanoAddress {
		return new CardanoAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::ADA));
	}
}
