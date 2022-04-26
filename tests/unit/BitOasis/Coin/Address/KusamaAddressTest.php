<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class KusamaAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['E5o12agZ5cMy1WxQFpNHRBoDYJAg9b5WDYh93XrccxnYPn'],
			['E5o12agZ5cMy1WxQFpNHRBoDYJAg9b5WDYh93XrccxnYPnba'],
			['058empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRWm'],
			['1dagojg92h4t439dKLGNKhngoiwqehgOIGNOIGHpibT1TDgzS9euVZYBkgKTRWm'],
			['3o1rj0INDIAHge0i3tb08POFO9fj39h9r3hr0Hhet0ibT3r5FTTGr5gGt35r3gG'],
		];
	}

	public function providerValidate() {
		return [
			['E5o12agZ5cMy1WxQFpNHRBoDYJAg9b5WDYh93XrccxnYPnb'],
			['EiH7yrzRpFPJviJFC2pfsFasurZquHh6T7UUkm9kyxDwuQJ'],
			['GA9b4Z86es13jA9tZwakX6fjjo4ZxXVjPPKBsg8iTNYaqcM'],
			['HvodGfoXEkUDFUuEtup3ZKQnNVfuj2swFnEwyR9KeWvUTot'],
			['HFHRcniJYkTEDGGCb8tKwg96piVAz81Hgnq4TRsJhNPKxXT'],
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
	 * @dataProvider providerValidate
	 * @throws InvalidAddressException
	 */
	public function testAdditionalId(string $address) {
		$polkadotAddress = $this->createAddress($address);
		$this->assertFalse($polkadotAddress->supportsAdditionalId());
		$this->assertNull($polkadotAddress->getAdditionalIdName());
		$this->assertNull($polkadotAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return KusamaAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): KusamaAddress {
		return new KusamaAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::KSM));
	}
}
