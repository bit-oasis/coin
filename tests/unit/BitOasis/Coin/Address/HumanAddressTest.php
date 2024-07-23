<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\HumanAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class HumanAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
		];
	}

	public function providerValidate(): array {
		return [
			['0x54634Ff25F49791a385E601659Bbf62007CE4dfa'],
			['0x0e18BDd657cEf68F333e70c190E36F3b1397422d'],
			['0xD1669Ac6044269b59Fa12c5822439F609Ca54F41'],
			['0x89F2ab029DcD11bD5A00Ed6A77ccBE46315212e8'],
			['0x1ceF61dFb750D7C75Ea2f0Ac1e6D1a5FF0935Cb9'],
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
	public function testAdditionalId(string $address): void {
		$createdAddress = $this->createAddress($address);
		$this->assertFalse($createdAddress->supportsAdditionalId());
		$this->assertNull($createdAddress->getAdditionalIdName());
		$this->assertNull($createdAddress->getAdditionalId());
	}

	/**
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): HumanAddress {
		return new HumanAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::HMT),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM)
		);
	}
}