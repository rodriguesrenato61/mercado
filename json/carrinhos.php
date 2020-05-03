<?php

	
	if(isset($_GET['opcao'])){
		
		require_once("../app/Carrinho.php");
	
		$carrinho = new Carrinho();
	
		$opcao = $_GET['opcao'];
		
		switch($opcao){
			case "index":
				//http://localhost/carrinho/json/carrinhos.php?opcao=index&inicio=&fim=&page=
				$inicio = addslashes($_GET['inicio']);
				$fim = addslashes($_GET['fim']);
				$page = addslashes($_GET['page']);
				
				$sql = $carrinho->index($inicio, $fim, $page);
				
				while($row = $sql->fetch()){
					$registros[] = array(
						"id" => $row['id'],
						"produtos" => $row['produtos'],
						"status" => $row['status_carrinho'],
						"total" => number_format((float) $row['total_compra'], 2 , ',', '.'),
						"data" => $row['dia'],
						"hora" => $row['hora']
					);
				}
				
				
				$retorno[] = array(
					"registros" => $registros,
					"limit" => $carrinho->getLimit(),
					"total" => $carrinho->getTotal()
				);
				
				echo json_encode($retorno);
			
			break;
			
			case "get":
			
				$carrinho_id = addslashes($_GET['id']);
				
				$row = $carrinho->get($carrinho_id);
				
				$registros[] = array(
					"id" => $row['id'],
					"produtos" => $row['produtos'],
					"status" => $row['status_carrinho'],
					"total" => $row['total_compra'],
					"dia" => $row['dia'],
					"hora" => $row['hora'],
				);
				
				echo json_encode($registros);
			
			break;
			
		}
		
	}
	
	
	if(isset($_POST['opcao'])){
		
		require_once("../app/Carrinho.php");
	
		$carrinho = new Carrinho();
	
		$opcao = addslashes($_POST['opcao']);
		
		switch($opcao){
			
			case "novo":
		
				echo json_encode($carrinho->novo());
			
			break;
			
			case "create":
			
				$registros[] = array(
					"tipo" => true,
					"msg" => "Carrinho criado com sucesso!",
					"novo_id" => $carrinho->create()
				);
			
				echo json_encode($registros);
		
			break;
			
			case "finalizar":
				$carrinho_id = addslashes($_POST['id']);
				echo json_encode($carrinho->finalizar($carrinho_id));
			break;
		
			case "delete":
		
				$carrinho_id = addslashes($_POST['id']);
			
				echo json_encode($carrinho->delete($carrinho_id));
		
			break;
			
		}
		
		
	}

?>
