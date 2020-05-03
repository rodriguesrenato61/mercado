<?php

	
	if(isset($_POST['opcao'])){
		
		require_once("../app/Sessao.php");
		require_once("../app/Mercado.php");
	
		$sessao = new Sessao();
		$mercados = new Mercado();
	
		$opcao = addslashes($_POST['opcao']);
		
		switch($opcao){
			case "create":
				if($sessao->getUser_id()){
					$nome = addslashes($_POST['nome']);
					$email = addslashes($_POST['email']);
					$endereco = addslashes($_POST['endereco']);
					$cnpj = addslashes($_POST['cnpj']);
					$fone = addslashes($_POST['fone']);
					$zap = addslashes($_POST['zap']);
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
		
	}

?>
