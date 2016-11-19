<?php
class Wrap {
	// Defining constants
	const GREYDIVCONTENT = 'panel-default';
	const DARKBLUEDIVCONTENT = 'panel-primary';
	const LIGHTBLUEDIVCONTENT = 'panel-info';
	const YELLOWDIVCONTENT = 'panel-warning';
	const REDDIVCONTENT = 'panel-danger';
	const GREENDIVCONTENT = 'panel-success';
	//
	public function wrapContent($h1, $body, $color) {
		$wrap = '<div class="panel ' . $color . '">' . "\n";
		$wrap .= '  <div class="panel-heading">' . "\n";
		$wrap .= '    <h1 class="panel-title">' . $h1 . '</h1>' . "\n";
		$wrap .= '	</div>' . "\n";
		$wrap .= '  <div class="panel-body">' . "\n";
		$wrap .= $body . "\n";
		$wrap .= '  </div>' . "\n";
		$wrap .= '</div>' . "\n";
		
		return $wrap;
	}
	public function wrapNavigation($h1, $menuItem, $naviLinks) {
		$wrap = '  
          <p class="navbar-brand"><a href="' . $_SERVER ['PHP_SELF'] . '">' . $h1 . '</a></p>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $menuItem . '<span class="caret"></span></a>
              <ul class="dropdown-menu">';
		$wrap .= $naviLinks . "\n";
		$wrap .= '    </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>';
		
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
}
?>
