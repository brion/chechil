<?php

class HighlighterTest extends PHPUnit_Framework_TestCase {
	/**
	 * @dataProvider provideHighlighting
	 */
	public function testHighlighting($lang, $infile, $outfile) {
		$input = file_get_contents($infile);
		$expected = file_get_contents($outfile);
		$chechil = new Chechil\Highlighter($input, $lang);
		$this->assertEquals($expected, $chechil->parse_code(), "Highlighting for language $lang");
	}

	public function provideHighlighting() {
		$result = array();
		foreach(glob(__DIR__ . '/data/texts/*.in.txt') as $file) {
			if (!preg_match('#^(.*?)([^\./\\\\]+?)(\..+)?\.in\.txt$#', $file, $m)) {
				throw new Exception("Invalid test file name: '$file'");
			}
			$path = $m[1];
			$lang = $m[2];
			$suffix = $m[3];
			$outfile = "$path$lang$suffix.out.txt";
			$result[] = array($lang, $file, $outfile);
		}
		if (!$result) {
			throw new Exception("No language tests found, is something wrong?");
		}
		return $result;
	}
}
