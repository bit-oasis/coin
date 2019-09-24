<?php

namespace BitOasis\Coin;

/**
 * @author Stanislav Fukala <stanislav.fukala@gmail.com>
 */
interface LegacyAddress {

	/**
	 * @return string simple address without additional ID
	 */
	public function getLegacyAddress();

}
