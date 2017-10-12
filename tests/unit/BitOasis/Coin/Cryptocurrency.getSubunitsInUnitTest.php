<?php

namespace BitOasis\Coin;

use UnitTest;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CryptocurrencyGetSubunitsInUnitTest extends UnitTest {

	public function providerGetSubunitsInUnit() {
	    return [
	    	[new Cryptocurrency('NVM', 0, ''), '1'],
	    	[new Cryptocurrency('BTC', 8, ''), '100000000'],
	    	[new Cryptocurrency('ETH', 18, ''), '1000000000000000000'],
	    	[new Cryptocurrency('XRP', 6, ''), '1000000'],
	    ];
	}

	/**
	 * @param Cryptocurrency $cryptocurrency
	 * @param string $subunitsInUnit
	 * @dataProvider providerGetSubunitsInUnit
	 */
	public function testGetSubunitsInUnit(Cryptocurrency $cryptocurrency, $subunitsInUnit) {
	    $this->assertEquals($subunitsInUnit, $cryptocurrency->getSubunitsInUnit());
	}

}