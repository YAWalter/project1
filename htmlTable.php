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
	private static function rowBuild($index, $cells) {
		
		return '<tr>' . htmlTable::cellBuild($index, $cells) . '</tr>';
	}

	private static function cellBuild($index, $data) {
		
		$cells = '';
		foreach ($data as $unit) {
			if ($index == 0) {
				$cells .= '<th>' . $unit . '</th>';
			} else {
				$cells .= '<td>' . $unit . '</td>';
			}				
		}
		
		return $cells;
	}
}

?>