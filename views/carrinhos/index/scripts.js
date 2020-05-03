const inicio = document.querySelector("#inicio");

const fim = document.querySelector("#fim");

const pesquisar = document.querySelector("#form-pesquisar");

const carrinhosTable = document.querySelector("#carrinhos-table");

const btnNovo = document.querySelector("#btn-novo");

const paginate = document.querySelector("#paginate");

const page = document.querySelector("#page");

const btnDeletar = document.querySelector("#btn-deletar");

const inputDeleteCarrinho = document.querySelector("#delete-carrinho-id");

const objetoCarrinho = new Carrinho();

var html;
var totalRegistros = 0;

btnDeletar.addEventListener('click', function(event){
	event.preventDefault();
	removerCarrinho(inputDeleteCarrinho.value);
	
});

function loadRemoverCarrinhos(remover, ids){
	let i = 0;
	ids.forEach(function(id_carrinho){
		
		remover[i].addEventListener('click', function(event){
			event.preventDefault();
			
			abrirModalDelete(id_carrinho);
			
		});
		i++;
	});

}

function abrirModalDelete(carrinho_id){
	inputDeleteCarrinho.value = carrinho_id;
	modalBodyDeletarCarrinho.innerHTML = "<h2>Você tem certeza de que deseja deletar o carrinho de id "+carrinho_id+"?</h2>";
	modalDeletarCarrinhoShow();
}

function removerCarrinho(id_carrinho){
	
	let resposta = objetoCarrinho.delete(id_carrinho);
	
	resposta.then(function(response){
		let sucess, msg;
		response.forEach(function(result){
		
			sucess = result.tipo;
			msg = result.msg;
			
		});
		
		if(sucess){
			loadCarrinhos();
		}
		loadMensagem(sucess, msg);
		modalDeletarCarrinhoClose();
	});
	
}

function loadPaginas(links){
	let i = 0;
	let a = document.querySelectorAll(".pagina");
	links.forEach(function(link){
		a[i].addEventListener('click', function(event){
			event.preventDefault();
			page.value = link;
			loadCarrinhos();
		});
		i++;
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
	
	
	resposta = objetoCarrinho.index(dt_inicio, dt_fim, page.value);
	
	resposta.then(function(response){
		
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
		
		let registros, limit;
	
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
					rota.setUrl("views/carrinhos/create/index.php?id="+registro.id);
					html += "<td><a href='"+rota.getUrl()+"'><img src='"+rota.getRoute("editar-icon")+"' alt='editar'></a></td>";
					html += "<td><a class='remover' href=''><img src='"+rota.getRoute("remover-icon")+"' alt='remover'></a></td>";
					count++;
					ids_carrinho.push(registro.id);
				}else{
					html += "<td></td>";
					html += "<td></td>";
				}
				html += "</tr>";
				
			});
			
			totalRegistros = parseInt(carrinho.total);
			limit = parseInt(carrinho.limit);
			
		});
		
		carrinhosTable.innerHTML = html;
		
		let links = paginacao(page.value, limit, totalRegistros, paginate);
		loadPaginas(links);
		
		
		if(count > 0){
			let remover = document.querySelectorAll(".remover");
			loadRemoverCarrinhos(remover, ids_carrinho);
		}
		
	}).catch(function(err){
		alert("Nenhum registro encontrado!");
	});
}

function createCarrinho(){
	
	let resposta = objetoCarrinho.create();
	
	resposta.then(function(response){
	
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
	
	let resposta = objetoCarrinho.novo();
	
	resposta.then(function(response){
	
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
