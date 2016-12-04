<?php
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
	
