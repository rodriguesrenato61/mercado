<?php

	require_once("../app/Venda.php");
	
	$vendas = new Venda();
	$opcao = $_GET['opcao'];
	
	switch($opcao){
		
		case "index":
			/* http://localhost/carrinho/json/vendas.php?opcao=index&id=2&status=0 */
			$carrinho_id = $_GET['id'];
			$status = $_GET['status'];
			
			$rows = $vendas->index($carrinho_id, $status);
			
			while($row = $rows->fetch()){
				$registros[] = array(
					"id" => $row['id'],
					"codigo" => $row['codigo'],
					"produto" => $row['produto'],
					"pvenda" => $row['pvenda'],
					"unidades" => $row['unidades'],
					"total_venda" => $row['total_venda']
				);
			}
			
			echo(json_encode($registros));
		break;
		
		case "get":
			/* http://localhost/Carrinho/Controllers/VendaController.php?opcao=get&id=18 */
			$venda_id = $_GET['id'];
			$row = $vendas->get($venda_id);
			$registro[] = array(
				"id" => $row['id'],
				"codigo" => $row['codigo'],
				"produto" => $row['produto'],
				"preco" => $row['pvenda'],
				"unidades" => $row['unidades'],
			);
			
			echo json_encode($registro);
		
		break;
		
		case "total":
			/* http://localhost/carrinho/json/vendas.php?opcao=total&id=2 */
			$carrinho_id = $_GET['id'];
			echo($vendas->getTotal($carrinho_id));
		break;
		
		case "create":
		
			$carrinho_id = $_GET['id'];
			$codigo = $_GET['codigo'];
			$unidades = $_GET['unidades'];
			
			echo json_encode($vendas->create($carrinho_id, $codigo, $unidades));
		
		break;
		
		case "update":
			
			$venda_id = $_GET['id'];
			$unidades = $_GET['unidades'];
			
			echo json_encode($vendas->update($venda_id, $unidades));
				
		break;
			
		case "delete":
				
			$carrinho_id = $_GET['id'];
			$codigo = $_GET['codigo'];
				
			echo($vendas->delete($carrinho_id, $codigo));
				
		break;
		
	}
	
	if(isset($_POST['opc'])){
	
		$opc = $_POST['opc'];
		
		/* http://localhost/carrinho/json/vendas.php */
	
		switch($opc){
			case "create":
		
				$carrinho_id = $_POST['id'];
				$codigo = $_POST['codigo'];
				$unidades = $_POST['unidades'];
			
				echo json_encode($vendas->create($carrinho_id, $codigo, $unidades));
		
			break;
			
			case "update":
			
				$venda_id = $_POST['id'];
				$unidades = $_POST['unidades'];
			
				echo json_encode($vendas->update($venda_id, $unidades));
				
			break;
			
			case "delete":
				
				$carrinho_id = $_POST['id'];
				$codigo = $_POST['codigo'];
				
				echo($vendas->delete($carrinho_id, $codigo));
				
			break;
		}
		
	}

?>
