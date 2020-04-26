<?php

	require_once("../../../app/User.php");
	
	$user = new User();
	
	$user->acessar("home admin");

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="styles.css">
		<title>Home</title>
	</head>
	<body>
		<div class="container">
			<nav class="nav-superior">
				<ul>
					<li><a href="../../login/sair.php">SAIR</a></li>
				</ul>
			</nav>
			
			<div class="user-info">
				<?php
				
					$usuario = $user->getUserLogin();
					
					echo("<h1>Bem vindo, ".$usuario['user_name']."</h1>");
				
				?>
			</div>
			
			<div class="items">
				<div class="items-row1">
					<div class="item">
						<div class="item-contador">
					 		<h1>10</h1>
						</div> <!-- class item-contador -->
						<div class="item-nome">
							<h1><a href="../../produtos/index/index.php?page=1">Produtos</a></h1>
						</div>
					</div> <!-- class item -->
						
					<div class="espaco">
					</div> <!-- class espaco -->
					
					<div class="item">
						<div class="item-contador">
					 		<h1>10</h1>
						</div> <!-- class item-contador -->
						<div class="item-nome">
							<h1><a href="../../vendas/index/index.php?page=1">Vendas</a></h1>
						</div>
					</div> <!-- class item -->
						
					<div class="espaco">
					</div>
					
					<div class="item">
						<div class="item-contador">
					 		<h1>10</h1>
						</div> <!-- class item-contador -->
						<div class="item-nome">
							<h1><a href="../../carrinhos/index/index.php?page=1">Carrinhos</a></h1>
						</div>
					</div> <!-- class item -->

				</div> <!-- class items-row1 -->
				
				<div class="items-row">
				
					<div class="item">
						<div class="item-contador">
					 		<h1>10</h1>
						</div> <!-- class item-contador -->
						<div class="item-nome">
							<h1><a href="../../users/index/index.php?page=1">Usuários</a></h1>
						</div>
					</div> <!-- class item -->
						
					<div class="espaco">
					</div> <!-- class espaco -->
						
					<div class="item">
						<div class="item-contador">
					 		<h1>10</h1>
						</div> <!-- class item-contador -->
						<div class="item-nome">
							<h1><a href="../../produtos/index/index.php?page=1">Histórico</a></h1>
						</div>
					</div> <!-- class item -->
						
				</div> <!-- class items-row -->
			
			</div> <!-- class items -->
		</div> <!-- class container -->
	</body>
</html>




