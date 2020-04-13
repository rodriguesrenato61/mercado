<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styles.css">
		<title>Carrinhos</title>
	</head>
	<body>
		
		<div class="container">
			
			<nav class="nav-superior">
				<ul>
					<li>
						<a href="#">VENDAS</a>
					</li>
					<li>
						<a href="../../produtos/index/index.php?page=1">PRODUTOS</a>
					</li>
				</ul>
			</nav>
			
			<div class="carrinhos-container">
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
					<button class="btn-novo" id="btn-novo">New</button>
				</div> <!-- class pesquisar -->
				<div class="carrinhos-list">
					<div class="carrinhos-items">
						<table border="1px" id="carrinhos-table">
							<tr>
								<th>Id</th>
								<th>Produtos</th>
								<th>Status</th>
								<th>Total</th>
								<th>Data</th>
								<th>Hora</th>
							</tr>
						</table> <!--id carrinhos-table -->
					</div> <!-- class carrinhos-items -->
				</div> <!-- class carrinhos-list -->
				
				<div class="paginate" id="paginate">
				</div>
				
			</div> <!-- class carrinhos-container -->
		</div> <!-- class container -->
	</body>
	<script src="../../../js/rota.js"></script>
	<script src="scripts.js"></script>
</html>
