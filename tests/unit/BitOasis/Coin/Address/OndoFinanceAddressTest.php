<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\OndoFinanceAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Shawki Alassi <shawki.alassi@bitoasis.net>
 */
class OndoFinanceAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['0xcffdded873554f362ac02f8fb1fO2e5ada10516f'],
			['0xcffdded873554f362ac02f8fb1f02e5ada10516g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
		];
	}

	public function providerValidate(): array {
		return [
			['0xfAbA6f8e4a5E8Ab82F62fe7C39859FA577C2F6f0'],
			['0x4d224452801ACEd8B2F0aebE155379bb5D594381'],
			['0x1f9840a85d5aF5bf1D1762F925BDADdC4201F984'],
			['0xA0b86991c6218b36c1d19D4a2e9Eb0cE3606eB48'],
			['0xd8dA6BF26964aF9D7eEd9e03E53415D37aA96045'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress($address): void {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address): void {
		$createdAddress = $this->createAddress($address);
		$this->assertFalse($createdAddress->supportsAdditionalId());
		$this->assertNull($createdAddress->getAdditionalIdName());
		$this->assertNull($createdAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return OndoFinanceAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address): OndoFinanceAddress {
		return new OndoFinanceAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::ONDO),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}
}
