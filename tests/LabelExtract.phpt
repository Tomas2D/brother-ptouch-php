<?php

require_once __DIR__ . '/bootstrap.php';

use BrotherPTouch\LabelExtractor;
use Tester\Assert;


$pathToLabel = __DIR__ . '/files/label.lbx';
$extractor = new LabelExtractor($pathToLabel);
$data = $extractor->extract();

Assert::count(8, $data, 'Check correct count of extracted items');

