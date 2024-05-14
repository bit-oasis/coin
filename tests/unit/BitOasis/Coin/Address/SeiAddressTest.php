<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\SeiAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class SeiAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			// Invalid: Missing "sei" prefix
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['notsei1umsz72jtj9n30hkehahhq9mfj5k53apv8s6hsy'],
			// Invalid: Length is not 32 bytes
			['sei1umsz72jtj9n30hkehahhq9mfj5k53apv8s6hsyextra'],
			['notsei1umsz72jtj9n30hkehahhq9mfj5k53apv8s6hsyextra'],
			['sei1umsz72jtj9n30hkehhhq9mfj5k53apv8s6hsy'],
		];
	}

	public function providerValidate() {
		return [
			['sei1umsz72jtj9n30hkehahhq9mfj5k53apv8s6hsy'],
			['sei14y0q9ax6smr32sqt7spxvlsksjw7pyxsqcf9eg'],
			['sei12p0jcq6ftqa7gpr4mfnm5ymu579yuwpxctxap4'],
			['sei14n9fhykwk8rk7zln7rzd6uyhm2gzntuw2pv0e9'],
			['sei13qj8z08uufaj38kffxuwafj5qxfk758hu09czc'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress($address) {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address) {
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
	 * @return SeiAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new SeiAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::SEI),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::SEI)
		);
	}
}