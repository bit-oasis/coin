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
class FilecoinAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['f0150'],
			['f01024'],
			['f01729'],
			['f018446744073709551615'],
			['f17uoq6tp427uzv7fztkbsnn64iwotfrristwpryy'],
			['f1xcbgdhkgkwht3hrrnui3jdopeejsoatkzmoltqy'],
			['f1xtwapqc6nh4si2hcwpr3656iotzmlwumogqbuaa'],
			['f1wbxhu3ypkuo6eyp6hjx6davuelxaxrvwb2kuwva'],
			['f12fiakbhe2gwd5cnmrenekasyn6v5tnaxaqizq6a'],
			['f24vg6ut43yw2h2jqydgbg2xq7x6f4kub3bg6as6i'],
			['f25nml2cfbljvn4goqtclhifepvfnicv6g7mfmmvq'],
			['f2nuqrg7vuysaue2pistjjnt3fadsdzvyuatqtfei'],
			['f24dd4ox4c2vpf5vk5wkadgyyn6qtuvgcpxxon64a'],
			['f3vvmn62lofvhjd2ugzca6sof2j2ubwok6cj4xxbfzz4yuxfkgobpihhd2thlanmsh3w2ptld2gqkn2jvlss4a'],
			['f3wmuu6crofhqmm3v4enos73okk2l366ck6yc4owxwbdtkmpk42ohkqxfitcpa57pjdcftql4tojda2poeruwa'],
			['f3s2q2hzhkpiknjgmf4zq3ejab2rh62qbndueslmsdzervrhapxr7dftie4kpnpdiv2n6tvkr743ndhrsw6d3a'],
			['f3q22fijmmlckhl56rn5nkyamkph3mcfu5ed6dheq53c244hfmnq2i7efdma3cj5voxenwiummf2ajlsbxc65a'],
		];
	}

	public function providerInvalid() {
		return [
			['cosmos1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht3'],
			['terra1ncjg4a59x2pgvqy9qjyqprlj8lrwshm0wleht7'],
			['erd1grsamgcrg0068n67c8tcf2tf40apvyllduahcswzq9d9wxdaz9tq02whp'],
			['erdgrsamgcrg0068n67c8tcf2tf40apvyllduahcswzq9d9wxdaz9tq02whp6'],
			['f03535b2'],
			['d0150'],
			['d17uoq6tp427uzv7fztkbsnn64iwotfrristwpryy'],
			['f1xtwapqc6nh4si2hcwpr3653iotzmlwumogqbuaa'],
			['f1xtwapqc6nh4si2hcwpr3653iotzmlwumogqbabc'],
			['f1xtwapqc6nh4si2hcwpr3653iotzmlwumogqbabcas'],
			['f1xtwapqc6nh4si2hcwpr3653iotzmlwumogqba'],
			['f3vvmn62lofvhjd2ugzca6sof2j2ubwok6cj4xxbfzz4yuxfkgobpihhd2thlanmsh3w2ptld2gqkn2jvlss'],
			['f3vvmn62lofvhjd2ugzca6sof2j2ubwok6cj4xxbfzz4yuxfkgobpihhd2thlanmsh3w2ptld2gqkn2jvlssasfg'],
			['f3vvmn62lofvhjd2ugzca6sof2j2ubwok6cj4xxbfzz4yuxfkgobpihhd2thlanmsh3w2ptld2gqkn2jvlssb2'],
			['d3vvmn62lofvhjd2ugzca6sof2j2ubwok6cj4xxbfzz4yuxfkgobpihhd2thlanmsh3w2ptld2gqkn2jvlss4a'],
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
	 * @return FilecoinAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress(string $address): FilecoinAddress {
		return new FilecoinAddress(
			$address,
			UnitTestUtils::getCryptocurrency(Cryptocurrency::FIL),
			UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::FILECOIN)
		);
	}

}
