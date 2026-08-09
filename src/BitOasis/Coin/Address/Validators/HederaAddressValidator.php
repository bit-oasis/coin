<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * Validates a Hedera account ID in `shard.realm.num` form (e.g. 0.0.123456) with an
 * optional 5-letter checksum suffix (e.g. 0.0.123456-vfmkw), plus an optional memo.
 *
 * @author tariq.tawalbeh <tariq.tawalbeh@bitoasis.net>
 */
class HederaAddressValidator implements ValidationInterface {

	private const ACCOUNT_ID_PATTERN = '/^\d+\.\d+\.\d+(-[a-z]{5})?$/';

	private const MEMO_MAX_LENGTH = 100;

	/** @var string */
	protected $address;

	/** @var string|null */
	protected $memo;

	public function __construct($address, $memo = null) {
		$this->address = $address;
		$this->memo = $memo;
	}

	/**
	 * @inheritDoc
	 */
	public function validate(): bool {
		if (!is_string($this->address) || preg_match(self::ACCOUNT_ID_PATTERN, $this->address) !== 1) {
			return false;
		}

		if ($this->memo !== null && !$this->isValidMemo($this->memo)) {
			return false;
		}

		return true;
	}

	private function isValidMemo(string $memo): bool {
		$length = strlen($memo);

		return $length >= 1 && $length <= self::MEMO_MAX_LENGTH && ctype_alnum($memo);
	}
}
