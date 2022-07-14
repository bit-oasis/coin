<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Network\CryptocurrencyNetwork;
use UnitTest;
use UnitTestUtils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class NearAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
			['efbad19288fe961664f70b03b122541b46244cb287557e26b17c2b0926c6c61b1'],
			['1efbad19288fe961664f70b03b122541b46244cb287557e26b17c2b0926c6c61b'],
			['efbad19288fe961664f70b03b122541b46244cb287557e26b17c2b0926c6c61t'],
			['_invalidaddress.near'],
			['i__nvalid.near'],
			['i--nvalid.near'],
			['--invalid.near'],
			['-invalid.near'],
			['invalid-_near'],
			['invalid.test'],
			['invalid.bulo'],
			['invalid.kulo'],
			['invalid.neard'],
			['invalid.nears'],
			['@invalid.near'],
			['invalid@.near'],
			['i@nvalid.near'],
			['inval.id.near'],
			['inval.near.xxx'],
			['invalaskgnadkjgbadosjhgoiadhgpiadhgpiadhgpiadhgpiadhgpiadhgoiabdgopiadhpighapodghpadihgpaihgpidahpiadhgadg.near'],
		];
	}

	public function providerValidate() {
		return [
			// Any hex string with 64 length
			['valid_address.near'],
			['va_li_d_address.near'],
			['va-lid-address.near'],
			['valid_address-1.near'],
			['valid-a-d-d-ress-2.near'],
			['any-address-0-9-a-z.near'],
			['efbad19288fe961664f70b03b122541b46244cb287557e26b17c2b0926c6c61b'],
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
		$nearAddress = $this->createAddress($address);
		$this->assertFalse($nearAddress->supportsAdditionalId());
		$this->assertNull($nearAddress->getAdditionalIdName());
		$this->assertNull($nearAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return NearAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new NearAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::NEAR),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::NEAR)
		);
	}
}
