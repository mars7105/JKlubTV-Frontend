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
class File {
	public function getHTMLStart() {
		$filename = "html/htmlstart.html";
		if (file_exists ( $filename )) {
			$handle = fopen ( $filename, "r" );
			$htmlstart = fread ( $handle, filesize ( $filename ) );
			fclose ( $handle );
			return $htmlstart;
		} else {
			
			return "";
		}
	}
	public function getHTMLEnd() {
		$filename = "html/htmlend.html";
		if (file_exists ( $filename )) {
			$handle = fopen ( $filename, "r" );
			$htmlend = fread ( $handle, filesize ( $filename ) );
			fclose ( $handle );
			return $htmlend;
		} else {
			return "";
		}
	}
	public function getHTMLFile($filename) {
		if (file_exists ( $filename )) {
			$handle = fopen ( $filename, "r" );
			$content = fread ( $handle, filesize ( $filename ) );
			fclose ( $handle );
			return $content;
		} else {
			return "";
		}
	}
	public function getConfigJson() {
		$configJSON = '../temp/config.json';
		if (file_exists ( $configJSON )) {
			$handle = fopen ( $configJSON, "r" );
			$json = fread ( $handle, filesize ( $configJSON ) );
			fclose ( $handle );
			$jsonFiles = json_decode ( $json, true );
			return $jsonFiles;
		} else {
			
			return null;
		}
	}
	public function getMenuJson() {
		$configJSON = '../temp/menus.json';
		if (file_exists ( $configJSON )) {
			$handle = fopen ( $configJSON, "r" );
			$json = fread ( $handle, filesize ( $configJSON ) );
			fclose ( $handle );
			$jsonFiles = json_decode ( $json, true );
			return $jsonFiles;
		} else {
			return null;
		}
	}
	public function getJson($filename) {
		if (file_exists ( $filename )) {
			
			// liest den Inhalt einer Datei in einen String
			$handle = fopen ( $filename, "r" );
			$json = fread ( $handle, filesize ( $filename ) );
			fclose ( $handle );
			$data = json_decode ( $json, true );
			return $data;
		} else {
			return null;
		}
	}
	public function writeMenuJson($result) {
		$menufile = '../temp/menus.json';
		$resultjson = json_encode ( $result, JSON_UNESCAPED_SLASHES );
		file_put_contents ( $menufile, $resultjson );
	}
	public function writeHTMLFile($filename, $content) {
		$file = '../' . $filename;
		file_put_contents ( $file, $content );
	}
	public function writeConfigJson($result) {
		$configfile = "../temp/config.json";
		$resultjson = json_encode ( $result, JSON_UNESCAPED_SLASHES );
		file_put_contents ( $configfile, $resultjson );
	}
}

?>
