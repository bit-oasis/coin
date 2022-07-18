<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;
use BitOasis\Coin\CryptocurrencyNetwork;
use UnitTestUtils;
use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class LitecoinAddressTest extends UnitTest {

	public function providerToNewAddressFormat() {
		return [
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx', 'MFWg1wVLhorAwDEtCTGtjHvCBvQZpEv6dm'],
			['3A2rCJHyoMuYnowLHkvuvMgU7WLSRwZKL9', 'MGEzWBhwkUkybKDEPdvFjzvsSCvtSubGwa'],
			['37qvZetB6pbbZYTdWV6hYn4MX3P5E6UjUh', 'ME44sYJ93wT2N3jXcN63NRJkqjyXFwtvj9'],
			['3KwSLET9P3WZNKAjXRTKQYo7w4tZ8qEUaC', 'MS9ae7s7LAMzApSddJSfEC3XFmV17kMZjY'],
			['LP8A3cjNAXsMBQvy9s4ptavo7owhS2XPr1', 'LP8A3cjNAXsMBQvy9s4ptavo7owhS2XPr1'],
			['Lciocvp1PvQyMH9Srmxn7dSC94Gk2YtCLm', 'Lciocvp1PvQyMH9Srmxn7dSC94Gk2YtCLm'],
		];
	}

	public function providerOldFormatAddress() {
		return [
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx', 'MFWg1wVLhorAwDEtCTGtjHvCBvQZpEv6dm'],
			['3A2rCJHyoMuYnowLHkvuvMgU7WLSRwZKL9', 'MGEzWBhwkUkybKDEPdvFjzvsSCvtSubGwa'],
			['37qvZetB6pbbZYTdWV6hYn4MX3P5E6UjUh', 'ME44sYJ93wT2N3jXcN63NRJkqjyXFwtvj9'],
			['3KwSLET9P3WZNKAjXRTKQYo7w4tZ8qEUaC', 'MS9ae7s7LAMzApSddJSfEC3XFmV17kMZjY'],
			['3KwSLET9P3WZNKAjXRTKQYo7w4tZ8qEUaC', '3KwSLET9P3WZNKAjXRTKQYo7w4tZ8qEUaC'],
			[null, 'LP8A3cjNAXsMBQvy9s4ptavo7owhS2XPr1'],
			[null, 'Lciocvp1PvQyMH9Srmxn7dSC94Gk2YtCLm'],
		];
	}

	public function providerNewFormatAddress() {
		return [
			['39JXi45Nkgzk8hxz6aHYuefnsDp7qnf4fx', 'MFWg1wVLhorAwDEtCTGtjHvCBvQZpEv6dm'],
			['3A2rCJHyoMuYnowLHkvuvMgU7WLSRwZKL9', 'MGEzWBhwkUkybKDEPdvFjzvsSCvtSubGwa'],
			['37qvZetB6pbbZYTdWV6hYn4MX3P5E6UjUh', 'ME44sYJ93wT2N3jXcN63NRJkqjyXFwtvj9'],
			['3KwSLET9P3WZNKAjXRTKQYo7w4tZ8qEUaC', 'MS9ae7s7LAMzApSddJSfEC3XFmV17kMZjY'],
			['MS9ae7s7LAMzApSddJSfEC3XFmV17kMZjY', 'MS9ae7s7LAMzApSddJSfEC3XFmV17kMZjY'],
			['Lciocvp1PvQyMH9Srmxn7dSC94Gk2YtCLm', 'Lciocvp1PvQyMH9Srmxn7dSC94Gk2YtCLm'],
		];
	}

	/**
	 * @param string $legacyFormat
	 * @param string $expectedFormat
	 * @throws InvalidAddressException
	 * @throws InvalidAddressPrefixException
	 * @dataProvider providerToNewAddressFormat
	 */
	public function testToNewAddressFormat($legacyFormat, $expectedFormat) {
		$address = new LitecoinAddress($legacyFormat, self::getCurrency(), self::getNetwork());
		$this->assertEquals($address->toNewAddressFormat()->toString(), $expectedFormat);
	}

	/**
	 * @param string $expectedFormat
	 * @param string $newFormat
	 * @throws InvalidAddressException
	 * @throws InvalidAddressPrefixException
	 * @dataProvider providerToNewAddressFormat
	 */
	public function testToLegacyAddressFormat($expectedFormat, $newFormat) {
		$address = new LitecoinAddress($newFormat, self::getCurrency(), self::getNetwork());
		$this->assertEquals($address->toLegacyAddressFormat()->toString(), $expectedFormat);
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 * @dataProvider providerToNewAddressFormat
	 */
	public function testAdditionalId($address) {
		$litecoinAddress = new LitecoinAddress($address, self::getCurrency(), self::getNetwork());
		$this->assertFalse($litecoinAddress->supportsAdditionalId());
		$this->assertNull($litecoinAddress->getAdditionalIdName());
		$this->assertNull($litecoinAddress->getAdditionalId());
	}

	/**
	 * @param string $oldFormat
	 * @param string $newFormat
	 * @throws InvalidAddressException
	 * @dataProvider providerOldFormatAddress
	 */
	public function testOldFormatAddress($oldFormat, $newFormat) {
		$litecoinAddress = new LitecoinAddress($newFormat, self::getCurrency(), self::getNetwork());
		$oldFormatAddress = $litecoinAddress->getOldFormatAddress();
		$this->assertEquals($oldFormatAddress, $oldFormat);
	}

	/**
	 * @param string $oldFormat
	 * @param string $newFormat
	 * @throws InvalidAddressException
	 * @dataProvider providerNewFormatAddress
	 */
	public function testNewFormatAddress($oldFormat, $newFormat) {
		$litecoinAddress = new LitecoinAddress($oldFormat, self::getCurrency(), self::getNetwork());
		$newFormatAddress = $litecoinAddress->getNewFormatAddress();
		$this->assertEquals($newFormatAddress, $newFormat);
	}

	/**
	 * @return Cryptocurrency
	 */
	protected static function getCurrency() {
		return UnitTestUtils::getCryptocurrency(Cryptocurrency::LTC);
	}

	/**
	 * @return CryptocurrencyNetwork
	 */
	protected static function getNetwork() {
		return UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::LITECOIN);
	}

}
