<?php

class htmlTags {	

	public static function makeTitle($str) {			
		return '<title>' . $str . '</title>';
	}
	
	public static function heading($str) {
		return '<h1>' . $str . '</h1>';
	}

}
?>
