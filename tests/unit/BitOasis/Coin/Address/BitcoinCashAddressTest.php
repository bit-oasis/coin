<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class BitcoinCashAddressTest extends UnitTest {	

	public function providerBase58ToCashAddress() {
		return [
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu', 'bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a'],
			['1KXrWXciRDZUpQwQmuM1DbwsKDLYAYsVLR', 'bitcoincash:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy'],
			['16w1D5WRVKJuZUsSRzdLp9w3YGcgoxDXb', 'bitcoincash:qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r'],
			['3CWFddi6m4ndiGyKqzYvsFYagqDLPVMTzC', 'bitcoincash:ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq'],
			['3LDsS579y7sruadqu11beEJoTjdFiFCdX4', 'bitcoincash:pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e'],
			['31nwvkZwyPdgzjBJZXfDmSWsC4ZLKpYyUw', 'bitcoincash:pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37'],
		];
	}

	/**
	 * @param string $base58Address
	 * @param string $expectedAddress
	 * @dataProvider providerBase58ToCashAddress
	 */
	public function testToCashAddress($base58Address, $expectedAddress) {
		$address = new BitcoinCashAddress($base58Address, self::getCurrency());
		$this->assertEquals($address->toCashAddress()->toString(), $expectedAddress);
	}

	/**
	 * @param string $expectedAddress
	 * @param string $cashAddress
	 * @dataProvider providerBase58ToCashAddress
	 */
	public function testToBase58($expectedAddress, $cashAddress) {
		$address = new BitcoinCashAddress($cashAddress, self::getCurrency());
		$this->assertEquals($address->toBase58()->toString(), $expectedAddress);
	}

	/**
	 * @param string $base58Address
	 * @param string $cashAddress
	 * @dataProvider providerBase58ToCashAddress
	 */
	public function testToCashAddressSame($base58Address, $cashAddress) {
		$address = new BitcoinCashAddress($cashAddress, self::getCurrency());
		$this->assertEquals($address->toCashAddress()->toString(), $cashAddress);
	}

	/**
	 * @param string $base58Address
	 * @param string $cashAddress
	 * @dataProvider providerBase58ToCashAddress
	 */
	public function testToBase58Same($base58Address, $cashAddress) {
		$address = new BitcoinCashAddress($base58Address, self::getCurrency());
		$this->assertEquals($address->toBase58()->toString(), $base58Address);
	}

	/**
	 * @return Cryptocurrency
	 */
	protected static function getCurrency() {
		return new Cryptocurrency(Cryptocurrency::BCH, 8, 'Bitcoin cash');
	}

}
