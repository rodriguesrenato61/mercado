function User(){

	this.create = function(nome, email, user_name, passwd, fone, zap, tipo){
	
		rota.setUrl('json/users.php?opcao=create&nome='+nome+'&email='+email+'&user_name='+user_name+'&passwd='+passwd+'&fone='+fone+'&zap='+zap+'&tipo='+tipo);
	
		return fetch(rota.getUrl())
		
		.then(function(response){
		
			return response.json();
		});
	}
	
}
