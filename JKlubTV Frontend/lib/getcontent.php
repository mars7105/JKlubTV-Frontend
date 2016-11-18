<?php
include 'wrap.php';
if (isset ( $_GET ['param'] )) {
	echo showGroupTable ( htmlentities($_GET ['param']) );
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
			
			$menuLinks .= '<li><a href="index.php?param=' . $i . '" >' . $data ["groupName"] [$i] . '</a></li>' . "\n";
		}
	}
	
	$menuName = $data ["menuName"];
	$content = $wrapper->wrapNavigation ( $data ["siteName"], $menuName, $menuLinks );
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
			$menuLinks .= '<li><a href="index.php?param=' . $i . '" >' . $data ["groupName"] [$i] . '</a></li>' . "\n";
		}
	}
	
	$menuName = $data ["menuName"];
	$content = $wrapper->wrapNavigation ( $data ["siteName"], $menuName, $menuLinks );
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
	$h1 = 'Test';
	$sidebar = '<h1 class="well">' . $h1 . '</h1>';
	for($i = 0; $i < count ( $header ); $i ++) {
		$sidebarModule = $wrapper->wrapGreyContent ( $header [$i], '<p>' . $body [$i] . '</p>' );
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
	
