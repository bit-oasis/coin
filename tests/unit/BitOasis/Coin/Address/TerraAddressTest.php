<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Network\CryptocurrencyNetwork;
use UnitTestUtils;
use UnitTest;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class TerraAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht5', 3140149957],
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht5', 4294967295],
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht5', 3513531646],
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht5', 3951464646],
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht5', 1035096894],
		];
	}

	public function providerInvalid() {
		return [
			['cosmos1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht3', 3140149957],
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht7', 4294967295],
			['1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht513513', 4294967295],
			['1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht5terra', 4294967295],
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht3', null],
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht3', 'some-stupid-memo'],
		];
	}

	public function providerDeserialize() {
		return [
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht5#3140149957', 'terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht5', '3140149957'],
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht5#4294967295', 'terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht5', '4294967295'],
		];
	}

	/**
	 * @param string $serializedAddress
	 * @param string $expectedAddress
	 * @param string|null $expectedMemo
	 * @throws InvalidAddressException
	 * @dataProvider providerDeserialize
	 */
	public function testDeserialize($serializedAddress, string $expectedAddress, $expectedMemo) {
		$terra = TerraAddress::deserialize(
			$serializedAddress,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::LUNA),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::TERRA)
		);
		$this->assertEquals($expectedAddress, $terra->getAddress());
		$this->assertEquals($expectedMemo, $terra->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @param string|null $tag
	 * @dataProvider providerInvalid
	 */
	public function testInvalidAddress(string $address, $tag) {
		$this->tester->expectThrowable(InvalidAddressException::class, function() use ($address, $tag) {
			$this->createAddress($address, $tag);
		});
	}

	/**
	 * @param string $address
	 * @param $tag
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address, $tag) {
		$terraAddress = $this->createAddress($address, $tag);
		$this->assertTrue($terraAddress->supportsAdditionalId());
		$this->assertNotNull($terraAddress->getAdditionalIdName());
		$this->assertEquals($tag, $terraAddress->getAdditionalId());
		$this->assertEquals($terraAddress->getTag(), $terraAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @param string|null $tag
	 * @return TerraAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address, $tag = null): TerraAddress {
		return new TerraAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::LUNA),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::TERRA),
			$tag
		);
	}

}
