<?php
// include 'tablecontent.php';

class Crosstablemodul {
	public function createTable($data,$i) {
		// CROSSTABLE
		$tableContent = new TableContent ();
		$crosstable = $data ["crossTable"] [$i];
		$crossTableColor = $data ["crossTableColor"];
		$crossHeader = strip_tags ( $data ["crossHeader"] [$i], $allowable_tags );
		$crossTableText = strip_tags ( $data ["crossTableText"] [$i], $allowable_tags );
		$crossH1 = strip_tags ( $data ["jsonCrossTitle"], $allowable_tags );
		$cTable = $tableContent->createTable ( $crosstable, $crossHeader, $crossTableText, $crossTableColor [$i], $crossH1 );
		return $cTable;
	}
}
?>