<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\HamsterKombatAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author shawki.alassi <shawki.alassi@bitoasis.net>
 */
class HamsterKombatAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['0ca6e321c7cce9ecedf0a8ca2492ec8592494aa5fb5ce0387dff96ef6af982a3e'],
			['0xfa103c21ea2df71dfb92b0652f8b1d795e51cdef'],
			['-1:b77c79138ccd39b73bd71eb7d20e85d106396f452027b94008526982542c0a381'],
			['-1:b77c79138ccd39b73bd71eb7d20e85d106396f452027b94008526982542c0a3'],
			['128:0c97a0557a00b420e64f2e12f35811c29cae223b81b978dbb8aa7fcd2909e821'],
		];
	}

	public function providerValidate(): array {
		return [
			['0:ca6e321c7cce9ecedf0a8ca2492ec8592494aa5fb5ce0387dff96ef6af982a3e'],
			['-1:b77c79138ccd39b73bd71eb7d20e85d106396f452027b94008526982542c0a38'],
			['127:0c97a0557a00b420e64f2e12f35811c29cae223b81b978dbb8aa7fcd2909e821'],
			['-128:3816e94ce7f33c6379f0b87d000ae5c2c92bd195d744959db4cf759c28aa1408'],
			['EQAMl6BVegC0IOZPLhLzWBHCnK4iO4G5eNu4qn_NKQnoISvm'],
		];
	}

	/**
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress(string $address): void {
		$this->tester->expectThrowable(InvalidAddressException::class, function () use ($address): void {
			$this->createAddress($address);
		});
	}

	/**
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testValidAddress(string $address): void {
		$this->assertNotNull($this->createAddress($address));
	}

	/**
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): HamsterKombatAddress {
		return new HamsterKombatAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::HMSTR),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::TON)
		);
	}

}
