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
	$keyindex = 0;
	foreach ( $jsonArray ['htmlfiles'] as $key ) {
		for($i = 0; $i < count ( $key ); $i ++) {
			$jsonFiles [$keyindex] = $key [$i];
			$keyindex ++;
		}
		
// 		$file = '../' . $htmlfiles [$countindex] [$i];
	}
	
	$filename = $jsonFiles [$index];
	if (file_exists ( $filename )) {
		
		include $filename;
	}
}

?>
	
