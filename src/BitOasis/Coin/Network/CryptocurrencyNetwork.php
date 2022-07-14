<?php

namespace BitOasis\Coin\Network;

class CryptocurrencyNetwork {

	const KEY = 'cryptocurrencyNetwork';

	const BITCOIN = 'bitcoin';
	const BITCOIN_CASH = 'bitcoin_cash';
	const ETHEREUM = 'erc20';
	const ETHEREUM_CLASSIC = 'ethereum_classic';
	const TRON = 'trc20';
	const MATIC = 'matic';
	const RIPPLE = 'ripple';
	const LITECOIN = 'litecoin';
	const ZCASH = 'zcash';
	const STELLAR_LUMEN = 'stellar_lumen';
	const EOS = 'eos';
	const MONERO = 'monero';
	const ALGORAND = 'algorand';
	const NEO = 'neo';
	const TEZOS = 'tezos';
	const DOGECOIN = 'dogecoin';
	const WAVES = 'waves';
	const POLKADOT = 'polkadot';
	const SOLANA = 'solana';
	const CARDANO = 'cardano';
	const FANTOM = 'fantom';
	const TERRA = 'terra';
	const TERRA2 = 'terra2';
	const COSMOS = 'cosmos';
	const NEAR = 'near';
	const AVALANCHE_X = 'avalanche_x';
	const DIGIBYTE = 'digibyte';
	const ELRONG_EGOLD = 'elrond_egold';
	const FILECOIN = 'filecoin';
	const IOTA = 'iota';
	const KUSAMA = 'kusama';
	const QTUM = 'qtum';
	const THETA = 'theta';
	const VE_CHAIN = 've_chain';
	const VERGE = 'verge';

	/** @var string */
	protected $code;

	/** @var string */
	protected $name;

	/** @var string */
	protected $alias;

	/**
	 * Cryptocurrency network constructor.
	 * @param string $code
	 * @param string $name
	 * @param string|null $alias
	 */
	public function __construct(string $code, string $name, string $alias = null) {
		$this->code = $code;
		$this->name = $name;
		$this->alias = $alias;
	}

	/**
	 * @return string
	 */
	public function getCode(): string {
		return $this->code;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return string|null
	 */
	public function getAlias(): ?string {
		return $this->alias;
	}

	public function toString(): string {
		return $this->name . ($this->alias !== null ? " ($this->alias)" : "");
	}

	public function equals(CryptocurrencyNetwork $network): bool {
		return $this->code === $network->code;
	}
}
