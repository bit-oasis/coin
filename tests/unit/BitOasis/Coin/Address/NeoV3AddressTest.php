<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTestUtils;
use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class NeoV3AddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['NiTwToAuoKwE5DPLTnyvEYXuSGLuGpMJ6T'],
			['NPQTbHwvbnfhRUcC3epNYtwUDV8bEEv9hb'],
			['NZxpsDUTfccHRWPaoxAukkTjhkDsq5K5cf'],
			['NfxkpQx5B6eL6BDpxfPmYPj6tr28gFdfiT'],
			['NbF75kjgUmJhwdXQsRZBPFH1viV3XcybkT'],
			['NTPBX8iZQBQ17rMr4kwSMJwmpGEPExcuXA'],
		];
	}

	public function providerInvalidAddress() {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['158empuh8qY17bsnK65kmnYPsmbT1TDgzS9euVZYBkgKTRW1'],
			['AKxnTpwQzZNLaGpK1WhUSucM9G5e71e19Y'],
			['AH9oFBoQn88AUXfZsjmLPBiiZ27FoQGrbC'],
			['ATKQ2f3iHtojSrzXkESavZ1qyhLeoPX2fA'],
			['3o1rj0INDIAHge0i3tb08POFO9fj39h9r3hr0Hhet0ibT3r5FTTGr5gGt35r3gG'],
			['2to3kfM6w5Z16CTbLj8N8mcxQsQKHPmNEGYTAyMPKAoX'],
			['4yhAARGVmryMueZ39XHLi1wvdgQ1rc6vBRQKfLeiczeZ']
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
	 * @dataProvider providerValidate
	 * @throws InvalidAddressException
	 */
	public function testAdditionalId($address) {
		$neoAddress = $this->createAddress($address);
		$this->assertFalse($neoAddress->supportsAdditionalId());
		$this->assertNull($neoAddress->getAdditionalIdName());
		$this->assertNull($neoAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return NeoV3Address
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): NeoV3Address {
		return new NeoV3Address($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::NEO));
	}

}
