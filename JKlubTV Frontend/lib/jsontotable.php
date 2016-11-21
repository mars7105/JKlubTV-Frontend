<?php
include 'wrap.php';
$login = false;
include 'checklogin.php';
if ($login != true) {
	echo "Wrong Username or Password!";
	// das Programm normal beenden
	exit ();
} else {
	if (isset ( $_POST )) {
		
		createHTMLTables ();
		echo "Ok";
	} else {
		echo "POST is not set";
	}
}
function createHTMLTables() {
	$allowable_tags = allowTags ();
	// $timeStampFilename = '../tables/timestamp.json';
	// $timeStamp = "0";
	// if (file_exists ( $timeStampFilename )) {
	// $timeStamphandle = fopen ( $timeStampFilename, "r" );
	
	// $timeStampjson = htmlspecialchars ( fread ( $timeStamphandle, filesize ( $timeStampFilename ) ) );
	// fclose ( $handle );
	// $timeStamp = json_decode ( $timeStampjson, true );
	// }
	$wrapper = new Wrap ();
	$configJSON = '../config.json';
	$handle = fopen ( $configJSON, "r" );
	$json = fread ( $handle, filesize ( $configJSON ) );
	fclose ( $handle );
	$jsonFiles = json_decode ( $json, true );
	// echo $jsonFiles ['filename'] . " " . count ( $jsonFiles ['filename'] ) . " " . "/n";
	
	$content = '';
	$menuLinks = '';
	$filename = '../' . $jsonFiles ['filename'];
	// foreach ( $filenames as $filename ) {
	
	if (file_exists ( $filename )) {
		// echo $filename;
		// liest den Inhalt einer Datei in einen String
		$handle = fopen ( $filename, "r" );
		$json = fread ( $handle, filesize ( $filename ) );
		fclose ( $handle );
		$data = json_decode ( $json, true );
		// $timeStampJSON = $data ["timeStamp"];
		$crossTableColor = $data ["crossTableColor"];
		$meetingTableColor = $data ["meetingTableColor"];
		for($i = 0; $i < count ( $data ["groupName"] ); $i ++) {
			// CROSSTABLE
			$allContent = '';
			$greyContent = '';
			$greenCrossContent = '';
			$greenMeetingContent = '';
			$greyH1 = strip_tags ( $data ["tournamentName"], $allowable_tags ) . ' - ' . strip_tags ( $data ["groupName"] [$i], $allowable_tags );
			$greenCrossH1 = strip_tags ( $data ["jsonCrossTitle"], $allowable_tags );
			$greenMeetingH1 = strip_tags ( $data ["jsonMeetingtitle"], $allowable_tags );
			
			$crosstable = $data ["crossTable"] [$i];
			$cTable = createTable ( $crosstable );
			$crossHeader = strip_tags ( $data ["crossHeader"] [$i], $allowable_tags );
			$crossTableText = strip_tags ( $data ["crossTableText"] [$i], $allowable_tags );
			$cTable .= $wrapper->wrapContent ( $crossHeader, $crossTableText, $crossTableColor [$i] );
			$greenCrossContent = $wrapper->wrapContent ( $greenCrossH1, $cTable, $crossTableColor [$i] );
			
			// MEETINGTABLE
			$meetingtable = $data ["meetingTable"] [$i];
			$mTable = createTable ( $meetingtable );
			$meetingHeader = strip_tags ( $data ["meetingHeader"] [$i], $allowable_tags );
			$meetingTableText = strip_tags ( $data ["meetingTableText"] [$i], $allowable_tags );
			$mTable .= $wrapper->wrapContent ( $meetingHeader, $meetingTableText, $meetingTableColor [$i] );
			$greenMeetingContent = $wrapper->wrapContent ( $greenMeetingH1, $mTable, $meetingTableColor [$i] );
			
			$allContent = '<h1 class="well">' . $greyH1 . '</h1>';
			$allContent .= $greenCrossContent . $greenMeetingContent;
			$file = '../tables/' . htmlspecialchars ( $data ["tournamentName"] ) . '-' . htmlspecialchars ( $data ["groupName"] [$i] ) . '.html';
			
			// if (strcmp ( $timeStampJSON, $timeStamp ) != 0) {
			
			file_put_contents ( $file, $allContent );
			// }
			// $menuLinks .= '<li><a href="index.php?param=' . $i . '" >' . $data ["groupName"] [$i] . '</a></li>' . "\n";
		}
		// }
	}
	// file_put_contents ( $timeStampFilename, json_encode ( $timeStampJSON ) );
}
function createTable($table) {
	$allowable_tags = allowTags ();
	$tempTable = '';
	$tempTable .= '<table class="table table-bordered well">' . "\n";
	$counter = 0;
	// $crosstable = $data ["crossTable"];
	foreach ( $table as $jsons ) {
		$tempTable .= '  <tr>' . "\n";
		
		foreach ( $jsons as $key => $rvalue ) {
			if ($counter == 0) {
				$tempTable .= '    <th class="alert-warning">' . strip_tags ( $rvalue, $allowable_tags ) . '</th>' . "\n";
			} else {
				$tempTable .= '    <td>' . strip_tags ( $rvalue, $allowable_tags ) . '</td>' . "\n";
			}
		}
		$tempTable .= '  </tr>' . "\n";
		$counter ++;
	}
	$tempTable .= '</table>' . "\n";
	return $tempTable;
}
function allowTags() {
	return "<p><br><br/><br />";
}
?>