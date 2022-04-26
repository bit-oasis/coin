<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTestUtils;
use UnitTest;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class ElrondEgoldAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['erd1grsamgcrg0068n67c8tcf2tf40apvyllduahcswzq9d9wxdaz9tq02whp6'],
			['erd1wtm3yl58vcnj089lqy3tatkdpwklffh4pjnf27zwsa2znjyk355sutafqh'],
			['erd1ff377y7qdldtsahvt28ec45zkyu0pepuup33adhr8wr2yuelwv7qpevs9e'],
			['erd1rm8pg3yrngzyhrjejkz3xq2lfp64mvnt64llj3fyft53d3t4ckjq0q8v4k'],
			['erd1qr9av6ar4ymr05xj93jzdxyezdrp6r4hz6u0scz4dtzvv7kmlldse7zktc'],
		];
	}

	public function providerInvalid() {
		return [
			['cosmos1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht3'],
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht7'],
			['1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht513513'],
			['erd1grsamgcrg0068n67c8tcf2tf40apvyllduahcswzq9d9wxdaz9tq02whp'],
			['erdgrsamgcrg0068n67c8tcf2tf40apvyllduahcswzq9d9wxdaz9tq02whp6'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalid
	 */
	public function testInvalidAddress(string $address) {
		$this->tester->expectThrowable(InvalidAddressException::class, function() use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address) {
		$address = $this->createAddress($address);
		$this->assertFalse($address->supportsAdditionalId());
		$this->assertNull($address->getAdditionalIdName());
		$this->assertNull($address->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return ElrondEgoldAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): ElrondEgoldAddress {
		return new ElrondEgoldAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::EGLD));
	}

}
