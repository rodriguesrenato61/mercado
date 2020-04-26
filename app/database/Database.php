<?php

	require_once("Mensagem.php");

	class Database{
	
		private $pdo, $msg, $total;
		
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
		
		//views
		public function vw_produtos($codigo, $nome, $categoria){
		
			$query = "SELECT * FROM vw_produtos";
			
			$clausulas = array();
			$valores = array();
			$i = 0;
			
			if($codigo != "" && $codigo != "0" && $codigo != null){
				$clausulas[$i] = "codigo = :codigo";
				$valores[$i]['campo'] = ":codigo";
				$valores[$i]['valor'] = (int) $codigo;
				$i++;
			}
			
			
			if($nome != "" && $nome != null){
				$clausulas[$i] = "produto LIKE :produto";
				$valores[$i]['campo'] = ":produto";
				$valores[$i]['valor'] = "%".$nome."%";
				$i++;
			}
			
			if($categoria != "" && $categoria != "0" && $categoria != null){
				$clausulas[$i] = "categoria_id = :categoria";
				$valores[$i]['campo'] = ":categoria";
				$valores[$i]['valor'] = (int) $categoria;
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
			
			$query .= $filtros;
			$sql = $this->pdo->prepare($query);
			for($cont = 0; $cont < $i; $cont++){
				$sql->bindValue($valores[$cont]['campo'], $valores[$cont]['valor']);
			}
			
			$sql->execute();
			
			
			return $sql;
		} 
		
		public function vw_users($nome, $nivel, $page){
		
			$limit = 5;
			
			$query = "SELECT * FROM vw_users WHERE tipo_id != 1";
			$query_total = "SELECT COUNT(*) AS total FROM vw_users"; 
			$clausulas[] = array();
			$valores[] = array();
			$j = 0;
			
			if($nome != "" && $nome != null){
				$clausulas[$j] = "nome LIKE :nome";
				$valores[$j]['campo'] = ":nome";
				$valores[$j]['valor'] = '%'.$nome.'%';
				$j++;
			}
			
			if($nivel != "" && $nivel != "0" && $nivel != null){
				$clausulas[$j] = "tipo_id = :nivel_id";
				$valores[$j]['campo'] = ":nivel_id";
				$valores[$j]['valor'] = (int) $nivel;
				$j++;
			}
			
			$filtros = "";
			
			for($i = 0; $i < $j; $i++){
				$filtros .= " AND ".$clausulas[$i];
			}
			
			$query_total .= $filtros;
			
			if($page != "0" && $page != "" && $page != null){
				$pagina = (int) $page;
				$atual = (($pagina - 1) * $limit);
				$filtros .= " LIMIT ".$atual.", ".$limit;
			}
			
			$query .= $filtros;
			$sql = $this->pdo->prepare($query);
			$sql2 = $this->pdo->prepare($query_total);
			for($i = 0; $i < $j; $i++){
				$sql->bindValue($valores[$i]['campo'], $valores[$i]['valor']);
				$sql2->bindValue($valores[$i]['campo'], $valores[$i]['valor']);
			}
			
			$sql->execute();
			$sql2->execute();
			$row = $sql2->fetch();
			$this->total = (int) $row['total'];
			
			return $sql;
		}
		
		//retornando total de registros encontrados em uma consulta
		public function getTotal(){
			return $this->total;
		}
		
		//selects
		public function selectNiveis(){
			$sql = $this->pdo->prepare("SELECT * FROM niveis WHERE id != 1");
			$sql->execute();
			
			return $sql;
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
		
		//procedures
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
		
		public function update_user($id, $nome, $email, $user_name, $passwd, $fone, $zap, $tipo){
			
			$sql = $this->pdo->prepare("CALL update_user(:id, :nome, :email, :user_name, :passwd, :fone, :zap, :tipo)");
			$sql->bindValue(":id", (int) $id);
			$sql->bindValue(":nome", $nome);
			$sql->bindValue(":email", $email);
			$sql->bindValue(":user_name", $user_name);
			$sql->bindValue(":passwd", md5($passwd));
			$sql->bindValue(":fone", $fone);
			$sql->bindValue(":zap", $zap);
			$sql->bindValue(":tipo", (int) $tipo);
			
			try{
				$sql->execute();
				$this->msg->set(true, "Usuário atualizado com sucesso!");
			}catch(Exception $e){
				$this->msg->set(false, "Erro ao atualizar usuário!");
			}
			
			return $this->msg->get();
		}
		
		public function delete_user($id){
			
			$sql = $this->pdo->prepare("CALL delete_user(:id)");
			$sql->bindValue(":id", (int) $id);
			
			try{
				$sql->execute();
				$this->msg->set(true, "Usuário deletado com sucesso!");
			}catch(Exception $e){
				$this->msg->set(false, "Erro ao deletar usuário!");
			}
			
			return $this->msg->get();
		}
		
		public function logar($user, $password){
		
			$sql = $this->pdo->prepare("SELECT * FROM users WHERE (email = :email OR user_name = :user_name) AND passwd = :password");
			$sql->bindValue(":email", $user);
			$sql->bindValue(":user_name", $user);
			$sql->bindValue(":password", md5($password));
			$sql->execute();
		
			return $sql;
		}
		
		//functions
		public function permite($user_id, $permissao_id){
			
			$sql = $this->pdo->prepare("SELECT permite(:user_id, :permissao_id)");
			$sql->bindValue(":user_id", (int) $user_id);
			$sql->bindValue(":permissao_id", (int) $permissao_id);
			$sql->execute();
			
			$row = $sql->fetch();
			
			return (boolean) $row[0];
		} 
	}
?>
