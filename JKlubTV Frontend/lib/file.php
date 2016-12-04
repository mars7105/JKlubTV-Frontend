<?php
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
