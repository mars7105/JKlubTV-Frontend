<?php
session_start ();
include 'wrap.php';
if (! empty ( $_GET ['param'] ) && ! empty ( $_SESSION ['content'] )) {
	showMenu ();
} else {
	createHTMLTables ();
	showMenu ();
}
function showMenu() {
	$wrapper = new Wrap ();
	$param = $_GET ['param'];
	$content = $_SESSION ['content'];
	$files = $_SESSION ['files'];
	$table = file_get_contents ( $files [$param] );
	$content .= '<div class="container theme-showcase" role="main">
	<!-- Main jumbotron for a primary marketing message or call to action -->
	<div class="col-md-8">';
	$content .= $table;
	$content .= '</div> <!-- col-sm-8 blog-main -->';
	$sidePanels = $_SESSION ['sidePanels'];
	$sidebar .= createSidebarPanel ( $sidePanels );
	$content .= $wrapper->wrapSidebar ( $sidebar ) . '</div> <!--container -->';
	$content .= createFooter ();
	
	echo $content;
	session_destroy ();
}
function createHTMLTables() {
	$timeStampFilename = 'tables/timestamp.json';
	$timeStamp = "0";
	if (file_exists ( $timeStampFilename )) {
		$timeStamphandle = fopen ( $timeStampFilename, "r" );
		
		$timeStampjson = fread ( $timeStamphandle, filesize ( $timeStampFilename ) );
		fclose ( $handle );
		$timeStamp = json_decode ( $timeStampjson, true );
	}
	
	$wrapper = new Wrap ();
	$configJSON = 'config.json';
	$handle = fopen ( $configJSON, "r" );
	$json = fread ( $handle, filesize ( $configJSON ) );
	fclose ( $handle );
	$jsonFiles = json_decode ( $json, true );
	
	$content = '';
	$menuLinks = '';
	
	foreach ( $jsonFiles as $key => $filename ) {
		
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
				$file [$i] = 'tables/' . $data ["tournamentName"] . '-' . $data ["groupName"] [$i] . '.html';
				
				if (strcmp ( $timeStampJSON, $timeStamp ) != 0) {
					
					file_put_contents ( $file [$i], $allContent );
				}
				$menuLinks .= '<li><a href="index.php?param=' . $i . '" >' . $data ["groupName"] [$i] . '</a></li>' . "\n";
			}
		}
	}
	file_put_contents ( $timeStampFilename, json_encode ( $timeStampJSON ) );
	
	$menuName = $data ["menuName"];
	$content = $wrapper->wrapNavigation ( $data ["siteName"], $menuName, $menuLinks );
	
	$_SESSION ['sidePanels'] = $data ["sidePanels"];
	$_SESSION ['content'] = $content;
	$_SESSION ['files'] = $file;
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
function createSidebarPanel($panelText) {
	$wrapper = new Wrap ();
	$h1 = 'Test';
	$sidebar = '<h1 class="well">' . $h1 . '</h1>';
	for($i = 0; $i < count ( $panelText ); $i = $i + 2) {
		$sidebarModule = $wrapper->wrapGreyContent ( $panelText [$i], '<p>' . $panelText [$i + 1] . '</p>' );
		$sidebar .= $wrapper->wrapSidebarModule ( $sidebarModule );
	}
	return $sidebar;
}
function createFooter() {
	$wrap = '
	<footer class="blog-footer">
		<p>
			<a href="http://getbootstrap.com">Bootstrap</a>
		</p>
		<p>
			<a href="#">Back to top</a>
		</p>
	</footer>';
	return $wrap;
}
?>
	
