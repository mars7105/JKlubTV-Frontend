<?php
$login = false;
include 'checklogin.php';
if ($login != true) {
	echo "Wrong Username or Password!";
	// das Programm normal beenden
	exit ();
} else {
	if ((isset ( $_POST ))) {
		$string = $_POST ["json"];
		$jsonFileName = $_POST ["jsonFileName"];
		$file = htmlspecialchars ( '../temp/' . $jsonFileName );
		$bodytag = html_entity_decode ( $string, ENT_QUOTES );
		file_put_contents ( $file, $bodytag );
		
		echo "Ok";
	} else {
		echo "POST is not set";
		exit ();
	}
}
// function createHash($string) {
// 	$hash = hash ( 'sha256', $string );
// 	return $hash;
// }
?>