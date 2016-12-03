<?php
$login = false;
include 'checklogin.php';
if ($login != true) {
	echo "Wrong Username or Password!";
	// das Programm normal beenden
	exit ();
} else {
	if ((isset ( $_POST ))) {
		$jsonFiles = html_entity_decode ( htmlspecialchars ( $_POST ["jsonFiles"] ), ENT_QUOTES );
		$findFile = checkConfig ( $jsonFiles );
		if ($findFile) {
			
		} else {
			$jsonArray = json_decode ( $jsonFiles, true );
			$htmlfiles = $jsonArray ['htmlfiles'];
			$filename = $jsonArray ['filename'];
			
			$configfile = '../temp/config.json';
			$handle = fopen ( $configfile, "r" );
			$json = fread ( $handle, filesize ( $configfile ) );
			fclose ( $handle );
			$jsonArray2 = json_decode ( $json, true );
			
			$htmlfiles2 = $jsonArray2 ['htmlfiles'];
			$filename2 = $jsonArray2 ['filename'];
			if ($htmlfiles2 == null || $filename2 == null) {
				$resultjson = $jsonFiles;
			} else {
				$result ['filename'] = array_merge ( $filename, $filename2 );
				$result ['htmlfiles'] = array_merge ( $htmlfiles, $htmlfiles2 );
				
				$resultjson = json_encode ( $result, JSON_UNESCAPED_SLASHES );
			}
			saveConfig ( $resultjson );
		}
		echo "Ok";
	} else {
		echo "POST is not set";
		exit ();
	}
}
function saveConfig($jsonFiles) {
	$configfile = "../temp/config.json";
	
	file_put_contents ( $configfile, $jsonFiles );
	
	
}
function checkConfig($jsonFiles) {
	$configfile = '../temp/config.json';
	if (file_exists ( $configfile )) {
		$handle = fopen ( $configfile, "r" );
		$json = fread ( $handle, filesize ( $configfile ) );
		fclose ( $handle );
		$jsonArray = json_decode ( $json, true );
		
		$htmlfiles = $jsonArray ['htmlfiles'];
		$filename = $jsonArray ['filename'];
		$jsonFilesArray = json_decode ( $jsonFiles, true );
		// $searchArray = $jsonFilesArray ['filename'];
		$key = array_search ( $jsonFilesArray ['filename'] [0], $filename );
// 		echo $key;
		if (false !== $key) {
			return true;
		} else {
			return false;
		}
	} else {
		saveConfig ( $jsonFiles );
		return true;
	}
}
?>