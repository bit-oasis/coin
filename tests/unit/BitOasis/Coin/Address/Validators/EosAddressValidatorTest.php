<?php

namespace BitOasis\Coin\Address\Validators;

use UnitTest;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class EosAddressValidatorTest extends UnitTest {

	public function providerValidate() {
		return [
		/** address ok / memo fail */
			['sicborobot12', "\xc3 this has \xe6\x9d some invalid utf8 \xe6", false],
			['sicborobot12', 'www.okbet.im,全网最高分红，锁仓收益245%!挖矿收益高达20%!The highest dividend in the whole network, the lockout income is 245%! The mining income is as high as 20%!www.okbet.imwww.okbet.im,全网最高分红，锁仓收益245%!挖矿收益高达20%!The highest dividend in the whole network, the lockout income is 245%! The mining income is as high as 20%!www.okbet.im', false],
		/** address ok / memo ok */
			['sicborobot12', 'www.okbet.im,全网最高分红，锁仓收益245%!挖矿收益高达20%!The highest dividend in the whole network, the lockout income is 245%! The mining income is as high as 20%!www.okbet.im', true],
			['batbaccarat1', '279786', true],
			['sicborobot14', 'producer vote pay', true],
			['asdqweasdqwe', '区块链 Hash 值开奖平台 EOSPlay 新游戏老虎机上线! 另有乐透,骰子等着您赢得奖池回报!!! https://eosplay.com/?d6867ae3', true],
			['john.doe....', 'Win 100,000 ZOS + 10 EOS!!! (1) Send 1 ZOS to zosresponses (2) Write a catchy slogan in the memo field (3) Checkout https://medium.com/@airdropsdac/zos-airdrop-claim-your-tokens-and-enter-to-win-100-000-zos-16e8713d55d7 for more info!', true],
			['john.doe1234', '', true],
			['eoshuobipool', '', true],
		/** address fail / memo ok */
			['sicborobot12a', 'www.okbet.im,全网最高分红，锁仓收益245%!挖矿收益高达20%!The highest dividend in the whole network, the lockout income is 245%! The mining income is as high as 20%!www.okbet.im', false],
			['batbaccarat1.', '279786', false],
			['sicborobot146', 'producer vote pay', false],
			['asdqweasdqw', '区块链 Hash 值开奖平台 EOSPlay 新游戏老虎机上线! 另有乐透,骰子等着您赢得奖池回报!!! https://eosplay.com/?d6867ae3', false],
			['john.doe...', 'Win 100,000 ZOS + 10 EOS!!! (1) Send 1 ZOS to zosresponses (2) Write a catchy slogan in the memo field (3) Checkout https://medium.com/@airdropsdac/zos-airdrop-claim-your-tokens-and-enter-to-win-100-000-zos-16e8713d55d7 for more info!', false],
			['john.doe123', '', false],
			['eoshuobipoo', '', false]
		];
	}

	/**
	 * @param string $address
	 * @param $memo
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidate($address, $memo, $expectedValue) {
		$validator = new EosAddressValidator($address, $memo);
		$this->assertEquals($expectedValue, $validator->validate());
	}

	/**
	 * @param string $address
	 * @param $memo
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidateWithExceptions($address, $memo, $expectedValue) {
		if ($expectedValue === true) {
			$validator = new EosAddressValidator($address, $memo);
			$this->assertEquals($expectedValue, $validator->validateWithExceptions());
		}
	}

	/**
	 * @param string $address
	 * @param $memo
	 * @param bool $expectedValue
	 * @dataProvider providerValidate
	 */
	public function testValidateWithExceptionsInvalidAddress($address, $memo, $expectedValue) {
		if ($expectedValue === false) {
			$validator = new StellarAddressValidator($address, $memo);
			$this->tester->expectException(InvalidAddressException::class, function() use($validator) {
				$validator->validateWithExceptions();
			});
		}
	}

}
