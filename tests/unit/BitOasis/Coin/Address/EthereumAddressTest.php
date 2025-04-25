<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class EthereumAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
		];
	}

	public function providerValidate(): array {
		return [
			['0xad2cc05dbde36e3b21fe4692e432be3074adb729'],
			['0xa1d8d972560c2f8144af871db508f0b0b10a3fbf'],
			['0x21a31ee1afc51d94c2efccaa2092ad1028285549'],
			['0x70dba826182e04a4fef97cdc87f5228d71a0b5e0'],
			['0x77696bb39917c91a0c3908d577d5e322095425ca'],
		];
	}

	/**
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress(string $address): void {
		$this->tester->expectThrowable(InvalidAddressException::class, function() use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @dataProvider providerValidate
	 * @throws InvalidAddressException
	 */
	public function testAdditionalId(string $address): void {
		$createdAddress = $this->createAddress($address);
		$this->assertFalse($createdAddress->supportsAdditionalId());
		$this->assertNull($createdAddress->getAdditionalIdName());
		$this->assertNull($createdAddress->getAdditionalId());
	}

	/**
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): EthereumAddress {
		return new EthereumAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::ETH),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}
}