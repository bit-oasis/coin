<?php

namespace unit\BitOasis\Coin\Address;

use BitOasis\Coin\Address\XdcNetworkAddress;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTest;
use UnitTestUtils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class XdcNetworkAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			// Invalid: ERC20 addresses
			['0x6c3e4cb2e96bO1f4b866965a91ed4437839a121a'],
			['0x6c3e4cb2e96b01f4b866965a91ed4437839a121g'],
			// Invalid: New XDC addresses format
			['rxdceCF4ea7907e779b8A7D0F90CB95Fe06F43b610FB'],
			['1xdc39b8467a9fC59F94F802174dcB523cB79C93bd4a'],
			['xde39b8467a9fC59F94F802174dcB523cB79C93bd4a'],
		];
	}

	public function providerValidate() {
		return [
			['xdceCF4ea7907e779b8A7D0F90CB95Fe06F43b610FB'],
			['xdc4076f8B2A06515a1899d951A339B260b9673569D'],
			['0xEA674fdDe714fd879de3EdF0F56AA9516B898ec8'],
			['0xac03bb73b6a9e108530aff4ef5077c2b3d481e5a'],
			['xdc39b8467a9fC59F94F802174dcB523cB79C93bd4a'],
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
	 * @return XdcNetworkAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new XdcNetworkAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::XDC),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::XDC_NETWORK)
		);
	}
}