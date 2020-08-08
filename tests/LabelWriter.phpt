<?php

require_once __DIR__ . '/bootstrap.php';

use App\LabelWriter;
use App\LabelExtractor;
use Tester\Assert;

final class LabelWriterTestCase extends \Tester\TestCase
{
	private $pathToLabel = __DIR__ . '/files/label.lbx';
	private $pathToEditedLabel;

	public function testWrite()
	{
		$writer = new LabelWriter($this->pathToLabel);

		$this->pathToEditedLabel = $writer->write([
			'This',
			'library',
			'can',
			'do',
			'it!',
		]);

		Assert::true(is_file($this->pathToEditedLabel), 'Test if new label file has been created.');
	}

	public function testReadNew()
	{
		$extractor = new LabelExtractor($this->pathToEditedLabel);
		$data = $extractor->extract();

		Assert::equal(['This', 'library', 'can', 'do', 'it!'], array_slice($data, 0, 5));
	}

	public function testCompareNewAndOld()
	{
		$extractorOld = new LabelExtractor($this->pathToLabel);
		$extractorNew = new LabelExtractor($this->pathToEditedLabel);

		var_dump($extractorOld);
		var_dump($extractorNew);

		Assert::notSame($extractorOld->extract(), $extractorNew->extract());
	}
}

(new LabelWriterTestCase())->run();