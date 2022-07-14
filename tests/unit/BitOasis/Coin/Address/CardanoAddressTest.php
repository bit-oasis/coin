<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Network\CryptocurrencyNetwork;
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
			['DdzFFzCqrht1mN73kqE59Vtmdj816DZmcqmhaTdi3Qi4EGqzd4PcyoSV7rSfDSPW5EoNe1FjW7io4YKrsrT6HiQV8P8f8fpGzdALxUxT'],
			['addr1qx2fxv2umyhttkxyxp8x0dlpdt3k6cwng5pxj3jhsydzer3n0c3vllmyqwsx5wktcd8cc3sq835lu7drv2xwl2wywfgse35a3x'],
			['addr128phkx6acpnf78fuvxn0mkew3l0fd058hzquvz7w36x4gtupnz75xxcrtw79hua1'],
			['addr2vx2fxv2umyhttkxyxp8x0dlpdt3k6cwng5pxj3jhsydzers66hrl8'],
			['addre1vx2fxv2umyhttkxyxp8x0dlpdt3k6cwng5pxj3jhsydzers66hrl8'],
			['addrvx2fxv2umyhttkxyxp8x0dlpdt3k6cwng5pxj3jhsydzers66hrl8'],
		];
	}

	public function providerValidate() {
		return [
			['DdzFFzCqrht1mN73kqE59Vtmdj816DZmcqmhaTdi3Qi4EGqzd4PcyoSV7rSfDSPW5EoNe1FjW7io4YKrsrT6HiQV8P8f8fpAzdALxUxT'],
			['DdzFFzCqrht1q7xBcjXUiqzFo6Js9DdJfLVXPgYjim9XAxzQyatPpQKX1tBUUFCJp6whBxuMQMpeCXm7hiMqn4jg5W375PkURj48yqKR'],
			['addr1qx2fxv2umyhttkxyxp8x0dlpdt3k6cwng5pxj3jhsydzer3n0d3vllmyqwsx5wktcd8cc3sq835lu7drv2xwl2wywfgse35a3x'],
			['addr1z8phkx6acpnf78fuvxn0mkew3l0fd058hzquvz7w36x4gten0d3vllmyqwsx5wktcd8cc3sq835lu7drv2xwl2wywfgs9yc0hh'],
			['addr1yx2fxv2umyhttkxyxp8x0dlpdt3k6cwng5pxj3jhsydzerkr0vd4msrxnuwnccdxlhdjar77j6lg0wypcc9uar5d2shs2z78ve'],
			['addr1x8phkx6acpnf78fuvxn0mkew3l0fd058hzquvz7w36x4gt7r0vd4msrxnuwnccdxlhdjar77j6lg0wypcc9uar5d2shskhj42g'],
			['addr1gx2fxv2umyhttkxyxp8x0dlpdt3k6cwng5pxj3jhsydzer5pnz75xxcrzqf96k'],
			['addr128phkx6acpnf78fuvxn0mkew3l0fd058hzquvz7w36x4gtupnz75xxcrtw79hu'],
			['addr1vx2fxv2umyhttkxyxp8x0dlpdt3k6cwng5pxj3jhsydzers66hrl8'],
			['addr1w8phkx6acpnf78fuvxn0mkew3l0fd058hzquvz7w36x4gtcyjy7wx']
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
	 * @throws InvalidAddressException
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
		return new CardanoAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::ADA),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::CARDANO)
		);
	}
}
