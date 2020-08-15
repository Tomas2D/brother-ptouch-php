<?php

namespace BrotherPTouch;

final class LabelWriter extends Parser
{
	/**
	 * @param array $data
	 * @param string $xPathSelector
	 * @return false|string|void
	 */
	public function write(array $data, string $xPathSelector = '//text:text/pt:data')
	{
		// Create copy of archive
		$temp = tempnam(sys_get_temp_dir(), 'pt_');
		rename($temp, $temp .= '.lbx');
		copy($this->path, $temp);

		// Open archive
		$zip = $this->openZip($temp);

		// Update values
		$xml = $this->readByEntry($zip, function (\SimpleXMLElement &$value, int $index) use (&$data) {
			if (isset($data[$index])) {
				$value[0] = $data[$index];

				$charLenEl = $value->xpath('following-sibling::text:stringItem');
				if (!empty($charLenEl)) {
					$charLenEl[0]->attributes()->charLen = (string)mb_strlen($data[$index]);
				}
			}
		}, $xPathSelector);

		// Override old XML file
		$zip->addFromString(self::CONTENT_FILENAME, $xml->asXML());
		$zip->close();

		// Return new name
		return $temp;
	}

}