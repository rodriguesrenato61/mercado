function Produto(){
	
	this.index = function(codigo_produto, nome_produto, categoria_produto, page_produto){
		rota.setUrl("json/produtos.php?opcao=index&codigo="+codigo_produto+"&nome="+nome_produto+"&categoria="+categoria_produto+"&page="+page_produto);
		return fetch(rota.getUrl())
		.then(function(response){
			return response.json();
		});
	}
	
	this.get = function(codigo_produto){
		rota.setUrl('json/produtos.php?opcao=get&codigo='+codigo_produto);
		return fetch(rota.getUrl())
		.then(function(response){
			return response.json();
		});
	}
	
	this.indexCategorias = function(){
		rota.setUrl("json/produtos.php?opcao=categorias");
		
		return fetch(rota.getUrl())
		.then(function(response){
			return response.json();
		});
	}
	
	this.create = function(codigo, nome, categoria, pcusto, pvenda, estoque){
		
		let form = new FormData();
		
		form.append('opcao', 'create');
		form.append('nome', nome);
		form.append('categoria', categoria);
		form.append('pcusto', pcusto);
		form.append('pvenda', pvenda);
		form.append('estoque', estoque);
		
		rota.setUrl('json/produtos.php');
		
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		}).then(function(response){
			return response.json();
		});
	}
	
	this.update = function(codigo, nome, categoria, pcusto, pvenda, estoque){
		
		let form = new FormData();
		
		form.append('opcao', 'update');
		form.append('codigo', codigo);
		form.append('nome', nome);
		form.append('categoria', categoria);
		form.append('pcusto', pcusto);
		form.append('pvenda', pvenda);
		form.append('estoque', estoque);
		
		rota.setUrl('json/produtos.php');
		
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		}).then(function(response){
			return response.json();
		});
	}
	
	this.delete = function(codigo){
		
		let form = new FormData();
		
		form.append('opcao', 'delete');
		form.append('codigo', codigo);
		
		rota.setUrl('json/produtos.php');
		
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		}).then(function(response){
			return response.json();
		});
	}
}
