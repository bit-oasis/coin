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
class SolanaAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['158empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRW1'],
			['158empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRWt'],
			['058empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRWm'],
			['1dagojg92h4t439dKLGNKhngoiwqehgOIGNOIGHpibT1TDgzS9euVZYBkgKTRWm'],
			['3o1rj0INDIAHge0i3tb08POFO9fj39h9r3hr0Hhet0ibT3r5FTTGr5gGt35r3gG'],
			['DSgwK2mZUmJHaZqBKrcC2SSadRtoUFgv1qdaZPUifp'],
		];
	}

	public function providerValidate() {
		return [
			['DSgwK2mZUmJHaZqBKrcC2SSadRtoUFgv1qdaZPUifpto'],
			['8xW2s6Fgvkry7LCj9iysHpEKd65JqgV3QUaArGgXbFau'],
			['AmbcqD1BDrREBGHtRgcCjVe5JsEFTQ8T2r4Hi82ETP9e'],
			['3U5H7KoAi7jYothucy47vZqh5N3NYCPh436Tsghukw62'] // off-curve address
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
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
	public function testAdditionalId(string $address) {
		$solanaAddress = $this->createAddress($address);
		$this->assertFalse($solanaAddress->supportsAdditionalId());
		$this->assertNull($solanaAddress->getAdditionalIdName());
		$this->assertNull($solanaAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return SolanaAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): SolanaAddress {
		return new SolanaAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::SOL),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::SOLANA)
		);
	}
}
