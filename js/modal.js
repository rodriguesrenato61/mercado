
const modal = document.querySelector("#modal");

const modalEditar = document.querySelector("#modal-editar");

const modalBox = document.querySelector("#modal-box");

const modalBoxEditar = document.querySelector("#modal-box-editar");

const modalBody = document.querySelector("#modal-body");

const modalDados = document.querySelector("#modal-dados");

const modalDadosEditar = document.querySelector("#modal-dados-editar");

const modalFechar = document.querySelector("#modal-fechar");

function modalShow(barcode){
	
	fetch('http://localhost/carrinho/json/produtos.php?opcao=get&codigo='+barcode)
		
	.then(function(response){
			
		return response.json();
		
	}).then(function(response){
			
		let html = "";
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
			
			modalDados.innerHTML = html
			
			modal.style.display = "block";
			modalBox.style.display = "block";
		}else{
			alert("Produto não encontrado!");
		}
		
	});
	
}

function modalEditarShow(venda_id){
	
	fetch('http://localhost/carrinho/json/vendas.php?opcao=get&id='+venda_id)
		
	.then(function(response){
			
		return response.json();
		
	}).then(function(response){
			
		let html = "";
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
			
			modalDadosEditar.innerHTML = html
			
			modalEditar.style.display = "block";
			modalBoxEditar.style.display = "block";
			
		}else{
			alert("Produto não encontrado!");
		}
		
	});
	
}

function modalClose(){
	
	modal.style.display = "none";
	modalBox.style.display = "none";
}

function modalEditarClose(){
	
	modalEditar.style.display = "none";
	modalBoxEditar.style.display = "none";
}


