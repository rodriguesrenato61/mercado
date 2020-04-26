<?php

	require_once("../app/Produto.php");
	require_once("../app/database/Database.php");
	
	$conn = new Database("localhost", "mercado2", "root", "d3s1p6g6");

	$opcao = $_GET['opcao'];
	$produtos = new Produto();
	switch($opcao){
		case "teste":
			/* http://localhost/carrinho/json/produtos.php?opcao=teste&codigo=&nome=&categoria= */
			$codigo = $_GET['codigo'];
			$nome = $_GET['nome'];
			$categoria = $_GET['categoria'];
			
			
			$sql = $conn->vw_produtos($codigo, $nome, $categoria);

			while($row = $sql->fetch()){
				$registros[] = array(
					"codigo" => $row['codigo'],
					"produto"=> $row['produto'],
					"categoria" => $row['categoria']
				);
			}
			
			echo json_encode($registros);
			
			/*
			$sql = $conn->vw_produtos($codigo, $nome, $categoria);
			echo($sql);
			*/
		
		break;
		
		case "teste2":
		
			/* http://localhost/carrinho/json/produtos.php?opcao=teste2 */
		
			if($conn->permite(54, 3)){
				
				echo("Permissão concedida!");
				
			}else{
				echo("Permissão negada!");
			}
		
		break;
		
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
					"pcusto" => number_format((float) $row['pcusto'], 2, ',', '.'),
					"pvenda" => number_format((float) $row['pvenda'], 2, ',', '.'),
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
				"pcusto" => number_format((float) $row['pcusto'], 2, ',', '.'),
				"pvenda" => number_format((float) $row['pvenda'], 2, ',', '.'),
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
