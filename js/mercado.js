function Mercado(){
	
	this.create = function(nome, email, endereco, cnpj, fone, zap){
		
		let form = new FormData();
		
		form.append('opcao', 'create');
		form.append('nome', nome);
		form.append('email', email);
		form.append('endereco', endereco);
		form.append('cnpj', cnpj);
		form.append('fone', fone);
		form.append('zap', zap);
		
		rota.setUrl('json/mercados.php');
		
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		}).then(function(response){
			return response.json();
		});
	}
	
}
