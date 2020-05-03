<?php

	require_once("database/connection.php");
	require_once("database/Mensagem.php");
	require_once("Sessao.php");
	
	class User{
		
		private $pdo, $msg, $user_id, $sessao, $total, $limit;
		
		public function __construct(){
			global $connection;
			
			$this->msg = new Mensagem;
			
			$this->pdo = $connection->getPdo();
			
			$this->sessao = new Sessao();
			
			$this->total = 0;
			
		}
		
		public function niveis(){
			global $connection;
			
			return $connection->selectNiveis();
		}
		
		public function create($nome, $email, $user_name, $passwd, $fone, $zap, $tipo){
			
			global $connection;
			
			$sql = $this->pdo->prepare("SELECT COUNT(*) AS total FROM users WHERE email = '".$email."'");
			$sql->execute();
			$row = $sql->fetch();
			$total = $row['total'];
			
			if($total > 0){
				
				$this->msg->set(false, "Erro, este email já está em uso!");
				$retorno = $this->msg->get();
				
			}else{

				$retorno = $connection->insert_user($nome, $email, $user_name, $passwd, $fone, $zap, $tipo);
				
			}
			
			return $retorno;
		} 
		
		public function index($nome, $nivel, $page){
			
			global $connection;
			
			$sql = $connection->vw_users($nome, $nivel, $page);
			$this->total = $connection->getTotal();
			$this->limit = $connection->getLimit();
			
			return $sql;
		}
		
		public function getLimit(){
			return $this->limit;
		}
		
		public function update($id, $nome, $email, $user_name, $passwd, $fone, $zap, $tipo){
			global $connection;
			$sql = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE (user_name = :user_name OR email = :email) AND id != :id");
			$sql->bindValue(":user_name", $user_name);
			$sql->bindValue(":email", $email);
			$sql->bindValue(":id", (int) $id);
			try{
				$sql->execute();
				$row = $sql->fetch();
				$linhas = (int) $row[0];
				if($linhas > 0){
					$this->msg->set(false, "Erro, já existe usuário com esses dados!");
					$retorno = $this->msg->get();
				}else{
					$retorno = $connection->update_user($id, $nome, $email, $user_name, $passwd, $fone, $zap, $tipo);
					$this->sessao->setMsg($retorno[0]['tipo'], $retorno[0]['msg']);
				}
			}catch(Exception $e){
				$this->msg->set(false, "Erro ao analisar dados!");
				$retorno = $this->msg->get();
			}
			
			return $retorno;
		}
		
		public function delete($user_id){
			global $connection;
			$sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :user_id");
			$sql->bindValue(":user_id", (int) $user_id);
			try{
				$sql->execute();
				if($sql->rowCount() > 0){
					$mensagem = $connection->delete_user($user_id);
					$this->msg->set($mensagem[0]['tipo'], $mensagem[0]['msg']);
				}else{
					$this->msg->set(false, "Erro, não existe nenhum usuário com esse id!");
				}
			}catch(Exception $e){
				$this->msg->set(false, "Erro ao buscar usuário!");
			}
			
			return $this->msg->get();
		}
		
		public function getTotal(){
			return $this->total;
		}
		
		public function get($user_id){
		
			$sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :user_id");
			$sql->bindValue(":user_id", (int) $user_id);
			$sql->execute();
		
			return $sql->fetch();
		}
		
		public function getUserLogin(){
			$user_id = $this->sessao->getUser_id();
			return $this->get($user_id);
		}
		
		public function tipos(){
			$sql = $this->pdo->prepare("SELECT * FROM niveis WHERE id != 1");
			$sql->execute();
			
			return $sql;
		}
		
		public function acessar($pagina){
			
			global $connection;
			
			$user_id = $this->sessao->getUser_id();
			
			switch($pagina){
				
				case "home admin":
					
					if($user_id){
						
						if(!$connection->permite($user_id, 2)){
							header("Location: ../../404/index.html");
						}
					}else{
						
						header("Location: ../../login/index.php");
					}
				break;
				
				case "cadastrar mercado":
					
					if(!$user_id){
						
						header("Location: ../../login/index.php");
						
					}
				break;
				
				case "visualizar produtos":
					
					if($user_id){
						if(!$connection->permite($user_id, 3)){
							header("Location: ../../404/index.html");
						}
						
					}else{
						header("Location: ../../login/index.php");
					}
				break;
				
				case "visualizar vendas":
					
					if($user_id){
						if(!$connection->permite($user_id, 7)){
							header("Location: ../../404/index.html");
						}
						
					}else{
						header("Location: ../../login/index.php");
					}
				break;
				
				case "visualizar carrinhos":
					
					if($user_id){
						if(!$connection->permite($user_id, 9)){
							header("Location: ../../404/index.html");
						}
						
					}else{
						header("Location: ../../login/index.php");
					}
				break;
				
				case "visualizar usuários":
					
					if($user_id){
						if(!$connection->permite($user_id, 10)){
							header("Location: ../../404/index.html");
						}
						
					}else{
						header("Location: ../../login/index.php");
					}
				break;
			}
		}
		
		public function logar($user, $password){
			global $connection;
		
			try{
			
				$sql = $connection->logar($user, $password);
				
				if($sql->rowCount() > 0){
					$row = $sql->fetch();
					$id = (int) $row['id'];
					$this->sessao->setUser_id($id);
					$this->msg->set(true, "Usuário logado com sucesso!");
				}else{
					$this->sessao->anular();
					$this->msg->set(false, "Erro, usuário ou senha incorretos!");
				}
			
			}catch(Exception $e){
				$this->msg->set(false, "Erro ao executar operação!");
			}
			
			return $this->msg->get();
		}
		
		public function getMsg(){
			
			$mensagem = $this->sessao->getMsg();
			
			return $mensagem;
		}
		
	}

?>
