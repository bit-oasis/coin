<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Address\Validators\BitcoinCash\BaseBitcoinCashAddressValidator;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;
use BitOasis\Coin\Exception\AddressMixedCaseException;
use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
abstract class BaseBitcoinCashAddressValidatorTest extends UnitTest {

	public function providerValidAddress() {
		return [
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bchtest:ppm2qsznhks23z7629mms6s4cwef74vcwvhanqgjxu', BaseBitcoinCashAddressValidator::PREFIX_TESTNET, true],
			['bchreg:pqzg22ty3m437frzk4y0gvvyqj02jpfv7udqugqkne', BaseBitcoinCashAddressValidator::PREFIX_REGTEST, true],
		];
	}

	/**
	 * @param string $address
	 * @param string $prefix
	 * @param bool $cashAddressAllowed
	 * @dataProvider providerValidAddress
	 */
	public function testValidate($address, $prefix, $cashAddressAllowed) {
		$validator = $this->createValidator($address, $prefix);
		$validator->setCashAddressAllowed($cashAddressAllowed);
		$this->assertTrue($validator->validate());
		$this->assertTrue($validator->validateWithExceptions());
	}

	public function providerInvalidAddressPrefix() {
		return [
			['bitcoincahs:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', BaseBitcoinCashAddressValidator::PREFIX_MAINNET],
			['bitcoincahs:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', BaseBitcoinCashAddressValidator::PREFIX_TESTNET],
			['bitcoincahs:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', BaseBitcoinCashAddressValidator::PREFIX_REGTEST],
			[':qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', BaseBitcoinCashAddressValidator::PREFIX_MAINNET],
			[':qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', BaseBitcoinCashAddressValidator::PREFIX_TESTNET],
			[':qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', BaseBitcoinCashAddressValidator::PREFIX_REGTEST],
			['bitcoincash:pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', BaseBitcoinCashAddressValidator::PREFIX_REGTEST],
			['bitcoincash:pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', BaseBitcoinCashAddressValidator::PREFIX_TESTNET],
			['bchtest:ppm2qsznhks23z7629mms6s4cwef74vcwvhanqgjxu', BaseBitcoinCashAddressValidator::PREFIX_MAINNET],
			['bchtest:ppm2qsznhks23z7629mms6s4cwef74vcwvhanqgjxu', BaseBitcoinCashAddressValidator::PREFIX_REGTEST],
			['bchreg:pqzg22ty3m437frzk4y0gvvyqj02jpfv7udqugqkne', BaseBitcoinCashAddressValidator::PREFIX_MAINNET],
			['bchreg:pqzg22ty3m437frzk4y0gvvyqj02jpfv7udqugqkne', BaseBitcoinCashAddressValidator::PREFIX_TESTNET],
		];
	}

	/**
	 * @param string $address
	 * @param string $prefix
	 * @dataProvider providerInvalidAddressPrefix
	 */
	public function testValidateInvalidAddressPrefix($address, $prefix) {
		$validator = $this->createValidator($address, $prefix);
		$this->assertFalse($validator->validate());
		
		$this->tester->expectThrowable(InvalidAddressPrefixException::class, function() use($validator) {
			$validator->validateWithExceptions();
		});
	}

	public function providerAddressMixedCase() {
		return [
			['Qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BaseBitcoinCashAddressValidator::PREFIX_MAINNET],
			['bitcoincash:Qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', BaseBitcoinCashAddressValidator::PREFIX_MAINNET],
			['bitcoincash:Qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', BaseBitcoinCashAddressValidator::PREFIX_MAINNET],
			['bitcoincash:Ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', BaseBitcoinCashAddressValidator::PREFIX_MAINNET],
			['bitcoincash:Pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', BaseBitcoinCashAddressValidator::PREFIX_MAINNET],
			['bitcoincash:Pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', BaseBitcoinCashAddressValidator::PREFIX_MAINNET],
			['bchtest:Ppm2qsznhks23z7629mms6s4cwef74vcwvhanqgjxu', BaseBitcoinCashAddressValidator::PREFIX_TESTNET],
			['bchreg:Pqzg22ty3m437frzk4y0gvvyqj02jpfv7udqugqkne', BaseBitcoinCashAddressValidator::PREFIX_REGTEST],
		];
	}

	/**
	 * @param string $address
	 * @param string $prefix
	 * @dataProvider providerAddressMixedCase
	 */
	public function testValidateAddressMixedCase($address, $prefix) {
		$validator = $this->createValidator($address, $prefix);
		$this->assertFalse($validator->validate());
		
		$this->tester->expectThrowable(AddressMixedCaseException::class, function() use($validator) {
			$validator->validateWithExceptions();
		});
	}

	public function providerInvalidAddress() {
		return [
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVgg', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVgg', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qpm2q:znhks23z7629mms6s4cwef74vcwvy22gdx6a', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', BaseBitcoinCashAddressValidator::PREFIX_TESTNET, true],
			['ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', BaseBitcoinCashAddressValidator::PREFIX_REGTEST, true],
			['bchtest:pp:qsznhks23z7629mms6s4cwef74vcwvhanqgjxu', BaseBitcoinCashAddressValidator::PREFIX_TESTNET, true],
			['bchreg:pq:22ty3m437frzk4y0gvvyqj02jpfv7udqugqkne', BaseBitcoinCashAddressValidator::PREFIX_REGTEST, true],
			['bitcoincashqpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6z', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qqyq78nf2w', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:a5a8yrhz', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qdpyysjzgfpyysjzgfpyysjzgfpyysjzgg8zlhfxky', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:yppyysjzgfpyysjzgfpyysjzgfpyysjzggc5ldue0t', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:lapyysjzgfpyysjzgfpyysjzgfpyysjzggp9pz6yrw', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bchtest:ppm2qsznhks23z7629mms6s4cwef74vcwvhanqgjxu', BaseBitcoinCashAddressValidator::PREFIX_TESTNET, false],
			['bchreg:pqzg22ty3m437frzk4y0gvvyqj02jpfv7udqugqkne', BaseBitcoinCashAddressValidator::PREFIX_REGTEST, false],
		];
	}

	/**
	 * @param string $address
	 * @param string $prefix
	 * @param bool $cashAddressAllowed
	 * @dataProvider providerInvalidAddress
	 */
	public function testValidateInvalidAddress($address, $prefix, $cashAddressAllowed) {
		$validator = $this->createValidator($address, $prefix);
		$validator->setCashAddressAllowed($cashAddressAllowed);
		$this->assertFalse($validator->validate());
		
		$this->tester->expectThrowable(InvalidAddressException::class, function() use($validator) {
			$validator->validateWithExceptions();
		});
	}

	public function providerIsBase58Address() {
		return [
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['1KXrWXciRDZUpQwQmuM1DbwsKDLYAYsVLR', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['16w1D5WRVKJuZUsSRzdLp9w3YGcgoxDXb', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', BaseBitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bchtest:ppm2qsznhks23z7629mms6s4cwef74vcwvhanqgjxu', BaseBitcoinCashAddressValidator::PREFIX_TESTNET, false],
			['bchreg:pqzg22ty3m437frzk4y0gvvyqj02jpfv7udqugqkne', BaseBitcoinCashAddressValidator::PREFIX_REGTEST, false],
		];
	}

	/**
	 * @param string $address
	 * @param string $prefix
	 * @param bool $expectedValue
	 * @dataProvider providerIsBase58Address
	 */
	public function testIsBase58Address($address, $prefix, $expectedValue) {
		$validator = $this->createValidator($address, $prefix);
		$this->assertEquals($validator->isBase58Address(), $expectedValue);
	}

	/**
	 * @param string $address
	 * @param string $prefix
	 * @param bool $expectedValue
	 * @dataProvider providerIsBase58Address
	 */
	public function testIsCashAddressAddress($address, $prefix, $expectedValue) {
		$validator = $this->createValidator($address, $prefix);
		$this->assertNotEquals($validator->isCashAddress(), $expectedValue);
	}

	/**
	 * @param string $address
	 * @param string $prefix
	 * @return BaseBitcoinCashAddressValidator
	 */
	abstract protected function createValidator($address, $prefix);

}
