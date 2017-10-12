<?php

// # DEBUGGING
// echo '<h1><br> *** TURN DEBUG OFF!! *** <br></h1><br>';
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);

// # AUTOLOADER
// # add classes by writing [$class].php instead
class Manage {
	public static function autoload($class) {
		include $class . '.php';
	}
}
spl_autoload_register(array('Manage', 'autoload'));

// # INSTANTIATE PROGRAM OBJECT
$obj = new main();

class main {
	
	private $html;

	public function __construct() {
		
		// get the 'page' param (default = 'homepage')
		$pageRequest = pageBuild::getName();
		
		$page = new $pageRequest;

		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$page->get();
		} else {
			$page->post();
		}
	}
	
	public function __destruct() {
			echo '<hr>';
	}
}

// a page has no name...
abstract class page {
	protected $html;

	public function __construct() {
		$this->html = pageBuild::PageHeader();
	}
    
	public function __destruct() {
		$this->html .= pageBuild::pageEnder();
		echo $this->html;
	}

	public function get() {
		echo 'default get message';
	}

	public function post() {
		//print_r($_POST);
	}
}

// index.php?page=homepage
class homepage extends page {
	public function get() {
		$this->html .= htmlForm::formBuild();
	}
	
	public function post() {
		// some environment variables
		$name = $_FILES['fileToUpload']['name'];
		$tmp_name = $_FILES['fileToUpload']['tmp_name'];
		$filedata = pageBuild::filepath();
		$resource = $filedata['upload'] . $name;
		
		if ($name) {
			//$this->html .= 'uploading file to: ' . $resource;
			//$this->html .= htmlTags::lineBreak();
			if (move_uploaded_file($tmp_name, $resource)) {
				$this->html .= 'SUCCESS';
			} else {
				$this->html .= 'FAILURE ' . $_FILES['fileToUpload']['error'];
			}
		}
			
		// set the header redirect
		header(pageBuild::redirect('CSVdisplay', $name));
		
		// print error message, because you should be gone by now...
		$this->html .= htmlTags::heading('WHY ARE YOU HERE?!');
	}
}

// index.php?page=CSVdisplay
class CSVdisplay extends page {
	public function get() {
		$file = pageBuild::filepath();
		
		// if there's a file, parse it
		$csv = ($file['name'] != NULL) ? 
			parser::fileToCsv($file['path']) :
			array();
		// debug
		// $this->html .= htmlTags::pre(print_r($csv, true));
		
		$this->html .= pageBuild::filename($file['name']);
		$this->html .= htmlTable::tableBuild($csv);
	}
}

// class for building the form
class htmlForm extends page {
	public static function formBuild() {
		$form  = htmlTags::heading('Upload CSV File:');		
		$form .= '<form action="index.php?page=homepage" method="post" enctype="multipart/form-data">';
		$form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
		$form .= '<input type="submit" value="Upload CSV" name="submit">';
		$form .= '</form> ';
		
		return $form;
	}		
}

// read the given file through the parser until EOF
class parser extends page {
	public static function fileToCsv($path) {
		$csv = array();
		
		$file = fopen($path, "r") or die("Unable to open file!");
		$csv = textParse::arrayMaker($file);
		fclose($file);
		
		return $csv;
	}
}

/*
	Create an HTML form to upload a CSV file:
		-When the CSV file is uploaded:
			-Save it to AFS in /upload directory within your project
			-Forward the user to a page using the "header" function
		-The new page displays the contents of the CSV file in an HTML table:  
			-use the <th> tag for the first row of the table and have the field names from the CSV file in this row.
*/

?>