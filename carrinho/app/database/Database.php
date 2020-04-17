<?php

	require_once("Mensagem.php");

	class Database{
	
		private $pdo, $msg;
		
		public function __construct($host, $dbname, $user, $password){
			
			$this->msg = new Mensagem;
			
			try{
				$this->pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $user, $password);
			}catch(Exception $e){
				echo("Erro ao conectar ao banco: ".$e->getMessage());
			}
		}
		
		public function getPdo(){
			return $this->pdo;
		}
		
		public function selectCount($query){
			
			$sql = $this->pdo->prepare($query);
			
			try{
				$sql->execute();
				$row = $sql->fetch();
				$total = (int) $row['total'];
			}catch(Exception $e){
				$total = false;
			}
			
			return $total;
		}
		
		public function selectIntNumber($query){
			
			$sql = $this->pdo->prepare($query);
			
			try{
				$sql->execute();
				$row = $sql->fetch();
				$result = (int) $row[0];
			}catch(Exception $e){
				$result = false;
			}
			
			return $result;
		}
		
		public function insert_user($nome, $email, $user_name, $passwd, $fone, $zap, $tipo){
			
			$sql = $this->pdo->prepare("CALL insert_user(:nome, :email, :user_name, :passwd, :fone, :zap, :tipo)");
			$sql->bindValue(":nome", $nome);
			$sql->bindValue(":email", $email);
			$sql->bindValue(":user_name", $user_name);
			$sql->bindValue(":passwd", md5($passwd));
			$sql->bindValue(":fone", $fone);
			$sql->bindValue(":zap", $zap);
			$sql->bindValue(":tipo", (int) $tipo);
			
			try{
				$sql->execute();
				$this->msg->set(true, "Usuário inserido com sucesso!");
			}catch(Exception $e){
				$this->msg->set(false, "Erro ao inserir usuário!");
			}
			
			return $this->msg->get();
		}
		
		public function insert_mercado($nome, $email, $endereco, $cnpj, $fone, $zap, $admin){
			$sql = $this->pdo->prepare("CALL insert_mercado(:nome, :email, :endereco, :cnpj, :fone, :zap, :admin)");
			$sql->bindValue(":nome", $nome);
			$sql->bindValue(":email", $email);
			$sql->bindValue(":endereco", $endereco);
			$sql->bindValue(":cnpj", $cnpj);
			$sql->bindValue(":fone", $fone);
			$sql->bindValue(":zap", $zap);
			$sql->bindValue(":admin", (int) $admin);
		
			try{
				$sql->execute();
				$this->msg->set(true, "Mercado cadastrado com sucesso!");
			}catch(Exception $e){
				$this->msg->set(false, "Erro ao cadastrar mercado!"); 
			}
		
			return $this->msg->get();
		}
	}
?>
