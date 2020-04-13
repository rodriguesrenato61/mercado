const inicio = document.querySelector("#inicio");

const fim = document.querySelector("#fim");

const pesquisar = document.querySelector("#form-pesquisar");

const carrinhosTable = document.querySelector("#carrinhos-table");

const btnNovo = document.querySelector("#btn-novo");

var html;

function loadRemoverCarrinhos(remover, ids){
	let i = 0;
	ids.forEach(function(id_carrinho){
		
		remover[i].addEventListener('click', function(event){
			event.preventDefault();
			
			removerCarrinho(id_carrinho);
			
		});
		i++;
	});

}

function removerCarrinho(id_carrinho){
	
	rota.setUrl('json/carrinhos.php?opcao=delete&id='+id_carrinho);
	
	fetch(rota.getUrl())
	
	.then(function(response){
		
		return response.json();
	}).then(function(response){
		let tipo, msg;
		response.forEach(function(result){
		
			tipo = result.tipo;
			msg = result.msg;
			
		});
		
		if(tipo){
			alert(msg);
			loadCarrinhos();
		}else{
			alert(msg);
		}
	});
	
}


function loadCarrinhos(){
	
	let dt_inicio = "";
	let dt_fim = "";
	
	if(inicio.value != ""){
		inicial = inicio.value;
		dt_inicial = inicial.split("/");
		dt_inicio = dt_inicial[2]+"-"+dt_inicial[1]+"-"+dt_inicial[0]; 
	}
	
	if(fim.value != ""){
		final = fim.value;
		dt_final = final.split("/");
		dt_fim = dt_final[2]+"-"+dt_final[1]+"-"+dt_final[0]; 
	}
	
	rota.setUrl('json/carrinhos.php?opcao=index&inicio='+dt_inicio+'&fim='+dt_fim);
	
	fetch(rota.getUrl())
	
	.then(function(response){
		return response.json();
	}).then(function(response){
		
		let count = 0;
		let ids_carrinho = new Array();
	
		html = "<tr>";
		html += "<th>Id</th>";
		html += "<th>Produtos</th>";
		html += "<th>Status</th>";
		html += "<th>Total</th>";
		html += "<th>Data</th>";
		html += "<th>Hora</th>";
		html += "<th colspan=2>Ação</th>";
		html += "</tr>";
	
		response.forEach(function(carrinho){
			
			html += "<tr>";
			html += "<td>"+carrinho.id+"</td>";
			if(carrinho.produtos != null){
				html += "<td>"+carrinho.produtos+"</td>";
			}else{
				html += "<td>0</td>";
			}
			html += "<td>"+carrinho.status+"</td>";
			if(carrinho.total != null){
				html += "<td>R$ "+carrinho.total+"</td>";
			}else{
				html += "<td>0</td>";
			}
			html += "<td>"+carrinho.data+"</td>";
			html += "<td>"+carrinho.hora+"</td>";
			if(carrinho.status == "Em andamento"){
				rota.setUrl("views/carrinhos/create/index.php?id="+carrinho.id);
				html += "<td><a href='"+rota.getUrl()+"'><img src='"+rota.getRoute("editar-icon")+"' alt='editar'></a></td>";
				html += "<td><a class='remover' href=''><img src='"+rota.getRoute("remover-icon")+"' alt='remover'></a></td>";
				count++;
				ids_carrinho.push(carrinho.id);
			}else{
				html += "<td></td>";
				html += "<td></td>";
			}
			html += "</tr>";
			
			
			
		});
		
		carrinhosTable.innerHTML = html;
		
		if(count > 0){
			let remover = document.querySelectorAll(".remover");
			loadRemoverCarrinhos(remover, ids_carrinho);
		}
		
	}); /*.catch(function(err){
		alert("Nenhum registro encontrado!");
	});*/
}

function createCarrinho(){
	
	rota.setUrl('json/carrinhos.php?opcao=create');
	
	fetch(rota.getUrl())
	
	.then(function(response){
		
		return response.json();
	}).then(function(response){
	
		let tipo, msg, novo_id;
		
		response.forEach(function(result){
		
			tipo = result.tipo;
			msg = result.msg;
			novo_id = result.novo_id;
			
		});
		
		if(tipo){
			rota.setUrl('views/carrinhos/create/index.php?id='+novo_id);
			window.location.href = rota.getUrl();
		}else{
			alert(msg);
		}
		
	});
}

function novoCarrinho(){
	
	rota.setUrl('json/carrinhos.php?opcao=novo');
	
	fetch(rota.getUrl())
	
	.then(function(response){
		
		return response.json();
	}).then(function(response){
	
		let tipo, msg, novo_id;
		
		response.forEach(function(result){
		
			tipo = result.tipo;
			msg = result.msg;
			novo_id = result.novo_id;
			
		});
		
		if(tipo){
			rota.setUrl('views/carrinhos/create/index.php?id='+novo_id);
			window.location.href = rota.getUrl();
		}else{
			if(confirm(msg)){
				createCarrinho();
			}
		}
		
	});
}

loadCarrinhos();

pesquisar.addEventListener('submit', function(event){
	event.preventDefault();
	loadCarrinhos();
});

btnNovo.addEventListener('click', function(){
	novoCarrinho();
});
