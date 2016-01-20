<?php
class Conexion{

	private 	$host;
	private 	$usuario;
	private 	$password;
	private 	$db;

	function __construct(){
		$this->host 	= "mysql:host=localhost; dbname=motocoms_contacto;charset=utf8";
		$this->usuario	= "motocoms_pagina";
		$this->password = "#pagina14()#";
	}
	public function conecta(){
		try {
			// Conexión a Mysql
            $this->db = new PDO($this->host,$this->usuario,$this->password);
            $this->db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

            return $this->db;

	    } catch (PDOException $e) {
	        print "<p>Error: No puede conectarse con la base de datos.</p>\n";
	        exit();
	    }
	}

}