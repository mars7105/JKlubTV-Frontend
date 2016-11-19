<?php
$login = false;
if (isset ( $_POST ['login'] ) && ! empty ( $_POST ['username'] ) && ! empty ( $_POST ['password'] )) {
	
	if ($_POST ['username'] == 'testuser' && $_POST ['testpassword'] == 'qwertz12345') {
		
		$timeout = time ();
		$username = 'test';
		$login = true;
	} else {
		echo "Wrong Username or Password!";
		// das Programm normal beenden
		exit ();
	}
} else {
	echo "Wrong Username or Password!";
	// das Programm normal beenden
	exit ();
}
?>