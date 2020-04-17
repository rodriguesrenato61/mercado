<?php

	require_once("../../../app/User.php");
	
	$user = new User();
	
	$user->acessar("cadastrar mercado");

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="styles.css">
		<title>Cadastrar mercado</title>
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
			<div class="mercado-container">
				<div class="mercado-head">
					<h2>Cadastrar mercado</h2>
				</div> <!-- class mercado-head -->
				<div class="mercado-body">
					<form id="form-cadastrar">
						<input type="text" name="nome" id="nome" placeholder="nome">
						<input type="email" name="email" id="email" placeholder="email">
						<input type="text" name="endereco" id="endereco" placeholder="endereço">
						<input type="number" name="cnpj" id="cnpj" placeholder="cnpj">
						<input type="number" name="fone" id="fone" placeholder="fone">
						<input type="number" name="zap" id="zap" placeholder="Whatszapp">
						
						<div class="div-button">
							<button type="submit">Cadastrar</button>
						</div> <!-- class div-button -->
					</form> <! -- id form-cadastrar -->
				</div> <!-- class mercado-body -->
			</div> <!-- class mercado-container -->

		</div> <!-- class container -->
		<script src="../../../js/rota.js"></script>
		<script src="../../../js/mercado.js"></script>
		<script src="scripts.js"></script>
	</body>
</html>


