<?php
//JKlubTV - Ein Programm zum verwalten von Schach Turnieren
//Copyright (C) 2015  Martin Schmuck m_schmuck@gmx.net
//
//This program is free software: you can redistribute it and/or modify
//it under the terms of the GNU General Public License as published by
//the Free Software Foundation, either version 3 of the License, or
//(at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.
//
//You should have received a copy of the GNU General Public License
//along with this program.  If not, see <http://www.gnu.org/licenses/>.
class Sidebarnavigationmodul {
	function createHeaderNavi($jsonFiles) {
		$file = new File ();
		$wrapper = new Wrap ();
		$content = "";
		$menuindex = 0;
		$menus = "";
		$content = $wrapper->wrapHeader ( 'Navigation' );
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
	function createSidebarNavi($jsonFiles, $countindex, $groupindex) {
		$file = new File ();
		$wrapper = new Wrap ();
		// $content = "";
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
		$h1 = $wrapper->wrapHeader ( 'Navigation' );
		$content = $wrapper->wrapSidebar ( $h1 . $menus );
		return $content;
	}
}
?>