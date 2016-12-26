<?php
class user_chesstables {
	function getContent() {
		$index = htmlentities ( strip_tags ( $_GET ['param'] ) );
		if ($index >= 0 && $index < 20 && is_numeric ( $index )) {
			$content = showGroupTable ( $index );
		} else {
			$content = showGroupTable ( 0 );
		}
		
		return $content;
	}
	function showGroupTable($index) {
		$configfile = "fileadmin/jklubtvfrontend/temp/menus.json";
		$handle = fopen ( $configfile, "r" );
		$json = fread ( $handle, filesize ( $configfile ) );
		fclose ( $handle );
		$result = json_decode ( $json, true );
		
		// $content = getHTMLFile ( $result ['begin'] [$index] );
		$content .= getHTMLFile ( $result ['tables'] [$index] );
		$content .= getHTMLFile ( $result ['navigation'] [$index] );
		// $content .= getHTMLFile ( $result ['sidebar'] [$index] );
		// $content .= getHTMLFile ( $result ['end'] [$index] );
		return $content;
	}
	function getHTMLFile($filename) {
		if (file_exists ( $filename )) {
			$handle = fopen ( $filename, "r" );
			$content = fread ( $handle, filesize ( $filename ) );
			fclose ( $handle );
			return $content;
		} else {
			return "";
		}
	}
}
?>