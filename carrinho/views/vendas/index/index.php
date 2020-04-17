<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles.css">
		<title>Vendas</title>
	</head>
	<body>
		
		<div class="container">
			
			<nav class="nav-superior">
				<ul>
					<li>
						<a href="../../carrinhos/index/index.php?page=1">CARRINHOS</a>
					</li>
					<li>
						<a href="../../produtos/index/index.php?page=1">PRODUTOS</a>
					</li>
				</ul>
			</nav>
			
			<div class="vendas-container">
				<div class="pesquisar">
					<form id="form-pesquisar">
						<input type="text" id="inicio" placeholder="data inicial">
						<input type="text" id="fim" placeholder="data final">
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
					
				</div> <!-- class pesquisar -->
				<div class="vendas-list">
					<div class="vendas-items">
						<table border="1px" id="vendas-table">
							<tr>
								<th>Id</th>
								<th>Código</th>
								<th>Produto</th>
								<th>Preço</th>
								<th>Unidades</th>
								<th>Total</th>
								<th>Dia</th>
								<th>Hora</th>
								</tr>
							</tr>
						</table> <!--id vendas-table -->
					</div> <!-- class vendas-items -->
				</div> <!-- class vendas-list -->
				
				<div class="paginate" id="paginate">
				</div>
				
			</div> <!-- class carrinhos-container -->
		</div> <!-- class container -->
	</body>
	<script src="../../../js/rota.js"></script>
	<script src="scripts.js"></script>
</html>
