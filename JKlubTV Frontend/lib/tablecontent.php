<?php
class TableContent {
	public function createTable($table, $header, $tabletext, $color, $tableheader) {
		$wrapper = new Wrap ();
		$allowable_tags = allowTags ();
		$tempTable = '';
		$tempTable .= '<table class="table table-bordered well">' . "\n";
		$counter = 0;
		foreach ( $table as $jsons ) {
			$tempTable .= '  <tr>' . "\n";
			
			foreach ( $jsons as $key => $rvalue ) {
				if ($counter == 0) {
					$tempTable .= '    <th class="alert-warning">' . strip_tags ( $rvalue, $allowable_tags ) . '</th>' . "\n";
				} else {
					$tempTable .= '    <td>' . strip_tags ( $rvalue, $allowable_tags ) . '</td>' . "\n";
				}
			}
			$tempTable .= '  </tr>' . "\n";
			$counter ++;
		}
		$tempTable .= '</table>' . "\n";
		$crossHeader = strip_tags ( $header, $allowable_tags );
		$crossTableText = strip_tags ( $tabletext, $allowable_tags );
		if (strcmp ( $crossHeader, "" ) != 0) {
			$tempTable .= $wrapper->wrapContent ( $crossHeader, $crossTableText, $color );
		}
		$content = $wrapper->wrapContent ( $tableheader, $tempTable, $color );
		
		return $content;
	}
	public function allowTags() {
		return "<p><br><br/><br />";
	}
}

?>