<?php
class Statusjson {
	public function sendStatusOk() {
		$statusString ['statusCode'] = 'Ok';
		$statusString ['md5sum'] = '0';
		$resultjson = json_encode ( $statusString, JSON_UNESCAPED_SLASHES );
		return $resultjson;
	}
	public function sendStatusError($errorString) {
		$statusString ['statusCode'] = $errorString;
		$statusString ['md5sum'] = '0';
		$resultjson = json_encode ( $statusString, JSON_UNESCAPED_SLASHES );
		return $resultjson;
	}
	public function sendmd5Sum($md5sum) {
		$statusString ['statusCode'] = 'Ok';
		$statusString ['md5sum'] = $md5sum;
		$resultjson = json_encode ( $statusString, JSON_UNESCAPED_SLASHES );
		return $resultjson;
	}
	public function sendStatusPostnotSetError() {
		$statusString ['statusCode'] = 'POST is not set';
		$statusString ['md5sum'] = '0';
		$resultjson = json_encode ( $statusString, JSON_UNESCAPED_SLASHES );
		return $resultjson;
	}
	public function sendStatusPostWrongError() {
		$statusString ['statusCode'] = 'POST is wrong';
		$statusString ['md5sum'] = '0';
		$resultjson = json_encode ( $statusString, JSON_UNESCAPED_SLASHES );
		return $resultjson;
	}
	public function sendStatusLoginError() {
		$statusString ['statusCode'] = 'Wrong Username or Password!';
		$statusString ['md5sum'] = '0';
		$resultjson = json_encode ( $statusString, JSON_UNESCAPED_SLASHES );
		return $resultjson;
	}
}

?>