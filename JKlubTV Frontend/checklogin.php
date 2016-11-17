<?php
ob_start ();
session_start ();

if (isset ( $_POST ['login'] ) && ! empty ( $_POST ['username'] ) && ! empty ( $_POST ['password'] )) {
	
	if ($_POST ['username'] == 'test' && $_POST ['password'] == 'test') {
		$_SESSION ['valid'] = true;
		$_SESSION ['timeout'] = time ();
		$_SESSION ['username'] = 'test';
		
		echo 'Login';
	} else {
		echo 'Wrong username or password';
	}
}
ob_flush ();
?>