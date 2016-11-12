<?php
if (! empty ( $_POST )) {
	
	$string = $_POST ["json"];
	$jsonFileName = $_POST ["jsonFileName"];
	$menuName = $_POST ["menuName"];
	$configFlag = $_POST ["configFlag"];
	
	$file = htmlspecialchars ( 'jsonFiles/' . $jsonFileName );
	$bodytag = html_entity_decode ( $string, ENT_QUOTES );
	file_put_contents ( $file, $bodytag );
	// $script .= ' $jsonFiles[] = "' . $file . '";' . "\n";
	
	// file_put_contents ( $configfile, $script, FILE_APPEND );
	
	echo "Ok";
}

?>
