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
$login = false;
include 'statusjson.php';
include 'file.php';
$status = new Statusjson ();
include 'checklogin.php';
if ($login != true) {
	echo $status->sendStatusLoginError ();
	// das Programm normal beenden
	exit ();
} else {
	if (isset ( $_POST )) {
		$jsonFiles = html_entity_decode ( $_POST ["jsonFiles"], ENT_QUOTES );
		
		$jsonArray = json_decode ( $jsonFiles, true );
		$findFile = checkConfig ( $jsonArray );
		if ($findFile == true) {
			
			echo $status->sendStatusOk ();
		} else {
			mergeJson ( $jsonArray );
			echo $status->sendStatusOk ();
		}
	} else {
		echo $status->sendStatusPostnotSetError ();
		exit ();
	}
}
function mergeJson($jsonArray) {
	$file = new File ();
	$htmlfiles = $jsonArray ['htmlfiles'];
	$filename = $jsonArray ['filename'];
	
	$jsonArray2 = $file->getConfigJson ();
	
	$htmlfiles2 = $jsonArray2 ['htmlfiles'];
	$filename2 = $jsonArray2 ['filename'];
	if ($htmlfiles2 == null || $filename2 == null) {
		$result = $jsonArray;
	} else {
		$result ['filename'] = array_merge ( $filename, $filename2 );
		$result ['htmlfiles'] = array_merge ( $htmlfiles, $htmlfiles2 );
	}
	
	$file->writeConfigJson ( $result );
}
function checkConfig($jsonFiles) {
	$file = new File ();
	$jsonArray = $file->getConfigJson ();
	
	if ($jsonArray != null) {
		$htmlfiles = $jsonArray ['htmlfiles'];
		$filename = $jsonArray ['filename'];
		
		$key = array_search ( $jsonFiles ['filename'] [0], $filename );
		if (false === $key) {
			return false;
		} else {
			return true;
		}
	} else {
		$file->writeConfigJson ( $jsonFiles );
		return true;
	}
}

?>