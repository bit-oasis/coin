<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTestUtils;
use UnitTest;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class IotaAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['iota1qqp7hq495gnqtarjx56ulwyfympwznfsrnr3eyy6sc4knrwf4x8ngmf8qca'],
			['iota1qpvxxa07dk6efvx2g0l4necmyq4wfd99ff6jkg06jf87t30twv30kwjxh76'],
			['iota1qrw93e6mpj8s4uxg5rxecs44uw07rc2r0awegvc9k9zdxk38rx9vs7wu9r9'],
			['iota1qqzhttptvju5ungrs35vk7l4lqejvuue2xfsr0le45jd68kvqpja6au22q5'],
			['iota1qrsdh8ekngwqa2yjp99xv5ca05h8mexqw7vkp892dcfgl7c8sf7j2qkwt0t'],
			['iota1qps6kgf2l2qquhqrshp8hy340s82fqc0uqlemxc0dp7rygg8mzskku5lu7l'],
			['iota1qqnhw4lx2fx8pl7m8lpm3zpehy37mckpwqeuyc3cc8aczwjxtzdlz0a2sw9'],
			['iota1qzg90wwndza0acghkyf5m2rll8jz2et6gffajtqfw532k25t6mtykerqv7l'],
		];
	}

	public function providerInvalid() {
		return [
			['cosmos1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht3'],
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht7'],
			['1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht513513'],
			['iota1grsamgcrg0068n67c8tcf2tf40apvyllduahcswzq9d9wxdaz9tq02whp'],
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
	 * @return IotaAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): IotaAddress {
		return new IotaAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::IOTA));
	}

}
