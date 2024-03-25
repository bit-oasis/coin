<?php

namespace BitOasis\Coin\Utils\CBOR;

use BitOasis\Coin\Utils\Exception\InvalidArgumentException;
use RuntimeException;
use function mb_strlen;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class StringStream implements Stream {

	const ENCODING = '8bit';

	const MIN_LENGTH = 0;

	const MAX_LENGTH = 1024;

	/** @var resource */
	private $resource;

	public function __construct(string $data) {
		$resource = \fopen('php://memory', 'rb+');
		if ($resource === false) {
			throw new RuntimeException('Unable to open the memory');
		}
		$result = \fwrite($resource, $data);
		if ($result === false) {
			throw new RuntimeException('Unable to write the memory');
		}
		$result = \rewind($resource);
		if ($result === false) {
			throw new RuntimeException('Unable to rewind the memory');
		}

		$this->resource = $resource;
	}

	public static function create(string $data): self {
		return new self($data);
	}

	/**
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 */
	public function read(int $length): string {
		if ($length === self::MIN_LENGTH) {
			return '';
		}

		$alreadyRead = 0;
		$data = '';
		while ($alreadyRead < $length) {
			$left = $length - $alreadyRead;
			$sizeToRead = $left < self::MAX_LENGTH && $left > self::MIN_LENGTH ? $left : self::MAX_LENGTH;
			$newData = \fread($this->resource, $sizeToRead);
			$alreadyRead += $sizeToRead;

			if ($newData === false) {
				throw new RuntimeException('Unable to read the memory');
			}
			if (mb_strlen($newData, self::ENCODING) < $sizeToRead) {
				$this->throwInvalidDataLengthException($data, $length);
			}
			$data .= $newData;
		}

		if (mb_strlen($data, self::ENCODING) !== $length) {
			$this->throwInvalidDataLengthException($data, $length);
		}

		return $data;
	}

	/**
	 * @throws InvalidArgumentException
	 */
	protected function throwInvalidDataLengthException(string $data, int $expectedLength): void {
		$message = \sprintf('Out of range. Expected: %d, read: %d.', $expectedLength, mb_strlen($data, self::ENCODING));
		throw new InvalidArgumentException($message);
	}
}
