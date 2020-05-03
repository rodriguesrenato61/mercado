function Venda(){

	this.create = function(carrinho_id, codigo, unidades){
	
		let form = new FormData();
		
		form.append('opcao', 'create');
		form.append('id', carrinho_id);
		form.append('codigo', codigo);
		form.append('unidades', unidades);
	
		rota.setUrl('json/vendas.php');
		
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		}).then(function(response){
			return response.json();
		});
		
	}

	this.update = function(venda_id, unidades){
	
		let form = new FormData();
		
		form.append('opcao', 'update');
		form.append('id', venda_id);
		form.append('unidades', unidades);
		
		rota.setUrl('json/vendas.php');
		
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		}).then(function(response){
			return response.json();
		});
		
	}
	
	this.delete = function(carrinho_id, codigo){
	
		let form = new FormData();
		
		form.append('opcao', 'delete');
		form.append('id', carrinho_id);
		form.append('codigo', codigo);
		
		rota.setUrl('json/vendas.php');
		
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		}).then(function(response){
			return response.json();
		});
		
	}
	
}

function carregarVendas(dt_inicial, dt_final, carrinho_id, status, page){

	rota.setUrl('json/vendas.php?opcao=index&inicio='+dt_inicial+'&fim='+dt_final+'&id='+carrinho_id+'&status='+status+'&page='+page);
	
	return fetch(rota.getUrl())
	
	.then(function(response){
		
		return response.json();
	});
}
