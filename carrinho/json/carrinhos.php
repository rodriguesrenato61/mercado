<?php

	require_once("../app/Carrinho.php");
	
	$carrinho = new Carrinho();
	
	$opcao = $_GET['opcao'];
	
	switch($opcao){
		case "index":
			$inicio = $_GET['inicio'];
			$fim = $_GET['fim'];
			
			$sql = $carrinho->index($inicio, $fim, null);
			
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
			
			echo json_encode($registros);
		
		break;
		
		case "get":
		
			$carrinho_id = $_GET['id'];
			
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
			$carrinho_id = $_GET['id'];
			echo json_encode($carrinho->finalizar($carrinho_id));
		break;
		
		case "delete":
		
			$carrinho_id = $_GET['id'];
			
			echo json_encode($carrinho->delete($carrinho_id));
		
		break;
	}

?>
