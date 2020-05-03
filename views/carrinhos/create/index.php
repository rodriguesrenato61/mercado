<?php

	require_once("../../../app/User.php");
	require_once("../../html/funcoes.php");
	
	$user = new User();
	

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../../../css/modal.css">
		<link rel="stylesheet" href="../../../css/navbar.css">
		<link rel="stylesheet" href="../../../css/mensagem.css">
		<link rel="stylesheet" href="styles.css">
		<title>Carrinho</title>
	</head>
	<body>
		
		<?php
		
			if(isset($_GET['id'])){
				$carrinho_id = $_GET['id'];
				echo("<input type='hidden' name='carrinho_id' id='carrinho_id' value='".$carrinho_id."'>");
			}
		
		?>
		
		<?php 
			criarModal("carrinho editar venda");
			criarModal("delete venda");
		 ?>
		
		
		<div class="container">
			<?php navbar(); ?>
			<?php mensagem(); ?>
			<div class="carrinho-container">
				<div class="container1">
					<div class="produto-container">
						<div class="form-pesquisar">
							<form id="pesquisar-produto">
								<input type="number" name="barcode" id="barcode" placeholder="código do produto">
								<button type="submit" class="pesquisar">buscar</button>
							</form> <!-- id pesquisar-produto -->
						</div> <!-- class form-pesquisar -->
						<div class="produto-info" id="produto-info">
							<div class="produto-imagem">
								<img alt="imagem do produto">
							</div> <!-- class produto-imagem -->
							<div class="produto-encontrado">
								<div class="produto-dados" id="produto-dados">
									<strong>Código: </strong> 0001<br>
									<strong>Produto: </strong> Margarina<br>
									<strong>Categoria: </strong> Alimentos<br>
									<strong>Preço: </strong> R$ 3,00<br>
									<strong>Estoque: </strong> 23<br>
								</div> <!-- class produto-dados -->
							</div> <!-- class produto-encontrado -->
						</div> <!-- class produto-info -->
						<div class="unidades-container" id="unidades-container">
							<input type="number" name="unidades" id="unidades" placeholder="unidades">
							<button id="btn-adicionar">Adicionar</button>
						</div> <!-- class unidades-container -->
					</div> <!-- class produto-container -->
					
					<div class="total-container" id="total-container">
						<strong>Produtos: </strong>0<br>
						<strong>Total: </strong>R$ 00,00<br>
					</div> <!-- class total-container -->
					<div class="finalizar-container">
						<button id="btn-finalizar">Finalizar</button>
					</div> <!-- class finalizar-container -->
				</div> <!-- class container1 -->
				<div class="container2">
					<div class="carrinho-table">
						<table id="items">
							
						</table>
					</div> <!-- class carrinho-table -->
				</div>
			</div> <!-- class carrinho-container -->
		</div> <!-- class container -->
		<script src="../../../js/rota.js"></script>
		<script src="../../../js/modal.js"></script>
		<script src="../../../js/venda.js"></script>
		<script src="../../../js/carrinho.js"></script>
		<script src="scripts.js"></script>
	</body>
</html>
