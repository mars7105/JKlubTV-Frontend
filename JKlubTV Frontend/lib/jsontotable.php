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
	// $menus = makemenus ( $jsonFiles );
	$result = "";
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
				$content .= $wrapper->wrapNavigation ( htmlspecialchars ( $data ["siteName"] ), '' );
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
				if (strcmp ( $crossHeader, "" ) != 0) {
					$cTable .= $wrapper->wrapContent ( $crossHeader, $crossTableText, $crossTableColor [$i] );
				}
				$greenCrossContent = $wrapper->wrapContent ( $greenCrossH1, $cTable, $crossTableColor [$i] );
				
				// MEETINGTABLE
				$meetingtable = $data ["meetingTable"] [$i];
				$mTable = createTable ( $meetingtable );
				$meetingHeader = strip_tags ( $data ["meetingHeader"] [$i], $allowable_tags );
				$meetingTableText = strip_tags ( $data ["meetingTableText"] [$i], $allowable_tags );
				if (strcmp ( $meetingHeader, "" ) != 0) {
					$mTable .= $wrapper->wrapContent ( $meetingHeader, $meetingTableText, $meetingTableColor [$i] );
				}
				$greenMeetingContent = $wrapper->wrapContent ( $greenMeetingH1, $mTable, $meetingTableColor [$i] );
				
				$allContent = '<h1 class="well">' . $greyH1 . '</h1>';
				$allContent .= $greenCrossContent . $greenMeetingContent;
				
				$color = $data ["color"];
				
				// $content .= $menus;
				$content .= '<div class="container theme-showcase" role="main">
	<!-- Main jumbotron for a primary marketing message or call to action -->
	<div class="col-md-8">';
				$content .= $allContent;
				
				$content .= '</div> ';
				$h1 = '<h1 class="well">Navigation</h1>' . "\n";
				$menus = makedashboardmenus ( $jsonFiles, $countindex, $i );
				$content .= $wrapper->wrapSidebar ( $h1 . $menus );
				$content .= '<!-- col-sm-8 blog-main -->';
				
				$h1 = '<h1 class="well">Information</h1>' . "\n";
				if (count ( $data ["sidePanelsheader"] ) == 0) {
					$h1 = '';
				}
				$sidePanelsheader = $data ["sidePanelsheader"];
				$sidePanelsbody = $data ["sidePanelsbody"];
				$sidebar = createSidebarPanel ( $sidePanelsheader, $sidePanelsbody, $color );
				$content .= $wrapper->wrapSidebar ( $h1 . $sidebar ) . '</div> <!--container -->';
				$content .= createFooter ();
				$content .= $htmlend;
				
				$file = '../' . $htmlfiles [$countindex] [$i];
				$result [] = $htmlfiles [$countindex] [$i];
				file_put_contents ( $file, $content );
			}
			$countindex ++;
		}
	}
	$file = '../temp/menus.json';
	$resultjson = json_encode ( $result, JSON_UNESCAPED_SLASHES );
	file_put_contents ( $file, $resultjson );
}
function makemenus($jsonFiles) {
	$wrapper = new Wrap ();
	$content = "";
	$menuindex = 0;
	$menus = "";
	foreach ( $jsonFiles ['filename'] as $filename ) {
		if (file_exists ( $filename )) {
			// liest den Inhalt einer Datei in einen String
			$handle = fopen ( $filename, "r" );
			$json = fread ( $handle, filesize ( $filename ) );
			fclose ( $handle );
			$data = json_decode ( $json, true );
			$menuLinks = '';
			
			for($index = 0; $index < count ( $data ["groupName"] ); $index ++) {
				
				$menuLinks .= '<li><a href="index.php?param=' . $menuindex . '" >' . strip_tags ( $data ["groupName"] [$index] ) . '</a></li>';
				$menuindex ++;
			}
			
			$menuName = htmlspecialchars ( $data ["menuName"] );
			$menus .= $wrapper->wrapMenu ( $menuName, $menuLinks );
		}
	}
	$content .= $wrapper->wrapNavigation ( htmlspecialchars ( $data ["siteName"] ), $menus );
	
	return $content;
}
function makedashboardmenus($jsonFiles, $countindex, $groupindex) {
	$wrapper = new Wrap ();
	$content = "";
	$menuindex = 0;
	$menus = "";
	$menuLinks = '';
	$menuBox = '';
	$cindex = 0;
	foreach ( $jsonFiles ['filename'] as $filename ) {
		
		if (file_exists ( $filename )) {
			
			// liest den Inhalt einer Datei in einen String
			$handle = fopen ( $filename, "r" );
			$json = fread ( $handle, filesize ( $filename ) );
			fclose ( $handle );
			$data = json_decode ( $json, true );
			
			$menuLinks .= '<div class="list-group">';
			$menuLinks .= '<span class="list-group-item alert-info">' . $data ["tournamentName"] . '</span>';
			
			for($index = 0; $index < count ( $data ["groupName"] ); $index ++) {
				if ($countindex == $cindex && $groupindex == $index) {
					$menuLinks .= '<a class="list-group-item active" href="index.php?param=' . $menuindex . '" >' . strip_tags ( $data ["groupName"] [$index] ) . '</a>' . "\n";
				} else {
					$menuLinks .= '<a class="list-group-item" href="index.php?param=' . $menuindex . '" >' . strip_tags ( $data ["groupName"] [$index] ) . '</a>' . "\n";
				}
				$menuindex ++;
			}
			$menuLinks .= '</div>';
			// $menuBox .= $wrapper->wrapContent ( htmlspecialchars ( $data ["tournamentName"] ), $menuLinks, 0 );
		}
		$cindex ++;
	}
	$menuName = htmlspecialchars ( $data ["menuName"] );
	// $menus .= $wrapper->wrapContent ( $menuName, $menuLinks, 0 );
	$menus .= $menuLinks;
	// $content .= $wrapper->wrapNavigation ( htmlspecialchars ( $data ["siteName"] ), $menus );
	
	return $menus;
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
	$sidebar = "";
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