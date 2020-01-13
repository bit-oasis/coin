<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use UnitTestUtils;
use UnitTest;

/**
 * @author Stanislav Fukala <stanislav.fukala@gmail.com>
 */
class AlgorandAddressTest extends UnitTest {

	public function providerInvalidAddress() {
		return [
			['IB3NJALXLDX5JLYCD4TMTMLVCKDRZNS4JONMMIWD6XM7DSKYR7MWHI6I7U'],
		];
	}

	public function providerValidate() {
		return [
			['IB3NJALXLDX5JLYCD4TMTMLVCKDRZNS4JONHMIWD6XM7DSKYR7MWHI6I7U'],
			['7ZUECA7HFLZTXENRV24SHLU4AVPUTMTTDUFUBNBD64C73F3UHRTHAIOF6Q'],
			['IDUTJEUIEVSMXTU4LGTJWZ2UE2E6TIODUKU6UW3FU3UKIQQ77RLUBBBFLA'],
			['DN7MBMCL5JQ3PFUQS7TMX5AH4EEKOBJVDUF4TCV6WERATKFLQF4MQUPZTA'],
			['BFRTECKTOOE7A5LHCF3TTEOH2A7BW46IYT2SX5VP6ANKEXHZYJY77SJTVM'],
			['47YPQTIGQEO7T4Y4RWDYWEKV6RTR2UNBQXBABEEGM72ESWDQNCQ52OPASU'],
			['BH55E5RMBD4GYWXGX5W5PJ5JAHPGM5OXKDQH5DC4O2MGI7NW4H6VOE4CP4'],
		];
	}

	/**
	 * @param string $address
	 * @dataProvider providerInvalidAddress
	 */
	public function testInvalidAddress($address) {
		$this->tester->expectException(InvalidAddressException::class, function() use ($address) {
			$this->createAddress($address);
		});
	}

	/**
	 * @param string $address
	 * @dataProvider providerValidate
	 */
	public function testAdditionalId($address) {
		$omiseGoAddress = $this->createAddress($address);
		$this->assertFalse($omiseGoAddress->supportsAdditionalId());
		$this->assertNull($omiseGoAddress->getAdditionalIdName());
		$this->assertNull($omiseGoAddress->getAdditionalId());
	}

	/**
	 * @param string $address
	 * @return AlgorandAddress
	 * @throws InvalidAddressException
	 */
	protected function createAddress($address) {
		return new AlgorandAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::ALG));
	}

}
