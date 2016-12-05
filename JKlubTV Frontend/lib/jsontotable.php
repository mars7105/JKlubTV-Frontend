<?php
include 'wrap.php';
include 'tablecontent.php';
include 'statusjson.php';
include 'file.php';
$status = new Statusjson ();
$login = false;
include 'checklogin.php';
if ($login != true) {
	echo $status->sendStatusLoginError ();
	// das Programm normal beenden
	exit ();
} else {
	if (isset ( $_POST )) {
		
		createHTMLTables ();
		echo $status->sendStatusOk ();
	} else {
		echo $status->sendStatusPostnotSetError ();
	}
}
function createHTMLTables() {
	$file = new File ();
	$htmlstart = $file->getHTMLStart ();
	$htmlend = $file->getHTMLEnd ();
	
	$allowable_tags = allowTags ();
	$wrapper = new Wrap ();
	$tableContent = new TableContent ();
	
	$jsonFiles = $file->getConfigJson ();
	$content = '';
	$menuLinks = '';
	$htmlfiles = $jsonFiles ['htmlfiles'];
	
	$countindex = 0;
	$result = "";
	foreach ( $jsonFiles ['filename'] as $filename ) {
		if (file_exists ( $filename )) {
			
			$data = $file->getJson ( $filename );
			
			$crossTableColor = $data ["crossTableColor"];
			$meetingTableColor = $data ["meetingTableColor"];
			for($i = 0; $i < count ( $data ["groupName"] ); $i ++) {
				
				$content = $htmlstart;
				$content .= $wrapper->wrapNavigation ( '', '' );
				$menuLinks = '';
				
				// CROSSTABLE
				$crosstable = $data ["crossTable"] [$i];
				
				$crossHeader = strip_tags ( $data ["crossHeader"] [$i], $allowable_tags );
				$crossTableText = strip_tags ( $data ["crossTableText"] [$i], $allowable_tags );
				$crossH1 = strip_tags ( $data ["jsonCrossTitle"], $allowable_tags );
				$cTable = $tableContent->createTable ( $crosstable, $crossHeader, $crossTableText, $crossTableColor [$i], $crossH1 );
				
				// MEETINGTABLE
				$meetingtable = $data ["meetingTable"] [$i];
				
				$meetingHeader = strip_tags ( $data ["meetingHeader"] [$i], $allowable_tags );
				$meetingTableText = strip_tags ( $data ["meetingTableText"] [$i], $allowable_tags );
				$meetingH1 = strip_tags ( $data ["jsonMeetingtitle"], $allowable_tags );
				$mTable = $tableContent->createTable ( $meetingtable, $meetingHeader, $meetingTableText, $meetingTableColor [$i], $meetingH1 );
				
				$color = $data ["color"];
				
				$content .= $wrapper->getContainer ();
				$greyH1 = strip_tags ( $data ["tournamentName"], $allowable_tags ) . ' - ' . strip_tags ( $data ["groupName"] [$i], $allowable_tags );
				
				$content .= $wrapper->wrapHeader ( $greyH1 );
				$content .= $cTable . $mTable . '</div> ';
				
				$h1 = $wrapper->wrapHeader ( 'Navigation' );
				$menus = makedashboardmenus ( $jsonFiles, $countindex, $i );
				$content .= $wrapper->wrapSidebar ( $h1 . $menus );
				$content .= '<!-- col-sm-8 blog-main -->';
				
				$h1 = $wrapper->wrapHeader ( 'Information' );
				if (count ( $data ["sidePanelsheader"] ) == 0) {
					$h1 = '';
				}
				$sidePanelsheader = $data ["sidePanelsheader"];
				$sidePanelsbody = $data ["sidePanelsbody"];
				$sidebar = $wrapper->createSidebarPanel ( $sidePanelsheader, $sidePanelsbody, $color );
				$content .= $wrapper->wrapSidebar ( $h1 . $sidebar ) . '</div> <!--container -->';
				$content .= $wrapper->createFooter ();
				$content .= $htmlend;
				
				$result [] = $htmlfiles [$countindex] [$i];
				$file->writeHTMLFile ( $htmlfiles [$countindex] [$i], $content );
			}
			$countindex ++;
		}
	}
	$file->writeMenuJson ( $result );
}
function makemenus($jsonFiles) {
	$file = new File ();
	$wrapper = new Wrap ();
	$content = "";
	$menuindex = 0;
	$menus = "";
	foreach ( $jsonFiles ['filename'] as $filename ) {
		if (file_exists ( $filename )) {
			// liest den Inhalt einer Datei in einen String
			
			$data = $file->getJson ( $filename );
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
	$file = new File ();
	$wrapper = new Wrap ();
	$content = "";
	$menuindex = 0;
	$menus = "";
	
	$menuBox = '';
	$cindex = 0;
	
	foreach ( $jsonFiles ['filename'] as $filename ) {
		
		if (file_exists ( $filename )) {
			$data = $file->getJson ( $filename );
			// liest den Inhalt einer Datei in einen String
			$menuLinks = '';
			$navi = '';
			
			for($index = 0; $index < count ( $data ["groupName"] ); $index ++) {
				if ($countindex == $cindex && $groupindex == $index) {
					$menuLinks .= $wrapper->wrapListGroupItemActive ( $menuindex, strip_tags ( $data ["groupName"] [$index] ) );
				} else {
					$menuLinks .= $wrapper->wrapListGroupItem ( $menuindex, strip_tags ( $data ["groupName"] [$index] ) );
				}
				$menuindex ++;
			}
			$navi = $wrapper->wrapListGroup ( $data ["tournamentName"], $menuLinks );
			$menus .= $navi;
			$cindex ++;
		}
		
	}
	
	return $menus;
}
function createHash($string) {
	$hash = hash ( 'sha256', $string );
	return $hash;
}
function allowTags() {
	return "<p><br><br/><br />";
}
?>