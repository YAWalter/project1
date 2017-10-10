<?php

// # DEBUGGING
echo '<h1><br> *** TURN DEBUG OFF!! *** <br></h1><br>';
ini_set('display_errors', 'On');
error_reporting(E_ALL);

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
			echo $this->html;
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
		$this->html .= pageBuild:pageEnder();
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
		// post() should (validate file&) place the file in the folder	

		
/*
	COMMENTED BECAUSE I'VE JUST COPIED/PASTED...

		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
			   echo "File is an image - " . $check["mime"] . ".";
			   $uploadOk = 1;
		    } else {
			   echo "File is not an image.";
			   $uploadOk = 0;
		    }
		}

		
	COMMENTED BECAUSE I'VE JUST COPIED/PASTED...
*/
		
		// set redirect for header
		header("Location: index.php?page=CSVdisplay");
		
		// print error message, because you should be gone by now...
		$this->html .= htmlTags::heading('WHY ARE YOU HERE?!');
	}
}

// index.php?page=CSVdisplay
class CSVdisplay extends page {
	public function get() {
		
		// test data
		$testcsv = '1,2,3,4,5,6\n7,8,9,10,11,12\n13,14,15,16,17,18';

		$upload = './uploads/';
		$csv = array();
/*
refer to: https://www.w3schools.com/php/php_file_open.asp
*/
		// if there's a filename param, process the file
		$file = pageBuild::getFile();
		$filepath = $upload . $file;
		if (!is_null($file)) {
			$file = fopen($filepath, "r") or die("Unable to open file!");
			$csv = fread($file, filesize("$filepath"));
		
			$this->html .= '<hr><pre>' . print($csv) . '</pre>';
		
			fclose($file);
		}
		
		// format the data output
		$table = arrayTools::csvChunker($csv);
		
		// debug
		$this->html .= '<hr><pre>' . print_r($table, true) . '</pre>';
		
		$this->html .= htmlTable::tableBuild($table);
	}
}

// class for building forms
class htmlForm extends page {
	public static function formBuild() {
		$form = htmlTags::heading('Upload CSV File:');
		$form .= '<form action="index.php?page=homepage" method="post" enctype="multipart/form-data">';
		$form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
		$form .= '<input type="submit" value="Upload CSV" name="submit">';
		$form .= '</form> ';
		
		return $form;
	}
		
}

/*
	Create an HTML form to upload a CSV file
		-When the CSV file is uploaded:
			-Save it to AFS in /upload directory within your project
			-Forward the user to a page using the "header" function (https://www.w3schools.com/PhP/func_http_header.asp)
		-The new page displays the contents of the CSV file in an HTML table:  
			-use the <th> tag for the first row of the table and have the field names from the CSV file in this row.
*/

?>