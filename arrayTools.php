<?php

// class for making usable arrays from CSV input (comma/newline-only strings)
class arrayTools extends page {
	
	public static function csvChunker($csv) {
		$chunked = array();
		
		$rows = arrayTools::chunker($csv, '\n');
		foreach ($rows as $line) {
			$chunked[] = arrayTools::chunker($line, ',');
		}
		
		return $chunked;
	}
	
	// possible combination of the two chunkers?
	public static function chunker($array, $char) {
		
		return explode($char, $array);
	}
	
}

?>