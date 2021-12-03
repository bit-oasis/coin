<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class LoopringAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
		];
	}

	public function providerValidate() {
		return [
			['0x29984d1f9055cafb02dcdd53c54b727902e44975'],
			['0x28c6c06298d514db089934071355e5743bf21d60'],
			['0x503828976d22510aad0201ac7ec88293211d23da'],
			['0x1204817f01fb0aec63ba9859c4996a88c13501b5'],
			['0x943dd11d27ede237cafc30dbb568eca9b83728b8'],
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
	 */
	public function testAdditionalId($address) {
		$augurAddress = $this->createAddress($address);
		$this->assertFalse($augurAddress->supportsAdditionalId());
		$this->assertNull($augurAddress->getAdditionalIdName());
		$this->assertNull($augurAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return LoopringAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new LoopringAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::LRC));
	}
}
