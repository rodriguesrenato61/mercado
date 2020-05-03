<?php

	require_once('database/connection.php');

	class Produto{
		
		private $pdo, $total, $msg, $limit;
		
		public function __construct(){
			global $connection;
			$this->pdo = $connection->getPdo();
			$this->msg = new Mensagem;
		}

		public function index($codigo, $nome, $categoria_id, $page){
			
			global $connection;
			
			$sql = $connection->vw_produtos($codigo, $nome, $categoria_id, $page);
			$this->total = $connection->getTotal();
			$this->limit = $connection->getLimit();
			
			return $sql;
		}
		
		public function get($codigo){
			
			$sql = $this->pdo->prepare("SELECT * FROM vw_produtos WHERE codigo = :c");
			$sql->bindValue(":c", (int) $codigo);
			$sql->execute();
			
			return $sql->fetch();
		}
		
		public function categorias(){
			global $connection;
			$sql = $connection->select_categorias();
			return $sql;
		}
		
		public function create($nome, $categoria_id, $pcusto, $pvenda, $estoque){
			global $connection;
			$sql = $this->pdo->prepare("SELECT * FROM produtos WHERE nome = :nome");
			$sql->bindValue(":nome", $nome);
			$sql->execute();
			
			if($sql->rowCount() > 0){
				$this->msg->set(false, "Erro, esse nome ja existe!");
				
			}else{
				$pcusto = (float) $pcusto;
				$pvenda = (float) $pvenda;
				if($pcusto > 0 && $pvenda > 0){
					$estoque = (int) $estoque;
					if($estoque >= 0){
						
						$result = $connection->insert_produto($nome, $categoria_id, $pcusto, $pvenda, $estoque);
						$this->msg->set($result[0]['tipo'], $result[0]['msg']);
						
					}else{
						$this->msg->set(false, "Erro, estoque invalido!");
						
					}
				}else{
					$this->msg->set(false, "Erro, coloque os precos corretamente!");
					
				}
			}
			
			return $this->msg->get();
		}
		
		public function update($codigo, $nome, $categoria_id, $pcusto, $pvenda, $estoque){
			global $connection;
			$sql = $this->pdo->prepare("SELECT * FROM produtos WHERE codigo != :codigo AND nome = :nome");
			$sql->bindValue(":codigo", (int) $codigo);
			$sql->bindValue(":nome", $nome);
			$sql->execute();
			
			if($sql->rowCount() > 0){
				
				$this->msg->set(false, "Erro, esse nome ja existe!");

			}else{
				$pcusto = (float) $pcusto;
				$pvenda = (float) $pvenda;
				if($pcusto > 0 && $pvenda > 0){
					$estoque = (int) $estoque;
					if($estoque >= 0){
						$result = $connection->update_produto($codigo, $nome, $categoria_id, $pcusto, $pvenda, $estoque);
						$this->msg->set($result[0]['tipo'], $result[0]['msg']);
					}else{
						$this->msg->set(false,"Erro, estoque invalido!");
					}
				}else{
					$this->msg->set(false, "Erro, coloque os precos corretamente!");
				}
			}
			
			return $this->msg->get();
		}
		
		public function delete($codigo){
			global $connection;
			
			$sql = $this->pdo->prepare("SELECT * FROM produtos WHERE codigo = :codigo");
			$sql->bindValue(":codigo", (int) $codigo);
			$sql->execute();
				
			if($sql->rowCount() > 0){
					
				$result = $connection->delete_produto($codigo);
				$this->msg->set($result[0]['tipo'], $result[0]['msg']);
						
			}else{
				$this->msg->set(false, "Erro, produto nao encontrado!");
			}
				
			return $this->msg->get();
		}
		
		public function getTotal(){
			return $this->total;
		}
		
		public function getLimit(){
			return $this->limit;
		}

	}

?>
