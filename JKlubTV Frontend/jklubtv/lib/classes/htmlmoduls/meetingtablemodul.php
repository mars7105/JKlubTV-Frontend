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
class Meetingtablemodul {
	public function createTable($data, $i) {
		// MEETINGTABLE
		$tableContent = new TableContent ();
		$meetingtable = $data ["meetingTable"] [$i];
		$meetingTableColor = $data ["meetingTableColor"];
		$meetingHeader = strip_tags ( $data ["meetingHeader"] [$i], $allowable_tags );
		$meetingTableText = strip_tags ( $data ["meetingTableText"] [$i], $allowable_tags );
		$meetingH1 = strip_tags ( $data ["jsonMeetingtitle"], $allowable_tags );
		$mTable = $tableContent->createTable ( $meetingtable, $meetingHeader, $meetingTableText, $meetingTableColor [$i], $meetingH1 );
		return $mTable;
	}
}
?>