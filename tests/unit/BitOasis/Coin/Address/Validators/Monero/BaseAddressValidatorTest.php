<?php

namespace BitOasis\Coin\Address\Validators\Monero;

use UnitTest;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class BaseAddressValidatorTest extends UnitTest {

	public function providerValidate() {
		return [
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A', null, true],
			['453VWT5GEkXGc2J9asRpXpRkjoCGKCJr96rndm2VMe5yECiAcUB3h8pFxZ8YGbmbGmVefwWHPXmLR69Vw1sVNWz5TsFqYbK', null, true],
			['46qB9tcR1feVZ7xq42tx8V8sLbYdnFdGf6EndL1fCPRuUXroufYGzzCFtZwrjkthAc8C65xBpmWCYAR1KKBXykF76GADvYE', null, true],
			['47EwBbH25ppVVQpCFJ78ziaANxG4FLXgdh5BLaQuuCQbPhcN5mL3Fm7WbwaVe4vUMveKAzAiA4j8xgUi29TpKXpm3x362po', null, true],
			['46BeWrHpwXmHDpDEUmZBWZfoQpdc6HaERCNmx1pEYL2rAcuwufPN9rXHHtyUA4QVy66qeFQkn6sfK8aHYjA3jk3o1Bv16em', null, true],
			['4AxPt7hETP7FjSwRgVym6nhy2z8uFJB3U2q7HaZwBkB6g89eJbATWuLBBpnsCbtLToeS9sdJfAsRKAsZhW3k7iJWK6k5xwK', null, true],
			['47CL7FiNtW417VjzWt9Zse8Z8URhaHaA2L9jJq6rrLtDhiYK9PfbCavhhMKws9xEdKHBeGcQtJmPt4uEMivooNztC5UkHLD', null, true],
			['4AfUP827TeRZ1cck3tZThgZbRCEwBrpcJTkA1LCiyFVuMH4b5y59bKMZHGb9y58K3gSjWDCBsB4RkGsGDhsmMG5R2qmbLeW', null, true],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A', '', true],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', true],
			['453VWT5GEkXGc2J9asRpXpRkjoCGKCJr96rndm2VMe5yECiAcUB3h8pFxZ8YGbmbGmVefwWHPXmLR69Vw1sVNWz5TsFqYbK', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', true],
			['46qB9tcR1feVZ7xq42tx8V8sLbYdnFdGf6EndL1fCPRuUXroufYGzzCFtZwrjkthAc8C65xBpmWCYAR1KKBXykF76GADvYE', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', true],
			['47EwBbH25ppVVQpCFJ78ziaANxG4FLXgdh5BLaQuuCQbPhcN5mL3Fm7WbwaVe4vUMveKAzAiA4j8xgUi29TpKXpm3x362po', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', true],
			['46BeWrHpwXmHDpDEUmZBWZfoQpdc6HaERCNmx1pEYL2rAcuwufPN9rXHHtyUA4QVy66qeFQkn6sfK8aHYjA3jk3o1Bv16em', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', true],
			['4AxPt7hETP7FjSwRgVym6nhy2z8uFJB3U2q7HaZwBkB6g89eJbATWuLBBpnsCbtLToeS9sdJfAsRKAsZhW3k7iJWK6k5xwK', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', true],
			['47CL7FiNtW417VjzWt9Zse8Z8URhaHaA2L9jJq6rrLtDhiYK9PfbCavhhMKws9xEdKHBeGcQtJmPt4uEMivooNztC5UkHLD', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', true],
			['4AfUP827TeRZ1cck3tZThgZbRCEwBrpcJTkA1LCiyFVuMH4b5y59bKMZHGb9y58K3gSjWDCBsB4RkGsGDhsmMG5R2qmbLeW', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', true],
			['44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A', 'xff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', false],
			['453VWT5GEkXGc2J9asRpXpRkjoCGKCJr96rndm2VMe5yECiAcUB3h8pFxZ8YGbmbGmVefwWHPXmLR69Vw1sVNWz5TsFqYbK', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa548', false],
			['46qB9tcR1feVZ7xq42tx8V8sLbYdnFdGf6EndL1fCPRuUXroufYGzzCFtZwrjkthAc8C65xBpmWCYAR1KKBXykF76GADvYE', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa5486161', false],
			['46qB9tcR1feVZ7xq42tx8V8sLbYdnFdGf6EndL1fCPRuUXroufYGzzCFtZwrjkthAc8C65xBpmWCYAR1KKBXykF76GADvYE', '88ba7587c3a41a75', false],
			['46qB9tcR1feVZ7xq42tx8V8sLbYdnFdGf6EndL1fCPRuUXroufYGzzCFtZwrjkthAc8C65xBpmWCYAR1KKBXykF76GADvYE', 'x8ba7587c3a41a75', false],
			['46qB9tcR1feVZ7xq42tx8V8sLbYdnFdGf6EndL1fCPRuUXroufYGzzCFtZwrjkthAc8C65xBpmWCYAR1KKBXykF76GADvYE', '88ba7587c3a41a', false],
			['46qB9tcR1feVZ7xq42tx8V8sLbYdnFdGf6EndL1fCPRuUXroufYGzzCFtZwrjkthAc8C65xBpmWCYAR1KKBXykF76GADvYE', '88ba7587c3a41a7575', false],
			['4Gu184XsVma17VjzWt9Zse8Z8URhaHaA2L9jJq6rrLtDhiYK9PfbCavhhMKws9xEdKHBeGcQtJmPt4uEMivooNztHViznm8GhvREB6AU3C', null, false],
			['4LiMFV6cvNPEnw78i2hTtsdfFsAZakMfGMiwiMZrYygUc3dDXn9z4jSfCafKCtUwbSPCjudw4Uj7SdLReEpcCGWsNEz9zBNWbJmL4f6cUn', null, false],
			['4LiMFV6cvNPEnw78i2hTtsdfFsAZakMfGMiwiMZrYygUc3dDXn9z4jSfCafKCtUwbSPCjudw4Uj7SdLReEpcCGWsN6vBr8dc8VW3tkPGv6', null, false],
			['4LiMFV6cvNPEnw78i2hTtsdfFsAZakMfGMiwiMZrYygUc3dDXn9z4jSfCafKCtUwbSPCjudw4Uj7SdLReEpcCGWsNBVUL5n9ViE3SoLwsP', null, false],
			['4Gu184XsVma17VjzWt9Zse8Z8URhaHaA2L9jJq6rrLtDhiYK9PfbCavhhMKws9xEdKHBeGcQtJmPt4uEMivooNztHViznm8GhvREB6AU3C', '', false],
			['4Gu184XsVma17VjzWt9Zse8Z8URhaHaA2L9jJq6rrLtDhiYK9PfbCavhhMKws9xEdKHBeGcQtJmPt4uEMivooNztHViznm8GhvREB6AU3C', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', false],
			['4LiMFV6cvNPEnw78i2hTtsdfFsAZakMfGMiwiMZrYygUc3dDXn9z4jSfCafKCtUwbSPCjudw4Uj7SdLReEpcCGWsNEz9zBNWbJmL4f6cUn', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', false],
			['4LiMFV6cvNPEnw78i2hTtsdfFsAZakMfGMiwiMZrYygUc3dDXn9z4jSfCafKCtUwbSPCjudw4Uj7SdLReEpcCGWsN6vBr8dc8VW3tkPGv6', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', false],
			['4LiMFV6cvNPEnw78i2hTtsdfFsAZakMfGMiwiMZrYygUc3dDXn9z4jSfCafKCtUwbSPCjudw4Uj7SdLReEpcCGWsNBVUL5n9ViE3SoLwsP', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', false],
			['4Gu184XsVma17VjzWt9Zse8Z8URhaHaA2L9jJq6rrLtDhiYK9PfbCavhhMKws9xEdKHBeGcQtJmPt4uEMivooNztHViznm8GhvREB6AU3C', 'xff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', false],
			['4LiMFV6cvNPEnw78i2hTtsdfFsAZakMfGMiwiMZrYygUc3dDXn9z4jSfCafKCtUwbSPCjudw4Uj7SdLReEpcCGWsNEz9zBNWbJmL4f6cUn', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa548', false],
			['4LiMFV6cvNPEnw78i2hTtsdfFsAZakMfGMiwiMZrYygUc3dDXn9z4jSfCafKCtUwbSPCjudw4Uj7SdLReEpcCGWsN6vBr8dc8VW3tkPGv6', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa5486161', false],
			['54AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A', null, false],
			['453VWT5GEkXGc2J9asRpXpRkjoCGKCJr96rndm2VMe5yECiAcUB3h8pFxZ8YGbmbGmVefwWHPXmLR69Vw1sVNWz5TsFqYbA', null, false],
			['zcc7P9dbq71WTwXi148oXGSvZC6eo2ZkMi3s57qTGLzm9Bhzt3GNVo4AzNJHtEM2gSbyvsthDkmKHCWLvTJ6ysEnfpdANVa', null, false],
			['t3YJXRu6pC4er4gsQU7R3jVnAuj4zMQCRU1', null, false],
			['t1gRHW5AYgLsNwKRTLXGcXU2wWdP3C3bEtX', null, false],
			['54AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A', '', false],
			['54AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', false],
			['453VWT5GEkXGc2J9asRpXpRkjoCGKCJr96rndm2VMe5yECiAcUB3h8pFxZ8YGbmbGmVefwWHPXmLR69Vw1sVNWz5TsFqYbA', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', false],
			['zcc7P9dbq71WTwXi148oXGSvZC6eo2ZkMi3s57qTGLzm9Bhzt3GNVo4AzNJHtEM2gSbyvsthDkmKHCWLvTJ6ysEnfpdANVa', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', false],
			['t3YJXRu6pC4er4gsQU7R3jVnAuj4zMQCRU1', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', false],
			['t1gRHW5AYgLsNwKRTLXGcXU2wWdP3C3bEtX', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', false],
			['54AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A', 'xff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa54861', false],
			['453VWT5GEkXGc2J9asRpXpRkjoCGKCJr96rndm2VMe5yECiAcUB3h8pFxZ8YGbmbGmVefwWHPXmLR69Vw1sVNWz5TsFqYbA', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa548', false],
			['zcc7P9dbq71WTwXi148oXGSvZC6eo2ZkMi3s57qTGLzm9Bhzt3GNVo4AzNJHtEM2gSbyvsthDkmKHCWLvTJ6ysEnfpdANVa', '9ff44a34ee78a1f3cc43c4ca87b233d97f3885e59b5fb8879079c3b52fa5486161', false],
		];
	}

	/**
	 * @param string $address
	 * @param string|null $paymentId
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidate($address, $paymentId, $expectedValue) {
		$validator = new BaseAddressValidator($address, $paymentId);
		$this->assertEquals($validator->validate(), $expectedValue);
	}

	/**
	 * @param string $address
	 * @param string|null $paymentId
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidateWithException($address, $paymentId, $expectedValue) {
		if ($expectedValue === true) {
			$validator = new BaseAddressValidator($address, $paymentId);
			$validator->validateWithExceptions();
		}
	}

	/**
	 * @param string $address
	 * @param string|null $paymentId
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidateWithExceptionInvalidAddress($address, $paymentId, $expectedValue) {
		if ($expectedValue === false) {
			$validator = new BaseAddressValidator($address, $paymentId);
			$this->tester->expectThrowable(InvalidAddressException::class, function() use($validator) {
				$validator->validateWithExceptions();
			});
		}
	}

}
