function User(){

	this.create = function(nome, email, user_name, passwd, fone, zap, tipo){
	
		rota.setUrl('json/users.php?opcao=create&nome='+nome+'&email='+email+'&user_name='+user_name+'&passwd='+passwd+'&fone='+fone+'&zap='+zap+'&tipo='+tipo);
	
		return fetch(rota.getUrl())
		
		.then(function(response){
		
			return response.json();
		});
	}
	
	this.logar = function(user, password){
		rota.setUrl('json/users.php?opcao=login&user='+user+'&password='+password);
		return fetch(rota.getUrl())
		.then(function(response){
			return response.json();
		});
	}
	
	this.index = function(nome_user, tipo_id, pagina){
		rota.setUrl('json/users.php?opcao=index&nome='+nome_user+'&nivel='+tipo_id+'&page='+pagina);
		return fetch(rota.getUrl())
		.then(function(response){
			return response.json();
		});
	} 
	
	this.update = function(id, nome, email, user_name, passwd, fone, zap, tipo){
	
		rota.setUrl('json/users.php?opcao=update&id='+id+'&nome='+nome+'&email='+email+'&user_name='+user_name+'&password='+passwd+'&fone='+fone+'&zap='+zap+'&tipo='+tipo);
	
		return fetch(rota.getUrl())
		
		.then(function(response){
		
			return response.json();
		});
	}
	
	this.delete = function(id_usuario){
		rota.setUrl('json/users.php?opcao=delete&id='+id_usuario);
		return fetch(rota.getUrl())
		.then(function(response){
			return response.json();
		});
	}
	
}
