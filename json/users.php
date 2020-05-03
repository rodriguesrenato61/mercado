<?php

	
	
	if(isset($_GET['opcao'])){
		
		require_once("../app/User.php");
	
		$user = new User();
	
		$opcao = $_GET['opcao'];
		
		switch($opcao){
			
			case "index":
			
				//http://localhost/carrinho/json/users.php?opcao=index&nivel=&page=
				$nome = addslashes($_GET['nome']);
				$nivel = addslashes($_GET['nivel']);
				$page = addslashes($_GET['page']);
				
				$sql = $user->index($nome, $nivel, $page);
				
				
				while($row = $sql->fetch()){
					$registros[] = array(
						"id" => $row['id'],
						"nome" => $row['nome'],
						"email" => $row['email'],
						"user_name" => $row['user_name'],
						"nivel" => $row['nivel'],
						"fone" => $row['fone'],
						"zap" => $row['zap']
					);
				}
				
				$result[] = array(
					"registros" => $registros,
					"limit" => $user->getLimit(),
					"total" => $user->getTotal()
				);
				
				echo json_encode($result);		
			
			break;
			
			case "msg":
			
				echo json_encode($user->getMsg());
			
			break;
			
			/*case "create":*/
				// http://localhost/carrinho/json/users.php?opcao=create&nome=Renato+Rodrigues+de+Souza&email=rodriguesrenato70@gmail.com&user_name=rodriguesrenato70&password=123&fone=98999812283&zap=98999812283&tipo=3
				/*$nome = addslashes($_GET['nome']);
				$email = addslashes($_GET['email']);
				$user_name = addslashes($_GET['user_name']);
				$password = addslashes($_GET['password']);
				$fone = addslashes($_GET['fone']);
				$zap = addslashes($_GET['zap']);
				$tipo = addslashes($_GET['tipo']);
				
				$result = $user->create($nome, $email, $user_name, $password, $fone, $zap, $tipo);
				
				echo json_encode($result);
				
			break;*/
			
		}
		
	}
	
	if(isset($_POST['opcao'])){
		
		require_once("../app/User.php");
	
		$user = new User();
	
		$opcao = $_POST['opcao'];
		
		switch($opcao){
		
			case "login":
	
				$usuario = addslashes($_POST['user']);
				$password = addslashes($_POST['password']);
			
				$result = $user->logar($usuario, $password);
			
				echo json_encode($result);
			
			break;
			
			case "create":

				$nome = addslashes($_POST['nome']);
				$email = addslashes($_POST['email']);
				$user_name = addslashes($_POST['user_name']);
				$password = addslashes($_POST['password']);
				$fone = addslashes($_POST['fone']);
				$zap = addslashes($_POST['zap']);
				$tipo = addslashes($_POST['tipo']);
				
				$result = $user->create($nome, $email, $user_name, $password, $fone, $zap, $tipo);
				
				echo json_encode($result);
				
			break;
			
			case "update":			

				$user_id = addslashes($_POST['id']);
				$nome = addslashes($_POST['nome']);
				$email = addslashes($_POST['email']);
				$user_name = addslashes($_POST['user_name']);
				$password = addslashes($_POST['password']);
				$fone = addslashes($_POST['fone']);
				$zap = addslashes($_POST['zap']);
				$tipo = addslashes($_POST['tipo']);
				
				$result = $user->update($user_id, $nome, $email, $user_name, $password, $fone, $zap, $tipo);

				echo json_encode($result);
			break;
			
			case "delete":
			
				$user_id = addslashes($_POST['id']);
				echo json_encode($user->delete($user_id));
			
			break;
			
		}
		
	}

?>
