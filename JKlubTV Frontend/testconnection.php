<?php
session_start ();
ob_start ();

if (! $_SESSION ["myusername"]) {
	header ( "location:info.php" );
}
if (! empty ( $_POST )) {
	
	$test = $_POST ["test"];
	
	if (strcmp ( $test, "true" ) == 0) {
		echo "Test Ok";
	} else {
		echo "Test Error";
	}
} else {
	echo "ERROR";
}
ob_end_flush ();
