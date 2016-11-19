<?php
$login = false;
include 'checklogin.php';
if ($login != true) {
	echo "Wrong Username or Password!";
	// das Programm normal beenden
	exit;
} else {
	if ((isset ( $_POST ))) {
		$test = htmlspecialchars ( $_POST ["test"] );
		$cmp = "true";
		if (strcmp ( $test, $cmp ) == 0) {
			echo "Ok";
		} else {
			echo "POST is wrong";
			exit;
		}
	} else {
		echo "POST is not set";
		exit;
	}
}
?>