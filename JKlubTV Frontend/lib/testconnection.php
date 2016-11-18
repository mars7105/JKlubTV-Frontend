<?php
include 'checklogin.php';
if ($login != true) {
	echo "Wrong Username or Password!";
} else {
	if ((isset ( $_POST ))) {
		$test = $_POST ["test"];
		$cmp = "true";
		if (strcmp ( $test, $cmp ) == 0) {
			echo "Ok";
		} else {
			echo "POST is wrong";
		}
	} else {
		echo "POST is not set";
	}
}
?>