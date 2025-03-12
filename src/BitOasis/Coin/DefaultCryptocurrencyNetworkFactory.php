<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidNetworkException;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class DefaultCryptocurrencyNetworkFactory implements CryptocurrencyNetworkFactory {

	/** @var CryptocurrencyNetwork[] */
	protected $networks = [];

	public function __construct() {
		$this->addNetworks();
	}

	/**
	 * @inheritDoc
	 */
	public function create(string $code): CryptocurrencyNetwork {
		if (!isset($this->networks[$code])) {
			throw new InvalidNetworkException('Cryptocurrency network ' . $code . ' not defined');
		}
		return $this->networks[$code];
	}

	protected function addNetworks() {
		$this->networks[CryptocurrencyNetwork::BITCOIN] = new CryptocurrencyNetwork(CryptocurrencyNetwork::BITCOIN, 'Bitcoin');
		$this->networks[CryptocurrencyNetwork::ETHEREUM] = new CryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM, 'Ethereum', 'ERC20');
		$this->networks[CryptocurrencyNetwork::ETHEREUM_CLASSIC] = new CryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM_CLASSIC, 'Ethereum Classic');
		$this->networks[CryptocurrencyNetwork::ETHEREUM_POW] = new CryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM_POW, 'Ethereum PoW');
		$this->networks[CryptocurrencyNetwork::RIPPLE] = new CryptocurrencyNetwork(CryptocurrencyNetwork::RIPPLE, 'Ripple');
		$this->networks[CryptocurrencyNetwork::LITECOIN] = new CryptocurrencyNetwork(CryptocurrencyNetwork::LITECOIN, 'Litecoin');
		$this->networks[CryptocurrencyNetwork::BITCOIN_CASH] = new CryptocurrencyNetwork(CryptocurrencyNetwork::BITCOIN_CASH, 'Bitcoin Cash');
		$this->networks[CryptocurrencyNetwork::ZCASH] = new CryptocurrencyNetwork(CryptocurrencyNetwork::ZCASH, 'Zcash');
		$this->networks[CryptocurrencyNetwork::STELLAR_LUMEN] = new CryptocurrencyNetwork(CryptocurrencyNetwork::STELLAR_LUMEN, 'Stellar Lumen');
		$this->networks[CryptocurrencyNetwork::EOS] = new CryptocurrencyNetwork(CryptocurrencyNetwork::EOS, 'Eos');
		$this->networks[CryptocurrencyNetwork::MONERO] = new CryptocurrencyNetwork(CryptocurrencyNetwork::MONERO, 'Monero');
		$this->networks[CryptocurrencyNetwork::ALGORAND] = new CryptocurrencyNetwork(CryptocurrencyNetwork::ALGORAND, 'Algorand');
		$this->networks[CryptocurrencyNetwork::NEO] = new CryptocurrencyNetwork(CryptocurrencyNetwork::NEO, 'Neo');
		$this->networks[CryptocurrencyNetwork::TEZOS] = new CryptocurrencyNetwork(CryptocurrencyNetwork::TEZOS, 'Tezos');
		$this->networks[CryptocurrencyNetwork::DOGECOIN] = new CryptocurrencyNetwork(CryptocurrencyNetwork::DOGECOIN, 'Dogecoin');
		$this->networks[CryptocurrencyNetwork::WAVES] = new CryptocurrencyNetwork(CryptocurrencyNetwork::WAVES, 'Waves');
		$this->networks[CryptocurrencyNetwork::POLKADOT] = new CryptocurrencyNetwork(CryptocurrencyNetwork::POLKADOT, 'Polkadot');
		$this->networks[CryptocurrencyNetwork::SOLANA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::SOLANA, 'Solana');
		$this->networks[CryptocurrencyNetwork::CARDANO] = new CryptocurrencyNetwork(CryptocurrencyNetwork::CARDANO, 'Cardano');
		$this->networks[CryptocurrencyNetwork::FANTOM] = new CryptocurrencyNetwork(CryptocurrencyNetwork::FANTOM, 'Fantom');
		$this->networks[CryptocurrencyNetwork::TERRA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::TERRA, 'Terra');
		$this->networks[CryptocurrencyNetwork::TERRA2] = new CryptocurrencyNetwork(CryptocurrencyNetwork::TERRA2, 'Terra2');
		$this->networks[CryptocurrencyNetwork::COSMOS] = new CryptocurrencyNetwork(CryptocurrencyNetwork::COSMOS, 'Cosmos');
		$this->networks[CryptocurrencyNetwork::NEAR] = new CryptocurrencyNetwork(CryptocurrencyNetwork::NEAR, 'Near Protocol');
		$this->networks[CryptocurrencyNetwork::AVALANCHE_X] = new CryptocurrencyNetwork(CryptocurrencyNetwork::AVALANCHE_X, 'Avalanche X-Chain');
		$this->networks[CryptocurrencyNetwork::AVALANCHE_C] = new CryptocurrencyNetwork(CryptocurrencyNetwork::AVALANCHE_C, 'Avalanche C-Chain');
		$this->networks[CryptocurrencyNetwork::DIGIBYTE] = new CryptocurrencyNetwork(CryptocurrencyNetwork::DIGIBYTE, 'Digibyte');
		$this->networks[CryptocurrencyNetwork::ELRONG_EGOLD] = new CryptocurrencyNetwork(CryptocurrencyNetwork::ELRONG_EGOLD, 'Elrond Egold', 'EGLD');
		$this->networks[CryptocurrencyNetwork::FILECOIN] = new CryptocurrencyNetwork(CryptocurrencyNetwork::FILECOIN, 'Filecoin');
		$this->networks[CryptocurrencyNetwork::IOTA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::IOTA, 'IOTA');
		$this->networks[CryptocurrencyNetwork::KUSAMA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::KUSAMA, 'Kusama');
		$this->networks[CryptocurrencyNetwork::QTUM] = new CryptocurrencyNetwork(CryptocurrencyNetwork::QTUM, 'Qtum');
		$this->networks[CryptocurrencyNetwork::TRON] = new CryptocurrencyNetwork(CryptocurrencyNetwork::TRON, 'Tron Network', 'TRC20');
		$this->networks[CryptocurrencyNetwork::THETA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::THETA, 'Theta');
		$this->networks[CryptocurrencyNetwork::VE_CHAIN] = new CryptocurrencyNetwork(CryptocurrencyNetwork::VE_CHAIN, 'VeChain');
		$this->networks[CryptocurrencyNetwork::VERGE] = new CryptocurrencyNetwork(CryptocurrencyNetwork::VERGE, 'Verge');
		$this->networks[CryptocurrencyNetwork::BITCOIN_GOLD] = new CryptocurrencyNetwork(CryptocurrencyNetwork::BITCOIN_GOLD, 'Bitcoin Gold');
		$this->networks[CryptocurrencyNetwork::SUI] = new CryptocurrencyNetwork(CryptocurrencyNetwork::SUI, 'Sui');
		$this->networks[CryptocurrencyNetwork::SEI] = new CryptocurrencyNetwork(CryptocurrencyNetwork::SEI, 'Sei');
		$this->networks[CryptocurrencyNetwork::XDC_NETWORK] = new CryptocurrencyNetwork(CryptocurrencyNetwork::XDC_NETWORK, 'XinFin');
		$this->networks[CryptocurrencyNetwork::TON] = new CryptocurrencyNetwork(CryptocurrencyNetwork::TON, 'The Open Network');
		$this->networks[CryptocurrencyNetwork::CELO] = new CryptocurrencyNetwork(CryptocurrencyNetwork::CELO, 'Celo');
		$this->networks[CryptocurrencyNetwork::FLARE] = new CryptocurrencyNetwork(CryptocurrencyNetwork::FLARE, 'Flare');
		$this->networks[CryptocurrencyNetwork::INJECTIVE] = new CryptocurrencyNetwork(CryptocurrencyNetwork::INJECTIVE, 'Injective');
		$this->networks[CryptocurrencyNetwork::KAVA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::KAVA, 'Kava');
		$this->networks[CryptocurrencyNetwork::SONGBIRD] = new CryptocurrencyNetwork(CryptocurrencyNetwork::SONGBIRD, 'Songbird');
		$this->networks[CryptocurrencyNetwork::CELESTIA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::CELESTIA, 'Celestia');
		$this->networks[CryptocurrencyNetwork::SONIC] = new CryptocurrencyNetwork(CryptocurrencyNetwork::SONIC, 'Sonic');
	}

}

