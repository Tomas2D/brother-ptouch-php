<?php

namespace BrotherPTouch;

use BrotherPTouch\Exceptions\InvalidLabelFileException;

abstract class Parser
{
	protected const CONTENT_FILENAME = 'label.xml';

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @var string
	 */
	protected $filename;

	/**
	 * Parser constructor.
	 * @param string $path
	 */
	public function __construct(string $path)
	{
		if (!is_file($path) || !is_readable($path)) {
			throw new InvalidLabelFileException('File does not exists or cannot be read');
		}

		if (substr($path, -4) !== '.lbx') {
			throw new InvalidLabelFileException('File is probably not in .lbx format!');
		}

		$this->path = $path;

		$filename = explode('/', $path);
		$this->filename = str_replace('.lbx', '', array_pop($filename));
	}

	/**
	 * @return \ZipArchive
	 */
	protected function openZip(?string $path = NULL)
	{
		$zip = new \ZipArchive();
		$statusCode = $zip->open($path ? $path : $this->path);

		if (is_numeric($statusCode)) {
			throw new InvalidLabelFileException();
		}

		return $zip;
	}

	/**
	 * @param \ZipArchive $zip
	 * @param callable $callback
	 * @param string $xPathSelector
	 * @return \SimpleXMLElement
	 */
	protected function readByEntry(\ZipArchive &$zip,
								   callable $callback,
								   string $xPathSelector)
	{
		$content = $zip->getFromName(self::CONTENT_FILENAME);
		if ($content === FALSE) {
			throw new InvalidLabelFileException('Archive is malformed, does not contain ' . self::CONTENT_FILENAME);
		}

		$xml = @simplexml_load_string($content);
		if (FALSE === ($xml instanceof \SimpleXMLElement)) {
			throw new InvalidLabelFileException('File is malformed, it is not in valid XML format.');
		}

		$matches = $xml->xpath($xPathSelector);
		array_walk($matches, $callback);

		return $xml;
	}

}