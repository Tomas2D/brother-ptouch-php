<?php

namespace App\Exceptions;

class InvalidLabelFileException extends \Exception {
	protected $message = 'Supplied file is not valid lbx format.';
}