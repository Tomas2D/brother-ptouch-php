<?php

require_once __DIR__ . '/bootstrap.php';

use App\LabelWriter;
use App\LabelExtractor;
use Tester\Assert;

class BarcodeWriter extends \Tester\TestCase
{
	private $pathToLabel = __DIR__ . '/files/qr_code.lbx';
	private $pathToEditedLabel;

	public function testWrite()
	{
		$writer = new LabelWriter($this->pathToLabel);

		$this->pathToEditedLabel = $writer->write([
			'https://tomas2d.cz',
		], '//barcode:barcode/pt:data');

		Assert::true(is_file($this->pathToEditedLabel), 'Test if new label file has been created.');
	}

	public function testReadNew()
	{
		$extractor = new LabelExtractor($this->pathToEditedLabel);
		$data = $extractor->extract('//barcode:barcode/pt:data');

		Assert::equal(['https://tomas2d.cz'], array_slice($data, 0, 1));
	}

	public function testCompareNewAndOld()
	{
		$extractorOld = new LabelExtractor($this->pathToLabel);
		$extractorNew = new LabelExtractor($this->pathToEditedLabel);

		Assert::notSame($extractorOld->extract('//barcode:barcode/pt:data'), $extractorNew->extract('//barcode:barcode/pt:data'));

		unlink($this->pathToEditedLabel);
	}
}

(new BarcodeWriter())->run();