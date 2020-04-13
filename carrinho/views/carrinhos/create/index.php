<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="styles.css">
		<link rel="stylesheet" href="../../../css/modal.css">
		<title>Carrinho</title>
	</head>
	<body>
		<div class="modal" id="modal">
		</div>
		<div class="modal-meio" id="modal-meio">
			<div class="modal-box" id="modal-box">
				<div class="modal-body" id="modal-body">
					<div class="modal-produto modal-imagem">
						Imagem
					</div>
					<div class="modal-produto dados">
						<div class="modal-dados" id="modal-dados">
						
						</div>
						<div class="modal-bottom">
							<input type="number" class="modal-unidades" id="unidades" placeholder="unidades">
							<button class="modal-btn" id="modal-fechar">Cancelar</button>
							<button class="modal-btn" id="registrar">Registrar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal-editar" id="modal-editar">
		</div>
		<div class="modal-meio" id="modal-meio">
			<div class="modal-box" id="modal-box-editar">
				<div class="modal-body" id="modal-body">
					<div class="modal-produto modal-imagem">
						Imagem
					</div>
					<div class="modal-produto dados">
						<div class="modal-dados" id="modal-dados-editar">
						
						</div>
						<div class="modal-bottom">
							<input type="hidden" id="id_venda">
							<input type="number" class="modal-unidades" id="unidades-editar" placeholder="unidades">
							<button class="modal-btn" id="modal-editar-fechar">Cancelar</button>
							<button class="modal-btn" id="salvar">Salvar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="container">
			<nav class="nav-superior">
				<ul>
					<li>
						<a href="../../carrinhos/index/index.php">
							CARRINHOS
						</a>
					</li>
					<li>
						<a href="#">
							VENDAS
						</a>
					</li>
					<li>
						<a href="../../produtos/index/">
							PRODUTOS
						</a>
					</li>
				</ul>
			</nav>
			<div class="carrinho-container">
				<form id="form-procurar">
					<input class="barcode" type="text" name="barcode" id="barcode" placeholder="barcode">
					<button class="procurar" id="procurar" type="submit">Buscar</button>
				</form>
				
				<input type="hidden" name="id" id="id" value="<?php echo($_GET['id']); ?>">

				<div class="items" id="items">
					
				</div>
				<div class="total-item">
					<div class="total-container" id="total">
				 
					</div>
					<button class="btn-finalizar" id="finalizar">Finalizar</button>
				</div>
			
			</div>
		<script src="../../../js/modal.js"></script>
		<script src="../../../js/rota.js"></script>
		<script src="scripts.js"></script>
	</body>
</html>


