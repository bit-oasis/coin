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
class CosmosAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['cosmos15v50ymp6n5dn73erkqtmq0u8adpl8d3ujv2e74', 3140149957],
			['cosmos15v50ymp6n5dn73erkqtmq0u8adpl8d3ujv2e74', 4294967295],
			['cosmos15v50ymp6n5dn73erkqtmq0u8adpl8d3ujv2e74', 3513531646],
			['cosmos15v50ymp6n5dn73erkqtmq0u8adpl8d3ujv2e74', 3951464646],
			['cosmos15v50ymp6n5dn73erkqtmq0u8adpl8d3ujv2e74', 1035096894],
		];
	}

	public function providerInvalid() {
		return [
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht3', 3140149957],
			['cosmos1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht7', 4294967295],
			['1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht513513', 4294967295],
			['1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht5cosmos', 4294967295],
			['cosmos1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht3', null],
			['cosmos1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht3', 'some-stupid-memo'],
		];
	}

	public function providerDeserialize() {
		return [
			['cosmos15v50ymp6n5dn73erkqtmq0u8adpl8d3ujv2e74#3140149957', 'cosmos15v50ymp6n5dn73erkqtmq0u8adpl8d3ujv2e74', '3140149957'],
			['cosmos15v50ymp6n5dn73erkqtmq0u8adpl8d3ujv2e74#4294967295', 'cosmos15v50ymp6n5dn73erkqtmq0u8adpl8d3ujv2e74', '4294967295'],
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
		$cosmosAddress = CosmosAddress::deserialize(
			$serializedAddress,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::ATOM),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::TERRA)
		);
		$this->assertEquals($expectedAddress, $cosmosAddress->getAddress());
		$this->assertEquals($expectedMemo, $cosmosAddress->getAdditionalId());
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
	 * @return CosmosAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address, $tag = null): CosmosAddress {
		return new CosmosAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::ATOM),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::COSMOS),
			$tag
		);
	}

}
