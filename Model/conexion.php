<?php
class conexion { 
	public $ID;
	private $Server;
	private $User;
	private $Password;
	private $DataBase;

	public function __construct ($server="localhost", $user="root", $password = "", $database=""){
		$this->Server  = $server;
		$this->User  = $user;					
		$this->DataBase  = $database;
		$this->Password  = $password;
		$this->ID = mysql_pconnect($server, $user, $password);
		mysql_select_db($database);
        mysql_query("SET NAMES 'utf8'");
		if (!$this->ID) {
			die('No Conexion: '.mysql_error());
		}
	}
} 
?>

