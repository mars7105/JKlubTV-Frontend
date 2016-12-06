<?php
//JKlubTV - Ein Programm zum verwalten von Schach Turnieren
//Copyright (C) 2015  Martin Schmuck m_schmuck@gmx.net
//
//This program is free software: you can redistribute it and/or modify
//it under the terms of the GNU General Public License as published by
//the Free Software Foundation, either version 3 of the License, or
//(at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.
//
//You should have received a copy of the GNU General Public License
//along with this program.  If not, see <http://www.gnu.org/licenses/>.

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