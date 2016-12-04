<?php
class File {
	public function getHTMLStart() {
		$filename = "html/htmlstart.html";
		$handle = fopen ( $filename, "r" );
		$htmlstart = fread ( $handle, filesize ( $filename ) );
		fclose ( $handle );
		return $htmlstart;
	}
	public function getHTMLEnd() {
		$filename = "html/htmlend.html";
		$handle = fopen ( $filename, "r" );
		$htmlend = fread ( $handle, filesize ( $filename ) );
		fclose ( $handle );
		return $htmlend;
	}
	public function getConfigJson() {
		$configJSON = '../temp/config.json';
		$handle = fopen ( $configJSON, "r" );
		$json = fread ( $handle, filesize ( $configJSON ) );
		fclose ( $handle );
		$jsonFiles = json_decode ( $json, true );
		return $jsonFiles;
	}
	public function getJson($filename) {
		// liest den Inhalt einer Datei in einen String
		$handle = fopen ( $filename, "r" );
		$json = fread ( $handle, filesize ( $filename ) );
		fclose ( $handle );
		$data = json_decode ( $json, true );
		return $data;
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
}

?>
