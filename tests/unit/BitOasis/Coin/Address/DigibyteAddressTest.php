<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;
use UnitTestUtils;
use UnitTest;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class DigibyteAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['DJtCUTgitjdxXTUQK78BVm93AmrfFLAiWy'],
			['DCu92sq6BUC2eDZUWkFnng8h28HM33WDpW'],
			['D9RCns9jprMJCtmzoHPdW78ScjnCoqxSg6'],
			['DKoUARtAM564Ls3gj5JnqGRpUrtor2UwzV'],
			['DKgXqynY4y82dYqSoC4Bt77A3qYKEg7fq4'],
			['dgb1qngjxps47zyxd5c87emjxd3zw0qnwv7p4vgsd8l'],
			['dgb1qyhg2xjdg9vf3u625pcjpkpkk4ah2p9x5suc899'],
			['dgb1qflkw0jypkdqjvtyynypufnracn0j5mm5nrlr7a'],
			['SbVNuFWJJq9wvrjj1qUsyeWzdJVojS1MqZ'],
			['Sfbt8PhCtE9tAaSD4rZhnB1BT1w8iDnWBt'],
			['SMrEKzXPiY97jRXREEkf39496Ej7Xrc9VE'],
		];
	}

	public function providerInvalidAddress() {
		return [
			['AKgXqynY4y82dYqSoC4Bt77A3qYKEg7fq4'],
			['BKgXqynY4y82dYqSoC4Bt77A3qYKEg7fq4'],
			['DKgXqynY4y82dYqSoC4Bt77A3qYKEg71q4'],
			['DKgAqynY4y82dYqSoC4Bt77A3qYKEg71q'],
			['DKgYqynY4y82dYqSoC4Bt77A3qYKEg71q41'],
			['DKgTqynY4y82dYqSoC4Bt77A3qYKEg71q11'],
			['SMrEKzXPiY97jRXREEkf39496Ej7Xrc9VE1'],
			['dgb1qyhg2xjdg9vf3u625pcjpkpkk4ah2p9x5suc804'],
			['dgb2qflkw0jypkdqjvtyynypufnracn0j5mm5nrlr7a'],
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
	public function testAdditionalId($address) {
		$address = $this->createAddress($address);
		$this->assertFalse($address->supportsAdditionalId());
		$this->assertNull($address->getAdditionalIdName());
		$this->assertNull($address->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return DigibyteAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new DigibyteAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::DGB),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::DIGIBYTE)
		);
	}

}
