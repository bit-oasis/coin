<?php

namespace BitOasis\Coin\Utils\Crc16;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class Crc16Table {

	/** @var Crc16Parameters */
	public $params;

	/** @var array */
	public $data;

	public function __construct(Crc16Parameters $params, array $data = []) {
		$this->params = $params;
		$this->data = $data;
	}

	/**
	 * @return Crc16Parameters
	 */
	public function getParams(): Crc16Parameters {
		return $this->params;
	}

	/**
	 * @return array
	 */
	public function getData(): array {
		return $this->data;
	}

	/**
	 * @param int $value
	 * @return void
	 */
	public function appendToData(int $value): void {
		$this->data[] = $value;
	}

}