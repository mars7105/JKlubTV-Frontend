<?php
session_start ();
if (empty ( $_SESSION ["username"] )) {
	header ( "location:info.php" );
}
if (isset ( $_POST )) {
	
	$test = $_POST ["test"];
	$cmp = "true";
	if (strcmp ( $test, $cmp ) == 0) {
		echo "Ok";
	} else {
		echo "POST is wrong";
		session_destroy ();
	}
} else {
	echo "POST is not set";
	session_destroy ();
}
?>