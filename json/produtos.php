<?php

	
	if(isset($_GET['opcao'])){
	
		require_once("../app/Produto.php");
		
		$produtos = new Produto();
		
		$opcao = addslashes($_GET['opcao']);
		
		switch($opcao){
			
			case "index":
				/*http://localhost/carrinho/json/produtos.php?opcao=index&codigo=&nome=&categoria=0&page=1 */
				$codigo = addslashes($_GET['codigo']);
				$nome = addslashes($_GET['nome']);
				$categoria_id = addslashes($_GET['categoria']);
				$page = addslashes($_GET['page']);
				
				$sql = $produtos->index($codigo, $nome, $categoria_id, $page);
				
				while($row = $sql->fetch()){
					$registros[] = array(
						"codigo" => $row['codigo'],
						"produto" => $row['produto'],
						"categoria" => $row['categoria'],
						"pcusto" => number_format((float) $row['pcusto'], 2, ',', '.'),
						"pvenda" => number_format((float) $row['pvenda'], 2, ',', '.'),
						"estoque" => $row['estoque']
					);
				}
				
				$result[] = array(
					"registros" => $registros,
					"limit" => $produtos->getLimit(),
					"total" => $produtos->getTotal()
				);
				
				echo json_encode($result);
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
				$codigo = addslashes($_GET['codigo']);
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
			
			
		}
		
	}

	if(isset($_POST['opcao'])){
			
		require_once("../app/Produto.php");
		
		$produtos = new Produto();
			
		$opcao = addslashes($_POST['opcao']);
		
		switch($opcao){
			
			case "create":
				
				$nome = addslashes($_POST['nome']);
				$categoria_id = addslashes($_POST['categoria']);
				$pcusto = addslashes($_POST['pcusto']);
				$pvenda = addslashes($_POST['pvenda']);
				$estoque = addslashes($_POST['estoque']);
				
				$retorno = $produtos->create($nome, $categoria_id, $pcusto, $pvenda, $estoque);
				echo json_encode($retorno);
			break;
			
			case "update":
				// http://localhost/carrinho/json/produtos.php?opcao=update&codigo=22&nome=Spaggeti&categoria=1&pcusto=1.55&pvenda=3.00&estoque=21
				$codigo = addslashes($_POST['codigo']);
				$nome = addslashes($_POST['nome']);
				$categoria_id = addslashes($_POST['categoria']);
				$pcusto = addslashes($_POST['pcusto']);
				$pvenda = addslashes($_POST['pvenda']);
				$estoque = addslashes($_POST['estoque']);
				
				$retorno = $produtos->update($codigo, $nome, $categoria_id, $pcusto, $pvenda, $estoque);
				echo json_encode($retorno);
			break;
			
			case "delete":
			
				$codigo = addslashes($_POST['codigo']);
				
				$retorno = $produtos->delete($codigo);
				echo json_encode($retorno);
			
			break;
			
		}
		
	}

?>
