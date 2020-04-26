<?php

	require_once("database/connection.php");
	
	class Carrinho{
		
		private $pdo, $total;
		
		public function __construct(){
			global $connection;
			$this->pdo = $connection->getPdo();
		}
		
		public function index($inicio, $fim, $page){
			
			$limit = 5;
			
			$query = "SELECT * FROM vw_carrinhos";
			$query_total = "SELECT COUNT(*) AS total FROM vw_carrinhos";
			
			$clausulas[] = array();
			$i = 0;
			
			if($inicio != null && $inicio != ""){
				$clausulas[$i] = "dt >= '".$inicio."'";
				$i++;
			}
			
			if($fim != null && $fim != ""){
				$clausulas[$i] = "dt <= '".$fim."'";
				$i++;
			}
			
			for($cont = 0; $cont < $i; $cont++){
				if($cont == 0){
					$query .= " WHERE ".$clausulas[$cont];
					$query_total .= " WHERE ".$clausulas[$cont];
				}else{
					$query .= " AND ".$clausulas[$cont];
					$query_total .= " AND ".$clausulas[$cont];
				}
			}
			
			$this->setTotal($query_total);
			
			if($page != "" && $page != null && $page != "0"){
				$query .= " LIMIT ".(($page - 1) * $limit).", ".$limit;
			}
			
			$sql = $this->pdo->prepare($query);
			$sql->execute();
			
			return $sql;
		}
		
		public function novo(){
			
			$sql = $this->pdo->prepare("SELECT COUNT(*) AS total FROM carrinhos WHERE status_carrinho = 'Em andamento'");
			$sql->execute();
			$row = $sql->fetch();
			$total = (int) $row['total'];
			if($total > 0){
				$retorno[] = array(
					"tipo" => false,
					"msg" => "Ainda existe carrinho(s) não terminado(s), deseja criar um novo mesmo assim?",
					"novo_id" => null
				);
			}else{
				
				$novo_id = $this->create();
				
				$retorno[] = array(
					"tipo" => true,
					"msg" => "Novo carrinho criado com sucesso!",
					"novo_id" => $novo_id
				);
			}
			
			return $retorno;
		}
		
		public function create(){
			
			$sql = $this->pdo->prepare("CALL novo_carrinho()");
			$sql->execute();
				
			$sql = $this->pdo->prepare("SELECT MAX(id) AS novo_id FROM carrinhos");
			$sql->execute();
			$row = $sql->fetch();
			$novo_id = (int) $row['novo_id'];
			
			return $novo_id;
		}
		
		public function get($carrinho_id){
			
			$sql = $this->pdo->prepare("SELECT * FROM vw_carrinhos WHERE id = :c");
			$sql->bindValue(":c", (int) $carrinho_id);
			$sql->execute();
			
			return $sql->fetch();
		}
		
		public function getNew(){
			
			$sql = $this->pdo->prepare("SELECT status_carrinho FROM carrinhos WHERE status_carrinho = :s");
			$sql->bindValue(":s", "Em andamento");
			$sql->execute();
			
			while($carrinho = $sql->fetch()){
				$result = $carrinho[0];
			}
			
			return $result;
		}
		
		public function finalizar($carrinho_id){
			
			$row = $this->get($carrinho_id);
			
			if($row['total_compra'] != null){ 
			
				$sql = $this->pdo->prepare("CALL fechar_carrinho(:c)");
				$sql->bindValue(":c", (int) $carrinho_id);
			
				try{
					$sql->execute();
					$retorno[] = array(
						"tipo" => true,
						"msg" => "Carrinho finalizado com sucesso!"
					);
				}catch(Exception $e){
					$retorno[] = array(
						"tipo" => false,
						"msg" => "Erro ao finalizar carrinho!"
					);
				}
				
			}else{ 
				$retorno[] = array(
					"tipo" => false,
					"msg" => "Vc não pode finalizar o carrinho se não houver nenhum produto nele!"
				);
			}
			
			return $retorno;
		}
		
		public function delete($carrinho_id){
		
			$sql = $this->pdo->prepare("SELECT * FROM carrinhos WHERE id = :c");
			$sql->bindValue(":c", (int) $carrinho_id);
			$sql->execute();
			
			if($sql->rowCount() > 0){
				
				$sql = $this->pdo->prepare("CALL delete_carrinho(:c)");
				$sql->bindValue(":c", (int) $carrinho_id);
				
				try{
					$sql->execute();
					$retorno[] = array(
						"tipo" => true,
						"msg" => "Carrinho deletado com sucesso!"
					);
				}catch(Exception $e){
					
					$retorno[] = array(
						"tipo" => false,
						"msg" => "Erro ao deletar carrinho!"
					);
				}
				
			}else{
			
				$retorno[] = array(
					"tipo" => false,
					"msg" => "Erro carrinho não encontrado!"
				);
				
			}
			
			return $retorno;
			
		}
		
		public function setTotal($query){
			$sql = $this->pdo->prepare($query);
			$sql->execute();
			$row = $sql->fetch();
			
			$this->total = (int) $row['total'];
		}
		
		public function getTotal(){
			return $this->total;
		}
	}

?>
