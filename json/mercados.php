<?php

	require_once("../app/Sessao.php");
	require_once("../app/Mercado.php");
	
	$sessao = new Sessao();
	$mercados = new Mercado();
	
	$opcao = $_GET['opcao'];
	
	switch($opcao){
		case "create":
			if($sessao->getUser_id()){
				$nome = $_GET['nome'];
				$email = $_GET['email'];
				$endereco = $_GET['endereco'];
				$cnpj = $_GET['cnpj'];
				$fone = $_GET['fone'];
				$zap = $_GET['zap'];
				$user_id = $sessao->getUser_id();
				
				$retorno = $mercados->create($nome, $email, $endereco, $cnpj, $fone, $zap, $user_id);
				echo json_encode($retorno);
			}else{
				$msg = new Mensagem;
				$msg->set(false, "Erro, você não tem autorização para realizar esta operação!");
				echo json_encode($msg->get());
			}
		break;
	}

?>
