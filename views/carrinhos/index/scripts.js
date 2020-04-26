const inicio = document.querySelector("#inicio");

const fim = document.querySelector("#fim");

const pesquisar = document.querySelector("#form-pesquisar");

const carrinhosTable = document.querySelector("#carrinhos-table");

const btnNovo = document.querySelector("#btn-novo");

const paginate = document.querySelector("#paginate");

const page = document.querySelector("#page");

var html;
var totalRegistros = 0;

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
	
	rota.setUrl('json/carrinhos.php?opcao=index&inicio='+dt_inicio+'&fim='+dt_fim+'&page='+page.value);
	
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
		
		let registros;
	
		response.forEach(function(carrinho){
			
			registros = carrinho.registros;
			
			registros.forEach(function(registro){
				
				html += "<tr>";
				html += "<td>"+registro.id+"</td>";
				if(registro.produtos != null){
					html += "<td>"+registro.produtos+"</td>";
				}else{
					html += "<td>0</td>";
				}
				html += "<td>"+registro.status+"</td>";
				if(registro.total != null){
					html += "<td>R$ "+registro.total+"</td>";
				}else{
				html += "<td>0</td>";
				}
				html += "<td>"+registro.data+"</td>";
				html += "<td>"+registro.hora+"</td>";
				if(registro.status == "Em andamento"){
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
			
			totalRegistros = parseInt(carrinho.total);
			
		});
		
		carrinhosTable.innerHTML = html;
		
		paginacao(page.value);
		
		
		if(count > 0){
			let remover = document.querySelectorAll(".remover");
			loadRemoverCarrinhos(remover, ids_carrinho);
		}
		
	}).catch(function(err){
		alert("Nenhum registro encontrado!");
	});
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


function loadPaginas(a, links){
		let i = 0;
		links.forEach(function(link){
			a[i].addEventListener('click', function(event){
				event.preventDefault();
				page.value = link;
				loadCarrinhos();
			});
			i++;
		});
	}
	
		
		
function paginacao(atual){
		
	atual = parseInt(atual);
			
	let limit = 5;
	let colunas = 3;
	let paginas = Math.ceil(totalRegistros/limit);

	let inicio = ((atual - 1) * limit) + 1;
	let fim;
		
	if((atual * limit) >= totalRegistros){
		fim = totalRegistros;
	}else{
		fim = atual * limit;
	} 
			
	linhas = Math.ceil(paginas/colunas);
			
	let pagina_inicial;
	let pagina_final;
	let final_bloco;
	let linha;
	let i;
		
	for(i = 1; i <= linhas; i++){
			
		final_bloco = i * colunas;
			
		if(final_bloco >= atual){
				
			pagina_inicial = ((i - 1) * colunas) + 1;
				
			if(final_bloco >= paginas){
				pagina_final = paginas;
			}else{
				pagina_final = final_bloco;
			}
				
			linha = i;
			break;
				
		}
	}
			
	html = "<h2>";
	let links = new Array();
	let num;
			
	for(i = pagina_inicial; i <= pagina_final; i++){
				
		if(i == pagina_inicial){
					
			if(i > colunas){
				html += "<a class='pagina seta' href=''><<<</a>";
				num = i - 1;
				links.push(num);
			}
		}
				
		if(i == atual){
					
			html += " <strong><a class='pagina escolhido' href=''>"+i+"</a></strong>";
			num = i;
			links.push(num);
		}else{
			html += " <a class='pagina comum' href=''>"+i+"</a>";
			num = i;
			links.push(num);
		}
				
		if(i == pagina_final){
			if(i < paginas){
				html += " <a class='pagina seta' href=''>>>></a>";
				num = i + 1;
				links.push(num);
			}
		}
				
	}
			
	html += "</h2>";
			
	paginate.innerHTML = html;
			
	let a = document.querySelectorAll(".pagina");
			
	loadPaginas(a, links);
			
}

loadCarrinhos();

pesquisar.addEventListener('submit', function(event){
	event.preventDefault();
	loadCarrinhos();
});

btnNovo.addEventListener('click', function(){
	novoCarrinho();
});
