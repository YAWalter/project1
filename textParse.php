<?php

// class for cleaning up text from CSV input
class textParse extends page {
	
	public static function dropEmpty($arr) {
		// removes empty space in elements
		$clean = array();
		foreach ($arr as $raw) {
			$clean[] = textParse::cleaner($raw);
		}
		
		return $clean;
	}
	
	public static function cleaner($str) {
		
		return rtrim(ltrim($str));
	}
	
	public static function testarray() {
		$arr1 = array(' ', '  ', ' phew!', '   ', 'some text   ', '    ', '\n');
		$arr2 = array(' ', '  ', "\t", '', '    ', "\n");
		
		return '<pre>' . print_r(textParse::dropEmpty($arr2), true) . '</pre>';
	}
}
?>