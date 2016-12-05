<?php
// JKlubTV - Ein Programm zum verwalten von Schach Turnieren
// Copyright (C) 2015 Martin Schmuck m_schmuck@gmx.net
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program. If not, see <http://www.gnu.org/licenses/>.
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