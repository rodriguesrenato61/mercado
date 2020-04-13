<?php

	require_once("../app/Produto.php");

	$opcao = $_GET['opcao'];
	$produtos = new Produto();
	switch($opcao){
		case "index":
			/*http://localhost/carrinho/json/produtos.php?opcao=index&codigo=&nome=&categoria=0&page=1 */
			$codigo = $_GET['codigo'];
			$nome = $_GET['nome'];
			$categoria_id = $_GET['categoria'];
			$page = $_GET['page'];
			$sql = $produtos->index($codigo, $nome, $categoria_id, $page);
			$total = $produtos->getTotal();
			while($row = $sql->fetch()){
				$registros[] = array(
					"codigo" => $row['codigo'],
					"produto" => $row['produto'],
					"categoria" => $row['categoria'],
					"pcusto" => $row['pcusto'],
					"pvenda" => $row['pvenda'],
					"estoque" => $row['estoque'],
					"total" => $total
				);
			}
			
			echo json_encode($registros);
		break;
		
		case "categorias":
			$sql = $produtos->categorias();
			while($row = $sql->fetch()){
				$registros[] = array(
					"id" => $row['id'],
					"nome" => $row['nome']
				);
			}
			
			echo json_encode($registros);
		break;
		
		case "get":
			/* http://localhost/carrinho/json/produtos.php?opcao=get&codigo=2 */
			$codigo = $_GET['codigo'];
			$row = $produtos->get($codigo);
			$registro[] = array(
				"codigo" => $row['codigo'],
				"produto" => $row['produto'],
				"categoria_id" => $row['categoria_id'],
				"categoria" => $row['categoria'],
				"pcusto" => $row['pcusto'],
				"pvenda" => $row['pvenda'],
				"estoque" => $row['estoque'] 
			);
			
			echo(json_encode($registro));
				
		break;
		
		case "create":
			
			$nome = $_GET['nome'];
			$categoria_id = $_GET['categoria'];
			$pcusto = $_GET['pcusto'];
			$pvenda = $_GET['pvenda'];
			$estoque = $_GET['estoque'];
			
			$retorno = $produtos->create($nome, $categoria_id, $pcusto, $pvenda, $estoque);
			echo json_encode($retorno);
		break;
		
		case "update":
		
			$codigo = $_GET['codigo'];
			$nome = $_GET['nome'];
			$categoria_id = $_GET['categoria'];
			$pcusto = $_GET['pcusto'];
			$pvenda = $_GET['pvenda'];
			$estoque = $_GET['estoque'];
			
			$retorno = $produtos->update($codigo, $nome, $categoria_id, $pcusto, $pvenda, $estoque);
			echo json_encode($retorno);
		break;
		
		case "delete":
		
			$codigo = $_GET['codigo'];
			
			$retorno = $produtos->delete($codigo);
			echo json_encode($retorno);
		
		break;
	}

	if(isset($_POST['opc'])){
		
	$opc = $_POST['opc'];
	
	switch($opc){
		case "create":
			$nome = $_POST['nome'];
			$categoria_id = $_POST['categoria'];
			$pcusto = $_POST['pcusto'];
			$pvenda = $_POST['pvenda'];
			$estoque = $_POST['estoque'];
			
			$retorno = $produtos->create($nome, $categoria_id, $pcusto, $pvenda, $estoque);
			echo json_encode($retorno);
		break;
		
		case "update":
		
			$codigo = $_POST['codigo'];
			$nome = $_POST['nome'];
			$categoria_id = $_POST['categoria'];
			$pcusto = $_POST['pcusto'];
			$pvenda = $_POST['pvenda'];
			$estoque = $_POST['estoque'];
			
			$retorno = $produtos->update($codigo, $nome, $categoria_id, $pcusto, $pvenda, $estoque);
			echo json_encode($retorno);
		break;
		
		case "delete":
		
			$codigo = $_POST['codigo'];
			
			$retorno = $produtos->delete($codigo);
			echo json_encode($retorno);
		
		break;
	}
	
	}

?>
