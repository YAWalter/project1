<?php

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
			if ($header != '') {
				$cells .= '<th>' . $header . '</th>';
			} else {
				continue;
			}
		}
		
		return $cells;
	}
	
	public static function cellBuild($data) {
		
		$cells = '';
		foreach ($data as $unit) {
			if ($unit != '') {
				$cells .= '<td>' . $unit . '</td>';			
			} else {
				continue;
			}
		}
		
		return $cells;
	}
	
}

?>