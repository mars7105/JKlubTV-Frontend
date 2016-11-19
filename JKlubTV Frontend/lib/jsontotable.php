<?php
$login = false;
include 'checklogin.php';
if ($login != true) {
	echo "Wrong Username or Password!";
	// das Programm normal beenden
	exit;
} else {
	if (isset ( $_POST )) {
		
		createHTMLTables ();
		echo "Ok";
	} else {
		echo "POST is not set";
	}
}
function createHTMLTables() {
	include 'wrap.php';
	$timeStampFilename = '../tables/timestamp.json';
	$timeStamp = "0";
	if (file_exists ( $timeStampFilename )) {
		$timeStamphandle = fopen ( $timeStampFilename, "r" );
		
		$timeStampjson = fread ( $timeStamphandle, filesize ( $timeStampFilename ) );
		fclose ( $handle );
		$timeStamp = json_decode ( $timeStampjson, true );
	}
	
	$wrapper = new Wrap ();
	$configJSON = '../config.json';
	$handle = fopen ( $configJSON, "r" );
	$json = fread ( $handle, filesize ( $configJSON ) );
	fclose ( $handle );
	$jsonFiles = json_decode ( $json, true );
	
	$content = '';
	$menuLinks = '';
	
	foreach ( $jsonFiles as $key => $filename ) {
		$filename = '../' . $filename;
		
		if (file_exists ( $filename )) {
			// liest den Inhalt einer Datei in einen String
			$handle = fopen ( $filename, "r" );
			$json = fread ( $handle, filesize ( $filename ) );
			fclose ( $handle );
			$data = json_decode ( $json, true );
			$timeStampJSON = $data ["timeStamp"];
			for($i = 0; $i < count ( $data ["groupName"] ); $i ++) {
				// CROSSTABLE
				$allContent = '';
				$greyContent = '';
				$greenCrossContent = '';
				$greenMeetingContent = '';
				$greyH1 = $data ["tournamentName"] . ' - ' . $data ["groupName"] [$i];
				$greenCrossH1 = $data ["jsonCrossTitle"];
				$greenMeetingH1 = $data ["jsonMeetingtitle"];
				
				$crosstable = $data ["crossTable"] [$i];
				$cTable = createTable ( $crosstable );
				
				$crossTableText = $data ["crossTableText"] [$i];
				$cTable .= $crossTableText;
				$greenCrossContent = $wrapper->wrapGreyContent ( $greenCrossH1, $cTable );
				
				// MEETINGTABLE
				$meetingtable = $data ["meetingTable"] [$i];
				$mTable = createTable ( $meetingtable );
				
				$meetingTableText = $data ["meetingTableText"] [$i];
				$mTable .= $meetingTableText;
				$greenMeetingContent = $wrapper->wrapGreyContent ( $greenMeetingH1, $mTable );
				
				$allContent = '<h1 class="well">' . $greyH1 . '</h1>';
				$allContent .= $greenCrossContent . $greenMeetingContent;
				$file [$i] = '../tables/' . $data ["tournamentName"] . '-' . $data ["groupName"] [$i] . '.html';
				
				// if (strcmp ( $timeStampJSON, $timeStamp ) != 0) {
				
				file_put_contents ( $file [$i], $allContent );
				// }
				// $menuLinks .= '<li><a href="index.php?param=' . $i . '" >' . $data ["groupName"] [$i] . '</a></li>' . "\n";
			}
		}
	}
	file_put_contents ( $timeStampFilename, json_encode ( $timeStampJSON ) );
}
function createTable($table) {
	$tempTable = '';
	$tempTable .= '<table class="table table-bordered well">' . "\n";
	$counter = 0;
	// $crosstable = $data ["crossTable"];
	foreach ( $table as $jsons ) {
		$tempTable .= '  <tr>' . "\n";
		
		foreach ( $jsons as $key => $rvalue ) {
			if ($counter == 0) {
				$tempTable .= '    <th class="alert-warning">' . $rvalue . '</th>' . "\n";
			} else {
				$tempTable .= '    <td>' . $rvalue . '</td>' . "\n";
			}
		}
		$tempTable .= '  </tr>' . "\n";
		$counter ++;
	}
	$tempTable .= '</table>' . "\n";
	return $tempTable;
}
?>