<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="styles.css">
		<title>Login</title>
	</head>
	<body>
		
		<div class="container">
			<div class="login-container">
				<div class="login-head">
					<h2>Login</h2>
				</div> <!-- class login-head -->
				<div class="login-body">
					<form id="form-logar">
						<input type="text" name="user" id="user" placeholder="email ou user name">
						<input type="password" name="password" id="password" placeholder="senha">
						<div class="div-button">
							<button type="submit" id="btn-login">Entrar</button>
						</div> <!-- class div-button -->
						<div class="cadastrar">
							<p>Não é usuário? <a href="../users/create/index.php">Cadastre-se</a></p>
						</div> <!-- class cadastrar -->
					</form>
				</div> <!-- class login-body -->
			</div> <!-- class login-container -->
		</div> <!-- class container -->
			
		<script src="../../js/rota.js"></script>
		<script src="../../js/user.js"></script>
		<script src="scripts.js"></script>
	</body>
</html>



