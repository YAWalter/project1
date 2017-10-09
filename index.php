<?php

/*
	Create an HTML form to upload a CSV file
		-When the CSV file is uploaded:
			-Save it to AFS in /upload directory within your project
			-Forward the user to a page using the "header" function (https://www.w3schools.com/PhP/func_http_header.asp)
		-The new page displays the contents of the CSV file in an HTML table:  
			-use the <th> tag for the first row of the table and have the field names from the CSV file in this row.
*/

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
		$this->html .= '<html><head>';
		$this->html .= '<link rel="stylesheet" href="styles.css">';
		$this->html .= pageBuild::makeTitle();
		$this->html .= '</head><body>';
	}
    
	public function __destruct() {
		$this->html .= '</body></html>';
		echo $this->html;
	}

	public function get() {
		echo 'default get message';
	}

	public function post() {
		print_r($_POST);
	}
}

// index.php?page=homepage
class homepage extends page {

	public function get() {
		
		$this->html .= htmlForm::formBuild();
		
	}
	
	public function post() {
		
		$csv = '1,2,3,4,5,6\n7,8,9,10,11,12\n13,14,15,16,17,18';
		$formData = arrayTools::csvChunker($csv);
		$form = htmlTable::tableBuild($formData);
		$this->html .= $form;
		
		$this->html .= print_r($_FILES, true);
	}
}

// class for page tools
class pageBuild extends page {
	
	public static function getName() {
		$page = 'homepage';
		if(isset($_REQUEST['page']))
			$page = $_REQUEST['page'];
		
		return $page;
	}
	
	public static function makeTitle() {
		$page = pageBuild::getName();
			
		return '<title>' . ucwords($page) . '</title>';
	}
}

// class for building forms
class htmlForm extends page {
	public static function formBuild() {
		$form = '<h1>Upload CSV File:</h1>';
		$form .= '<form action="index.php?uploadForm" method="post">';
		$form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
		$form .= '<input type="submit" value="Upload CSV" name="submit">';
		$form .= '</form> ';
		
		return $form;
	}
}

?>