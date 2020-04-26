<?php

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
				"total" => $user->getTotal()
			);
			
			echo json_encode($result);
			
		
		break;
		
		case "create":
		
			/* http://localhost/carrinho/json/users.php?opcao=create&nome=Renato+Rodrigues&email=rodriguesrenato61@gmail.com&user_name=rodriguesrenato61&passwd=123&fone=98988258639&zap=98999812283&tipo=2 */

		
			$nome = $_GET['nome'];
			$email = $_GET['email'];
			$user_name = $_GET['user_name'];
			$passwd = $_GET['passwd'];
			$fone = $_GET['fone'];
			$zap = $_GET['zap'];
			$tipo = $_GET['tipo'];
			
			$result = $user->create($nome, $email, $user_name, $passwd, $fone, $zap, $tipo);
			
			echo json_encode($result);
			
		break;
		
		case "login":
	
			$usuario = $_GET['user'];
			$password = $_GET['password'];
			
			$result = $user->logar($usuario, $password);
			
			echo json_encode($result);
	
		break;
		
		case "update":			
		
			// http://localhost/carrinho/json/users.php?opcao=update&id=2&nome=Renato+Rodrigues&email=rodriguesrenato61@gmail.com&user_name=rodriguesrenato61&password=123&fone=98988258639&zap=98999812283&tipo=2

			$user_id = addslashes($_GET['id']);
			$nome = addslashes($_GET['nome']);
			$email = addslashes($_GET['email']);
			$user_name = addslashes($_GET['user_name']);
			$password = addslashes($_GET['password']);
			$fone = addslashes($_GET['fone']);
			$zap = addslashes($_GET['zap']);
			$tipo = addslashes($_GET['tipo']);
			
			$result = $user->update($user_id, $nome, $email, $user_name, $password, $fone, $zap, $tipo);

			echo json_encode($result);
		break;
		
		case "msg":
		
			echo json_encode($user->getMsg());
		
		break;
		
		case "delete":
		
			$user_id = $_GET['id'];
			echo json_encode($user->delete($user_id));
		
		break;
		
	}

?>
