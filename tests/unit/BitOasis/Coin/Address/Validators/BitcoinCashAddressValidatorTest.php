<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;
use BitOasis\Coin\Exception\AddressMixedCaseException;
use UnitTest;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class BitcoinCashAddressValidatorTest extends UnitTest {

	public function providerValidAddress() {
		return [
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu', BitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVggu', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bchtest:ppm2qsznhks23z7629mms6s4cwef74vcwvhanqgjxu', BitcoinCashAddressValidator::PREFIX_TESTNET, true],
			['bchreg:pqzg22ty3m437frzk4y0gvvyqj02jpfv7udqugqkne', BitcoinCashAddressValidator::PREFIX_REGTEST, true],
		];
	}

	/**
	 * @param string $address
	 * @param string $prefix
	 * @param bool $cashAddressAllowed
	 * @dataProvider providerValidAddress
	 */
	public function testValidate($address, $prefix, $cashAddressAllowed) {
		$validator = new BitcoinCashAddressValidator($address, $prefix);
		$validator->setCashAddressAllowed($cashAddressAllowed);
		$this->assertTrue($validator->validate());
		$this->assertTrue($validator->validateWithExceptions());
	}

	public function providerInvalidAddressPrefix() {
		return [
			['bitcoincahs:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', BitcoinCashAddressValidator::PREFIX_MAINNET],
			['bitcoincahs:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', BitcoinCashAddressValidator::PREFIX_TESTNET],
			['bitcoincahs:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', BitcoinCashAddressValidator::PREFIX_REGTEST],
			[':qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', BitcoinCashAddressValidator::PREFIX_MAINNET],
			[':qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', BitcoinCashAddressValidator::PREFIX_TESTNET],
			[':qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', BitcoinCashAddressValidator::PREFIX_REGTEST],
			['bitcoincash:pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', BitcoinCashAddressValidator::PREFIX_REGTEST],
			['bitcoincash:pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', BitcoinCashAddressValidator::PREFIX_TESTNET],
			['bchtest:ppm2qsznhks23z7629mms6s4cwef74vcwvhanqgjxu', BitcoinCashAddressValidator::PREFIX_MAINNET],
			['bchtest:ppm2qsznhks23z7629mms6s4cwef74vcwvhanqgjxu', BitcoinCashAddressValidator::PREFIX_REGTEST],
			['bchreg:pqzg22ty3m437frzk4y0gvvyqj02jpfv7udqugqkne', BitcoinCashAddressValidator::PREFIX_MAINNET],
			['bchreg:pqzg22ty3m437frzk4y0gvvyqj02jpfv7udqugqkne', BitcoinCashAddressValidator::PREFIX_TESTNET],
		];
	}

	/**
	 * @param string $address
	 * @param string $prefix
	 * @dataProvider providerInvalidAddressPrefix
	 */
	public function testValidateInvalidAddressPrefix($address, $prefix) {
		$validator = new BitcoinCashAddressValidator($address, $prefix);
		$this->assertFalse($validator->validate());
		
		$this->tester->expectException(InvalidAddressPrefixException::class, function() use($validator) {
			$validator->validateWithExceptions();
		});
	}

	public function providerAddressMixedCase() {
		return [
			['Qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BitcoinCashAddressValidator::PREFIX_MAINNET],
			['bitcoincash:Qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', BitcoinCashAddressValidator::PREFIX_MAINNET],
			['bitcoincash:Qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', BitcoinCashAddressValidator::PREFIX_MAINNET],
			['bitcoincash:Ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', BitcoinCashAddressValidator::PREFIX_MAINNET],
			['bitcoincash:Pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', BitcoinCashAddressValidator::PREFIX_MAINNET],
			['bitcoincash:Pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', BitcoinCashAddressValidator::PREFIX_MAINNET],
			['bchtest:Ppm2qsznhks23z7629mms6s4cwef74vcwvhanqgjxu', BitcoinCashAddressValidator::PREFIX_TESTNET],
			['bchreg:Pqzg22ty3m437frzk4y0gvvyqj02jpfv7udqugqkne', BitcoinCashAddressValidator::PREFIX_REGTEST],
		];
	}

	/**
	 * @param string $address
	 * @param string $prefix
	 * @dataProvider providerAddressMixedCase
	 */
	public function testValidateAddressMixedCase($address, $prefix) {
		$validator = new BitcoinCashAddressValidator($address, $prefix);
		$this->assertFalse($validator->validate());
		
		$this->tester->expectException(AddressMixedCaseException::class, function() use($validator) {
			$validator->validateWithExceptions();
		});
	}

	public function providerInvalidAddress() {
		return [
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVgg', BitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['1BpEi6DfDAUFd7GtittLSdBeYJvcoaVgg', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qpm2q:znhks23z7629mms6s4cwef74vcwvy22gdx6a', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', BitcoinCashAddressValidator::PREFIX_TESTNET, true],
			['ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', BitcoinCashAddressValidator::PREFIX_REGTEST, true],
			['bchtest:pp:qsznhks23z7629mms6s4cwef74vcwvhanqgjxu', BitcoinCashAddressValidator::PREFIX_TESTNET, true],
			['bchreg:pq:22ty3m437frzk4y0gvvyqj02jpfv7udqugqkne', BitcoinCashAddressValidator::PREFIX_REGTEST, true],
			['bitcoincashqpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6z', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qqyq78nf2w', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:a5a8yrhz', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:qdpyysjzgfpyysjzgfpyysjzgfpyysjzgg8zlhfxky', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:yppyysjzgfpyysjzgfpyysjzgfpyysjzggc5ldue0t', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['bitcoincash:lapyysjzgfpyysjzgfpyysjzgfpyysjzggp9pz6yrw', BitcoinCashAddressValidator::PREFIX_MAINNET, true],
			['qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:qpm2qsznhks23z7629mms6s4cwef74vcwvy22gdx6a', BitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:qr95sy3j9xwd2ap32xkykttr4cvcu7as4y0qverfuy', BitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:qqq3728yw0y47sqn6l2na30mcw6zm78dzqre909m2r', BitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:ppm2qsznhks23z7629mms6s4cwef74vcwvn0h829pq', BitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:pr95sy3j9xwd2ap32xkykttr4cvcu7as4yc93ky28e', BitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bitcoincash:pqq3728yw0y47sqn6l2na30mcw6zm78dzq5ucqzc37', BitcoinCashAddressValidator::PREFIX_MAINNET, false],
			['bchtest:ppm2qsznhks23z7629mms6s4cwef74vcwvhanqgjxu', BitcoinCashAddressValidator::PREFIX_TESTNET, false],
			['bchreg:pqzg22ty3m437frzk4y0gvvyqj02jpfv7udqugqkne', BitcoinCashAddressValidator::PREFIX_REGTEST, false],
		];
	}

	/**
	 * @param string $address
	 * @param string $prefix
	 * @param bool $cashAddressAllowed
	 * @dataProvider providerInvalidAddress
	 */
	public function testValidateInvalidAddress($address, $prefix, $cashAddressAllowed) {
		$validator = new BitcoinCashAddressValidator($address, $prefix);
		$validator->setCashAddressAllowed($cashAddressAllowed);
		$this->assertFalse($validator->validate());
		
		$this->tester->expectException(InvalidAddressException::class, function() use($validator) {
			$validator->validateWithExceptions();
		});
	}

}
