<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;
use UnitTest;
use UnitTestUtils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class WavesAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
			['rLW9gnQo7BQhU6igk5keqYnH3TVrCxGRzm#3140149957'],
		];
	}

	public function providerValidate() {
		return [
			['3PGS9W5aZ4kdBFJJ9jxmgjLW8qfqu1b3Y66'],
			['3PQXH53ELRHiBoJaq5jLas61mGpzizoWuVo'],
			['3PMj3yGPBEa1Sx9X4TSBFeJCMMaE3wvKR4N'],
			['3P2pTpQhGbZrJXATKr75A1uZjeTrb4PHMYf'],
			['3PEjHv3JGjcWNpYEEkif2w8NXV4kbhnoGgu'],
			['3PJJhXKPjrZQBWH7boPKQU9rgLXPEmCCcDX'],
			['3P5wPrvSgxks5NzTPGDJXokT9PKQBSAp8En'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress($address) {
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
		$createdAddress = $this->createAddress($address);
		$this->assertFalse($createdAddress->supportsAdditionalId());
		$this->assertNull($createdAddress->getAdditionalIdName());
		$this->assertNull($createdAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return WavesAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new WavesAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::WAVES),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::WAVES)
		);
	}
}
