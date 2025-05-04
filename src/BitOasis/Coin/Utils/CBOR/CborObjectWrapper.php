<?php

namespace BitOasis\Coin\Utils\CBOR;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class CborObjectWrapper implements CborObject {

	/** @var \CBOR\CBORObject */
	protected $cborObject;

	public function __construct(\CBOR\CBORObject $cborObject) {
		$this->cborObject = $cborObject;
	}

	public function __toString(): string {
		return (string)$this->cborObject;
	}

	public function getAdditionalInformation(): int {
		return $this->cborObject->getAdditionalInformation();
	}

	public function getMajorType(): int {
		return $this->cborObject->getMajorType();
	}

	/**
	 * @inheritDoc
	 */
	public function getNormalizedData(bool $ignoreTags = false) {
		return $this->cborObject->getNormalizedData($ignoreTags);
	}
}
