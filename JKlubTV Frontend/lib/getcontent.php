<?php
$index = htmlentities ( strip_tags ( $_GET ['param'] ) );
if ($index >= 0 && $index < 20 && is_numeric ( $index )) {
	echo showGroupTable ( $index );
} else {
	echo showGroupTable ( 0 );
}

function showGroupTable($index) {
	$configfile = "jsonFiles/contentfiles.json";
	$handle = fopen ( $configfile, "r" );
	$json = fread ( $handle, filesize ( $configfile ) );
	fclose ( $handle );
	$jsonFiles = json_decode ( $json );
	
	$filename = $jsonFiles [$index];
	if (file_exists ( $filename )) {
		// liest den Inhalt einer Datei in einen String
		$handle = fopen ( $filename, "r" );
		$file = fread ( $handle, filesize ( $filename ) );
		fclose ( $handle );
	}
	
	return $file;
}

?>
	
