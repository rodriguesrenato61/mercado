<?php

	require_once("database/connection.php");
	require_once("database/Mensagem.php");
	require_once("Sessao.php");
	
	class User{
		
		private $pdo, $msg, $user_id, $sessao;
		
		public function __construct(){
			global $connection;
			
			$this->msg = new Mensagem;
			
			$this->pdo = $connection->getPdo();
			
			$this->sessao = new Sessao();
			
		}
		
		public function create($nome, $email, $user_name, $passwd, $fone, $zap, $tipo){
			
			global $connection;
			
			$query = ("SELECT COUNT(*) AS total FROM users WHERE email = '".$email."'");
			
			$total = $connection->selectCount($query);
			
			if($total > 0){
				
				$this->msg->set(false, "Erro, este email já está em uso!");
				$retorno = $this->msg->get();
				
			}else{

				$retorno = $connection->insert_user($nome, $email, $user_name, $passwd, $fone, $zap, $tipo);
				
				if($retorno[0]['tipo']){
					$tipo_id = (int) $tipo;
					if($tipo_id == 2){
						$admin_id = $connection->selectIntNumber("SELECT MAX(id) AS ultimo FROM users");
						$this->sessao->setUser_id($admin_id);
					}else{
						$this->sessao->anular();
					}
				}
				
			}
			
			return $retorno;
		} 
		
		public function get($user_id){
		
			$sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :user_id");
			$sql->bindValue(":user_id", (int) $user_id);
			$sql->execute();
		
			return $sql->fetch();
		}
		
		
		public function tipos(){
			$sql = $this->pdo->prepare("SELECT * FROM niveis WHERE id != 1");
			$sql->execute();
			
			return $sql;
		}
		
		public function acessar($pagina){
			
			switch($pagina){
				
				case "home admin":
				
					$user_id = $this->sessao->getUser_id();
					
					if($user_id != false){
						
						$usuario_dados = $this->get($user_id);
						
						if($usuario_dados['tipo_id'] != "2"){
							header("Location: ../../404/index.html");
						}
					}else{
						
						header("Location: ../views/404/index.html");
					}
				break;
				
				case "cadastrar mercado":
				
					$user_id = $this->sessao->getUser_id();
					
					if(!$user_id){
						
						header("Location: ../../404/index.html");
						
					}
				break;
			}
		}
	}

?>
