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
class QtumAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['MNqvjH6dMS76vePHAsN2LRrpC7KiXDC7o6'],
			['MUtNi5o1bFuX8pjCaE5Ymc1rZonvqutSes'],
			['QWMA9xMhXhoG53jM38xP9LMNuhe9nrUDwv'],
			['MQLEJoC32atwpPkcrkh6Tq77KyNRKBM17s'],
			['qc1qus2je3aftfn950v97cjj0v5puysypk97lzfwk76hcaupaktjrucqv86uh3'],
			['QQ5mp7cS1nd6sdXCsBDfWPDbDKrLajyP9U'],
			['qc1qz3m6agu2fsa9p6475xqk777axceyl07mhvwtrv80349mxyckeluscfch2j'],
		];
	}

	public function providerInvalid() {
		return [
			['cosmos1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht3'],
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht7'],
			['1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht513513'],
			['erd1grsamgcrg0068n67c8tcf2tf40apvyllduahcswzq9d9wxdaz9tq02whp'],
			['erdgrsamgcrg0068n67c8tcf2tf40apvyllduahcswzq9d9wxdaz9tq02whp6'],
			['MNqvjH6dMS76vePHAsN2LRrpC7KiXDC7o7'],
			['QWMA9xMhXhoG53jM38xP9LMNuhe9nrUDwva'],
			['QWMA9xMhXhoG53jM38xP9LMNuhe9nrUDw'],
			['qc2qus2je3aftfn950v97cjj0v5puysypk97lzfwk76hcaupaktjrucqv86uh3'],
			['oc1qus2je3aftfn950v97cjj0v5puysypk97lzfwk76hcaupaktjrucqv86uh3'],
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
	 * @return QtumAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): QtumAddress {
		return new QtumAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::QTUM),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::QTUM)
		);
	}

}
