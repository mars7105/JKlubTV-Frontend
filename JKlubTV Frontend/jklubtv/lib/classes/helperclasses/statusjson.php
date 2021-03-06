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
class Statusjson {
	public function sendStatusOk($phpmodul) {
		$statusString ['statusCode'] = 'Ok';
		$statusString ['md5sum'] [0] = '0';
		$statusString ['version'] = 'Frontend';
		$statusString ['phpModul'] = $phpmodul;
		$resultjson = json_encode ( $statusString, JSON_UNESCAPED_SLASHES );
		return $resultjson;
	}
	public function sendStatusError($phpmodul, $errorString) {
		$statusString ['statusCode'] = $errorString;
		$statusString ['md5sum'] [0] = '0';
		$statusString ['version'] = 'Frontend';
		$statusString ['phpModul'] = $phpmodul;
		$resultjson = json_encode ( $statusString, JSON_UNESCAPED_SLASHES );
		return $resultjson;
	}
	public function sendmd5Sum($phpmodul, $md5sum) {
		$statusString ['statusCode'] = 'Ok';
		$statusString ['md5sum'] = $md5sum;
		$statusString ['version'] = 'Frontend';
		$statusString ['phpModul'] = $phpmodul;
		$resultjson = json_encode ( $statusString, JSON_UNESCAPED_SLASHES );
		return $resultjson;
	}
	public function sendStatusPostnotSetError($phpmodul) {
		$statusString ['statusCode'] = 'POST is not set';
		$statusString ['md5sum'] [0] = '0';
		$statusString ['version'] = 'Frontend';
		$statusString ['phpModul'] = $phpmodul;
		$resultjson = json_encode ( $statusString, JSON_UNESCAPED_SLASHES );
		return $resultjson;
	}
	public function sendStatusPostWrongError($phpmodul) {
		$statusString ['statusCode'] = 'POST is wrong';
		$statusString ['md5sum'] [0] = '0';
		$statusString ['version'] = 'Frontend';
		$statusString ['phpModul'] = $phpmodul;
		$resultjson = json_encode ( $statusString, JSON_UNESCAPED_SLASHES );
		return $resultjson;
	}
	public function sendStatusLoginError($phpmodul) {
		$statusString ['statusCode'] = 'Wrong Username or Password!';
		$statusString ['md5sum'] [0] = '0';
		$statusString ['version'] = 'Frontend';
		$statusString ['phpModul'] = $phpmodul;
		$resultjson = json_encode ( $statusString, JSON_UNESCAPED_SLASHES );
		return $resultjson;
	}
	public function sendStatusWebVersion($phpmodul) {
		$statusString ['statusCode'] = 'Ok';
		$statusString ['md5sum'] [0] = '0';
		$statusString ['version'] = 'Frontend';
		$statusString ['phpModul'] = $phpmodul;
		$resultjson = json_encode ( $statusString, JSON_UNESCAPED_SLASHES );
		return $resultjson;
	}
}

?>