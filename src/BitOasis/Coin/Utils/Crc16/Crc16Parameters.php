<?php

namespace BitOasis\Coin\Utils\Crc16;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class Crc16Parameters {

	// List of algorithms with their parameters borrowed from here -  http://reveng.sourceforge.net/crc-catalogue/16.htm
	public const CRC16_ARC = [0x8005, 0x0000, true, true, 0x0000, 'CRC-16/ARC'];
	public const CRC16_AUG_CCITT = [0x1021, 0x1d0f, false, false, 0x0000, 'CRC-16/AUG-CCITT'];
	public const CRC16_BUYPASS = [0x8005, 0x0000, false, false, 0x0000, 'CRC-16/BUYPASS'];
	public const CRC16_CCITT_FALSE = [0x1021, 0xFFFF, false, false, 0x0000, 'CRC-16/CCITT-FALSE'];
	public const CRC16_CDMA2000 = [0xC867, 0xFFFF, false, false, 0x0000, 'CRC-16/CDMA2000'];
	public const CRC16_DDS_110 = [0x8005, 0x800D, false, false, 0x0000, 'CRC-16/DDS-110'];
	public const CRC16_DECT_R = [0x0589, 0x0000, false, false, 0x0001, 'CRC-16/DECT-R'];
	public const CRC16_DECT_X = [0x0589, 0x0000, false, false, 0x0000, 'CRC-16/DECT-X'];
	public const CRC16_DNP = [0x3D65, 0x0000, true, true, 0xFFFF, 'CRC-16/DNP'];
	public const CRC16_EN_13757 = [0x3D65, 0x0000, false, false, 0xFFFF, 'CRC-16/EN-13757'];
	public const CRC16_GENIBUS = [0x1021, 0xFFFF, false, false, 0xFFFF, 'CRC-16/GENIBUS'];
	public const CRC16_MAXIM = [0x8005, 0x0000, true, true, 0xFFFF, 'CRC-16/MAXIM'];
	public const CRC16_MCRF4XX = [0x1021, 0xFFFF, true, true, 0x0000, 'CRC-16/MCRF4XX'];
	public const CRC16_RIELLO = [0x1021, 0xB2AA, true, true, 0x0000, 'CRC-16/RIELLO'];
	public const CRC16_T10_DIF = [0x8BB7, 0x0000, false, false, 0x0000, 'CRC-16/T10-DIF'];
	public const CRC16_TELEDISK = [0xA097, 0x0000, false, false, 0x0000, 'CRC-16/TELEDISK'];
	public const CRC16_TMS37157 = [0x1021, 0x89EC, true, true, 0x0000, 'CRC-16/TMS37157'];
	public const CRC16_USB = [0x8005, 0xFFFF, true, true, 0xFFFF, 'CRC-16/USB'];
	public const CRC16_CRC_A  = [0x1021, 0xC6C6, true, true, 0x0000, 'CRC-16/CRC-A'];
	public const CRC16_KERMIT = [0x1021, 0x0000, true, true, 0x0000, 'CRC-16/KERMIT'];
	public const CRC16_MODBUS = [0x8005, 0xFFFF, true, true, 0x0000, 'CRC-16/MODBUS'];
	public const CRC16_X_25 = [0x1021, 0xFFFF, true, true, 0xFFFF, 'CRC-16/X-25'];
	public const CRC16_XMODEM = [0x1021, 0x0000, false, false, 0x0000, 'CRC-16/XMODEM'];

	/** @var int */
	public $poly;

	/** @var int */
	public $init;

	/** @var bool */
	public $refIn;

	/** @var bool */
	public $refOut;

	/** @var int */
	public $xorOut;

	/** @var string */
	public $name;

	public function __construct(int $poly, int $init, bool $refIn, bool $refOut, int $xorOut, string $name) {
		$this->poly = $poly;
		$this->init = $init;
		$this->refIn = $refIn;
		$this->refOut = $refOut;
		$this->xorOut = $xorOut;
		$this->name = $name;
	}

	/**
	 * @param array $algorithmParams
	 * @return Crc16Parameters
	 */
	public static function fromArray(array $algorithmParams): Crc16Parameters {
		list($poly, $init, $refIn, $refOut, $xorOut, $name) = $algorithmParams;
		return new Crc16Parameters($poly, $init, $refIn, $refOut, $xorOut, $name);
	}
}