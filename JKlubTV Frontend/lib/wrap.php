<?php
class Wrap {
	public function wrapContent($h1, $body, $color) {
		$sidePanelColor = $this->getColor ( $color );
		$wrap = '<div class="panel ' . $sidePanelColor . '">' . "\n";
		$wrap .= '  <div class="panel-heading">' . "\n";
		$wrap .= '    <h1 class="panel-title">' . $h1 . '</h1>' . "\n";
		$wrap .= '	</div>' . "\n";
		$wrap .= '  <div class="panel-body">' . "\n";
		$wrap .= $body . "\n";
		$wrap .= '  </div>' . "\n";
		$wrap .= '</div>' . "\n";
		
		return $wrap;
	}
	public function getColor($color) {
		$colorArray = array (
				'panel-default',
				'panel-primary',
				'panel-info',
				'panel-warning',
				'panel-danger',
				'panel-success' 
		);
		$sidePanelColor = $colorArray [$color];
		return $sidePanelColor;
	}
	public function wrapNavigation($h1, $menu) {
		$wrap = '  
          <p class="navbar-brand">' . $h1 . '</p>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">';
		$wrap .= $menu . "\n";
		$wrap .= '    </ul>
           
        </div><!--/.nav-collapse -->
      </div>
    </nav>';
		
		return $wrap;
	}
	public function wrapMenu($menuName, $naviLinks) {
		$wrap = '<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $menuName . '<span class="caret"></span></a>
              <ul class="dropdown-menu">';
		$wrap .= $naviLinks . "\n";
		$wrap .= "</ul></li>" . "\n";
		return $wrap;
	}
	public function wrapSidebar($body) {
		$wrap = '<div class="col-md-4 blog-sidebar">' . $body . '</div>';
		return $wrap;
	}
	public function wrapSidebarModule($body) {
		$wrap = '<div class="sidebar-module">' . $body . '</div>';
		return $wrap;
	}
	public function wrapDashboardMenu($menuItems) {
		// $wrap = '<div class="col-md-4 sidebar">' . "\n";
		$wrap = '	<ul class="nav nav-sidebar">' . "\n";
		$wrap .= $menuItems . "\n";
		$wrap .= '	</ul>' . "\n";
		// $wrap .= '</div>' . "\n";
		return $wrap;
	}
	public function wrapDashboardMenuItem($menuItem) {
		$wrap = '<li><a href="">' . $menuItem . '</a></li>' . "\n";
		return $wrap;
	}
	public function getContainer() {
		$content = '<div class="container theme-showcase" role="main">
	<!-- Main jumbotron for a primary marketing message or call to action -->
	<div class="col-md-8">';
		return $content;
	}
	public function wrapHeader($header) {
		$h1 = '<h1 class="well">' . $header . '</h1>' . "\n";
		return $h1;
	}
	public function createFooter() {
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
	public function createSidebarPanel($header, $body, $color) {
		$allowable_tags = $this->allowTags ();
		$sidebar = "";
		for($i = 0; $i < count ( $header ); $i ++) {
			
			$sidebarModule = $this->wrapContent ( strip_tags ( $header [$i], $allowable_tags ), strip_tags ( $body [$i], $allowable_tags ), $color [$i] );
			$sidebar .= $this->wrapSidebarModule ( $sidebarModule );
		}
		return $sidebar;
	}
	public function wrapListGroup($header, $item) {
		$menuLinks = '';
		$menuLinks .= '<div class="list-group">';
		$menuLinks .= '  <span class="list-group-item alert-info">' . $header . '</span>';
		$menuLinks .= $item;
		$menuLinks .= '</div>';
		
		return $menuLinks;
	}
	public function wrapListGroupItem($menuindex, $groupName) {
		$menuLinks = '<a class="list-group-item" href="index.php?param=' . $menuindex . '" >' . strip_tags ( $groupName ) . '</a>' . "\n";
		return $menuLinks;
	}
	public function wrapListGroupItemActive($menuindex, $groupName) {
		$menuLinks = '<a class="list-group-item active" href="index.php?param=' . $menuindex . '" >' . strip_tags ( $groupName ) . '</a>' . "\n";
		
		return $menuLinks;
	}
	public function allowTags() {
		return "<p><br><br/><br />";
	}
}
?>
