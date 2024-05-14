<?php

namespace BitOasis\Coin\Utils\Crc16;

use BitOasis\Coin\Utils\Binary;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 * Detailed information about the CRC algorithm and its specifications,
 * can be found here - http://www.zlib.net/crc_v3.txt
 */
class Crc16 {

	/**
	 * @param Crc16Parameters $parameters
	 * @return Crc16Table
	 */
	public function makeTable(Crc16Parameters $parameters): Crc16Table {
		$table = new Crc16Table($parameters);
		for ($i = 0; $i < 256; $i++) {
			$crc = $i << 8;
			for ($j = 0; $j < 8; $j++) {
				$bit = ($crc & 0x8000) !== 0;
				$crc <<= 1;
				if ($bit) {
					$crc ^= $parameters->poly;
				}
			}
			$table->appendToData($crc & 0xFFFF);
		}
		return $table;
	}

	/**
	 * @param string $buffer
	 * @param Crc16Table $table
	 * @return int
	 */
	public function checksum(string $buffer, Crc16Table $table): int {
		$crc = $this->init($table);
		$crc = $this->update($crc, $buffer, $table);
		return $this->complete($crc, $table);
	}

	/**
	 * @param Crc16Table $table
	 * @return int
	 */
	public function init(Crc16Table $table): int {
		return $table->getParams()->init;
	}

	/**
	 * @param int $crc
	 * @param string $buffer
	 * @param Crc16Table $table
	 * @return int
	 */
	public function update(int $crc, string $buffer, Crc16Table $table): int {
		for ($i = 0; $i < strlen($buffer); $i++) {
			$byte = ord($buffer[$i]);
			if ($table->getParams()->reflectIn) {
				$byte = Binary::reverseBits($byte, 8);
			}
			$crc = (($crc << 8) ^ $table->getData()[(($crc >> 8) & 0xff) ^ $byte]);
		}
		return $crc;
	}

	/**
	 * @param int $crc
	 * @param Crc16Table $table
	 * @return int
	 */
	public function complete(int $crc, Crc16Table $table): int {
		if ($table->getParams()->reflectOut) {
			return Binary::reverseBits($crc, 16) ^ $table->getParams()->xorOut;
		}
		return ($crc ^ $table->getParams()->xorOut) & 0xFFFF;
	}
}