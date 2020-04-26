const barcode = document.querySelector("#barcode");

const pesquisar = document.querySelector("#pesquisar-produto");

const adicionar = document.querySelector("#btn-adicionar");

const produtoDados = document.querySelector("#produto-dados");

const unidades = document.querySelector("#unidades");

const id = document.querySelector("#carrinho_id");

const items = document.querySelector("#items");

const total = document.querySelector("#total-container");

const produtoInfo = document.querySelector("#produto-info");

const modalEditar = document.querySelector("#modal-editar");

const modalMeio = document.querySelector("#modal-meio");

const modalDadosEditar = document.querySelector("#modal-dados-editar");

const unidadesEditar = document.querySelector("#unidades-editar");

const salvar = document.querySelector("#salvar");

const id_venda = document.querySelector("#id_venda");

const finalizar = document.querySelector("#btn-finalizar");
 
var totalCarrinho = 0; 
var totalProdutos = 0;

var html;

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

function modalEditarShow(venda_id){
	
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
			modalDadosEditar.innerHTML = html;
			modalEditar.style.display = "block";
			modalMeio.style.display = "block";
			
		}else{
			alert("Produto não encontrado!");
		}
		
	});
	
}

function modalEditarClose(){
	
	modalEditar.style.display = "none";
	modalMeio.style.display = "none";
}

function updateVenda(venda_id){
	
	rota.setUrl('json/vendas.php?opcao=update&id='+venda_id+'&unidades='+unidadesEditar.value);
	
	fetch(rota.getUrl())
	
	.then(function(response){
		return response.json();
	}).then(function(response){
		let msg;
		response.forEach(function(registro){
			msg = registro.msg;
		});
		loadVendas();
		alert(msg);
	}).catch(function(err){
		alert("Erro ao atualizar venda!");
	});

}

function loadEditar(ids){
	
	let editar = document.querySelectorAll(".editar");
		
	let i = 0;
		
	ids.forEach(function(venda_id){
			
		editar[i].addEventListener('click', function(event){
			
			event.preventDefault();
			
			id_venda.value = venda_id;
			
			modalEditarShow(venda_id);
			
		});
		i++;
	});
}


function loadRemover(codigos, removeLinks){
		
	let i = 0;
		
	codigos.forEach(function(codigo){
			
		removeLinks[i].addEventListener('click', function(event){
				
			event.preventDefault();
				
			if(confirm("Você tem certeza de que deseja remover esta venda?")){

				rota.setUrl('json/vendas.php?opcao=delete&id='+id.value+'&codigo='+codigo);

				fetch(rota.getUrl())
				
				.then(function(response){
				
					return response.json();
				}).then(function(response){
					
					let result;
					
					response.forEach(function(registro){
								
						result = registro.msg;
					
					});
							
					if(result == "1"){
						barcode.value = "";
						loadVendas();
						alert("Venda deletada!");
							
					}else{
						alert("Erro, venda não deletada!");
					}
				});
			}
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
	
	rota.setUrl('json/vendas.php?opcao=index&id='+id.value+'&status=0&inicio=&fim=&page=0');
	
	fetch(rota.getUrl())
	
	.then(function(response){
		
		return response.json();
	}).then(function(response){
			
		html = "";
		
		html += "<tr>";
		html += "<th>Código</th>";
		html += "<th>Produto</th>";
		html += "<th>Preço</th>";
		html += "<th>Unidades</th>";
		html += "<th>Total</th>";
		html += "<th colspan='2'>Ação</th>";
		html += "</tr>";
		
		let codigos = new Array();
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
				
				codigos.push(venda.codigo);
				ids.push(venda.id);
			
			});
			
			
		});
			
		items.innerHTML = html;
		
		loadTotal();
		loadEditar(ids);
		let removeLinks = document.querySelectorAll(".remover");
		loadRemover(codigos, removeLinks);
		
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
		
		rota.setUrl('json/vendas.php?opcao=create&id='+id.value+'&codigo='+barcode.value+'&unidades='+unidades.value);
		
		fetch(rota.getUrl())
		
		.then(function(response){
			
			return response.json();
		}).then(function(response){
			let type, msg;
			
			response.forEach(function(retorno){
				type = retorno.type;
				msg = retorno.msg;
			});
			
			if(type == true){
				loadVendas();
				barcode.value = "";
				unidades.value = "";
			}else{
				alert(msg);
			}
		
		});
	
	}else{
		
		alert("Preencha os campos corretamente!");
		
	}
}

function finalizarCarrinho(){

	rota.setUrl('json/carrinhos.php?opcao=finalizar&id='+id.value);
	
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
			rota.setUrl('views/carrinhos/index/index.php');
			window.location.href = rota.getUrl();
		}else{
			alert(msg);
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
	modalEditarClose();
});

finalizar.addEventListener('click', function(){
	finalizarCarrinho();
});


