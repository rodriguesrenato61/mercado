
const id = document.querySelector("#id");

const items = document.querySelector("#items");

const barcode = document.querySelector("#barcode");

const unidades = document.querySelector("#unidades");

const unidadesEditar = document.querySelector("#unidades-editar");

const form = document.querySelector("#form-procurar");

const total = document.querySelector("#total");

const registrar = document.querySelector("#registrar");

const procurar = document.querySelector("#procurar");

const fechar = document.querySelector("#modal-fechar");

const editarClose = document.querySelector("#modal-editar-fechar");

const salvar = document.querySelector("#salvar");

const id_venda = document.querySelector("#id_venda");

const finalizar = document.querySelector("#finalizar");

var carrinhoDados, totalProdutos;

function exibirModal(){
	if(barcode.value != "" && barcode.value != "0"){
		modalShow(barcode.value);
	}else{
		alert("Coloque o código do produto!");
	}
}


function loadRemover(codigos){
	
	let remover = document.querySelectorAll(".remover");
		
	let i = 0;
		
	codigos.forEach(function(codigo){
			
		remover[i].addEventListener('click', function(event){
				
			event.preventDefault();
				
			if(confirm("Você tem certeza de que deseja remover esta venda?")){
				/*
				let dados = {
					opc: 'delete',
					id: id.value,
					codigo: codigo.value
				};
					
				fetch('http://localhost/carrinho/json/vendas.php', {
					
					method: 'POST',
					body: JSON.stringify(dados)
					
				})*/
				
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
						loadTotal();
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

function loadVendas(){
	
	rota.setUrl('json/vendas.php?opcao=index&id='+id.value+'&status=0');
	
	fetch(rota.getUrl())
	
	.then(function(response){
		
		return response.json();
	}).then(function(response){
			
		let html = "";
		let codigos = new Array();
		let ids = new Array();
		
		items.innerHTML = "";
		
		response.forEach(function(venda){
	
			html += "<div class='produto-item'>";
			html += "<div class='produto-info produto-imagem'>";
			html += "Imagem";
			html += "</div>";
			html += "<div class='produto-info produto-dados'>";
			html += "<input type='hidden' id='venda_id' value='"+venda.id+"'>";
			html += "<strong>Código: </strong>"+venda.codigo+"<br>";
			html += "<strong>Produto: </strong>"+venda.produto+"<br>";
			html += "<strong>Preço: </strong>R$ "+venda.pvenda+"<br>"
			html += "<strong>Unidades: </strong> "+venda.unidades+"<br>";
			html += "<strong>Total: </strong> "+venda.unidades+" x "+venda.pvenda+" = "+venda.total_venda;
			html += "</div>";
			html += "<div class='produto-info produto-editar'>";
			html += "<a href='' class='editar'><img src='"+rota.getRoute("editar-icon")+"' /></a>";
			html += "</div>";
			html += "<div class='produto-info produto-remover'>";
			html += "<a href='' class='remover'><img src='"+rota.getRoute("remover-icon")+"' /></a>";
			html += "</div>";
			html += "</div>";
			
			console.log(venda.produto);
			
			codigos.push(venda.codigo);
			ids.push(venda.id);
			
		});
			
		items.innerHTML = html;
		loadRemover(codigos);
		loadEditar(ids);
		
	}).catch(function(err){
		items.innerHTML = "";
	});
}

function loadTotal(){
	
	rota.setUrl('json/vendas.php?opcao=total&id='+id.value);
	
	fetch(rota.getUrl())
	
	.then(function(response){
	
		return response.json();
	}).then(function(response){
		
		let html = "";
		let result;
		
		response.forEach(function(venda){
			result = venda.total;
		});
		
		if(result != null){
			html += "<strong>Total: </strong>R$ "+result;
		}else{
			html += "<strong>Total: </strong>R$ 00,00";
		}
		
		total.innerHTML = html;
	}).catch(function(err){
		total.innerHTML = "<strong>Total: </strong> Não encontrado!";
	});
}


function registrarVenda(){
	
	if(barcode.value != "0" && barcode.value != "" && unidades.value != "0" && unidades.value != ""){
		
		/*
		let dados = {
			opc: 'create',
			id: id.value,
			codigo: barcode.value,
			unidades: unidades.value
		};
		
		fetch('http://localhost/carrinho/json/vendas.php', {
			
			method: 'POST',
			body: JSON.stringify(dados)
			
		})*/
		
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
				loadTotal();
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

function updateVenda(venda_id){
	
	/*
	let dados = {
		opc: 'update',
		id: venda_id,
		unidades: unidadesEditar.value
	};
	
	fetch('http://localhost/carrinho/json/vendas.php', {
		
			method: 'POST',
			body: JSON.stringify(dados)
			
	})*/
	
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
		loadTotal();
		alert(msg);
	}).catch(function(err){
		alert("Erro ao atualizar venda!");
	});

}

function getCarrinho(){
	
	rota.setUrl('json/carrinhos.php?opcao=get&id='+id.value);
	
	fetch(rota.getUrl())
	
	.then(function(response){
		
		return response.json();
	}).then(function(response){
		let tmpProdutos;
		response.forEach(function(registro){
			
			if(registro.produtos == null){
				tmpProdutos = 0;
			}else{
				tmpProdutos = registro.produtos;
			}
		
			carrinhoDados = {
				id: registro.id,
				produtos: parseInt(tmpProdutos),
				status: registro.status,
				total: registro.total,
				dia: registro.dia,
				hora: registro.hora
			};
			
			totalProdutos = parseInt(tmpProdutos);
			
		});
		
	});
	return carrinhoDados;
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


form.addEventListener('submit', function(event){
	event.preventDefault()
	exibirModal();
});


barcode.addEventListener('focusout', function(){
	exibirModal();
});

registrar.addEventListener('click', function(){
	registrarVenda();
	modalClose();
});

fechar.addEventListener('click', function(){
	modalClose();
	unidades.value = "";
	barcode.value = ""; 
});

editarClose.addEventListener('click', function(){
	modalEditarClose();
});

salvar.addEventListener('click', function(){
	updateVenda(id_venda.value);
	console.log("Unidades: "+unidadesEditar.value);
	modalEditarClose();
	
});

finalizar.addEventListener('click', function(){
	finalizarCarrinho();
});

loadVendas();
loadTotal();




