<?php

require_once __DIR__ . '/bootstrap.php';

use BrotherPTouch\LabelExtractor;
use Tester\Assert;


$pathToLabel = __DIR__ . '/files/qr_code.lbx';
$extractor = new LabelExtractor($pathToLabel);
$data = $extractor->extract('//barcode:barcode/pt:data');

Assert::count(1, $data, 'Check correct count of extracted items');

