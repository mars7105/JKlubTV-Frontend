<?php
session_start ();
if (! $_SESSION ["myusername"]) {
	header ( "location:info.php" );
}
if (! empty ( $_POST )) {
	
	$string = $_POST ["json"];
	$jsonFileName = $_POST ["jsonFileName"];
	$menuName = $_POST ["menuName"];
	$configFlag = $_POST ["configFlag"];
	$file = htmlspecialchars ( 'jsonFiles/' . $jsonFileName );
	$bodytag = html_entity_decode ( $string, ENT_QUOTES );
	file_put_contents ( $file, $bodytag );
	
	echo "Ok";
} else {
	echo "ERROR";
}

?>
