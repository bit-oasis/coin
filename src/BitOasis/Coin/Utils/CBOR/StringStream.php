<?php

namespace BitOasis\Coin\Utils\CBOR;

use BitOasis\Coin\Utils\Exception\InvalidArgumentException;
use RuntimeException;
use function mb_strlen;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class StringStream implements Stream {

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
		if ($length === 0) {
			return '';
		}

		$alreadyRead = 0;
		$data = '';
		while ($alreadyRead < $length) {
			$left = $length - $alreadyRead;
			$sizeToRead = $left < 1024 && $left > 0 ? $left : 1024;
			$newData = \fread($this->resource, $sizeToRead);
			$alreadyRead += $sizeToRead;

			if ($newData === false) {
				throw new RuntimeException('Unable to read the memory');
			}
			if (mb_strlen($newData, '8bit') < $sizeToRead) {
				$this->throwInvalidDataLengthException($data, $length);
			}
			$data .= $newData;
		}

		if (mb_strlen($data, '8bit') !== $length) {
			$this->throwInvalidDataLengthException($data, $length);
		}

		return $data;
	}

	/**
	 * @throws InvalidArgumentException
	 */
	protected function throwInvalidDataLengthException(string $data, int $expectedLength): void {
		$message = \sprintf('Out of range. Expected: %d, read: %d.', $expectedLength, mb_strlen($data, '8bit'));
		throw new InvalidArgumentException($message);
	}
}
