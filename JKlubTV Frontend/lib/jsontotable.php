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
	$filename = "html/htmlstart.html";
	$handle = fopen ( $filename, "r" );
	$htmlstart = fread ( $handle, filesize ( $filename ) );
	fclose ( $handle );
	$filename = "html/htmlend.html";
	$handle = fopen ( $filename, "r" );
	$htmlend = fread ( $handle, filesize ( $filename ) );
	fclose ( $handle );
	$allowable_tags = allowTags ();
	$wrapper = new Wrap ();
	$configJSON = '../temp/config.json';
	$handle = fopen ( $configJSON, "r" );
	$json = fread ( $handle, filesize ( $configJSON ) );
	fclose ( $handle );
	$jsonFiles = json_decode ( $json, true );
	
	$content = '';
	$menuLinks = '';
	// $filename = $jsonFiles ['filename'];
	$htmlfiles = $jsonFiles ['htmlfiles'];
	
	$countindex = 0;
	foreach ( $jsonFiles ['filename'] as $filename ) {
		if (file_exists ( $filename )) {
			// liest den Inhalt einer Datei in einen String
			$handle = fopen ( $filename, "r" );
			$json = fread ( $handle, filesize ( $filename ) );
			fclose ( $handle );
			$data = json_decode ( $json, true );
			// $hash = createHash ( $data ["md5Sum"] );
			
			$crossTableColor = $data ["crossTableColor"];
			$meetingTableColor = $data ["meetingTableColor"];
			for($i = 0; $i < count ( $data ["groupName"] ); $i ++) {
				// CROSSTABLE
				$content = $htmlstart;
				$menuLinks = '';
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
				
				$color = $data ["color"];
				for($index = 0; $index < count ( $data ["groupName"] ); $index ++) {
					
					$menuLinks .= '<li><a href="index.php?param=' . $index . '" >' . strip_tags ( $data ["groupName"] [$index] ) . '</a></li>';
				}
				$menuName = htmlspecialchars ( $data ["menuName"] );
				$content .= $wrapper->wrapNavigation ( htmlspecialchars ( $data ["siteName"] ), $menuName, $menuLinks );
				$content .= '<div class="container theme-showcase" role="main">
	<!-- Main jumbotron for a primary marketing message or call to action -->
	<div class="col-md-8">';
				$content .= $allContent;
				$content .= '</div> <!-- col-sm-8 blog-main -->';
				$sidePanelsheader = $data ["sidePanelsheader"];
				$sidePanelsbody = $data ["sidePanelsbody"];
				$sidebar = createSidebarPanel ( $sidePanelsheader, $sidePanelsbody, $color );
				$content .= $wrapper->wrapSidebar ( $sidebar ) . '</div> <!--container -->';
				$content .= createFooter ();
				$content .= $htmlend;
				
				$file = '../' . $htmlfiles [$countindex] [$i];
				
				// $htmlfiles [$index] [$i] = "../temp/" . $htmlfiles [$index] [$i];
				file_put_contents ( $file, $content );
			}
			// $configfile = "../temp/config.json";
			$countindex ++;
		}
	}
}
function createTable($table) {
	$allowable_tags = allowTags ();
	$tempTable = '';
	$tempTable .= '<table class="table table-bordered well">' . "\n";
	$counter = 0;
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
function createSidebarPanel($header, $body, $color) {
	$wrapper = new Wrap ();
	
	$allowable_tags = allowTags ();
	$h1 = 'Test';
	$sidebar = '<h1 class="well">' . $h1 . '</h1>';
	for($i = 0; $i < count ( $header ); $i ++) {
		
		$sidebarModule = $wrapper->wrapContent ( strip_tags ( $header [$i], $allowable_tags ), strip_tags ( $body [$i], $allowable_tags ), $color [$i] );
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
function createHash($string) {
	$hash = hash ( 'sha256', $string );
	return $hash;
}
function allowTags() {
	return "<p><br><br/><br />";
}
?>