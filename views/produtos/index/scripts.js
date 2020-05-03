	
	const formPesquisar = document.querySelector("#form-pesquisar");
	const codigo = document.querySelector("#codigo");
	const nome = document.querySelector("#nome");
	const categorias = document.querySelector("#categorias");
	const produtosTable = document.querySelector("#produtos-table");
	const paginate = document.querySelector("#paginate");
	const page = document.querySelector("#page");
	
	const btnNew = document.querySelector("#btn-novo");
	
	const codigoProduto = document.querySelector("#codigo_produto");
	const nomeProduto = document.querySelector("#nome_produto");
	const categoriaProduto = document.querySelector("#categoria_produto");
	const pcusto = document.querySelector("#pcusto");
	const pvenda = document.querySelector("#pvenda");
	const estoque = document.querySelector("#estoque");
	
	const btnCadastrarSalvar = document.querySelector("#btn-cadastrar-salvar");
	const btnCancelar = document.querySelector("#btn-cancelar");
	
	const deleteProdutoId = document.querySelector("#delete-produto-id");
	const btnDeletar = document.querySelector("#btn-deletar");
	
	const objetoProduto = new Produto();
	var opcao_delete = 0;
	
	var opcao = 1;

	
	var total;
	
	var html;

function loadCategorias(){
		
	resposta = objetoProduto.indexCategorias();
		
	resposta.then(function(response){
		
		html = "<option value='0'>--Categorias--</option>";
		
		response.forEach(function(categoria){
		
			html += "<option value='"+categoria.id+"'>"+categoria.nome+"</option>";
		
		});
		
		categorias.innerHTML = html;
		categoriaProduto.innerHTML = html;
		
	}).catch(function(err){
			
		categorias.innerHTML = "<option value='0'>Erro</option>";
			categoriaProduto.innerHTML = "<option value='0'>Erro</option>";
	});
}
	
function loadEditar(btnEdits, codigos){
	let i = 0;
		
	codigos.forEach(function(codigo){
		btnEdits[i].addEventListener('click', function(event){
			event.preventDefault();
				
			abrirModalEditar(codigo.codigo);
		});
		i++;
	});
}
	
function loadRemoves(btnRemoves, codigos){
	let i = 0;
		
	codigos.forEach(function(codigo){
		btnRemoves[i].addEventListener('click', function(event){
			event.preventDefault();
				
			modalBodyDeletarProduto.innerHTML = "<h2>Você tem certeza de que deseja deletar o produto "+codigo.nome+"?</h2>";
			deleteProdutoId.value = codigo.codigo;
			modalDeletarProdutoShow();
				
		});
		i++;
	});
}
		
		
function loadProdutos(){
		
	resposta = objetoProduto.index('', '', '' , 1);
			
	resposta.then(function(response){
				
		html = "";
		let codigos = new Array();
		let registros, limit;
			
		html += "<tr>";
		html += "<th>Código</th>";
		html += "<th>Produto</th>";
		html += "<th>Categoria</th>";
		html += "<th>Preço de Custo</th>";
		html += "<th>Preço de Venda</th>";
		html += "<th>Estoque</th>";
		html += "<th colspan='2'>Ação</th>";
		html += "</tr>";
				
		response.forEach(function(result){
				
			registros = result.registros;
				
			registros.forEach(function(produto){
				html += "<tr>";
				html += "<td>"+produto.codigo+"</td>";
				html += "<td>"+produto.produto+"</td>";
				html += "<td>"+produto.categoria+"</td>";
				html += "<td>R$ "+produto.pcusto+"</td>";
				html += "<td>R$ "+produto.pvenda+"</td>";
				html += "<td>"+produto.estoque+"</td>";
				html += "<td><a href='' class='acao edit'><img src='"+rota.getRoute('editar-icon')+"'></a></td>";
				html += "<td><a href='' class='acao remove'><img src='"+rota.getRoute('remover-icon')+"'></a></td>";
				html += "</tr>";
				codigos.push({codigo: produto.codigo, nome: produto.produto});
			});
				
			limit = result.limit;
			total = result.total;
				
		});
				
		produtosTable.innerHTML = html;
			
		let btnEdits = document.querySelectorAll(".edit");
		loadEditar(btnEdits, codigos);
			
		let btnRemoves = document.querySelectorAll(".remove");
		loadRemoves(btnRemoves, codigos);
			
		let links = paginacao(page.value, limit, total, paginate);
		loadPaginas(links);
			
	}).catch(function(err){
			
		if(opcao_delete == 0){
			alert("Nenhum produto encontrado!");
		}
		codigo.value = "";
		nome.value = "";
		categorias.value = "0";
		page.value = 1;

	});
			
}

function buscarProdutos(){
		
	resposta = objetoProduto.index(codigo.value, nome.value, categorias.value, page.value);
			
	resposta.then(function(response){
				
		html = "";
		let codigos = new Array();
		let registros, limit;
			
		html += "<tr>";
		html += "<th>Código</th>";
		html += "<th>Produto</th>";
		html += "<th>Categoria</th>";
		html += "<th>Preço de Custo</th>";
		html += "<th>Preço de Venda</th>";
		html += "<th>Estoque</th>";
		html += "<th colspan='2'>Ação</th>";
		html += "</tr>";
				
		response.forEach(function(result){
				
			registros = result.registros;
				
			registros.forEach(function(produto){
				html += "<tr>";
				html += "<td>"+produto.codigo+"</td>";
				html += "<td>"+produto.produto+"</td>";
				html += "<td>"+produto.categoria+"</td>";
				html += "<td>R$ "+produto.pcusto+"</td>";
				html += "<td>R$ "+produto.pvenda+"</td>";
				html += "<td>"+produto.estoque+"</td>";
				html += "<td><a href='' class='acao edit'><img src='"+rota.getRoute('editar-icon')+"'></a></td>";
				html += "<td><a href='' class='acao remove'><img src='"+rota.getRoute('remover-icon')+"'></a></td>";
				html += "</tr>";
				codigos.push({codigo: produto.codigo, nome: produto.produto});
			});
				
			limit = result.limit;
			total = result.total;
				
		});
				
		produtosTable.innerHTML = html;
			
		let btnEdits = document.querySelectorAll(".edit");
		loadEditar(btnEdits, codigos);
			
		let btnRemoves = document.querySelectorAll(".remove");
		loadRemoves(btnRemoves, codigos);
			
		let links = paginacao(page.value, limit, total, paginate);
		loadPaginas(links);
			
	}).catch(function(err){
		
		alert("Nenhum produto encontrado!");

		codigo.value = "";
		nome.value = "";
		categorias.value = "0";
		page.value = 1;
		loadProdutos();
	});
			
}
	
function loadPaginas(links){
	let a = document.querySelectorAll(".pagina");
	let i = 0;
	links.forEach(function(link){
		a[i].addEventListener('click', function(event){
			event.preventDefault();
			page.value = link;
			buscarProdutos();
		});
		i++;
	});
}
	
function abrirModalCriar(){
	btnCadastrarSalvar.innerText = "Cadastrar";
	opcao = 1;
	modalCriarProdutoShow();
}
	
		
		
function abrirModalEditar(cod){
			
	resposta = objetoProduto.get(cod);
			
	resposta.then(function(response){

		response.forEach(function(produto){
			codigoProduto.value = produto.codigo;
			nomeProduto.value = produto.produto;
			categoriaProduto.value = produto.categoria_id;
			pcusto.value = produto.pcusto;	
			pvenda.value = produto.pvenda;
			estoque.value = produto.estoque;
		});
		btnCadastrarSalvar.innerText = "Salvar";
		opcao = 2;
		modalEditarProdutoShow();
	});
			
}
		
		
		
function updateProduto(){
			
	resposta = objetoProduto.update(codigoProduto.value, nomeProduto.value, categoriaProduto.value, pcusto.value, pvenda.value, estoque.value);		
			
	resposta.then(function(response){
		let sucess, msg;
		response.forEach(function(result){
			sucess = result.tipo;
			msg = result.msg;
		});
		if(sucess){
			loadProdutos();
			modalEditarProdutoClose();
			loadMensagem(sucess, msg);
			opcao = 0;
		}else{
			alert(msg);
		}
		
			
	}).catch(function(err){
		modalEditarProdutoClose();
		loadMensagem(false, "Erro, não foi possível atualizar o produto!");
		opcao = 0;
	});
}
		
function deleteProduto(cod){
			
	resposta = objetoProduto.delete(cod);
			
	resposta.then(function(response){
		let sucess, msg;
		response.forEach(function(result){
			sucess = result.tipo;
			msg = result.msg;
		});
		if(sucess){
			loadProdutos();
		}
		loadMensagem(sucess, msg);
			
	}).catch(function(err){
		loadMensagem(false, "Erro ao enviar requisição!");
	});
}

		
function createProduto(){
			
	if(codigoProduto.value != "" && codigoProduto.value !="0" && nomeProduto.value != "" && categoriaProduto.value != "0" && pcusto.value != "0" && pcusto.value != "" && pvenda.value != "0" && pvenda.value != "" && estoque.value != "0" && estoque.value != ""){
				
		resposta = objetoProduto.create(codigoProduto.value, nomeProduto.value, categoriaProduto.value, pcusto.value, pvenda.value, estoque.value);
				
		resposta.then(function(response){
			let sucess, msg;
			response.forEach(function(result){
				sucess = result.tipo;
				msg = result.msg;
			});
			if(sucess){
				loadProdutos();
				modalCriarProdutoClose();
				loadMensagem(sucess, msg);
			}else{
				alert(msg);
				opcao = 1;
			}
				
		}).catch(function(err){
			loadMensagem(false, "Erro ao enviar requisição!");
		});
	}else{
		alert("Erro, preencha todos os campos corretamente!");
	}
			
}
		
function criar_atualizar(){

	switch(opcao){
		case 1:
			createProduto();
		break;
			
		case 2:
			updateProduto();
		break;

	}
	
}		
		
		
formPesquisar.addEventListener('submit', function(event){
	event.preventDefault();
	page.value = 1;
	opcao_delete = 0;
	buscarProdutos();
			
});
		
btnNew.addEventListener('click', function(){
	abrirModalCriar();		
});
		
btnCadastrarSalvar.addEventListener('click', function(){
	criar_atualizar();
});

btnCancelar.addEventListener('click', function(){
	modalCriarProdutoClose();
});

btnDeletar.addEventListener('click', function(){
	deleteProduto(deleteProdutoId.value);
	opcao_delete = 1;
	loadProdutos();
	modalDeletarProdutoClose();
});
	
loadCategorias();
loadProdutos();
		
