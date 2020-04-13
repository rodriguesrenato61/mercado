<?php

	require_once("database/connection.php");
	require_once("Produto.php");
	
	class Venda{
	
		private $pdo;
		private $produto;
		
		public function __construct(){
			global $connection;
			$this->pdo = $connection->getPdo();
			$this->produto = new Produto();
		}
		
		
		public function create($carrinho_id, $codigo, $unidades){
			
			$row = $this->produto->get($codigo);
			$estoque = (int) $row['estoque'];
		
			if($unidades <= $estoque){
				
				$sql = $this->pdo->prepare("CALL registrar_venda(:i, :c, :u)");
				$sql->bindValue(":i", (int) $carrinho_id);
				$sql->bindValue(":c", (int) $codigo);
				$sql->bindValue(":u", (int) $unidades);
			
				try{
					$sql->execute();
					$retorno[] = array(
						"type" => true,
						"msg" => "Venda criada com sucesso!"
					);
				}catch(Exception $e){
					$retorno[] = array(
						"type" => false,
						"msg" => "Erro ao registrar venda!"
					);
				}
			
			}else{
			
				$retorno[] = array(
					"type" => false,
					"msg" => "Erro, estoque insuficiente!"
				);
			}
			
			return $retorno;
		}
	
		public function index($carrinho_id, $status){
		
			$sql = $this->pdo->prepare("SELECT * FROM vw_vendas WHERE venda_status = :s AND carrinho_id = :c ORDER BY dt_criacao DESC");
			if($status == 0){
				$sql->bindValue(":s", "Não pago");
			}else{
				$sql->bindValue(":s", "Pago");
			}
			
			$sql->bindValue(":c", (int) $carrinho_id);
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
			$sql = $this->pdo->prepare("SELECT SUM(total_venda) AS total FROM vw_vendas WHERE carrinho_id = :c");
			$sql->bindValue(":c", (int) $carrinho_id);
			$sql->execute();
			
			while($registro = $sql->fetch()){
				$vendas[] = array(
					"total" => number_format((float) $registro['total'], 2, ',', '.')
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
			$sql = $this->pdo->prepare("CALL delete_venda(:c, :p)");
			$sql->bindValue(":c", (int) $carrinho_id);
			$sql->bindValue(":p", (int) $codigo);
			
			try{
				$sql->execute();
				$registro[] = array("msg" => 1);
			}catch(Exception $e){
				$registro[] = array("msg" => 0);
			}
			
			return json_encode($registro);
		}
	}

?>
