<?php
$login = false;
if (isset ( $_POST ['login'] ) && ! empty ( $_POST ['username'] ) && ! empty ( $_POST ['password'] )) {
	
	if ($_POST ['username'] == 'test' && $_POST ['password'] == 'test') {
		
		$timeout = time ();
		$username = 'test';
		$login = true;
	}
}
?>