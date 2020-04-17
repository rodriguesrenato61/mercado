<?php

	require_once("database/connection.php");

	class Mercado{
		
		private $pdo, $msg, $total;
		
		public function __construct(){
			global $connection;
			$this->pdo = $connection->getPdo();
			$this->msg = new Mensagem;
		}
		
		public function index($email, $page){
			
			$limit = 5;
			
			$query = ("SELECT * FROM vw_mercados");
			$query_total = ("SELECT COUNT(*) AS total FROM vw_mercados");
			
			$clausulas[] = array();
			$i = 0;
			
			if($email != "" && $email != null){
				$clausulas[$i] = "email = '".$email."'";
				$i++;
			}
			
			$filtros = "";
			
			for($cont = 0; $cont < $i; $cont++){
				if($cont == 0){
					$filtros .= " WHERE ".$clausulas[$cont];
				}else{
					$filtros .= " AND ".$clausulas[$cont];
				}
			}
			
			$query_total .= $filtros;
			$this->setTotal($query_total);
			
			$query .= $filtros;
			
			$query .= " ORDER BY mercado";
			
			if($page != null && $page != "" && $page != "0"){
				$page = (int) $page;
				$query .= " LIMIT ".(($page - 1) * limit).", ".$limit;
			}
			
			$sql = $this->pdo->prepare($query);
			$sql->execute();
			
			return $sql;
		}
		
		public function create($nome, $email, $endereco, $cnpj, $fone, $zap, $admin){
			global $connection;
			$query = ("SELECT COUNT(*) AS total FROM estabelecimentos WHERE email = '".$email."' OR cnpj = '".$cnpj."'");
			$total = $connection->selectCount($query);
			if($total > 0){
				$this->msg->set(false, "Erro já existe um mercado com esses dados!");
				$retorno = $this->msg->get();
			}else{
				$retorno = $connection->insert_mercado($nome, $email, $endereco, $cnpj, $fone, $zap, $admin);
			}
			
			return $retorno;
		}
		
		public function setTotal($query){
			$sql = $this->pdo->prepare($query);
			$sql->execute();
			$row = $sql->fetch();
			
			$this->total = (int) $row[0];
		}
		
		public function getTotal(){
			return $this->total;
		}
		
	}

?>
