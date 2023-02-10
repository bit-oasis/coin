# Library for virtual currencies
[![CircleCI](https://circleci.com/gh/bit-oasis/coin.svg?style=svg&circle-token=94662eadbc391bcbacf097480d9110d03a7f0ed6)](https://circleci.com/gh/bit-oasis/coin)

##Warning
Multiplication or division can return different results for passed numbers in float and string, because of float rounding, see [PHP doc](https://www.php.net/manual/en/language.types.float.php) for details. This could be solved by setting maximal decimals to be used of course, but we've chosen to not limit decimals in favor of better precision in string representation.

##Breaking changes in v3
This version is designed for Nette >= 3.0 (currently supports Nette 2.4) and does not support Kdyby\Doctrine anymore (as it's not maintained). Instead the package relies on Nettrine\Orm and thus, unfortunately, it looses some features (e.g. automatic registering of custom DB types).
###Nettrine/ORM extension proxies
Please use proxies for Doctrine related extensions (Nettrine packages) from [Davefu/Kdyby-Contributte-Bridge](https://github.com/davefu/Kdyby-Contributte-Bridge) package.
The package provides few helper classes to simplify mapping configuration of this extension. The proxy package also provides cooperation of Kdyby/Events and Nettrine/ORM (Nettrine/DBAL respectively), if you use this package for event functionality.
###Custom database types has to be registered in main project config file
```yaml
extensions:
	dbal: Davefu\KdybyContributteBridge\DI\DbalExtensionProxy
	orm: Davefu\KdybyContributteBridge\DI\OrmExtensionProxy

dbal:
	connection:
		types:
			coin:
				class: BitOasis\Coin\Types\CoinType
				commented: true
			cryptocurrencyAddress:
				class: BitOasis\Coin\Types\CryptocurrencyAddressType
				commented: true

		typesMapping:
			coin: integer
			cryptocurrencyAddress: string
```

##Other changes
- For usage **without** networks support use v1.*
- For usage **with** networks support use v2.* or v3.*
