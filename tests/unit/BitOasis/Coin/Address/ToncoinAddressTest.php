<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\ToncoinAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class ToncoinAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			// Invalid: Not raw address format "workchain:accountId"
			['0ca6e321c7cce9ecedf0a8ca2492ec8592494aa5fb5ce0387dff96ef6af982a3e'],
			['0xfa103c21ea2df71dfb92b0652f8b1d795e51cdef'],
			// Invalid: AccountId Length is not 32 bytes
			['-1:b77c79138ccd39b73bd71eb7d20e85d106396f452027b94008526982542c0a381'],
			['-1:b77c79138ccd39b73bd71eb7d20e85d106396f452027b94008526982542c0a3'],
			// Invalid: Workchain is not signed 8-bit integer
			['128:0c97a0557a00b420e64f2e12f35811c29cae223b81b978dbb8aa7fcd2909e821'],
			['-129:0c97a0557a00b420e64f2e12f35811c29cae223b81b978dbb8aa7fcd2909e821'],
			// Invalid: Wrong prefix
			['RQAMl6BVegC0IOZPLhLzWBHCnK4iO4G5eNu4qn_NKQnoISvm'],
			['XQB3ncyBUTjZUA5EnFKR5_EnOMI9V1tTEAAPaiU71gc4TiUt'],
			// Invalid: Length is not 36 byte
			['UQDS46qzjIuiiBcZ2y_IK1xfIXfASQ0wYf3rg9n8vziLaC12A'],
			// Invalid: Checksum mismatch
			['EQB3ncyBXTjZUA5EnFKR5_EnOMI9V1tTEAAPaiU71gc4TiUt']
		];
	}

	public function providerValidate() {
		return [
			['0:ca6e321c7cce9ecedf0a8ca2492ec8592494aa5fb5ce0387dff96ef6af982a3e'],
			['-1:b77c79138ccd39b73bd71eb7d20e85d106396f452027b94008526982542c0a38'],
			['127:0c97a0557a00b420e64f2e12f35811c29cae223b81b978dbb8aa7fcd2909e821'],
			['-128:3816e94ce7f33c6379f0b87d000ae5c2c92bd195d744959db4cf759c28aa1408'],
			['EQAMl6BVegC0IOZPLhLzWBHCnK4iO4G5eNu4qn_NKQnoISvm'],
			['EQB3ncyBUTjZUA5EnFKR5_EnOMI9V1tTEAAPaiU71gc4TiUt'],
			['UQApDXClejVz1RzuWt0zwInOEX9BTAgZ7Iu1dBXXkvCGHdhM'],
			['UQDS46qzjIuiiBcZ2y_IK1xfIXfASQ0wYf3rg9n8vziLaC12'],
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
	 * @return ToncoinAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new ToncoinAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::TON),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::TON)
		);
	}
}