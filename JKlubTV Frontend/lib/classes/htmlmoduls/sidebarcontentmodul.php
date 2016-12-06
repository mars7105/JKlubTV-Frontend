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