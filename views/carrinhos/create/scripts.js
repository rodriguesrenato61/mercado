const barcode = document.querySelector("#barcode");

const pesquisar = document.querySelector("#pesquisar-produto");

const adicionar = document.querySelector("#btn-adicionar");

const produtoDados = document.querySelector("#produto-dados");

const unidades = document.querySelector("#unidades");

const id = document.querySelector("#carrinho_id");

const items = document.querySelector("#items");

const total = document.querySelector("#total-container");

const unidadesEditar = document.querySelector("#unidades-editar");

const salvar = document.querySelector("#salvar");

const id_venda = document.querySelector("#id_venda");

const finalizar = document.querySelector("#btn-finalizar");

const inputDeleteVenda = document.querySelector("#delete-venda-id");

const btnDeletar = document.querySelector("#btn-deletar");

const objetoVenda = new Venda();

const objetoCarrinho = new Carrinho();
 
var totalCarrinho = 0; 
var totalProdutos = 0;

var html;

btnDeletar.addEventListener('click', function(){

	deleteVenda(inputDeleteVenda.value);

});

function deleteVenda(codigo_produto){

	let resposta = objetoVenda.delete(id.value, codigo_produto);
	
	resposta.then(function(response){
		
		let sucess, msg;
		
		response.forEach(function(result){
		
			sucess = result.tipo;
			msg = result.msg;
			
		});
		
		if(sucess){
			loadVendas();
		}
		modalDeletarVendaClose();
		alert(msg);
	}); 
	
}

function loadProduto(){
	
	rota.setUrl('json/produtos.php?opcao=get&codigo='+barcode.value);
	
	fetch(rota.getUrl())
		
	.then(function(response){
			
		return response.json();
		
	}).then(function(response){
			
		html = "";
		let erro = false;
				
		response.forEach(function(produto){
				
			if(produto.codigo != null){
					
					html += "<strong>Código: </strong>"+produto.codigo+"<br>";
					html += "<strong>Produto: </strong>"+produto.produto+"<br>";
					html += "<strong>Categoria: </strong>"+produto.categoria+"<br>";
					html += "<strong>Preço: </strong>R$ "+produto.pvenda+"<br>";
					html += "<strong>Estoque: </strong>"+produto.estoque+"<br>";
					
			
			}else{
				erro = true;
			}
				
		}); 
		
		if(!erro){
			
			produtoDados.innerHTML = html;
			unidades.style.visibility = "visible";
			adicionar.style.visibility = "visible";
			
		}else{
			
			alert("Produto não encontrado!");
		}
		
	});
	
}

function abrirModalEditar(venda_id){
	
	rota.setUrl('json/vendas.php?opcao=get&id='+venda_id);

	fetch(rota.getUrl())
		
	.then(function(response){
			
		return response.json();
		
	}).then(function(response){
			
		html = "";
		let erro = false;
				
		response.forEach(function(venda){
				
			if(venda.codigo != null){
			
					html += "<strong>Código: </strong>"+venda.codigo+"<br>";
					html += "<strong>Produto: </strong>"+venda.produto+"<br>";
					html += "<strong>Preço: </strong>R$ "+venda.preco+"<br>";
					html += "<strong>Unidades: </strong> "+venda.unidades+"<br>";
					
			}else{
				erro = true;
			}
				
		}); 
		
		if(!erro){
			modalEditarVendaDados.innerHTML = html;
			modalEditarVendaShow();
			
		}else{
			alert("Produto não encontrado!");
		}
		
	});
	
}


function updateVenda(venda_id){
	
	resposta = objetoVenda.update(venda_id, unidadesEditar.value);
	
	resposta.then(function(response){
		let msg;
		response.forEach(function(registro){
			msg = registro.msg;
		});
		loadVendas();
		unidadesEditar.value = "";
	}).catch(function(err){
		alert("Erro ao enviar requisição venda!");
	});

}

function loadEditar(ids){
	
	let editar = document.querySelectorAll(".editar");
		
	let i = 0;
		
	ids.forEach(function(venda_id){
			
		editar[i].addEventListener('click', function(event){
			
			event.preventDefault();
			
			id_venda.value = venda_id;
			
			abrirModalEditar(venda_id);
			
		});
		i++;
	});
}


function abrirModalDelete(dado){

	inputDeleteVenda.value = dado.codigo;
	modalBodyDeletarvenda.innerHTML = "<h2>Você tem certeza de que deseja deletar o produto "+dado.produto+" deste carrinho?</h2>";
	modalDeletarVendaShow();
}

function loadRemover(dados, removeLinks){
		
	let i = 0;
		
	dados.forEach(function(dado){
			
		removeLinks[i].addEventListener('click', function(event){
				
			event.preventDefault();
			
			abrirModalDelete(dado);	
			
		});
		i++;
	});
}

function loadTotal(){
	
	rota.setUrl('json/vendas.php?opcao=total&id='+id.value);
	
	fetch(rota.getUrl())
	
	.then(function(response){
	
		return response.json();
	}).then(function(response){
		
		html = "";
		let result;
		
		response.forEach(function(venda){
			result = venda.total;
			totalProdutos = venda.unidades;
		});
		
		if(result != null){
			html += "<strong>Produtos: </strong>"+totalProdutos+"<br>";
			html += "<strong>Total: </strong>R$ "+result;
		}else{
			html += "<strong>Produtos: </strong>0<br>";
			html += "<strong>Total: </strong>R$ 00,00";
		}
		
		total.innerHTML = html;
	}).catch(function(err){
		total.innerHTML = "<strong>Produtos: </strong>Não encontrado!<br><strong>Total: </strong> Não encontrado!";
	});
}


function loadVendas(){
	
	let resposta = objetoCarrinho.vendas(id.value, 0);
	
	resposta.then(function(response){
			
		html = "";
		
		html += "<tr>";
		html += "<th>Código</th>";
		html += "<th>Produto</th>";
		html += "<th>Preço</th>";
		html += "<th>Unidades</th>";
		html += "<th>Total</th>";
		html += "<th colspan='2'>Ação</th>";
		html += "</tr>";
		
		let dados = new Array();
		let ids = new Array();
		let registros;
		
		items.innerHTML = html;
		
		response.forEach(function(vendas){
			
			registros = vendas.registros;
			
			registros.forEach(function(venda){
			
				html += "<tr>";
				html += "<td>"+venda.codigo+"</td>";
				html += "<td class='td-produto'>"+venda.produto+"</td>";
				html += "<td>R$ "+venda.preco+"</td>";
				html += "<td>"+venda.unidades+"</td>";
				html += "<td> R$"+venda.total+"</td>";
				html += "<td><a href='' class='editar'><img src='"+rota.getRoute("editar-icon")+"' /></a></td>";
				html += "<td><a href='' class='remover'><img src='"+rota.getRoute("remover-icon")+"' /></a></td>";
				html += "</tr>";
				
				dados.push({codigo: venda.codigo, produto: venda.produto});
				ids.push(venda.id);
			
			});
			
			
		});
			
		items.innerHTML = html;
		
		loadTotal();
		loadEditar(ids);
		let removeLinks = document.querySelectorAll(".remover");
		loadRemover(dados, removeLinks);
		
	}).catch(function(err){
		html = "";
		
		html += "<tr>";
		html += "<th>Código</th>";
		html += "<th>Produto</th>";
		html += "<th>Preço</th>";
		html += "<th>Unidades</th>";
		html += "<th>Total</th>";
		html += "<th colspan='2'>Ação</th>";
		html += "</tr>";
		items.innerHTML = html;
	});
}

function registrarVenda(){
	
	if(barcode.value != "0" && barcode.value != "" && unidades.value != "0" && unidades.value != ""){
		
		let resposta = objetoVenda.create(id.value, barcode.value, unidades.value);
		
		resposta.then(function(response){
			
			let sucess, msg;
			
			response.forEach(function(retorno){
				sucess = retorno.tipo;
				msg = retorno.msg;
			});
			
			if(sucess){
				loadVendas();
			}
			barcode.value = "";
			unidades.value = "";
		});
	
	}else{
		
		alert("Preencha os campos corretamente!");
		
	}
}

function finalizarCarrinho(){

	resposta = objetoCarrinho.finalizar(id.value);
	
	resposta.then(function(response){
		
		let sucess, msg;
		
		response.forEach(function(result){
			sucess = result.tipo;
			msg = result.msg;
		});
		
		if(sucess){
			rota.redirect('views/carrinhos/index/index.php');
		}else{
			loadMensagem(sucess, msg);
		}
	});

}

loadVendas();

pesquisar.addEventListener('submit', function(event){
	event.preventDefault();
	loadProduto();
});

adicionar.addEventListener('click', function(){
	
	registrarVenda();
});

salvar.addEventListener('click', function(){
	updateVenda(id_venda.value);
	modalEditarVendaClose();
});

finalizar.addEventListener('click', function(){
	finalizarCarrinho();
});


