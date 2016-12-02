<?php
$index = htmlentities ( strip_tags ( $_GET ['param'] ) );
if ($index >= 0 && $index < 20 && is_numeric ( $index )) {
	showGroupTable ( $index );
} else {
	showGroupTable ( 0 );
}
function showGroupTable($index) {
	// $configfile = "temp/contentfiles.json";
	$configfile = "temp/config.json";
	$handle = fopen ( $configfile, "r" );
	$json = fread ( $handle, filesize ( $configfile ) );
	fclose ( $handle );
	$jsonArray = json_decode ( $json, true );
	$jsonFiles = $jsonArray ['htmlfiles'] [0];
	
	// $jsonFiles = json_decode ( $json );
	
	$filename = $jsonFiles [$index];
	if (file_exists ( $filename )) {
		// liest den Inhalt einer Datei in einen String
		// $handle = fopen ( $filename, "r" );
		// $file = fread ( $handle, filesize ( $filename ) );
		// fclose ( $handle );
		include $filename;
	}
	
	// return $file;
}

?>
	
