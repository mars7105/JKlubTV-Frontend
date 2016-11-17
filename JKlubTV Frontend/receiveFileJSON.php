<?php
session_start ();
if (empty ( $_SESSION ["username"] )) {
	header ( "location:info.php" );
}
if (isset ( $_POST )) {
	$configfile = "config.json";
	$string = htmlspecialchars ( $_POST ["jsonFiles"] );
	$bodytag = html_entity_decode ( $string, ENT_QUOTES );
	
	file_put_contents ( $configfile, $bodytag );
	echo "Ok";
} else {
	echo "ERROR";
	session_destroy ();
}
?>