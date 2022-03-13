<?php

namespace BitOasis\Coin\Utils\CBOR;

use CBOR\Decoder as OriginalDecoder;
use CBOR\OtherObject;
use CBOR\Tag;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class Decoder {

	/** @var OriginalDecoder|null */
	private $decoder;

	public function decode(string $data): CborObject {
		$stream = new StringStream($data);
		$object = $this->getDecoder()->decode($stream);

		return new CborObjectWrapper($object);
	}

	protected function getDecoder(): OriginalDecoder {
		if ($this->decoder === null) {
			$otherObjectManager = new OtherObject\OtherObjectManager();
			$otherObjectManager->add(OtherObject\SimpleObject::class);

			$tagManager = new Tag\TagObjectManager();
			$tagManager->add(Tag\PositiveBigIntegerTag::class);

			$this->decoder = new OriginalDecoder($tagManager, $otherObjectManager);
		}

		return $this->decoder;
	}
}
