<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\SuiAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class SuiAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			// Invalid: Missing "0x" prefix
			['f821d3483fc7725ebafaa5a3d12373d49901bdfce1484f219daa7066a30df77d'],
			// Invalid: Length is not 32 bytes
			['0x9b41efa4a78ae1dc79c0bfc705751ad7b20501623aadf5c4a735681eda64a6f'],
			// Invalid: Contains non-hex characters
			['0xf6d6a85940c50433adaa11bd76e1ba32d45c95aeb2ad54cf91c93c11a85eda5g'],
		];
	}

	public function providerValidate() {
		return [
			['0xf821d3483fc7725ebafaa5a3d12373d49901bdfce1484f219daa7066a30df77d'],
			['0x9b41efa4a78ae1dc79c0bfc705751ad7b20501623aadf5c4a735681eda64a6fa'],
			['0xf6d6a85940c50433adaa11bd76e1ba32d45c95aeb2ad54cf91c93c11a85eda57'],
			['0x02a212de6a9dfa3a69e22387acfbafbb1a9e591bd9d636e7895dcfc8de05f331'],
			['0x12db24de9eaf6e0a5ae9b512a4db2d804a116385890f550306b57e2709b1fd1d'],
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
	 * @return SuiAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new SuiAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::SUI),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::SUI)
		);
	}
}