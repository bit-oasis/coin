<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use UnitTestUtils;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class StellarAddressTest extends UnitTest {

	public function providerDeserialize() {
		return [
			['GAWPTHY6233GRWZZ7JXDMVXDUDCVQVVQ2SXCSTG3R3CNP5LQPDAHNBKL', 'GAWPTHY6233GRWZZ7JXDMVXDUDCVQVVQ2SXCSTG3R3CNP5LQPDAHNBKL', null],
			['GB3RMPTL47E4ULVANHBNCXSXM2ZA5JFY5ISDRERPCXNJUDEO73QFZUNK', 'GB3RMPTL47E4ULVANHBNCXSXM2ZA5JFY5ISDRERPCXNJUDEO73QFZUNK', null],
			['GB3RMPTL47E4ULVANHBNCXSXM2ZA5JFY5ISDRERPCXNJUDEO73QFZUNK#9296673e8b7048a159', 'GB3RMPTL47E4ULVANHBNCXSXM2ZA5JFY5ISDRERPCXNJUDEO73QFZUNK', '9296673e8b7048a159'],
			['GB3RMPTL47E4ULVANHBNCXSXM2ZA5JFY5ISDRERPCXNJUDEO73QFZUNK#929#6673e8b7048a1', 'GB3RMPTL47E4ULVANHBNCXSXM2ZA5JFY5ISDRERPCXNJUDEO73QFZUNK', '929#6673e8b7048a1'],
			['GB3RMPTL47E4ULVANHBNCXSXM2ZA5JFY5ISDRERPCXNJUDEO73QFZUNK##', 'GB3RMPTL47E4ULVANHBNCXSXM2ZA5JFY5ISDRERPCXNJUDEO73QFZUNK', '#'],
			['GB3RMPTL47E4ULVANHBNCXSXM2ZA5JFY5ISDRERPCXNJUDEO73QFZUNK#', 'GB3RMPTL47E4ULVANHBNCXSXM2ZA5JFY5ISDRERPCXNJUDEO73QFZUNK', ''],
		];
	}

	/**
	 * @param string $serializedAddress
	 * @param string $expectedAddress
	 * @param string|null $expectedMemo
	 * @dataProvider providerDeserialize
	 */
	public function testDeserialize($serializedAddress, $expectedAddress, $expectedMemo) {
		$stellarAddress = StellarAddress::deserialize($serializedAddress, $this->getCurrency());
		$this->assertEquals($expectedAddress, $stellarAddress->getAddress());
		$this->assertEquals($expectedMemo, $stellarAddress->getMemo());
	}

	/**
	 * @param string $serializedAddress
	 * @dataProvider providerDeserialize
	 */
	public function testAdditionalId($serializedAddress) {
		$stellarAddress = StellarAddress::deserialize($serializedAddress, $this->getCurrency());
		$this->assertTrue($stellarAddress->supportsAdditionalId());
		$this->assertEquals($stellarAddress->getMemo(), $stellarAddress->getAdditionalId());
	}

	/**
	 * @return Cryptocurrency
	 */
	protected static function getCurrency() {
		return UnitTestUtils::getCryptocurrency(Cryptocurrency::XLM);
	}

}
