<?php

// class for page tools
class pageBuild extends page {
	
	// adds "top matter": html, head, CSS, title, body and a page heading
	public static function pageHeader() {
	
		// helpful to have these locally
		$name = pageBuild::getName();
		//$file = pageBuild::getFile();
		
		$head  = '<html><head>';
		$head .= '<link rel ="stylesheet" href="styles.css">';
		$head .= htmlTags::makeTitle($name);
		$head .= '</head><body>';
		$head .= htmlTags::heading($name);
		
		return $head; 
	}

	public static function getName() {
		$page = 'homepage';
		if(isset($_REQUEST['page']))
			$page = $_REQUEST['page'];
		
		return ucwords($page);
	}
	
	public static function getFile() {
		$file = NULL;
		if(isset($_REQUEST['file'])) {
			$file = $_REQUEST['file'];
		}
		
		echo "file: $file \n";
		return $file;
	}
	
	public static function pageEnder() {
		return '</body></html>';
	}

}

?>