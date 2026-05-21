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

	public function providerInvalidAddress(): array {
		return [
			// Invalid: Missing "sei" prefix
			['notsei1umsz72jtj9n30hkehahhq9mfj5k53apv8s6hsy', 123],
			// Invalid: Length is not 32 bytes
			['sei1umsz72jtj9n30hkehahhq9mfj5k53apv8s6hsyextra', 123],
			['notsei1umsz72jtj9n30hkehahhq9mfj5k53apv8s6hsyextra', 123],
			['sei1umsz72jtj9n30hkehhhq9mfj5k53apv8s6hsy', null],
		];
	}

	public function providerValidate(): array {
		return [
			['sei1umsz72jtj9n30hkehahhq9mfj5k53apv8s6hsy', 1234],
			['sei14y0q9ax6smr32sqt7spxvlsksjw7pyxsqcf9eg', 0],
			['sei12p0jcq6ftqa7gpr4mfnm5ymu579yuwpxctxap4', 12343],
			['sei14n9fhykwk8rk7zln7rzd6uyhm2gzntuw2pv0e9', null],
			['sei13qj8z08uufaj38kffxuwafj5qxfk758hu09czc', 5100],
			['0xDFd5293D8e347dFe59E90eFd55b2956a1343963d'],
			['0xD8D6fFE342210057BF4DCc31DA28D006f253cEF0'],
			['0x22F9dCF4647084d6C31b2765F6910cd85C178C18'],
			['0x22F1153DF3FF6b8336a7193271Ca5316B6C9824D'],
			['0xD8D6fFE342210057BF4DCc31DA28D006f253cEF0'],
		];
	}

	/**
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress(string $address): void {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId(string $address, $tag = null): void {
		$seiAddress = $this->createAddress($address, $tag);

		if (!$seiAddress->isEvmAddress()) {
			$this->assertTrue($seiAddress->supportsAdditionalId());
		} else {
			$this->assertFalse($seiAddress->supportsAdditionalId());
		}

		$this->assertNotNull($seiAddress->getAdditionalIdName());
		$this->assertEquals($tag, $seiAddress->getAdditionalId());
		$this->assertEquals($seiAddress->getAdditionalId(), $seiAddress->getAdditionalId());
	}

	/**
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address, $tag = null): SeiAddress {
		return new SeiAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::SEI),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::SEI),
			$tag
		);
	}
}