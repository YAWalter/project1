<?php

// class for page tools
class pageBuild extends page {
	
	// adds "top matter": html, head, CSS, title, body and a page heading
	public static function pageHeader() {
		$name = pageBuild::getName();
		
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
		
		return $file;
	}
	
	public static function filename($name) {
		if ($name) {
			$output = htmlTags::heading('File: ' . $name);
		} else {
			$output = htmlTags::heading('<i>No File</i>');
		}
		
		return $output;
	}
	
	public static function filepath() {
		$upload = 'uploads/';
		$name = pageBuild::getFile();
		$path = $upload . $name;
		$filedata = array(
			'upload'=>$upload, 
			'name'  =>$name, 
			'path'  =>$path
		);
		
		return $filedata;
	}
	
	public static function redirect($page, $file) {
		return 'Location: index.php?page=' . $page . '&file=' . $file;
	}
	
	public static function pageEnder() {
		return '</body></html>';
	}

}

?>