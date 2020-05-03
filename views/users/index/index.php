<?php

	require_once("../../../app/User.php");
	require_once("../../html/funcoes.php");
	
	$user = new User();
	
	$user->acessar("visualizar usuários");

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../../../css/modal.css">
		<link rel="stylesheet" href="../../../css/mensagem.css">
		<link rel="stylesheet" href="../../../css/paginate.css">
		<link rel="stylesheet" href="styles.css">
		<title>Funcionários</title>
	</head>
	<body>
		
		<?php criarModal("delete usuário"); ?>
		
		<div class="container">
			
			<nav class="nav-superior">
				<ul>
					<li>
						<a href="../../carrinhos/index/index.php?page=1">CARRINHOS</a>
					</li>
					<li>
						<a href="../../produtos/index/index.php?page=1">PRODUTOS</a>
					</li>
					<li>
						<a href="../../homes/admin/index.php">HOME</a>
					</li>
				</ul>
			</nav>
			
			<div class="users-container">
				<div class="pesquisar">
					<form id="form-pesquisar">
						<input type="text" id="nome" placeholder="nome do usuário">
						<select id="nivel">
							<option value="0">--Nível--</option>
							<?php
								$sql = $user->niveis();
								while($nivel = $sql->fetch()){
									echo("<option value='".$nivel['id']."'>".$nivel['descricao']."</option>");
								}
							?>
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
					
				</div> <!-- class pesquisar -->
				<?php mensagem(); ?>
				<div class="users-list">
					<div class="users-items">
						<table border="1px" id="users-table">
							<tr>
								<th>Id</th>
								<th>Nome</th>
								<th>Usuário</th>
								<th>Nível</th>
								<th>email</th>
								<th>Fone</th>
								<th>Whatszapp</th>
								</tr>
							</tr>
						</table> <!--id users-table -->
					</div> <!-- class users-items -->
				</div> <!-- class users-list -->
				
				<?php criarPaginacao() ?>
				
			</div> <!-- class users-container -->
		</div> <!-- class container -->
	</body>
	<script src="../../../js/rota.js"></script>
	<script src="../../../js/modal.js"></script>
	<script src="../../../js/user.js"></script>
	<script src="../../../js/mensagem.js"></script>
	<script src="../../../js/paginate.js"></script>
	<script src="scripts.js"></script>
</html>
