<?php
if (! empty ( $_POST )) {
	
	$string = $_POST ["json"];
	$jsonFileName = $_POST ["jsonFileName"];
	$menuName = $_POST ["menuName"];
	$configFlag = $_POST ["configFlag"];
	$test = $_POST ["test"];
	$file = htmlspecialchars ( 'jsonFiles/' . $jsonFileName );
	$bodytag = html_entity_decode ( $string, ENT_QUOTES );
	file_put_contents ( $file, $bodytag );
	// $script .= ' $jsonFiles[] = "' . $file . '";' . "\n";
	
	// file_put_contents ( $configfile, $script, FILE_APPEND );
	if (strcmp ( $test, "true" ) == 0) {
		echo "Test Ok";
	} else {
		echo "Ok";
	}
} else {
	echo "ERROR";
}

?>
