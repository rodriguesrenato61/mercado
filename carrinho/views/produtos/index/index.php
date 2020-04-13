<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles.css">
		<title>Produtos</title>
	</head>
	<body>
		
		<div class="modal-fundo" id="modal-fundo">
		</div> <!-- class modal-fundo -->
		<div class="modal-meio" id="modal-meio">
			<div class="modal-box">
				<div class="modal-body">
					<div class="modal-items modal-imagem">
						<div class="imagem" id="imagem">
							Imagem
						</div> <!-- class imagem -->
						<div class="div-btn-imagem">
							<input type="file" id="carregar" class="btn-imagem" onChange="carregarImagem()">
						</div> <!-- class div-btn-imagem -->
					</div> <!-- class modal-items modal-imagem -->
					<div class="modal-items modal-campos">
						<input type="number" id="codigo_produto" placeholder="codigo">
						<input type="text" id="nome_produto" placeholder="produto">
						<select id="categoria_produto">
							<option value="0">--Categoria--</option>
						</select>
						<input type="number" id="pcusto" placeholder="preço de custo">
						<input type="number" id="pvenda" placeholder="preço de venda">
						<input type="number" id="estoque" placeholder="estoque">
						<div class="div-buttons">
							<button class="btn-cadastrar" id="btn-cadastrar">cadastrar</button>
							<button class="btn-cancelar" id="btn-cancelar" onclick="fecharModal()">cancelar</button>
						</div> <!-- class div-buttons -->
					</div> <!-- class modal-campos -->
				</div> <!-- class modal-body -->
			</div> <!-- class modal-box -->
		</div> <!-- class modal-meio -->
		
		
		<div class="modal-meio2" id="modal-meio2">
			<div class="modal-box">
				<div class="modal-body">
					<div class="modal-items modal-imagem">
						<div class="imagem" id="imagem">
							Imagem
						</div> <!-- class imagem -->
						<div class="div-btn-imagem">
							<input type="file" id="carregar" class="btn-imagem" onChange="carregarImagem()">
						</div> <!-- class div-btn-imagem -->
					</div> <!-- class modal-items modal-imagem -->
					<div class="modal-items modal-campos">
						<input type="number" id="codigo_produto2" placeholder="codigo" readonly>
						<input type="text" id="nome_produto2" placeholder="produto">
						<select id="categoria_produto2">
							<option value="0">--Categoria--</option>
						</select>
						<input type="number" id="pcusto2" placeholder="preço de custo">
						<input type="number" id="pvenda2" placeholder="preço de venda">
						<input type="number" id="estoque2" placeholder="estoque">
						<div class="div-buttons">
							<button class="btn-cadastrar" id="btn-salvar">salvar</button>
							<button class="btn-cancelar" id="btn-cancelar2" onclick="fecharModal2()">cancelar</button>
						</div> <!-- class div-buttons -->
					</div> <!-- class modal-campos -->
				</div> <!-- class modal-body -->
			</div> <!-- class modal-box -->
		</div> <!-- class modal-meio2 -->
		
		<div class="container">
			
			<nav class="nav-superior">
				<ul>
					<li>
						<a href="#">VENDAS</a>
					</li>
					<li>
						<a href="../../carrinhos/index/index.php">CARRINHOS</a>
					</li>
				</ul>
			</nav>
			
			<div class="produtos-container">
				<div class="pesquisar">
					<form id="form-pesquisar">
						<input type="number" id="codigo" placeholder="codigo">
						<input type="text" id="nome" placeholder="produto">
						<select id="categorias">
							<option value="0">--Categoria--</option>
						</select>
						<?php
							if(isset($_GET['page'])){
								$page = $_GET['page'];
								echo("<input type='hidden' id='page' value='".$page."'>");
							}else{
								echo("<input type='hidden' id='page' value='1'>");
							}
						?>
						<button type="submit" class="btn-buscar">Buscar</button>
					</form>
					<button class="btn-novo" id="btn-novo">New</button>
				</div> <!-- class pesquisar -->
				<div class="produtos-list">
					<div id="produtos-items">
					
					</div> <!--id produtos-items -->
				</div> <!-- class produtos-list -->
				
				<div class="paginate" id="paginate">
				</div>
				
			</div> <!-- class produtos-container -->
		</div> <!-- class container -->
	</body>
	<script src="../../../js/rota.js"></script>
	<script src="scripts.js"></script>
</html>
