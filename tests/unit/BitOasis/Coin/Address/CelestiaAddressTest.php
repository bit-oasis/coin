<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\CelestiaAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class CelestiaAddressTest extends UnitTest {

	public function providerInvalid() {
		return [
			['celestia1dkgjw7njm993hxv84fwlhhmjpykwycdvtveet31', 3140149957],
			['celestia1uvytvhunccudw8fzaxvsrumec53nawyjqw83y', 4294967295],
			['cosmos15v50ymp6n5dn73erkqtmq0u8adpl8d3ujv2e74', 3513531646],
			['cilestia14dzf69sys4f77ph5ycxt6t3yvngsygyhm4ffps', 3951464646],
			['acelestia19cdavlkp6jnag0328m6c2zfsedwtsc5kwdxaa', 1035096894],
		];
	}

	public function providerValidate() {
		return [
			['celestia1dkgjw7njm993hxv84fwlhhmjpykwycdvtveet3', 3140149957],
			['celestia1uvytvhunccudw8fzaxvsrumec53nawyjqw83yr', 4294967295],
			['celestia14dzf69sys4f77ph5ycxt6t3yvngsygyhm4ffps', 'some-stupid-memo'],
			['celestia1n9cdavlkp6jnag0328m6c2zfsedwtsc5kwdxaa', null],
		];
	}

	/**
	 * @dataProvider providerInvalid
	 */
	public function testInvalidAddress(string $address, $tag) {
		$this->tester->expectThrowable(InvalidAddressException::class, function() use ($address, $tag) {
			$this->createAddress($address, $tag);
		});
	}

	/**
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId(string $address, $tag) {
		$createdAddress = $this->createAddress($address, $tag);
		$this->assertTrue($createdAddress->supportsAdditionalId());
		$this->assertNotNull($createdAddress->getAdditionalIdName());
		$this->assertEquals($tag, $createdAddress->getAdditionalId());
		$this->assertEquals($createdAddress->getTag(), $createdAddress->getAdditionalId());
	}

	/**
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address, $tag = null): CelestiaAddress {
		return new CelestiaAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::TIA),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::CELESTIA),
			$tag
		);
	}
}