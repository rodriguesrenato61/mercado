<?php

	require_once("../../app/User.php");
	
	$user = new User();
	

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../../css/modal.css">
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
		
		<div class="modal-editar" id="modal-editar">
		</div>
		<div class="modal-meio" id="modal-meio">
			<div class="modal-box" id="modal-box-editar">
				<div class="modal-body" id="modal-body">
					<div class="modal-produto modal-imagem">
						<img src="../../assets/imgs/produtos/refrigerante.jpeg">
					</div>
					<div class="modal-produto dados">
						<div class="modal-dados" id="modal-dados-editar">
						
						</div>
						<div class="modal-bottom">
							<input type="hidden" id="id_venda">
							<input type="number" class="modal-unidades" id="unidades-editar" placeholder="unidades">
							<button class="modal-btn" id="modal-editar-fechar" onclick="modalEditarClose()">Cancelar</button>
							<button class="modal-btn" id="salvar">Salvar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="container">
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
								<img src="../../assets/imgs/produtos/refrigerante.jpeg">
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
					</div> <!-- class produto-container -->
					<div class="unidades-container" id="unidades-container">
						<input type="number" name="unidades" id="unidades" placeholder="unidades">
						<button id="btn-adicionar">Adicionar</button>
					</div> <!-- class unidades-container -->
					<div class="total-container" id="total-container">
						<!--
						<strong>Produtos: </strong>4<br>
						<strong>Total: </strong>R$ 36,00<br>-->
					</div> <!-- class total-container -->
					<div class="finalizar-container">
						<button id="btn-finalizar">Finalizar</button>
					</div> <!-- class finalizar-container -->
				</div> <!-- class container1 -->
				<div class="container2">
					<div class="carrinho-table">
						<table id="items">
							<!--
							<tr>
								<td>0001</td>
								<td>Margarina</td>
								<td>R$ 3,00</td>
								<td>7</td>
								<td>R$ 21,00</td>
								<td><button class="btn-editar">Editar</button></td>
								<td><button class="btn-remover">Remover</button></td>
							</tr>
							<tr>
								<td>0001</td>
								<td>Margarina</td>
								<td>R$ 3,00</td>
								<td>7</td>
								<td>R$ 21,00</td>
								<td><button class="btn-editar">Editar</button></td>
								<td><button class="btn-remover">Remover</button></td>
							</tr>
							<tr>
								<td>0001</td>
								<td>Margarina</td>
								<td>R$ 3,00</td>
								<td>7</td>
								<td>R$ 21,00</td>
								<td><button class="btn-editar">Editar</button></td>
								<td><button class="btn-remover">Remover</button></td>
							</tr>
							<tr>
								<td>0001</td>
								<td>Margarina</td>
								<td>R$ 3,00</td>
								<td>7</td>
								<td>R$ 21,00</td>
								<td><button class="btn-editar">Editar</button></td>
								<td><button class="btn-remover">Remover</button></td>
							</tr>
							<tr>
								<td>0001</td>
								<td>Margarina</td>
								<td>R$ 3,00</td>
								<td>7</td>
								<td>R$ 21,00</td>
								<td><button class="btn-editar">Editar</button></td>
								<td><button class="btn-remover">Remover</button></td>
							</tr>
							
							-->
						</table>
					</div> <!-- class carrinho-table -->
				</div>
			</div> <!-- class carrinho-container -->
		</div> <!-- class container -->
		<script src="../../js/rota.js"></script>
		<script src="scripts.js"></script>
	</body>
</html>
