<?php

require_once __DIR__ . '/bootstrap.php';

use BrotherPTouch\LabelExtractor;
use Tester\TestCase;

class LabelLoadInvalid extends TestCase
{
	public function getFilenames()
	{
		return [
			['label-not-exist.lbx'],
			['label-malformed-content.lbx'],
			['label-malformed-no-xml.lbx'],
			['label-not-valid.lbx'],
			['label-not-valid.txt']
		];
	}

	/**
	 * @dataProvider getFilenames
	 * @throws \BrotherPTouch\Exceptions\InvalidLabelFileException
	 */
	public function testLoop(string $path)
	{
		$extractor = new LabelExtractor('./files/' . $path);
		$extractor->extract();
	}
}

(new LabelLoadInvalid())->run();