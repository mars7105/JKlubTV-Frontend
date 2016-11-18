<?php
include 'checklogin.php';
if ($login != true) {
	echo "Wrong Username or Password!";
} else {
	if ((isset ( $_POST ))) {
		$string = $_POST ["json"];
		$jsonFileName = $_POST ["jsonFileName"];
		$menuName = $_POST ["menuName"];
		$file = htmlspecialchars ( '../jsonFiles/' . $jsonFileName );
		$bodytag = html_entity_decode ( $string, ENT_QUOTES );
		file_put_contents ( $file, $bodytag );
		
		echo "Ok";
	} else {
		echo "POST is not set";
	}
}
?>