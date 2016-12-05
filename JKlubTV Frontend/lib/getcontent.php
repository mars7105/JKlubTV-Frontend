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
$index = htmlentities ( strip_tags ( $_GET ['param'] ) );
if ($index >= 0 && $index < 20 && is_numeric ( $index )) {
	showGroupTable ( $index );
} else {
	showGroupTable ( 0 );
}
function showGroupTable($index) {
	$configfile = "temp/menus.json";
	$handle = fopen ( $configfile, "r" );
	$json = fread ( $handle, filesize ( $configfile ) );
	fclose ( $handle );
	$jsonArray = json_decode ( $json, true );
	
	$filename = $jsonArray [$index];
	if (file_exists ( $filename )) {
		// include $filename;
		$handle = fopen ( $filename, "r" );
		$content = fread ( $handle, filesize ( $filename ) );
		fclose ( $handle );
		echo $content;
	}
}

?>
	
