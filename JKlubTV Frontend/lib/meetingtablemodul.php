<?php
// include 'tablecontent.php';

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