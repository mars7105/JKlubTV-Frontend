<?php
$login = false;
include 'statusjson.php';
include 'file.php';
$status = new Statusjson ();
include 'checklogin.php';
if ($login != true) {
	echo $status->sendStatusLoginError();
	// das Programm normal beenden
	exit ();
} else {
	if (isset ( $_POST )) {
		$jsonFiles = html_entity_decode ( $_POST ["jsonFiles"], ENT_QUOTES );
		
		$jsonArray = json_decode ( $jsonFiles, true );
		$findFile = checkConfig ( $jsonArray );
		if ($findFile == true) {
			
			echo $status->sendStatusOk ();
		} else {
			mergeJson ( $jsonArray );
			echo $status->sendStatusOk ();
		}
	} else {
		echo $status->sendStatusPostnotSetError ();
		exit ();
	}
}
function mergeJson($jsonArray) {
	$file = new File ();
	$htmlfiles = $jsonArray ['htmlfiles'];
	$filename = $jsonArray ['filename'];
	
	$jsonArray2 = $file->getConfigJson ();
	
	$htmlfiles2 = $jsonArray2 ['htmlfiles'];
	$filename2 = $jsonArray2 ['filename'];
	if ($htmlfiles2 == null || $filename2 == null) {
		$result = $jsonArray;
	} else {
		$result ['filename'] = array_merge ( $filename, $filename2 );
		$result ['htmlfiles'] = array_merge ( $htmlfiles, $htmlfiles2 );
	}
	
	$file->writeConfigJson ( $result );
}
function checkConfig($jsonFiles) {
	$file = new File ();
	$jsonArray = $file->getConfigJson ();
	
	if ($jsonArray != null) {
		$htmlfiles = $jsonArray ['htmlfiles'];
		$filename = $jsonArray ['filename'];
		
		$key = array_search ( $jsonFiles ['filename'] [0], $filename );
		if (false === $key) {
			return false;
		} else {
			return true;
		}
	} else {
		$file->writeConfigJson ( $jsonFiles );
		return true;
	}
}

?>