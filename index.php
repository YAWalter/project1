<?php

/*
	Create an HTML form to upload a CSV file
		When the CSV file is uploaded, save it to AFS in /upload directory within your project
			Forward the user to a page using the "header" function (https://www.w3schools.com/PhP/func_http_header.asp)
		The new page displays the contents of the CSV file in an HTML table:  
			The HTML table should use the table head tag for the first row of the table and have the field names from the CSV file in this row.
*/

// # DEBUGGING
echo '<h1><br> *** TURN DEBUG OFF!! *** <br></h1><br>';
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// # AUTOLOADER
// # add classes by writing $class.php instead
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
		$pageRequest = 'homepage';
		if(isset($_REQUEST['page'])) {
			$pageRequest = $_REQUEST['page'];
		}
		
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
		$this->html .= '<html>';
		$this->html .= '<link rel="stylesheet" href="styles.css">';
		$this->html .= '<body>';
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

		$form = '<form action="index.php" method="post">';
		$form .= 'First name:<br>';
		$form .= '<input type="text" name="firstname" value="Mickey">';
		$form .= '<br>';
		$form .= 'Last name:<br>';
		$form .= '<input type="text" name="lastname" value="Mouse">';
		$form .= '<input type="submit" value="Submit">';
		$form .= '</form> ';
		$this->html .= 'homepage';
		$this->html .= $form;
	}

}

// index.php?page=testbuild
class testbuild extends page {

	public function get() {

		$csv = '1,2,3,4,5,6\n7,8,9,10,11,12\n13,14,15,16,17,18';
		$testarray = arrayTools::rowChunker($csv);
		print_r($testarray, true);
		$cells = array();
		foreach ($testarray as $line) {
			$cells[] = arrayTools::cellChunker($line);
			print_r($line, true);
		}
		$this->html .= htmlTable::tableBuild($cells);
	}

}

// index.php?page=homepage
class uploadForm extends page {

	public function get() {
		$form = '<form action="index.php?uploadForm" method="post">';
		$form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
		$form .= '<input type="submit" value="Upload Image" name="submit">';
		$form .= '</form> ';
		$this->html .= '<h1>Upload Form</h1>';
		$this->html .= $form;

    }

	public function post() {

		print_r($_FILES);
	}
}

// class for making usable arrays from CSV input (commas-and-whitespace-only strings)
class arrayTools extends page {
	
	public static function csvChunker($array) {
		$chunked = array();
		
		// INPUT FILE
		/* foreach (LINE_OF_INPUT as $line) {
			$row = arrayTools::rowChunker($line);
		} */
		
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

// class for building <tr>, <th>, and <td> sets
class htmlTable extends page {
	
	// The Big Kahuna; uses the below (in order, roughly) to build the table, with a header row
	public static function tableBuild($data) {

		$table = '';
		foreach ($data as $row => $columns) {
			$table .= htmlTable::rowBuild($row, $columns);
		}
		
		return '<table>' . $table . '</table>';
	}
	
	// builds a single row of the table from array (top row = <th>)
	public static function rowBuild($index, $cells) {
		
		$row = '';
		if ($index == 0) {
			$row = htmlTable::headBuild($cells);
		} else {
			$row = htmlTable::cellBuild($cells);
		}
		
		return '<tr>' . $row . '</tr>';
	}

	public static function headBuild($data) {
		
		$cells = '';
		foreach ($data as $header) {
			$cells .= '<th>' . $header . '</th>';
		}
		
		return $cells;
	}
	
	public static function cellBuild($data) {
		
		$cells = '';
		foreach ($data as $unit) {
			$cells .= '<td>' . $unit . '</td>';			
		}
		
		return $cells;
	}
}

?>