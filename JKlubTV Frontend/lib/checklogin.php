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
$login = false;
// include 'statusjson.php';
$status = new Statusjson ();
if (isset ( $_POST ['login'] ) && ! empty ( $_POST ['username'] ) && ! empty ( $_POST ['password'] )) {
	
	if ($_POST ['username'] == 'test' && $_POST ['password'] == 'test') {
		
		$timeout = time ();
		$username = 'test';
		$login = true;
	} else {
		echo $status->sendStatusLoginError();
		// das Programm normal beenden
		exit ();
	}
} else {
	echo $status->sendStatusLoginError();
	// das Programm normal beenden
	exit ();
}
?>