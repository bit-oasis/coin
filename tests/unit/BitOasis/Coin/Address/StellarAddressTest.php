<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;
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
	 * @throws InvalidAddressException
	 * @dataProvider providerDeserialize
	 */
	public function testDeserialize($serializedAddress, $expectedAddress, $expectedMemo) {
		$stellarAddress = StellarAddress::deserialize($serializedAddress, $this->getCurrency(), $this->getNetwork());
		$this->assertEquals($expectedAddress, $stellarAddress->getAddress());
		$this->assertEquals($expectedMemo, $stellarAddress->getMemo());
	}

	/**
	 * @param string $serializedAddress
	 * @param $expectedAddress
	 * @param $expectedMemo
	 * @throws InvalidAddressException
	 * @dataProvider providerDeserialize
	 */
	public function testAdditionalId($serializedAddress, $expectedAddress, $expectedMemo) {
		$stellarAddress = StellarAddress::deserialize($serializedAddress, $this->getCurrency(), $this->getNetwork());
		$this->assertTrue($stellarAddress->supportsAdditionalId());
		$this->assertNotNull($stellarAddress->getAdditionalIdName());
		$this->assertEquals($expectedMemo, $stellarAddress->getAdditionalId());
		$this->assertEquals($stellarAddress->getMemo(), $stellarAddress->getAdditionalId());
	}

	/**
	 * @return Cryptocurrency
	 */
	protected static function getCurrency() {
		return UnitTestUtils::getCryptocurrency(Cryptocurrency::XLM);
	}

	/**
	 * @return CryptocurrencyNetwork
	 */
	protected static function getNetwork() {
		return UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::STELLAR_LUMEN);
	}

}
