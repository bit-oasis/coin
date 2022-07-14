<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Network\CryptocurrencyNetwork;
use UnitTestUtils;
use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class DogecoinAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['DJtCUTgitjdxXTUQK78BVm93AmrfFLAiWy'],
			['DCu92sq6BUC2eDZUWkFnng8h28HM33WDpW'],
			['AFiDLLoAx9JSgNJCnLhrQ14wq2FQTjD7J6'],
			['A7DC5S9VjuHXpCAXWohuLNza9BxeuCWNWG'],
			['9y992i9uQjr3PJFS1EPmVrd6FahsJjhuk3'],
			['9yVEnEEbXLE1HPsM59yhQeVo8f4hPgJTXa'],
		];
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address) {
		$bitcoinAddress = new DogecoinAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::DOGE),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::DOGECOIN)
		);
		$this->assertFalse($bitcoinAddress->supportsAdditionalId());
		$this->assertNull($bitcoinAddress->getAdditionalIdName());
		$this->assertNull($bitcoinAddress->getAdditionalId());
	}
}
