	
	const formPesquisar = document.querySelector("#form-pesquisar");
	const codigo = document.querySelector("#codigo");
	const nome = document.querySelector("#nome");
	const categorias = document.querySelector("#categorias");
	const produtosItems = document.querySelector("#produtos-items");
	const paginate = document.querySelector("#paginate");
	const page = document.querySelector("#page");
	
	const modalFundo = document.querySelector("#modal-fundo");
	const modalMeio = document.querySelector("#modal-meio");
	
	const modalMeio2 = document.querySelector("#modal-meio2");
	
	const btnNew = document.querySelector("#btn-novo");
	
	const codigoProduto = document.querySelector("#codigo_produto");
	const nomeProduto = document.querySelector("#nome_produto");
	const categoriaProduto = document.querySelector("#categoria_produto");
	const pcusto = document.querySelector("#pcusto");
	const pvenda = document.querySelector("#pvenda");
	const estoque = document.querySelector("#estoque");
	
	const codigoProduto2 = document.querySelector("#codigo_produto2");
	const nomeProduto2 = document.querySelector("#nome_produto2");
	const categoriaProduto2 = document.querySelector("#categoria_produto2");
	const pcusto2 = document.querySelector("#pcusto2");
	const pvenda2 = document.querySelector("#pvenda2");
	const estoque2 = document.querySelector("#estoque2");
	
	const btnCadastrar = document.querySelector("#btn-cadastrar");
	
	const btnSalvar = document.querySelector("#btn-salvar");
	
	var total;
	
	var html;

	function loadCategorias(){
		
		rota.setUrl("json/produtos.php?opcao=categorias");
		
		fetch(rota.getUrl())
		
		.then(function(response){
		
			return response.json();
		}).then(function(response){
		
			html = "<option value='0'>--Categorias--</option>";
		
			response.forEach(function(categoria){
		
				html += "<option value='"+categoria.id+"'>"+categoria.nome+"</option>";
		
			});
		
			categorias.innerHTML = html;
			categoriaProduto.innerHTML = html;
			categoriaProduto2.innerHTML = html;
		
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
				
				abrirModal2(codigo);
			});
			i++;
		});
	}
	
	function loadRemoves(btnRemoves, codigos){
		let i = 0;
		
		codigos.forEach(function(codigo){
			btnRemoves[i].addEventListener('click', function(event){
				event.preventDefault();
				
				deleteProduto(codigo);
			});
			i++;
		});
	}
		
		
	function loadProdutos(){
		
		rota.setUrl("json/produtos.php?opcao=index&codigo="+codigo.value+"&nome="+nome.value+"&categoria="+categorias.value+"&page="+page.value);
		
		fetch(rota.getUrl())
			
		.then(function(response){
		
			return response.json();
		}).then(function(response){
				
			html = "";
			let codigos = new Array();
				
			response.forEach(function(produto){
				
				html += "<div class='produto-item'>";
				html += "<div class='produto-item-interno'>";
				html += "<div class='produto-info produto-imagem'>";
				html += "Imagem";
				html += "</div>";
				html += "<div class='produto-info produto-dados'>";
				html += "<strong>Codigo: </strong>"+produto.codigo+"<br>";
				html += "<strong>Produto: </strong>"+produto.produto+"<br>";
				html += "<strong>Categoria: </strong>"+produto.categoria+"<br>";
				html += "<strong>Preco custo: </strong>R$ "+produto.pcusto+"<br>";
				html += "<strong>Preco venda: </strong>R$ "+produto.pvenda+"<br>";
				html += "<strong>Estoque: </strong>"+produto.estoque+"<br>";
				html += "</div>";
				html += "<div class='produto-info produto-editar'>";
				rota.setUrl("assets/imgs/icons/edit-2.svg");
				html += "<a href='#' class='acao edit'><img src='"+rota.getUrl()+"'></a>";
				html += "</div>";
				html += "<div class='produto-info produto-remover'>";
				rota.setUrl("assets/imgs/icons/trash-2.svg");
				html += "<a href='#' class='acao remove'><img src='"+rota.getUrl()+"'></a>";
				html += "</div>";
				html += "</div>";
				html += "</div>";
				total = produto.total;
				codigos.push(produto.codigo);
			
			});
				
			produtosItems.innerHTML = html;
			
			let btnEdits = document.querySelectorAll(".edit");
			loadEditar(btnEdits, codigos);
			
			let btnRemoves = document.querySelectorAll(".remove");
			loadRemoves(btnRemoves, codigos);
			
			paginacao(page.value);
			
		
		}).catch(function(err){
			
			alert("Nenhum produto encontrado!");
		});
			
	}
	
	function loadPaginas(a, links){
		let i = 0;
		links.forEach(function(link){
			a[i].addEventListener('click', function(event){
				event.preventDefault();
				page.value = link;
				loadProdutos();
			});
			i++;
		});
	}
	
		
		
	function paginacao(atual){
		
		atual = parseInt(atual);
			
		let limit = 5;
		let colunas = 3;
		let paginas = Math.ceil(total/limit);

		let inicio = ((atual - 1) * limit) + 1;
		let fim;
		
		if((atual * limit) >= total){
			fim = total;
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
		
		function abrirModal(){
			modalFundo.style.display = "block";
			modalMeio.style.display = "block";
		}
		
		function abrirModal2(cod){
			
			rota.setUrl('json/produtos.php?opcao=get&codigo='+cod);
			
			fetch(rota.getUrl())
			
			.then(function(response){
				
				return response.json();
			}).then(function(response){
			
				response.forEach(function(produto){
					codigoProduto2.value = produto.codigo;
					nomeProduto2.value = produto.produto;
					categoriaProduto2.value = produto.categoria_id;
					pcusto2.value = produto.pcusto;
					pvenda2.value = produto.pvenda;
					estoque2.value = produto.estoque;
				});
				modalFundo.style.display = "block";
				modalMeio2.style.display = "block";
			})
			
		}
		
		function fecharModal2(){
			modalFundo.style.display = "none";
			modalMeio2.style.display = "none";
		}
		
		function updateProduto(){
			
			rota.setUrl('json/produtos.php?opcao=update&codigo='+codigoProduto2.value+'&nome='+nomeProduto2.value+'&categoria='+categoriaProduto2.value+'&pcusto='+pcusto2.value+'&pvenda='+pvenda2.value+'&estoque='+estoque2.value);
			
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
					loadProdutos();
					alert(msg);
				}else{
					alert(msg);
				}
			
			});
		}
		
		function deleteProduto(cod){
			
			rota.setUrl('json/produtos.php?opcao=delete&codigo='+cod);
			
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
					loadProdutos();
					alert(msg);
				}else{
					alert(msg);
				}
			
			});
		}
		
		function createProduto(){
			
			if(codigoProduto.value != "" && codigoProduto.value !="0" && nomeProduto.value != "" && categoriaProduto.value != "0" && pcusto.value != "0" && pcusto.value != "" && pvenda.value != "0" && pvenda.value != "" && estoque.value != "0" && estoque.value != ""){
				
				rota.setUrl('json/produtos.php?opcao=create&codigo='+codigoProduto.value+'&nome='+nomeProduto.value+'&categoria='+categoriaProduto.value+'&pcusto='+pcusto.value+'&pvenda='+pvenda.value+'&estoque='+estoque.value);
				
				fetch(rota.getUrl())
				
				.then(function(response){
					
					return response.json();
				}).then(function(response){
					let type, msg;
					response.forEach(function(result){
						type = result.tipo;
						msg = result.msg;
					});
					if(type == true){
						fecharModal();
						alert(msg);
						loadProdutos();
					}else{
						alert(msg);
					}
				}).catch(function(err){
					alert("Erro ao realizar requisição!");
				});
			}else{
				alert("Erro, preencha todos os campos corretamente!");
			}   
			
		}
		
		function fecharModal(){
			
			modalFundo.style.display = "none";
			modalMeio.style.display = "none";
			
		}
		
		
		
		formPesquisar.addEventListener('submit', function(event){
			event.preventDefault();
			page.value = 1;
			loadProdutos();
			
		});
		
		btnNew.addEventListener('click', function(){
			
			abrirModal();
			
		});
		
		btnCadastrar.addEventListener('click', function(){
			createProduto();
		});
		
		btnSalvar.addEventListener('click', function(){
			updateProduto();
			fecharModal2();
		});

		loadCategorias();
		loadProdutos();
		
