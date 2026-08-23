<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\HyperEvmAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author tariq.tawalbeh <tariq.tawalbeh@bitoasis.net>
 */
class HyperEvmAddressTest extends UnitTest {

	public function providerInvalidAddress(): array {
		return [
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121g'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121'],
			['tz1fhW886WYc5PQuGu7M3TRjwVTjrtQnKoqM'],
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx'],
		];
	}

	public function providerValidate(): array {
		return [
			['0x7A250d5630B4cF539739dF2C5dAcb4c659F2488D'],
			['0xdAC17F958D2ee523a2206206994597C13D831ec7'],
			['0x1f9840a85d5aF5bf1D1762F925BDADdC4201F984'],
			['0x2260FAC5E5542a773Aa44fBCfeDf7C193bc2C599'],
			['0x6B175474E89094C44Da98b954EedeAC495271d0F'],
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
	protected function createAddress(string $address): HyperEvmAddress {
		return new HyperEvmAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::HYPE),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::HYPER_EVM)
		);
	}

}