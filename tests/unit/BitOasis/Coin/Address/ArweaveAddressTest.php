<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\ArweaveAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 */
class ArweaveAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			// Invalid: too short
			['cJ5V8sgWZm1HBFPg7GdX2L4vJ2qS7SQW9eHm8IJ0i'],
			// Invalid: too long
			['cJ5V8sgWZm1HBFPg7GdX2L4vJ2qS7SQW9eHm8IJ0iZUa'],
			// Invalid: contains a character outside base64url
			['cJ5V8sgWZm1HBFPg7GdX2L4vJ2qS7SQW9eHm8IJ0i+U'],
			// Invalid: empty
			[''],
			/**
			 * Invalid: the last character holds two bits that the 32-byte hash does not fill, so
			 * these decode to the same wallet as ...iZU and are not addresses of their own
			 */
			['cJ5V8sgWZm1HBFPg7GdX2L4vJ2qS7SQW9eHm8IJ0iZV'],
			['cJ5V8sgWZm1HBFPg7GdX2L4vJ2qS7SQW9eHm8IJ0iZW'],
			['cJ5V8sgWZm1HBFPg7GdX2L4vJ2qS7SQW9eHm8IJ0iZX'],
		];
	}

	public function providerValidate() {
		return [
			['cJ5V8sgWZm1HBFPg7GdX2L4vJ2qS7SQW9eHm8IJ0iZU'],
			['fV_2mXsXp4LRfoARYd4ChzxYv4MBS0EjDDH5zOiJ2Ck'],
			['BNttTBH_DJuiJrDR1YA7-Lh_UPdSN9z4PGm1_vfRPzI'],
		];
	}

	public function providerNonStringAddress() {
		return [
			[null],
			[12345],
			[['cJ5V8sgWZm1HBFPg7GdX2L4vJ2qS7SQW9eHm8IJ0iZU']],
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
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testSerialize($address) {
		$createdAddress = $this->createAddress($address);

		$this->assertSame($address, $createdAddress->getAddress());
		$this->assertSame($address, $createdAddress->toString());
		$this->assertSame($address, $createdAddress->serialize());
		$this->assertTrue($createdAddress->equals(ArweaveAddress::deserialize(
			$createdAddress->serialize(),
			UnitTestUtils::getCryptocurrency(Cryptocurrency::AR),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ARWEAVE)
		)));
	}

	/**
	 * @param mixed $address
	 * @return ArweaveAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new ArweaveAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::AR),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ARWEAVE)
		);
	}
}
