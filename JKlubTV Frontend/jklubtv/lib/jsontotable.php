<?php
// JKlubTV - Ein Programm zum verwalten von Schach Turnieren
// Copyright (C) 2015 Martin Schmuck m_schmuck@gmx.net
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program. If not, see <http://www.gnu.org/licenses/>.
include 'classes/helperclasses/wrap.php';
include 'classes/helperclasses/statusjson.php';
include 'classes/helperclasses/file.php';
$status = new Statusjson ();
$login = false;
include 'checklogin.php';
include 'classes/htmlmoduls/tablecontent.php';
include 'classes/htmlmoduls/headermodul.php';
include 'classes/htmlmoduls/footermodul.php';
include 'classes/htmlmoduls/crosstablemodul.php';
include 'classes/htmlmoduls/meetingtablemodul.php';
include 'classes/htmlmoduls/sidebarnavigationmodul.php';
include 'classes/htmlmoduls/sidebarcontentmodul.php';
$phpmodul = 'jsontotable.php';
if ($login != true) {
	echo $status->sendStatusLoginError ( $phpmodul );
	// das Programm normal beenden
	exit ();
} else {
	if (isset ( $_POST )) {
		
		createHTMLTables ();
		echo $status->sendStatusOk ( $phpmodul );
	} else {
		echo $status->sendStatusPostnotSetError ( $phpmodul );
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
	$updateFile = $jsonFiles ['htmlfiles'];
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
			$sidebarPanelContent = $sidebarPanel->createSidebar ( $data );
			for($i = 0; $i < count ( $data ["groupName"] ); $i ++) {
				
				$begin = $htmlstart;
				
				// Top Menu
				$begin .= $wrapper->wrapNavigation ( '', '' );
				$topmenufile = 'temp/' . $data ["md5Sum"] . '-' . $i . '-' . 'begin' . '.html';
				$file->writeHTMLFile ( $topmenufile, $begin );
				
				$content .= $begin;
				$menuLinks = '';
				
				// CROSSTABLE
				$ctable = $crosstable->createTable ( $data, $i );
				$ctablefile = 'temp/' . $data ["md5Sum"] . '-' . $i . '-' . 'crosstable' . '.html';
				$file->writeHTMLFile ( $ctablefile, $ctable );
				
				// MEETINGTABLE
				$mtable = $meetingtable->createTable ( $data, $i );
				$mtablefile = 'temp/' . $data ["md5Sum"] . '-' . $i . '-' . 'meetingtable' . '.html';
				$file->writeHTMLFile ( $mtablefile, $mtable );
				
				// Tables
				$greyH1 = strip_tags ( $data ["tournamentName"], $allowable_tags ) . ' - ' . strip_tags ( $data ["groupName"] [$i], $allowable_tags );
				$tableheader = $wrapper->wrapHeader ( $greyH1 );
				$tables = $wrapper->createContainer ( $tableheader . $ctable . $mtable );
				$tablesfile = 'temp/' . $data ["md5Sum"] . '-' . $i . '-' . 'tables' . '.html';
				$file->writeHTMLFile ( $tablesfile, $tables );
				$content .= $tables;
				
				// Navigator
				$navi = $navigation->createSidebarNavi ( $jsonFiles, $countindex, $i );
				$navifile = 'temp/' . $data ["md5Sum"] . '-' . $i . '-' . 'navigation' . '.html';
				$file->writeHTMLFile ( $navifile, $navi );
				$content .= $navi;
				
				// Sidebar Content
				$sidebarfile = 'temp/' . $data ["md5Sum"] . '-' . $i . '-' . 'sidebar' . '.html';
				$file->writeHTMLFile ( $sidebarfile, $sidebarPanelContent );
				$content .= $sidebarPanelContent;
				
				// Footer
				$end = $footer;
				
				// End of htmml file
				$end .= $htmlend;
				$endfile = 'temp/' . $data ["md5Sum"] . '-' . $i . '-' . 'end' . '.html';
				$file->writeHTMLFile ( $endfile, $end );
				
				$content .= $end;
				
				// $result [] = $data ["md5Sum"] . '-' . $i;
				$result ['begin'] [] = $topmenufile;
				$result ['crosstable'] [] = $ctablefile;
				$result ['meetingtable'] [] = $mtablefile;
				$result ['tables'] [] = $tablesfile;
				$result ['navigation'] [] = $navifile;
				$result ['sidebar'] [] = $sidebarfile;
				$result ['end'] [] = $endfile;
				// Save HTML File
				// $file->writeHTMLFile ( $htmlfiles [$countindex] [$i], $content );
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