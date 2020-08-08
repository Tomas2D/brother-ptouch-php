<?php

namespace App;

final class LabelExtractor extends Parser
{
	/**
	 * @param string $selector
	 * @return array
	 */
	public function extract(string $selector = '//text:text/pt:data')
	{
		$zip = $this->openZip();

		$data = [];
		$this->readByEntry($zip, function (&$value) use (&$data) {
			$data[] = $value[0]->__toString();
		}, $selector);

		$zip->close();
		return $data;
	}

}