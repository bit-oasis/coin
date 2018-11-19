<?php

namespace BitOasis\Coin\Address;

use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
abstract class BaseBitcoinCashAddressTest extends UnitTest {	

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
		$address = $this->createAddress($base58Address);
		$this->assertEquals($address->toCashAddress()->toString(), $expectedAddress);
	}

	/**
	 * @param string $base58Address
	 * @param string $cashAddress
	 * @dataProvider providerBase58ToCashAddress
	 */
	public function testToBase58Same($base58Address) {
		$address = $this->createAddress($base58Address);
		$this->assertEquals($address->toBase58()->toString(), $base58Address);
	}

	public function providerCashAddressToBase58() {
		return [
			['bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', '1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu'],
			['bitcoincash:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', '1KXrWXciRDZUpQwQmuM1DbwsKDLYAYsVLR'],
			['bitcoincash:qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', '16w1D5WRVKJuZUsSRzdLp9w3YGcgoxDXb'],
			['bitcoincash:ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', '3CWFddi6m4ndiGyKqzYvsFYagqDLPVMTzC'],
			['bitcoincash:pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', '3LDsS579y7sruadqu11beEJoTjdFiFCdX4'],
			['bitcoincash:pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', '31nwvkZwyPdgzjBJZXfDmSWsC4ZLKpYyUw'],
			['qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', '1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu'],
			['qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', '1KXrWXciRDZUpQwQmuM1DbwsKDLYAYsVLR'],
			['qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', '16w1D5WRVKJuZUsSRzdLp9w3YGcgoxDXb'],
			['ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', '3CWFddi6m4ndiGyKqzYvsFYagqDLPVMTzC'],
			['pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', '3LDsS579y7sruadqu11beEJoTjdFiFCdX4'],
			['pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', '31nwvkZwyPdgzjBJZXfDmSWsC4ZLKpYyUw'],
		];
	}

	/**
	 * @param string $cashAddress
	 * @param string $expectedAddress
	 * @dataProvider providerCashAddressToBase58
	 */
	public function testToBase58($cashAddress, $expectedAddress) {
		$address = $this->createAddress($cashAddress);
		$this->assertEquals($address->toBase58()->toString(), $expectedAddress);
	}

	/**
	 * @param string $cashAddress
	 * @dataProvider providerCashAddressToBase58
	 */
	public function testToCashAddressSame($cashAddress) {
		$address = $this->createAddress($cashAddress);
		$this->assertEquals($address->toCashAddress()->toString(), $cashAddress);
	}

	public function providerToFullAddressString() {
		return [
			['bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', 'bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a'],
			['bitcoincash:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', 'bitcoincash:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy'],
			['bitcoincash:qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', 'bitcoincash:qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r'],
			['bitcoincash:ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', 'bitcoincash:ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq'],
			['bitcoincash:pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', 'bitcoincash:pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e'],
			['bitcoincash:pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', 'bitcoincash:pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37'],
			['qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', 'bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a'],
			['qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', 'bitcoincash:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy'],
			['qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', 'bitcoincash:qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r'],
			['ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', 'bitcoincash:ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq'],
			['pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', 'bitcoincash:pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e'],
			['pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', 'bitcoincash:pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37'],
            ['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu', '1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu'],
            ['1KXrWXciRDZUpQwQmuM1DbwsKDLYAYsVLR', '1KXrWXciRDZUpQwQmuM1DbwsKDLYAYsVLR'],
            ['16w1D5WRVKJuZUsSRzdLp9w3YGcgoxDXb', '16w1D5WRVKJuZUsSRzdLp9w3YGcgoxDXb'],
            ['3CWFddi6m4ndiGyKqzYvsFYagqDLPVMTzC', '3CWFddi6m4ndiGyKqzYvsFYagqDLPVMTzC'],
            ['3LDsS579y7sruadqu11beEJoTjdFiFCdX4', '3LDsS579y7sruadqu11beEJoTjdFiFCdX4'],
            ['31nwvkZwyPdgzjBJZXfDmSWsC4ZLKpYyUw', '31nwvkZwyPdgzjBJZXfDmSWsC4ZLKpYyUw'],
		];
	}

	/**
	 * @param string $inputAddress
	 * @param string $expectedAddress
	 * @dataProvider providerToFullAddressString
	 */
	public function testToFullAddressString($inputAddress, $expectedAddress) {
		$address = $this->createAddress($inputAddress);
		$this->assertEquals($address->toFullAddressString(), $expectedAddress);
	}

	public function providerToShortAddressString() {
		return [
			['bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', 'qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a'],
			['bitcoincash:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', 'qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy'],
			['bitcoincash:qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', 'qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r'],
			['bitcoincash:ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', 'ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq'],
			['bitcoincash:pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', 'pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e'],
			['bitcoincash:pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', 'pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37'],
			['qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', 'qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a'],
			['qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', 'qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy'],
			['qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', 'qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r'],
			['ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', 'ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq'],
			['pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', 'pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e'],
			['pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', 'pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37'],
            ['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu', '1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu'],
            ['1KXrWXciRDZUpQwQmuM1DbwsKDLYAYsVLR', '1KXrWXciRDZUpQwQmuM1DbwsKDLYAYsVLR'],
            ['16w1D5WRVKJuZUsSRzdLp9w3YGcgoxDXb', '16w1D5WRVKJuZUsSRzdLp9w3YGcgoxDXb'],
            ['3CWFddi6m4ndiGyKqzYvsFYagqDLPVMTzC', '3CWFddi6m4ndiGyKqzYvsFYagqDLPVMTzC'],
            ['3LDsS579y7sruadqu11beEJoTjdFiFCdX4', '3LDsS579y7sruadqu11beEJoTjdFiFCdX4'],
            ['31nwvkZwyPdgzjBJZXfDmSWsC4ZLKpYyUw', '31nwvkZwyPdgzjBJZXfDmSWsC4ZLKpYyUw'],
		];
	}

	/**
	 * @param string $inputAddress
	 * @param string $expectedAddress
	 * @dataProvider providerToShortAddressString
	 */
	public function testToShortAddressString($inputAddress, $expectedAddress) {
		$address = $this->createAddress($inputAddress);
		$this->assertEquals($address->toShortAddressString(), $expectedAddress);
	}

	/**
	 * @param string $base58Address
	 * @dataProvider providerBase58ToCashAddress
	 */
	public function testAdditionalId($base58Address) {
		$address = $this->createAddress($base58Address);
		$this->assertFalse($address->supportsAdditionalId());
		$this->assertNull($address->getAdditionalId());
	}

	/**
	 * @param $address string
	 * @return BaseBitcoinCashAddress
	 */
	abstract protected function createAddress($address);

}
