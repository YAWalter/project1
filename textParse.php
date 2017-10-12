<?php

// class for cleaning up text from CSV input
class textParse extends page {
	
	public static function arrayMaker($handle) {
		$clean = array();
		do {
			$raw = fgetcsv($handle);
			// only valid lines get processed
			if (!empty($raw)) {
				$val = textParse::dropEmpty($raw);
				// blank lines get skipped
				if (array_filter($val) != array()) {
					$clean[] = $val;
				}
			}
		} while ($raw != NULL);
		
		return $clean;
	}
	
	private static function dropEmpty($arr) {
		// removes empty space in elements
		$clean = array();
		foreach ($arr as $raw) {
			$clean[] = rtrim(ltrim($raw));
		}
		
		return $clean;
	}
}

?>