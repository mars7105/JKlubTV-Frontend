<?php
include 'wrap.php';
include 'tablecontent.php';
include 'statusjson.php';
include 'file.php';
$status = new Statusjson ();
$login = false;
include 'checklogin.php';
include 'headermodul.php';
include 'footermodul.php';
include 'crosstablemodul.php';
include 'meetingtablemodul.php';
include 'sidebarnavigationmodul.php';
include 'sidebarcontentmodul.php';
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
	
	$jsonFiles = $file->getConfigJson ();
	$content = '';
	$menuLinks = '';
	$htmlfiles = $jsonFiles ['htmlfiles'];
	
	$countindex = 0;
	$result = "";
	// Navi
	$navigation = new Sidebarnavigationmodul ();
	// CROSSTABLE
	$crosstable = new Crosstablemodul ();
	
	// MEETINGTABLE
	$meetingtable = new Meetingtablemodul ();
	
	// Sidebar
	$sidebarPanel = new Sidebarcontentmodul ();
	
	// Footer
	$footer = $wrapper->createFooter ();
	foreach ( $jsonFiles ['filename'] as $filename ) {
		if (file_exists ( $filename )) {
			
			$data = $file->getJson ( $filename );
			$sidebarPanelContent .= $sidebarPanel->createSidebar ( $data );
			for($i = 0; $i < count ( $data ["groupName"] ); $i ++) {
				
				$content = $htmlstart;
				$content .= $wrapper->wrapNavigation ( '', '' );
				$menuLinks = '';
				
				$greyH1 = strip_tags ( $data ["tournamentName"], $allowable_tags ) . ' - ' . strip_tags ( $data ["groupName"] [$i], $allowable_tags );
				
				$tables = $wrapper->wrapHeader ( $greyH1 );
				
				$tables .= $crosstable->createTable ( $data, $i );
				$tables .= $meetingtable->createTable ( $data, $i );
				$content .= $wrapper->createContainer ( $tables );
				
				$content .= $navigation->createSidebarNavi ( $jsonFiles, $countindex, $i );
				
				$content .= $sidebarPanelContent;
				
				$content .= $footer;
				$content .= $htmlend;
				
				$result [] = $htmlfiles [$countindex] [$i];
				$file->writeHTMLFile ( $htmlfiles [$countindex] [$i], $content );
			}
			$countindex ++;
		}
	}
	$file->writeMenuJson ( $result );
}
function createHash($string) {
	$hash = hash ( 'sha256', $string );
	return $hash;
}
function allowTags() {
	return "<p><br><br/><br />";
}
?>