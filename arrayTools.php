<?php

// class for making usable arrays from CSV input (comma/whitespace-only strings)
class arrayTools extends page {
	
	public static function csvChunker($csv) {
		$chunked = array();
		
		$rows = arrayTools::rowChunker($csv);
		foreach ($rows as $line) {
			$chunked[] = arrayTools::cellChunker($line);
		}
		
		return $chunked;
	}
	
	// splits a CSV into an array of rows
	public static function rowChunker($array) {
		
		return explode('\n', $array);
	}
	
	// splits one row into an array of cells
	public static function cellChunker($array) {
		
		return explode(',', $array);
	}
}

?>