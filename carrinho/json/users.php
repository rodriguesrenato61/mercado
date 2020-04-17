<?php

	require_once("../app/User.php");
	
	$user = new User();
	
	$opcao = $_GET['opcao'];
	
	switch($opcao){
		
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
		
	}

?>
