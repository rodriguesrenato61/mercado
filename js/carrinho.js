function Carrinho(){
	this.index = function(data_inicio, data_fim, pagina){
		rota.setUrl('json/carrinhos.php?opcao=index&inicio='+data_inicio+'&fim='+data_fim+'&page='+pagina);
		return fetch(rota.getUrl())
		.then(function(response){
			return response.json();
		});
	}
	
	this.novo = function(){
		
		let form = new FormData();
		form.append('opcao', 'novo');
		
		rota.setUrl('json/carrinhos.php');
		
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		}).then(function(response){
			return response.json();
		});
	}
	
	this.create = function(){
	
		let form = new FormData();
		
		form.append('opcao', 'create');
		
		rota.setUrl('json/carrinhos.php');
		
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		}).then(function(response){
			return response.json();
		});
		
	}
	
	this.vendas = function(carrinho_id, status){
		rota.setUrl('json/vendas.php?opcao=index&id='+carrinho_id+'&status='+status+'&inicio=&fim=&page=0');
		return fetch(rota.getUrl())
		.then(function(response){
			return response.json();
		});
	}
	
	this.delete = function(carrinho_id){
	
		let form = new FormData();
		
		form.append('opcao', 'delete');
		form.append('id', carrinho_id);
		
		rota.setUrl('json/carrinhos.php');
		
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		}).then(function(response){
			return response.json();
		});
		
	}
	
	this.finalizar = function(carrinho_id){
		
		let form = new FormData();
		
		form.append('opcao', 'finalizar');
		form.append('id', carrinho_id);
		
		rota.setUrl('json/carrinhos.php');
		
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		}).then(function(response){
			return response.json();
		});
	}
}
