<?php

namespace BrotherPTouch\Exceptions;

class InvalidLabelFileException extends \Exception {
	protected $message = 'Supplied file is not valid lbx format.';
}