<?php
include 'wrap.php';
if (isset ( $_GET ['param'] )) {
	$index = htmlentities ( $_GET ['param'] );
	if ($index >= 0 && $index < 20 && is_numeric ( $index )) {
		echo showGroupTable ( $index );
	} else {
		exit ();
	}
} else {
	echo showMenu ();
}
function showMenu() {
	$wrapper = new Wrap ();
	$configJSON = 'config.json';
	$handle = fopen ( $configJSON, "r" );
	$json = fread ( $handle, filesize ( $configJSON ) );
	fclose ( $handle );
	$jsonFiles = json_decode ( $json, true );
	
	$content = '';
	$menuLinks = '';
	$filename = $jsonFiles ['filename'];
	
	if (file_exists ( $filename )) {
		// liest den Inhalt einer Datei in einen String
		$handle = fopen ( $filename, "r" );
		$json = fread ( $handle, filesize ( $filename ) );
		fclose ( $handle );
		$data = json_decode ( $json, true );
		for($i = 0; $i < count ( $data ["groupName"] ); $i ++) {
			
			$menuLinks .= '<li><a href="index.php?param=' . $i . '" >' . strip_tags ( $data ["groupName"] [$i] ) . '</a></li>';
		}
	}
	
	$menuName = strip_tags ( $data ["menuName"] );
	$content = $wrapper->wrapNavigation ( strip_tags ( $data ["siteName"] ), $menuName, $menuLinks );
	$content .= '<div class="container theme-showcase" role="main">
	<!-- Main jumbotron for a primary marketing message or call to action -->
	<div class="col-md-8">';
	$content .= '</div> <!-- col-sm-8 blog-main -->';
	$sidePanelsheader = $data ["sidePanelsheader"];
	$sidePanelsbody = $data ["sidePanelsbody"];
	$sidebar .= createSidebarPanel ( $sidePanelsheader, $sidePanelsbody );
	$content .= $wrapper->wrapSidebar ( $sidebar ) . '</div> <!--container -->';
	$content .= createFooter ();
	
	return $content;
}
function showGroupTable($index) {
	$allowable_tags = allowTags ();
	$wrapper = new Wrap ();
	$configJSON = 'config.json';
	$handle = fopen ( $configJSON, "r" );
	$json = fread ( $handle, filesize ( $configJSON ) );
	fclose ( $handle );
	$jsonFiles = json_decode ( $json, true );
	
	$content = '';
	$menuLinks = '';
	$filename = $jsonFiles ['filename'];
	
	if (file_exists ( $filename )) {
		// liest den Inhalt einer Datei in einen String
		$handle = fopen ( $filename, "r" );
		$json = fread ( $handle, filesize ( $filename ) );
		fclose ( $handle );
		$data = json_decode ( $json, true );
		
		$allContent = '';
		$file = 'tables/' . $data ["tournamentName"] . '-' . $data ["groupName"] [$index] . '.html';
		
		$allContent = file_get_contents ( $file );
		for($i = 0; $i < count ( $data ["groupName"] ); $i ++) {
			$menuLinks .= '<li><a href="index.php?param=' . $i . '" >' . htmlspecialchars ( $data ["groupName"] [$i] ) . '</a></li>';
		}
	}
	
	$menuName = htmlspecialchars ( $data ["menuName"] );
	$content = $wrapper->wrapNavigation ( htmlspecialchars ( $data ["siteName"] ), $menuName, $menuLinks );
	$content .= '<div class="container theme-showcase" role="main">
	<!-- Main jumbotron for a primary marketing message or call to action -->
	<div class="col-md-8">';
	$content .= $allContent;
	$content .= '</div> <!-- col-sm-8 blog-main -->';
	$sidePanelsheader = $data ["sidePanelsheader"];
	$sidePanelsbody = $data ["sidePanelsbody"];
	$sidebar .= createSidebarPanel ( $sidePanelsheader, $sidePanelsbody );
	$content .= $wrapper->wrapSidebar ( $sidebar ) . '</div> <!--container -->';
	$content .= createFooter ();
	
	return $content;
}
function createSidebarPanel($header, $body) {
	$wrapper = new Wrap ();
	$allowable_tags = allowTags ();
	$h1 = 'Test';
	$sidebar = '<h1 class="well">' . $h1 . '</h1>';
	for($i = 0; $i < count ( $header ); $i ++) {
		$sidebarModule = $wrapper->wrapContent ( strip_tags ( $header [$i], $allowable_tags ), strip_tags ( $body [$i], $allowable_tags ), Wrap::GREYDIVCONTENT );
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
function allowTags() {
	return "<p><br><br/><br />";
}
?>
	
