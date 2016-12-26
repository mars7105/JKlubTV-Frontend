<?php
$login = false;
// include 'statusjson.php';
$status = new Statusjson ();
$phpmodul = 'checklogin.php';
if (isset ( $_POST ['login'] ) && ! empty ( $_POST ['username'] ) && ! empty ( $_POST ['password'] )) {
	
	if ($_POST ['username'] == 'test' && $_POST ['password'] == 'test') {
		
		$timeout = time ();
		$username = 'test';
		$login = true;
	} else {
		echo $status->sendStatusLoginError($phpmodul);
		// das Programm normal beenden
		exit ();
	}
} else {
	echo $status->sendStatusLoginError($phpmodul);
	// das Programm normal beenden
	exit ();
}
?>