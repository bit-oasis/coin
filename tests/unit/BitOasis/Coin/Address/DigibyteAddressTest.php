<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
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
		return new DigibyteAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::DGB));
	}

}
