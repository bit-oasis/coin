<?php

namespace BitOasis\Coin;

/**
 * @author Stanislav Fukala <stanislav.fukala@gmail.com>
 */
interface MultiFormatAddress {

	/**
	 * @return string|null simple address without additional ID
	 */
	public function getOldFormatAddress();

	/**
	 * @return string simple address without additional ID
	 */
	public function getNewFormatAddress();

}
