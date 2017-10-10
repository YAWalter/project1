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
		$this->html = pageBuild::PageHeader();
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
		// post() should (validate file&) place the file in the folder
		// call redirect from header
		header("Location: https://web.njit.edu/~yw674/project1/index.php?page=CSVdisplay");
		
		$this->html .= print_r($_FILES, true);
	}
}

// // index.php?page=CSVdisplay
class CSVdisplay extends page {
	public function get() {
		// gets filename from index.php?file=$file
		$csv = '1,2,3,4,5,6\n7,8,9,10,11,12\n13,14,15,16,17,18';
		$formData = arrayTools::csvChunker($csv);
	}
}

// class for page tools
class pageBuild extends page {
	
	public static function pageHeader() {
		$name = pageBuild::getName();	// helpful to have this locally
		
		$head  = '<html><head>';
		$head .= '<link rel ="stylesheet" href="styles.css">';
		$head .= pageBuild::makeTitle($name);
		$head .= '</head><body>';
		$head .= pageBuild::heading($name);
		
		return $head; 
	}
	
	public static function makeTitle($page) {			
		return '<title>' . ucwords($page) . '</title>';
	}

	public static function getName() {
		$page = 'homepage';
		if(isset($_REQUEST['page']))
			$page = $_REQUEST['page'];
		
		return $page;
	}

	public static function heading($str) {
		return '<h1>' . $str . '</h1>';
	}
}

// class for building forms
class htmlForm extends page {
	public static function formBuild() {
		$form = pageBuild::heading('Upload CSV File:');
		$form .= '<form action="index.php?page=homepage" method="post">';
		$form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
		$form .= '<input type="submit" value="Upload CSV" name="submit">';
		$form .= '</form> ';
		
		return $form;
	}
		
}

?>