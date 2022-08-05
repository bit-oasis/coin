<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;
use UnitTestUtils;
use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class MoneroAddressTest extends UnitTest {

	public function providerValidate() {
		return [
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A', null],
			['453VWT5GEkXGc2J9asRpXpRkjoCGKCJr96rndm2VMe5yECiAcUB3h8pFxZ8YGbmbGmVefwWHPXmLR69Vw1sVNWz5TsFqYbK', null],
			['46qB9tcR1feVZ7xq42tx8V8sLbYdnFdGf6EndL1fCPRuUXroufYGzzCFtZwrjkthAc8C65xBpmWCYAR1KKBXykF76GADvYE', null],
			['47EwBbH25ppVVQpCFJ78ziaANxG4FLXgdh5BLaQuuCQbPhcN5mL3Fm7WbwaVe4vUMveKAzAiA4j8xgUi29TpKXpm3x362po', null],
			['46BeWrHpwXmHDpDEUmZBWZfoQpdc6HaERCNmx1pEYL2rAcuwufPN9rXHHtyUA4QVy66qeFQkn6sfK8aHYjA3jk3o1Bv16em', null],
			['4AxPt7hETP7FjSwRgVym6nhy2z8uFJB3U2q7HaZwBkB6g89eJbATWuLBBpnsCbtLToeS9sdJfAsRKAsZhW3k7iJWK6k5xwK', null],
			['47CL7FiNtW417VjzWt9Zse8Z8URhaHaA2L9jJq6rrLtDhiYK9PfbCavhhMKws9xEdKHBeGcQtJmPt4uEMivooNztC5UkHLD', null],
			['4AfUP827TeRZ1cck3tZThgZbRCEwBrpcJTkA1LCiyFVuMH4b5y59bKMZHGb9y58K3gSjWDCBsB4RkGsGDhsmMG5R2qmbLeW', null],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A', ''],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861'],
			['453VWT5GEkXGc2J9asRpXpRkjoCGKCJr96rndm2VMe5yECiAcUB3h8pFxZ8YGbmbGmVefwWHPXmLR69Vw1sVNWz5TsFqYbK', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861'],
			['46qB9tcR1feVZ7xq42tx8V8sLbYdnFdGf6EndL1fCPRuUXroufYGzzCFtZwrjkthAc8C65xBpmWCYAR1KKBXykF76GADvYE', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861'],
			['47EwBbH25ppVVQpCFJ78ziaANxG4FLXgdh5BLaQuuCQbPhcN5mL3Fm7WbwaVe4vUMveKAzAiA4j8xgUi29TpKXpm3x362po', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861'],
			['46BeWrHpwXmHDpDEUmZBWZfoQpdc6HaERCNmx1pEYL2rAcuwufPN9rXHHtyUA4QVy66qeFQkn6sfK8aHYjA3jk3o1Bv16em', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861'],
			['4AxPt7hETP7FjSwRgVym6nhy2z8uFJB3U2q7HaZwBkB6g89eJbATWuLBBpnsCbtLToeS9sdJfAsRKAsZhW3k7iJWK6k5xwK', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861'],
			['47CL7FiNtW417VjzWt9Zse8Z8URhaHaA2L9jJq6rrLtDhiYK9PfbCavhhMKws9xEdKHBeGcQtJmPt4uEMivooNztC5UkHLD', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861'],
			['4AfUP827TeRZ1cck3tZThgZbRCEwBrpcJTkA1LCiyFVuMH4b5y59bKMZHGb9y58K3gSjWDCBsB4RkGsGDhsmMG5R2qmbLeW', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861'],
			['4Gu184XsVma17VjzWt9Zse8Z8URhaHaA2L9jJq6rrLtDhiYK9PfbCavhhMKws9xEdKHBeGcQtJmPt4uEMivooNztHViznm8GhvREB6AU3C', null],
			['4LiMFV6cvNPEnw78i2hTtsdfFsAZakMfGMiwiMZrYygUc3dDXn9z4jSfCafKCtUwbSPCjudw4Uj7SdLReEpcCGWsNEz9zBNWbJmL4f6cUn', null],
			['4LiMFV6cvNPEnw78i2hTtsdfFsAZakMfGMiwiMZrYygUc3dDXn9z4jSfCafKCtUwbSPCjudw4Uj7SdLReEpcCGWsN6vBr8dc8VW3tkPGv6', null],
			['4LiMFV6cvNPEnw78i2hTtsdfFsAZakMfGMiwiMZrYygUc3dDXn9z4jSfCafKCtUwbSPCjudw4Uj7SdLReEpcCGWsNBVUL5n9ViE3SoLwsP', null],
			['4Gu184XsVma17VjzWt9Zse8Z8URhaHaA2L9jJq6rrLtDhiYK9PfbCavhhMKws9xEdKHBeGcQtJmPt4uEMivooNztHViznm8GhvREB6AU3C', ''],
		];
	}

	/**
	 * @param string $address
	 * @param string|null $paymentId
	 * @throws InvalidAddressException
	 * @dataProvider providerValidate
	 */
	public function testValidate($address, $paymentId) {
		$moneroAddress = new MoneroAddress($address, UnitTestUtils::getCryptocurrency(Cryptocurrency::XMR), UnitTestUtils::getCryptocurrencyNetwork(CryptocurrencyNetwork::MONERO), $paymentId);
		$this->assertTrue($moneroAddress->supportsAdditionalId());
		$this->assertNotNull($moneroAddress->getAdditionalIdName());
		$this->assertEquals($paymentId, $moneroAddress->getAdditionalId());
		$this->assertEquals($moneroAddress->getPaymentId(), $moneroAddress->getAdditionalId());
	}

}
