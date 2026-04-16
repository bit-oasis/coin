<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidNetworkException;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class DefaultCryptocurrencyNetworkFactory implements CryptocurrencyNetworkFactory {

	/** @var CryptocurrencyNetwork[] */
	protected $networks = [];

	public function __construct(CryptocurrencyFactory $cryptocurrencyFactory) {
		$this->addNetworks($cryptocurrencyFactory);
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

	protected function addNetworks(CryptocurrencyFactory $cryptocurrencyFactory) {
		$this->networks[CryptocurrencyNetwork::BITCOIN] = new CryptocurrencyNetwork(CryptocurrencyNetwork::BITCOIN, 'Bitcoin', $cryptocurrencyFactory->create(Cryptocurrency::BTC));
		$this->networks[CryptocurrencyNetwork::ETHEREUM] = new CryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM, 'Ethereum', $cryptocurrencyFactory->create(Cryptocurrency::ETH), 'ERC20');
		$this->networks[CryptocurrencyNetwork::ETHEREUM_CLASSIC] = new CryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM_CLASSIC, 'Ethereum Classic', $cryptocurrencyFactory->create(Cryptocurrency::ETC));
		$this->networks[CryptocurrencyNetwork::ETHEREUM_POW] = new CryptocurrencyNetwork(CryptocurrencyNetwork::ETHEREUM_POW, 'Ethereum PoW', $cryptocurrencyFactory->create(Cryptocurrency::ETHW));
		$this->networks[CryptocurrencyNetwork::RIPPLE] = new CryptocurrencyNetwork(CryptocurrencyNetwork::RIPPLE, 'Ripple', $cryptocurrencyFactory->create(Cryptocurrency::XRP));
		$this->networks[CryptocurrencyNetwork::LITECOIN] = new CryptocurrencyNetwork(CryptocurrencyNetwork::LITECOIN, 'Litecoin', $cryptocurrencyFactory->create(Cryptocurrency::LTC));
		$this->networks[CryptocurrencyNetwork::BITCOIN_CASH] = new CryptocurrencyNetwork(CryptocurrencyNetwork::BITCOIN_CASH, 'Bitcoin Cash', $cryptocurrencyFactory->create(Cryptocurrency::BCH));
		$this->networks[CryptocurrencyNetwork::ZCASH] = new CryptocurrencyNetwork(CryptocurrencyNetwork::ZCASH, 'Zcash', $cryptocurrencyFactory->create(Cryptocurrency::ZEC));
		$this->networks[CryptocurrencyNetwork::STELLAR_LUMEN] = new CryptocurrencyNetwork(CryptocurrencyNetwork::STELLAR_LUMEN, 'Stellar Lumen', $cryptocurrencyFactory->create(Cryptocurrency::XLM));
		$this->networks[CryptocurrencyNetwork::EOS] = new CryptocurrencyNetwork(CryptocurrencyNetwork::EOS, 'Eos', $cryptocurrencyFactory->create(Cryptocurrency::EOS));
		$this->networks[CryptocurrencyNetwork::MONERO] = new CryptocurrencyNetwork(CryptocurrencyNetwork::MONERO, 'Monero', $cryptocurrencyFactory->create(Cryptocurrency::XMR));
		$this->networks[CryptocurrencyNetwork::ALGORAND] = new CryptocurrencyNetwork(CryptocurrencyNetwork::ALGORAND, 'Algorand', $cryptocurrencyFactory->create(Cryptocurrency::ALGO));
		$this->networks[CryptocurrencyNetwork::NEO] = new CryptocurrencyNetwork(CryptocurrencyNetwork::NEO, 'Neo', $cryptocurrencyFactory->create(Cryptocurrency::NEO));
		$this->networks[CryptocurrencyNetwork::TEZOS] = new CryptocurrencyNetwork(CryptocurrencyNetwork::TEZOS, 'Tezos', $cryptocurrencyFactory->create(Cryptocurrency::XTZ));
		$this->networks[CryptocurrencyNetwork::DOGECOIN] = new CryptocurrencyNetwork(CryptocurrencyNetwork::DOGECOIN, 'Dogecoin', $cryptocurrencyFactory->create(Cryptocurrency::DOGE));
		$this->networks[CryptocurrencyNetwork::WAVES] = new CryptocurrencyNetwork(CryptocurrencyNetwork::WAVES, 'Waves', $cryptocurrencyFactory->create(Cryptocurrency::WAVES));
		$this->networks[CryptocurrencyNetwork::POLKADOT] = new CryptocurrencyNetwork(CryptocurrencyNetwork::POLKADOT, 'Polkadot', $cryptocurrencyFactory->create(Cryptocurrency::DOT));
		$this->networks[CryptocurrencyNetwork::SOLANA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::SOLANA, 'Solana', $cryptocurrencyFactory->create(Cryptocurrency::SOL));
		$this->networks[CryptocurrencyNetwork::CARDANO] = new CryptocurrencyNetwork(CryptocurrencyNetwork::CARDANO, 'Cardano', $cryptocurrencyFactory->create(Cryptocurrency::ADA));
		$this->networks[CryptocurrencyNetwork::FANTOM] = new CryptocurrencyNetwork(CryptocurrencyNetwork::FANTOM, 'Fantom', $cryptocurrencyFactory->create(Cryptocurrency::FTM));
		$this->networks[CryptocurrencyNetwork::TERRA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::TERRA, 'Terra', $cryptocurrencyFactory->create(Cryptocurrency::LUNA));
		$this->networks[CryptocurrencyNetwork::TERRA2] = new CryptocurrencyNetwork(CryptocurrencyNetwork::TERRA2, 'Terra2', $cryptocurrencyFactory->create(Cryptocurrency::LUNA2));
		$this->networks[CryptocurrencyNetwork::COSMOS] = new CryptocurrencyNetwork(CryptocurrencyNetwork::COSMOS, 'Cosmos', $cryptocurrencyFactory->create(Cryptocurrency::ATOM));
		$this->networks[CryptocurrencyNetwork::NEAR] = new CryptocurrencyNetwork(CryptocurrencyNetwork::NEAR, 'Near Protocol', $cryptocurrencyFactory->create(Cryptocurrency::NEAR));
		$this->networks[CryptocurrencyNetwork::AVALANCHE_X] = new CryptocurrencyNetwork(CryptocurrencyNetwork::AVALANCHE_X, 'Avalanche X-Chain', $cryptocurrencyFactory->create(Cryptocurrency::AVAX));
		$this->networks[CryptocurrencyNetwork::AVALANCHE_C] = new CryptocurrencyNetwork(CryptocurrencyNetwork::AVALANCHE_C, 'Avalanche C-Chain', $cryptocurrencyFactory->create(Cryptocurrency::AVAX));
		$this->networks[CryptocurrencyNetwork::DIGIBYTE] = new CryptocurrencyNetwork(CryptocurrencyNetwork::DIGIBYTE, 'Digibyte', $cryptocurrencyFactory->create(Cryptocurrency::DGB));
		$this->networks[CryptocurrencyNetwork::ELRONG_EGOLD] = new CryptocurrencyNetwork(CryptocurrencyNetwork::ELRONG_EGOLD, 'Elrond Egold', $cryptocurrencyFactory->create(Cryptocurrency::EGLD), 'EGLD');
		$this->networks[CryptocurrencyNetwork::FILECOIN] = new CryptocurrencyNetwork(CryptocurrencyNetwork::FILECOIN, 'Filecoin', $cryptocurrencyFactory->create(Cryptocurrency::FIL));
		$this->networks[CryptocurrencyNetwork::IOTA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::IOTA, 'IOTA', $cryptocurrencyFactory->create(Cryptocurrency::IOTA));
		$this->networks[CryptocurrencyNetwork::KUSAMA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::KUSAMA, 'Kusama', $cryptocurrencyFactory->create(Cryptocurrency::KSM));
		$this->networks[CryptocurrencyNetwork::QTUM] = new CryptocurrencyNetwork(CryptocurrencyNetwork::QTUM, 'Qtum', $cryptocurrencyFactory->create(Cryptocurrency::QTUM));
		$this->networks[CryptocurrencyNetwork::TRON] = new CryptocurrencyNetwork(CryptocurrencyNetwork::TRON, 'Tron Network', $cryptocurrencyFactory->create(Cryptocurrency::TRX), 'TRC20');
		$this->networks[CryptocurrencyNetwork::THETA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::THETA, 'Theta', $cryptocurrencyFactory->create(Cryptocurrency::THETA));
		$this->networks[CryptocurrencyNetwork::VE_CHAIN] = new CryptocurrencyNetwork(CryptocurrencyNetwork::VE_CHAIN, 'VeChain', $cryptocurrencyFactory->create(Cryptocurrency::VET));
		$this->networks[CryptocurrencyNetwork::VERGE] = new CryptocurrencyNetwork(CryptocurrencyNetwork::VERGE, 'Verge', $cryptocurrencyFactory->create(Cryptocurrency::XVG));
		$this->networks[CryptocurrencyNetwork::BITCOIN_GOLD] = new CryptocurrencyNetwork(CryptocurrencyNetwork::BITCOIN_GOLD, 'Bitcoin Gold', $cryptocurrencyFactory->create(Cryptocurrency::BTG));
		$this->networks[CryptocurrencyNetwork::SUI] = new CryptocurrencyNetwork(CryptocurrencyNetwork::SUI, 'Sui', $cryptocurrencyFactory->create(Cryptocurrency::SUI));
		$this->networks[CryptocurrencyNetwork::SEI] = new CryptocurrencyNetwork(CryptocurrencyNetwork::SEI, 'Sei', $cryptocurrencyFactory->create(Cryptocurrency::SEI));
		$this->networks[CryptocurrencyNetwork::XDC_NETWORK] = new CryptocurrencyNetwork(CryptocurrencyNetwork::XDC_NETWORK, 'XinFin', $cryptocurrencyFactory->create(Cryptocurrency::XDC));
		$this->networks[CryptocurrencyNetwork::TON] = new CryptocurrencyNetwork(CryptocurrencyNetwork::TON, 'The Open Network', $cryptocurrencyFactory->create(Cryptocurrency::TON));
		$this->networks[CryptocurrencyNetwork::CELO] = new CryptocurrencyNetwork(CryptocurrencyNetwork::CELO, 'Celo', $cryptocurrencyFactory->create(Cryptocurrency::CELO));
		$this->networks[CryptocurrencyNetwork::FLARE] = new CryptocurrencyNetwork(CryptocurrencyNetwork::FLARE, 'Flare', $cryptocurrencyFactory->create(Cryptocurrency::FLR));
		$this->networks[CryptocurrencyNetwork::INJECTIVE] = new CryptocurrencyNetwork(CryptocurrencyNetwork::INJECTIVE, 'Injective', $cryptocurrencyFactory->create(Cryptocurrency::INJ));
		$this->networks[CryptocurrencyNetwork::KAVA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::KAVA, 'Kava', $cryptocurrencyFactory->create(Cryptocurrency::KAVA));
		$this->networks[CryptocurrencyNetwork::SONGBIRD] = new CryptocurrencyNetwork(CryptocurrencyNetwork::SONGBIRD, 'Songbird', $cryptocurrencyFactory->create(Cryptocurrency::SGB));
		$this->networks[CryptocurrencyNetwork::CELESTIA] = new CryptocurrencyNetwork(CryptocurrencyNetwork::CELESTIA, 'Celestia', $cryptocurrencyFactory->create(Cryptocurrency::TIA));
		$this->networks[CryptocurrencyNetwork::SONIC] = new CryptocurrencyNetwork(CryptocurrencyNetwork::SONIC, 'Sonic', $cryptocurrencyFactory->create(Cryptocurrency::S));
		$this->networks[CryptocurrencyNetwork::ARBITRUM] = new CryptocurrencyNetwork(CryptocurrencyNetwork::ARBITRUM, 'Arbitrum', $cryptocurrencyFactory->create(Cryptocurrency::ARB));
	}

}

