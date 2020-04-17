function Mercado(){
	
	this.create = function(nome, email, endereco, cnpj, fone, zap){
		rota.setUrl('json/mercados.php?opcao=create&nome='+nome+'&email='+email+'&endereco='+endereco+'&cnpj='+cnpj+'&fone='+fone+'&zap='+zap);
		return fetch(rota.getUrl())
		.then(function(response){
			return response.json();
		});
	}
	
}
