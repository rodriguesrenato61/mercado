<?php

	if(isset($_GET['opcao'])){
		
		require_once("../app/Venda.php");
		
		$vendas = new Venda();
		$opcao = addslashes($_GET['opcao']);
		
		switch($opcao){
			
			case "index":
				/* http://localhost/carrinho/json/vendas.php?opcao=index&id=7&status=0&inicio=&fim=&page=0 */
				$carrinho_id = addslashes($_GET['id']);
				$status = addslashes($_GET['status']);
				$inicio = addslashes($_GET['inicio']);
				$fim = addslashes($_GET['fim']);
				$page = addslashes($_GET['page']);
				
				$rows = $vendas->index($carrinho_id, $status, $inicio, $fim, $page);
				
				while($row = $rows->fetch()){
					$registros[] = array(
						"id" => $row['id'],
						"codigo" => $row['codigo'],
						"produto" => $row['produto'],
						"preco" => number_format((float) $row['pvenda'], 2, ',', '.'),
						"unidades" => $row['unidades'],
						"total" => number_format((float) $row['total_venda'], 2, ',', '.'),
						"dia" => $row['dia'],
						"hora" => $row['hora']
					);
				}
				
				$json_array[] = array(
					"registros" => $registros,
					"total" => $vendas->getTotalRegistros()
				);
				
				echo(json_encode($json_array));
			break;
			
			case "get":
				/* http://localhost/Carrinho/Controllers/VendaController.php?opcao=get&id=18 */
				$venda_id = addslashes($_GET['id']);
				$row = $vendas->get($venda_id);
				$registro[] = array(
					"id" => $row['id'],
					"codigo" => $row['codigo'],
					"produto" => $row['produto'],
					"preco" => number_format((float) $row['pvenda'], 2, ',', '.'),
					"unidades" => $row['unidades'],
				);
				
				echo json_encode($registro);
			
			break;
			
			case "total":
				/* http://localhost/carrinho/json/vendas.php?opcao=total&id=2 */
				$carrinho_id = addslashes($_GET['id']);
				echo($vendas->getTotal($carrinho_id));
			break;
			
			
		}
		
	}
	
	if(isset($_POST['opcao'])){
	
		require_once("../app/Venda.php");
		
		$vendas = new Venda();
		$opcao = addslashes($_POST['opcao']);
		
		switch($opcao){
		
			case "create":
			
				$carrinho_id = addslashes($_POST['id']);
				$codigo = addslashes($_POST['codigo']);
				$unidades = addslashes($_POST['unidades']);
				
				echo json_encode($vendas->create($carrinho_id, $codigo, $unidades));
			
			break;
			
			case "update":
				
				$venda_id = addslashes($_POST['id']);
				$unidades = addslashes($_POST['unidades']);
				
				echo json_encode($vendas->update($venda_id, $unidades));
					
			break;
				
			case "delete":
					
				$carrinho_id = addslashes($_POST['id']);
				$codigo = addslashes($_POST['codigo']);
					
				echo json_encode($vendas->delete($carrinho_id, $codigo));
					
			break;
			
		}
		
	}

?>
