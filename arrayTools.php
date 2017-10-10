<?php

// class for making usable arrays from CSV input (comma/newline-only strings)
class arrayTools extends page {
	
	public static function csvChunker($csv) {
		$chunked = array();
		
		$rows = arrayTools::chunker($csv, "\n");
		// processes each line, removing "s
		foreach ($rows as $line) {
			$raw = arrayTools::chunker($line, ',');
			$chunked[] = str_replace('"', '', $raw);
		}
		
		return $chunked;
	}
	
	// possible combination of the two chunkers?
	public static function chunker($array, $char) {
		
		return explode($char, $array);
	}
	
}

?>