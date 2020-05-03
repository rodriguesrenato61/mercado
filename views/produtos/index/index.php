<?php

	require_once("../../../app/User.php");
	require_once("../../html/funcoes.php");
	
	$user = new User();
	
	$user->acessar("visualizar produtos");


?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles.css">
		<link rel="stylesheet" href="../../../css/modal.css">
		<link rel="stylesheet" href="../../../css/mensagem.css">
		<title>Produtos</title>
	</head>
	<body>
		
		<?php 
			criarModal("criar produto");
			criarModal("delete produto"); 
		?>
		
		<div class="container">
			
			<nav class="nav-superior">
				<ul>
					<li>
						<a href="../../vendas/index/index.php?page=1">VENDAS</a>
					</li>
					<li>
						<a href="../../carrinhos/index/index.php">CARRINHOS</a>
					</li>
					<li>
						<a href="../../homes/admin/index.php">HOME</a>
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
				<?php mensagem(); ?>
				<div class="produtos-list">
					<div id="produtos-items">
						<table border="1" id="produtos-table">
						</table>
					</div> <!--id produtos-items -->
				</div>
				
				<?php criarPaginacao(); ?>
				
			</div> <!-- class produtos-container -->
		</div> <!-- class container -->
	</body>
	<script src="../../../js/rota.js"></script>
	<script src="../../../js/produto.js"></script>
	<script src="../../../js/mensagem.js"></script>
	<script src="../../../js/modal.js"></script>
	<script src="../../../js/paginate.js"></script>
	<script src="scripts.js"></script>
</html>
