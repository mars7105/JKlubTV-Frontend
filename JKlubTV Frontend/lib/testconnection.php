<?php
$login = false;
include 'statusjson.php';
$status = new Statusjson ();
include 'checklogin.php';
if ($login != true) {
	echo $status->sendStatusLoginError ();
	// das Programm normal beenden
	exit ();
} else {
	
	if ((isset ( $_POST ))) {
		
		$test = htmlspecialchars ( $_POST ["test"] );
		$cmp = "true";
		if (strcmp ( $test, $cmp ) == 0) {
			
			echo $status->sendStatusOk ();
		} else {
			
			echo $status->sendStatusPostWrongError ();
			exit ();
		}
	} else {
		
		echo $status->sendStatusPostnotSetError ();
		exit ();
	}
}
?>