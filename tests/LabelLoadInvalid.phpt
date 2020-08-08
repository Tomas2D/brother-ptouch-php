<?php

require_once __DIR__ . '/bootstrap.php';

use App\LabelWriter;
use App\LabelExtractor;
use Tester\Assert;

class LabelLoadInvalid extends \Tester\TestCase
{
	public function testOpenNonExistentFile()
	{
		Assert::exception(function() {
			$path = __DIR__ . '/files/label-not-exist.lbx';
			new LabelExtractor($path);
		}, \App\Exceptions\InvalidLabelFileException::class);
	}

	public function testOpenNonValidFormat()
	{
		Assert::exception(function() {
			$path = __DIR__ . '/files/label-not-valid.lbx';
			$extractor = new LabelExtractor($path);
			$extractor->extract();
		}, \App\Exceptions\InvalidLabelFileException::class);
	}
}

(new LabelLoadInvalid())->run();