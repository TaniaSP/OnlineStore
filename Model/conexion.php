<?php
class  conexion {
	public $id;
	private $servidor;
	private $usuario;
	private $contrasena;
	private $baseDeDatos;

	public function __construct ($servidor="localhost", $usuario="root", $contrasena = "", $baseDeDatos="tiendaenlinea"){
		$this->servidor  = $servidor;
		$this->usuario  = $usuario;					
		$this->baseDeDatos  = $baseDeDatos;
		$this->contrasena  = $contrasena;
		$this->id = mysql_pconnect($servidor, $usuario, $contrasena);
		mysql_select_db($baseDeDatos);
        mysql_query("SET NAMES 'utf8'");
		if (!$this->id) {
			die('No pudo conectarse: '.mysql_error());
		}
	}
}
?>