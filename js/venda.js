

function carregarVendas(dt_inicial, dt_final, carrinho_id, status, page){

	rota.setUrl('json/vendas.php?opcao=index&inicio='+dt_inicial+'&fim='+dt_final+'&id='+carrinho_id+'&status='+status+'&page='+page);
	
	return fetch(rota.getUrl())
	
	.then(function(response){
		
		return response.json();
	});
}
