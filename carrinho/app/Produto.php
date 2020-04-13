<?php

	require_once('database/connection.php');

	class Produto{
		
		private $pdo, $total;
		
		public function __construct(){
			global $connection;
			$this->pdo = $connection->getPdo();
		}

		public function index($codigo, $nome, $categoria_id, $page){
			
			$query = "SELECT * FROM vw_produtos";
			$query_total = "SELECT COUNT(*) AS total FROM vw_produtos";
			$limit = 5;
			
			$clausulas = array();
			$i = 0;
			
			if($codigo != "" && $codigo != "0" && $codigo != null){
				$codigo = (int) $codigo;
				$clausulas[$i] = "codigo = ".$codigo;
				$i++;
			}
			
			if($nome != "" && $nome != null){
				$clausulas[$i] = "produto LIKE '%".$nome."%'";
				$i++;
			}
			
			if($categoria_id != "0"){
				$categoria_id = (int) $categoria_id;
				$clausulas[$i] = "categoria_id = ".$categoria_id;
				$i++;
			}
			
			for($cont = 0; $cont < $i; $cont++){
				if($cont == 0){
					$query .= " WHERE ".$clausulas[$cont];
					$query_total .= " WHERE ".$clausulas[$cont];
				}else{
					$query .= " AND ".$clausulas[$cont];
					$query_total .= " WHERE ".$clausulas[$cont];
				}
			}
			
			$this->setTotal($query_total);
			
			$query .= " ORDER BY produto";
			
			if($page != null && $page != "0"){
				$page = (int) $page;
				$query .= " LIMIT ".(($page - 1) * $limit).", ".$limit;
			}
			
			$sql = $this->pdo->prepare($query);
			$sql->execute();
			
			return $sql;
		}
		
		public function get($codigo){
			
			$sql = $this->pdo->prepare("SELECT * FROM vw_produtos WHERE codigo = :c");
			$sql->bindValue(":c", (int) $codigo);
			$sql->execute();
			
			return $sql->fetch();
		}
		
		public function categorias(){
			$sql = $this->pdo->prepare("SELECT * FROM categorias");
			$sql->execute();
			
			return $sql;
		}
		
		public function create($nome, $categoria_id, $pcusto, $pvenda, $estoque){
			
			$sql = $this->pdo->prepare("SELECT * FROM produtos WHERE nome = :nome");
			$sql->bindValue(":nome", $nome);
			$sql->execute();
			
			if($sql->rowCount() > 0){
				$retorno[] = array(
					"tipo" => false,
					"msg" => "Erro, esse nome ja existe!"
				);
			}else{
				$pcusto = (float) $pcusto;
				$pvenda = (float) $pvenda;
				if($pcusto > 0 && $pvenda > 0){
					$estoque = (int) $estoque;
					if($estoque >= 0){
						try{
							$sql = $this->pdo->prepare("CALL insert_produto(:nome, :categoria_id, :pcusto, :pvenda, :estoque)");
							$sql->bindValue(":nome", $nome);
							$sql->bindValue(":categoria_id", (int) $categoria_id);
							$sql->bindValue(":pcusto", $pcusto);
							$sql->bindValue(":pvenda", $pvenda);
							$sql->bindValue(":estoque", $estoque);
							$sql->execute();
							
							$retorno[] = array(
								"tipo" => true,
								"msg" => "Produto inserido com sucesso!"
							);
						}catch(Exception $e){
							$retorno[] = array(
								"tipo" => false,
								"msg" => "Erro ao realizar operacao!"
							);
						}
					}else{
						$retorno[] = array(
							"tipo" => false,
							"msg" => "Erro, estoque invalido!"
						);
					}
				}else{
					$retorno[] = array(
						"tipo" => false,
						"msg" => "Erro, coloque os precos corretamente!"
					);
				}
			}
			
			return $retorno;
		}
		
		public function update($codigo, $nome, $categoria_id, $pcusto, $pvenda, $estoque){
			$sql = $this->pdo->prepare("SELECT * FROM produtos WHERE codigo != :codigo AND nome = :nome");
			$sql->bindValue(":codigo", (int) $codigo);
			$sql->bindValue(":nome", $nome);
			$sql->execute();
			
			if($sql->rowCount() > 0){
				$retorno[] = array(
					"tipo" => false,
					"msg" => "Erro, esse nome ja existe!"
				);
			}else{
				$pcusto = (float) $pcusto;
				$pvenda = (float) $pvenda;
				if($pcusto > 0 && $pvenda > 0){
					$estoque = (int) $estoque;
					if($estoque >= 0){
						try{
							$sql = $this->pdo->prepare("CALL update_produto(:codigo, :nome, :categoria_id, :pcusto, :pvenda, :estoque)");
							$sql->bindValue(":codigo", (int) $codigo);
							$sql->bindValue(":nome", $nome);
							$sql->bindValue(":categoria_id", (int) $categoria_id);
							$sql->bindValue(":pcusto", $pcusto);
							$sql->bindValue(":pvenda", $pvenda);
							$sql->bindValue(":estoque", $estoque);
							$sql->execute();
							
							$retorno[] = array(
								"tipo" => true,
								"msg" => "Produto atualizado com sucesso!"
							);
						}catch(Exception $e){
							$retorno[] = array(
								"tipo" => false,
								"msg" => "Erro ao realizar operacao!"
							);
						}
					}else{
						$retorno[] = array(
							"tipo" => false,
							"msg" => "Erro, estoque invalido!"
						);
					}
				}else{
					$retorno[] = array(
						"tipo" => false,
						"msg" => "Erro, coloque os precos corretamente!"
					);
				}
			}
			
			return $retorno;
		}
		
		public function delete($codigo){
				$sql = $this->pdo->prepare("SELECT * FROM produtos WHERE codigo = :codigo");
				$sql->bindValue(":codigo", (int) $codigo);
				$sql->execute();
				
				if($sql->rowCount() > 0){
					try{
						$sql = $this->pdo->prepare("CALL delete_produto(:codigo)");
						$sql->bindValue(":codigo", (int) $codigo);
						$sql->execute();
						
						$retorno[] = array(
							"tipo" => true,
							"msg" => "Produto deletado com sucesso!"
						);
					}catch(Exception $e){
						$retorno[] = array(
							"tipo" => false,
							"msg" => "Erro ao deletar produto!"
						);
					}
				}else{
					$retorno[] = array(
						"tipo" => false,
						"msg" => "Erro, produto nao encontrado!"
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
