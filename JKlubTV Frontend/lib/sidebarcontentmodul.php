<?php
class Sidebarcontentmodul {
	public function createSidebar($data) {
		$wrapper = new Wrap ();
		$h1 = $wrapper->wrapHeader ( 'Information' );
		$color = $data ["color"];
		if (count ( $data ["sidePanelsheader"] ) == 0) {
			$h1 = '';
		}
		$sidePanelsheader = $data ["sidePanelsheader"];
		$sidePanelsbody = $data ["sidePanelsbody"];
		$sidebar = $wrapper->createSidebarPanel ( $sidePanelsheader, $sidePanelsbody, $color );
		$content = $wrapper->wrapSidebar ( $h1 . $sidebar ) . '</div> <!--container -->';
		return $content;
	}
}
?>