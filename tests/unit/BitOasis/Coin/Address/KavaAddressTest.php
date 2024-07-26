<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\KavaAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class KavaAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121g'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A'],
			['kava1ueak7nzesm3pnev6lngp6lgk0ry02djz8pjpcgt'],
			['kava1k760ypy9tzhp6l2rmg06sq4n74z0d3relc549'],
			['kav1a13twqygswyzupqfggfgh9dmtgthgucn5wpfksh'],
		];
	}

	public function providerValidate(): array {
		return [
			['kava1ueak7nzesm3pnev6lngp6lgk0ry02djz8pjpcg'],
			['kava1k760ypy9tzhp6l2rmg06sq4n74z0d3relc549c'],
			['kava13tpwqygswyzupqfggfgh9dmtgthgucn5wpfksh'],
			['0x259308E7d8557e4Ba192De1aB8Cf7e0E21896442'],
			['0xB6c6a51D908f43044Eacd29B4DB51aBd720A9790'],
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
	protected function createAddress(string $address): KavaAddress {
		return new KavaAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::KAVA),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::KAVA)
		);
	}
}