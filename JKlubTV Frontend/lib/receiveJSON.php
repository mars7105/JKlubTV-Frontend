<?php
$login = false;
include 'statusjson.php';
$status = new Statusjson ();
include 'checklogin.php';
if ($login != true) {
	echo $status->sendStatusLoginError();
	// das Programm normal beenden
	exit ();
} else {
	if ((isset ( $_POST ))) {
		$string = $_POST ["json"];
		$jsonFileName = $_POST ["jsonFileName"];
		$file = htmlspecialchars ( '../temp/' . $jsonFileName );
		$bodytag = html_entity_decode ( $string, ENT_QUOTES );
		file_put_contents ( $file, $bodytag );
		
		echo $status->sendStatusOk ();
	} else {
		echo $status->sendStatusPostnotSetError ();
		exit ();
	}
}

?>