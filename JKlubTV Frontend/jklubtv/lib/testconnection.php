<?php
// JKlubTV - Ein Programm zum verwalten von Schach Turnieren
// Copyright (C) 2015 Martin Schmuck m_schmuck@gmx.net
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program. If not, see <http://www.gnu.org/licenses/>.
$login = false;
include 'classes/helperclasses/statusjson.php';
$status = new Statusjson ();
include 'checklogin.php';
$phpmodul = 'testconnection.php';
if ($login != true) {
	echo $status->sendStatusLoginError ( $phpmodul );
	// das Programm normal beenden
	exit ();
} else {
	
	if ((isset ( $_POST ))) {
		
		$test = htmlspecialchars ( $_POST ["test"] );
		$cmp = "true";
		if (strcmp ( $test, $cmp ) == 0) {
			
			echo $status->sendStatusOk ( $phpmodul );
		} else {
			
			echo $status->sendStatusPostWrongError ( $phpmodul );
			exit ();
		}
	} else {
		
		echo $status->sendStatusPostnotSetError ( $phpmodul );
		exit ();
	}
}
?>