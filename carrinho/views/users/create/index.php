<?php

	require_once("../../../app/User.php");
	
	$user = new User();

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="styles.css">
		<title>Cadastrar usuário</title>
	</head>
	<body>
		<div class="modal-fundo" id="modal-fundo">
		</div> <!-- class modal-fundo -->
		<div class="modal-meio" id="modal-meio">
			<div class="modal-box">
				<div class="modal-head">
					<h2>Erro</h2>
					<button class="fechar-modal" onclick="closeErros()">X</button>
				</div>
				<div class="modal-body">
					<ul id="ul-erros">
					</ul> <!-- id ul-erros -->
				</div> <!-- class modal-body -->
			</div> <!-- class modal-box -->
		</div> <!-- class modal-meio -->
			
			
		<div class="container">
			<div class="user-container">
				<div class="user-head">
					<h2>Cadastrar usuário</h2>
				</div> <!-- class user-head -->
				<div class="user-body">
					<form id="form-cadastrar">
						<input type="text" name="nome" id="nome" placeholder="nome">
						<input type="email" name="email" id="email" placeholder="email">
						<input type="text" name="user_name" id="user_name" placeholder="nome de usuário">
						<select id="tipo">
							<option value="0">--Tipo--</option>
							<?php
								$sql = $user->tipos();
								while($tipo = $sql->fetch()){
									echo("<option value='".$tipo['id']."'>".$tipo['descricao']."</option>");
								}
							
							?>
						</select> <!-- id tipo -->
						<input type="password" name="passwd" id="passwd" placeholder="senha">
						<input type="password" name="passwd2" id="passwd2" placeholder="repita a senha">
						<input type="number" name="fone" id="fone" placeholder="fone">
						<input type="number" name="zap" id="zap" placeholder="Whatszapp">
						<div class="div-button">
							<button type="submit">Cadastrar</button>
						</div> <!-- class div-button -->
					</form> <! -- id form-cadastrar -->
				</div> <!-- class user-body -->
			</div> <!-- class user-container -->

		</div> <!-- class container -->
		<script src="../../../js/rota.js"></script>
		<script src="../../../js/user.js"></script>
		<script src="scripts.js"></script>
	</body>
</html>

