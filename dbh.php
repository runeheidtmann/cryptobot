<?php

class dbh{
	private $servername;
	private $username;
	private $password;
	private $dbname;

	/**
	 * Put in your databaseinfo.
	 */
	public function connect(){
		$this->servername = "";
		$this->username = "";
		$this->password = "";
		$this->dbname = "";

		$conn = new mysqli($this->servername,$this->username,$this->password,$this->dbname);
		return $conn;

	}
}
?>