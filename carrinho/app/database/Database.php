<?php

	class Database{
	
		private $pdo;
		
		public function __construct($host, $dbname, $user, $password){
		
			try{
				$this->pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $user, $password);
			}catch(Exception $e){
				echo("Erro ao conectar ao banco: ".$e->getMessage());
			}
		}
		
		public function getPdo(){
			return $this->pdo;
		}
	}
?>
