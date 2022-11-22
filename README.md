# Library for virtual currencies
[![CircleCI](https://circleci.com/gh/bit-oasis/coin.svg?style=svg&circle-token=94662eadbc391bcbacf097480d9110d03a7f0ed6)](https://circleci.com/gh/bit-oasis/coin)

##Warning
Multiplication or division can return different results for passed numbers in float and string, because of float rounding, see [PHP doc](https://www.php.net/manual/en/language.types.float.php) for details. This could be solved by setting maximal decimals to be used of course, but we've chosen to not limit decimals in favor of better precision in string representation.

- For usage without networks support use v1.*
- For usage with networks support use v2.*
