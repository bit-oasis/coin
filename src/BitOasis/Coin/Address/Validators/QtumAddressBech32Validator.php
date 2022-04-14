<?php

namespace BitOasis\Coin\Address\Validators;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class QtumAddressBech32Validator extends Bech32AddressValidator {

	protected $prefix = 'qc';
	protected $bech32DecodedLength = 53;
	protected $label = 'QTUM';

}
