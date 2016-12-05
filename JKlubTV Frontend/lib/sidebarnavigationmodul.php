<?php
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