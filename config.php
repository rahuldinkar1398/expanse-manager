<?php

class Config {
	public function connection(){
		$host = 'localhost';
		
		$db_user = 'root';
		$db_pass = '';
		$db_name = 'expanse_db';
		$db = new mysqli($host, $db_user, $db_pass, $db_name);
		if($db->connect_error) {
				die('Could Not Connect: ' . $db->connect_error);
		}
		return $db;
	}
}
?>