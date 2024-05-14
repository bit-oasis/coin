<?php

namespace BitOasis\Coin\Utils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class Binary {

	/**
	 * @param int $bin
	 * @param int $width
	 * @return int
	 */
	public static function reverseBits(int $bin, int $width): int {
		$clonedBin = $bin;
		$bin = 0;
		for ($i = 0; $i < $width; ++$i) {
			$bin <<= 1;
			$bin |= ($clonedBin & 0x1);
			$clonedBin >>= 1;
		}
		return $bin;
	}
}