<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\HederaAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author tariq.tawalbeh <tariq.tawalbeh@bitoasis.net>
 */
class HederaAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			// Missing account number
			['0.0'],
			// Non-numeric parts
			['0.0.abc'],
			['abc'],
			// Ethereum address
			['0x264ded7e280E6D8FB6ce497Eb3F594b9bc4Ea6CC'],
			// Too many parts
			['0.0.123.456'],
			// Other chain
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			// Invalid memo (non-alphanumeric)
			['0.0.123456', 'memo with spaces'],
			['0.0.123456', 'memo!@#$'],
		];
	}

	public function providerValidate(): array {
		return [
			['0.0.98'],
			['0.0.123456'],
			['0.0.4217045'],
			// With checksum suffix
			['0.0.123456-vfmkw'],
			// With memo
			['0.0.123456', '123456'],
			['0.0.123456', 'EF97BA021ACDC4E48F56'],
		];
	}

	/**
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress(string $address, ?string $memo = null): void {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address, $memo): void {
			$this->createAddress($address, $memo);
		});
	}

	/**
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId(string $address, ?string $memo = null): void {
		$createdAddress = $this->createAddress($address, $memo);
		$this->assertTrue($createdAddress->supportsAdditionalId());
		$this->assertEquals('memo', $createdAddress->getAdditionalIdName());
		$this->assertEquals($memo, $createdAddress->getAdditionalId());
		$this->assertEquals($createdAddress->getMemo(), $createdAddress->getAdditionalId());
	}

	/**
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address, ?string $memo = null): HederaAddress {
		return new HederaAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::HBAR),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::HEDERA),
			$memo
		);
	}

}
