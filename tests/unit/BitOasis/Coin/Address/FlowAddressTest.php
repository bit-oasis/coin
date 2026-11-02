<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\FlowAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 */
class FlowAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			// Invalid: length is not 8 bytes
			['0xf919ee77447b74'],
			['0xf919ee77447b74977'],
			// Invalid: contains non-hex characters
			['0xf919ee77447b74g7'],
			// Invalid: empty
			[''],
			['0x'],
			// Invalid: fails the checksum built into the address (last digit changed)
			['0xf919ee77447b7496'],
			['0x0000000000000000'],
			// Invalid: valid addresses of the other Flow networks - testnet and emulator
			['0x8c5303eaa26202d6'],
			['0x7e60df042a9c0868'],
			['0xf8d6e0586b0a20c7'],
		];
	}

	public function providerValidate() {
		return [
			['0xf919ee77447b7497'],
			['0x1654653399040a61'],
			['0xe467b9dd11fa00df'],
			['0xf233dcee88fe0abe'],
		];
	}

	/**
	 * The prefix and the letter case are not part of the account identifier
	 */
	public function providerNormalize() {
		return [
			['0xf919ee77447b7497', '0xf919ee77447b7497'],
			['f919ee77447b7497', '0xf919ee77447b7497'],
			['0xF919EE77447B7497', '0xf919ee77447b7497'],
			['0XF919EE77447B7497', '0xf919ee77447b7497'],
			['F919ee77447B7497', '0xf919ee77447b7497'],
		];
	}

	public function providerNonStringAddress() {
		return [
			[null],
			[12345],
			[['0xf919ee77447b7497']],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress($address) {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @param mixed $address
	 * @dataProvider providerNonStringAddress
	 */
	public function testNonStringAddress($address) {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address) {
		$createdAddress = $this->createAddress($address);
		$this->assertFalse($createdAddress->supportsAdditionalId());
		$this->assertNull($createdAddress->getAdditionalIdName());
		$this->assertNull($createdAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @param string $expected
	 * @throws InvalidAddressException
	 * @dataProvider providerNormalize
	 */
	public function testNormalization($address, $expected) {
		$createdAddress = $this->createAddress($address);

		$this->assertSame($expected, $createdAddress->getAddress());
		$this->assertSame($expected, $createdAddress->serialize());
		$this->assertTrue($createdAddress->equals($this->createAddress($expected)));
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testSerialize($address) {
		$createdAddress = $this->createAddress($address);

		$this->assertSame($address, $createdAddress->toString());
		$this->assertSame($address, $createdAddress->serialize());
		$this->assertTrue($createdAddress->equals(FlowAddress::deserialize(
			$createdAddress->serialize(),
			UnitTestUtils::getCryptocurrency(Cryptocurrency::FLOW),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::FLOW)
		)));
	}

	/**
	 * @param mixed $address
	 * @return FlowAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new FlowAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::FLOW),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::FLOW)
		);
	}
}
