<?php
if (! empty ( $_POST )) {
	$configfile = "config.json";
	$string = $_POST ["jsonFiles"];
	$bodytag = html_entity_decode ( $string, ENT_QUOTES );
	
	file_put_contents ( $configfile, $bodytag );
	echo "Ok";
} else {
	echo "ERROR";
}
?>