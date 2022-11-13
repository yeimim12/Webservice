<?php
	/*
		Clase de conexión a MySQL 

		La clase PDO => se encarga de mantener la conexión a la base de datos 
	*/
	class Conexion extends PDO
	{
		private $hostBd = 'localhost';
		private $nombreBd = 'web_service';
		private $usuarioBd = 'root';
		private $passwordBd = '';


		/*
		CONSTRUCTOR
	    */
		
		public function __construct()
		{
			try{
				parent::__construct('mysql:host=' . $this->hostBd . ';dbname=' . $this->nombreBd . ';charset=utf8', $this->usuarioBd, $this->passwordBd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				
				} 
				/*
				Error 
	    		*/
				catch(PDOException $e){
				echo 'Error: ' . $e->getMessage();
				exit;
			}
		}
	}
?>