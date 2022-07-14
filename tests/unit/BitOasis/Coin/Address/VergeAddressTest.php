<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Network\CryptocurrencyNetwork;
use UnitTestUtils;
use UnitTest;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class VergeAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['DQkwDpRYUyNNnoEZDf5Cb3QVazh4FuPRs9'],
			['DBFHBjwbSM8KwMzEDk3AVVHrKqnw1V3zLG'],
			['DJUJgi3rB2FXeXC5wpeBSXa4fwr25NQWzo'],
			['D76EBMSp9sRinAKk4PK74Av94SxPkrL8QL'],
			['DPnbbrL5QGJ4sNPdAA5KsPxDmySBcHHcuF'],
			['DSBDimCy1KcJHxt75dNxuhVRDDHC8GGREQ']
		];
	}

	public function providerInvalid() {
		return [
			['D86EBMSp9sRinAKk4PK74Av94SxPkrL8QL'],
			['DAkwDpRYUyNNnoEZDf5Cb3QVazh4FuPRs9'],
			['DJUJgi3rB2FXeXC5wpeBSXa4fwr25NQWz'],
			['DJUJgi3rB2FXeXC5wpeBSXa4fwr25NQWzoA'],
			['MNqvjH6dMS76vePHAsN2LRrpC7KiXDC7o7'],
			['QWMA9xMhXhoG53jM38xP9LMNuhe9nrUDwva'],
			['QWMA9xMhXhoG53jM38xP9LMNuhe9nrUDw'],
			['1AzWF56n8PXDpvmKu2zYFttC2uCWnWphhr'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalid
	 */
	public function testInvalidAddress(string $address) {
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
		$address = $this->createAddress($address);
		$this->assertFalse($address->supportsAdditionalId());
		$this->assertNull($address->getAdditionalIdName());
		$this->assertNull($address->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return VergeAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): VergeAddress {
		return new VergeAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::XVG),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::VERGE)
		);
	}

}
