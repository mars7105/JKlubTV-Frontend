<?php
$login = false;
include 'checklogin.php';
if ($login != true) {
	echo "Wrong Username or Password!";
	// das Programm normal beenden
	exit;
} else {
	if ((isset ( $_POST ))) {
		$configfile = "../jsonFiles/config.json";
		$string = htmlspecialchars ( $_POST ["jsonFiles"] );
		$bodytag = html_entity_decode ( $string, ENT_QUOTES );
		
		file_put_contents ( $configfile, $bodytag );
		echo "Ok";
	} else {
		echo "POST is not set";
		exit;
	}
}
?>