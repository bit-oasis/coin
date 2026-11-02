<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\WaxAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 */
class WaxAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['way.too.long.name'],
			['thirteenchars'],
			['UPPERCASE123'],
			['wax.account6'],
			[''],
			// Dots only separate name parts
			['john.doe....'],
			['.wam'],
			['abc..def'],
			['............'],
		];
	}

	public function providerValidate(): array {
		return [
			['wax.account1'],
			['myaccount123'],
			['abc.def.ghi1'],
			// WAX Cloud Wallet names are shorter than 12 characters
			['abcde.wam'],
			['tooshort'],
			['a'],
		];
	}

	public function providerInvalidMemo(): array {
		return [
			['abcde.wam', "\xc3 this has \xe6\x9d some invalid utf8 \xe6"],
			['abcde.wam', str_repeat('a', 257)],
		];
	}

	public function providerValidMemo(): array {
		return [
			['abcde.wam', null],
			['abcde.wam', ''],
			['abcde.wam', '279786'],
			['abcde.wam', str_repeat('a', 256)],
			['abcde.wam', '区块链 Hash 值开奖平台'],
		];
	}

	/**
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress(string $address): void {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address): void {
			$this->createAddress($address);
		});
	}

	/**
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testValidAddress(string $address): void {
		$this->assertNotNull($this->createAddress($address));
	}

	/**
	 * @dataProvider providerInvalidMemo
	 */
	public function testInvalidMemo(string $address, string $memo): void {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address, $memo): void {
			$this->createAddress($address, $memo);
		});
	}

	/**
	 * @throws InvalidAddressException
	 * @dataProvider providerValidMemo
	 */
	public function testValidMemo(string $address, ?string $memo): void {
		$createdAddress = $this->createAddress($address, $memo);

		$this->assertSame($address, $createdAddress->getAddress());
		$this->assertSame($memo, $createdAddress->getMemo());
		$this->assertSame($memo, $createdAddress->getAdditionalId());
		$this->assertTrue($createdAddress->supportsAdditionalId());
		$this->assertSame('memo', $createdAddress->getAdditionalIdName());
	}

	/**
	 * @throws InvalidAddressException
	 * @dataProvider providerValidMemo
	 */
	public function testSerialize(string $address, ?string $memo): void {
		$createdAddress = $this->createAddress($address, $memo);
		$serialized = $createdAddress->serialize();

		$this->assertSame($address . ($memo === null ? '' : '#' . $memo), $serialized);
		$this->assertTrue($createdAddress->equals(WaxAddress::deserialize(
			$serialized,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::WAXP),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::WAX)
		)));
	}

	/**
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address, ?string $memo = null): WaxAddress {
		return new WaxAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::WAXP),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::WAX),
			$memo
		);
	}

}
