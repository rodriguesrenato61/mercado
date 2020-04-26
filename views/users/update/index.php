<?php

	require_once("../../../app/User.php");
	
	$user = new User();
	
	if(isset($_GET['id'])){
		$usuario = $user->get($_GET['id']);
	}else{
		header("Location: ../index/index.php?page=1");
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="styles.css">
		<title>Editar usuário</title>
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
					<h2>Atualizar usuário</h2>
				</div> <!-- class user-head -->
				<div class="user-body">
					<form id="form-atualizar">
						<?php
							$user_id = $_GET['id'];
							echo("<input type='hidden' name='id' id='user_id' value='".$user_id."'>");
							echo("<input type='text' name='nome' id='nome' value='".$usuario['nome']."' placeholder='nome'>");
							echo("<input type='email' name='email' id='email' value='".$usuario['email']."' placeholder='email'>");
							echo("<input type='text' name='user_name' id='user_name' value='".$usuario['user_name']."' placeholder='nome de usuário'>");
						
							echo("<select id='tipo'>");
							echo("<option value='0'>--Tipo--</option>");
							$sql = $user->tipos();
							while($tipo = $sql->fetch()){
								if($usuario['tipo_id'] == $tipo['id']){
									echo("<option selected value='".$tipo['id']."'>".$tipo['descricao']."</option>");
								}else{
									echo("<option value='".$tipo['id']."'>".$tipo['descricao']."</option>");
								}
							}
							
							
							echo("</select> <!-- id tipo -->");
							$password = md5($usuario['passwd']);
							echo("<input type='text' name='passwd' value='".$password."' id='passwd' placeholder='senha'>");
							echo("<input type='number' name='fone' id='fone' value='".$usuario['fone']."' placeholder='fone'>");
							echo("<input type='number' name='zap' id='zap' value='".$usuario['zap']."' placeholder='Whatszapp'>");
						?>
						<div class="div-button">
							<button type="submit">Salvar</button>
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

