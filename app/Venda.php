<?php

	require_once("database/connection.php");
	require_once("Produto.php");
	
	class Venda{
	
		private $pdo, $total;
		private $produto, $msg;
		public $query_string;
		
		public function __construct(){
			global $connection;
			$this->pdo = $connection->getPdo();
			$this->produto = new Produto();
			$this->msg = new Mensagem;
		}
		
		
		public function create($carrinho_id, $codigo, $unidades){
			
			global $connection;
			
			$row = $this->produto->get($codigo);
			
			$estoque = (int) $row['estoque'];
		
			if($unidades <= $estoque){
				
				$result = $connection->insert_venda($carrinho_id, $codigo, $unidades);
				
				$this->msg->set($result[0]['tipo'], $result[0]['msg']);
			
			}else{
			
				$this->msg->set(false, "Erro, estoque insuficiente!");
				
			}
			
			return $this->msg->get();
		}
	
		public function index($carrinho_id, $status, $inicio, $fim, $page){
			
			$limit = 10;
			
			$query = "SELECT * FROM vw_vendas";
			$query_total = "SELECT COUNT(*) AS total FROM vw_vendas";
			
			$clausulas[] = array();
			$i = 0;
			
			if($carrinho_id != null && $carrinho_id != "0"){
				$carrinho_id = (int) $carrinho_id;
				$clausulas[$i] = "carrinho_id = ".$carrinho_id;
				$i++;
			}
			
			if($status != null && $status != ""){
				$status = (int) $status;
				switch($status){
					case 0:
						$clausulas[$i] = "venda_status = 'Não pago'";
						$i++;
					break;
					case 1:
						$clausulas[$i] = "venda_status = 'Pago'";
						$i++;
					break;
				}
				
			}
			
			if($inicio != null && $inicio != ""){
				$clausulas[$i] = "data_venda >= '".$inicio."'";
				$i++;
			}
			
			if($fim != null && $fim != ""){
				$clausulas[$i] = "data_venda <= '".$fim."'";
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
			
			$filtros .= " ORDER BY dt_criacao DESC";
			
			if($page != "" && $page != null && $page != "0"){
				$filtros .= " LIMIT ".(($page - 1) * $limit).", ".$limit;
			}
			
			$query .= $filtros;
			
			$this->query_string = $query;
		
			$sql = $this->pdo->prepare($query);
			
			$sql->execute();
			
			return $sql;
		}
		
		public function get($venda_id){
			
			$sql = $this->pdo->prepare("SELECT * FROM vw_vendas WHERE id = :v");
			$sql->bindValue(":v", (int) $venda_id);
			$sql->execute();
			
			return $sql->fetch();
		}
		
		public function getTotal($carrinho_id){
			$sql = $this->pdo->prepare("SELECT SUM(total_venda) AS total, SUM(unidades) AS total_unidades FROM vw_vendas WHERE carrinho_id = :c");
			$sql->bindValue(":c", (int) $carrinho_id);
			$sql->execute();
			
			while($registro = $sql->fetch()){
				$vendas[] = array(
					"total" => number_format((float) $registro['total'], 2, ',', '.'),
					"unidades" => $registro['total_unidades']
				);
			}
			
			return json_encode($vendas);
		}
		
		public function update($venda_id, $unidades){
			$unidades = (int) $unidades;
			$venda = $this->get($venda_id);
			$venda_unidades = (int) $venda['unidades'];
			if($unidades > $venda_unidades){
				$row = $this->produto->get($venda['codigo']);
				$estoque = (int) $row['estoque'];
				$restante = $unidades - $venda_unidades;
				if($estoque >= $restante){
					$sql = $this->pdo->prepare("UPDATE produtos SET estoque = estoque - :r WHERE codigo = :c");
					$sql->bindValue(":r", $restante);
					$sql->bindValue(":c", (int) $venda['codigo']);
					$sql->execute();
					
					$sql = $this->pdo->prepare("UPDATE vendas SET unidades = :u WHERE id = :v");
					$sql->bindValue(":u", (int) $unidades);
					$sql->bindValue(":v", (int) $venda_id);
					$sql->execute();
					
					$retorno[] = array(
						"msg" => "Venda atualizada, estoque diminuiu!"
					);
					
				}else{
					$retorno[] = array(
						"msg" => "Erro, estoque insuficiente!"
					);
				}
				
			}
				
			if($unidades < $venda_unidades){
				$restante = $venda_unidades - $unidades;
				$sql = $this->pdo->prepare("UPDATE produtos SET estoque = estoque + :r WHERE codigo = :c");
				$sql->bindValue(":r", $restante);
				$sql->bindValue(":c", (int) $venda['codigo']);
				$sql->execute();
				
				$sql = $this->pdo->prepare("UPDATE vendas SET unidades = :u WHERE id = :v");
				$sql->bindValue(":u", (int) $unidades);
				$sql->bindValue(":v", (int) $venda_id);
				$sql->execute();
				$retorno[] = array(
						"msg" => "Venda atualizada, estoque aumentou!"
					);
			}
			
			return $retorno;	
		}
		
		public function delete($carrinho_id, $codigo){
			global $connection;
			
			$result = $connection->delete_venda($carrinho_id, $codigo);
			
			return $result;
		}
		
		public function setTotal($query){
			$sql = $this->pdo->prepare($query);
			$sql->execute();
			$row = $sql->fetch();
			
			$this->total = (int) $row['total'];
		}
		
		public function getTotalRegistros(){
			return $this->total;
		}
	}

?>
