const inicio = document.querySelector("#inicio");

const fim = document.querySelector("#fim");

const pesquisar = document.querySelector("#form-pesquisar");

const vendasTable = document.querySelector("#vendas-table");

const paginate = document.querySelector("#paginate");

const page = document.querySelector("#page");

var html;
var totalRegistros = 0;

function loadVendas(){
	
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
	
	rota.setUrl('json/vendas.php?opcao=index&id=&status=&inicio='+dt_inicio+'&fim='+dt_fim+'&page='+page.value);
	
	fetch(rota.getUrl())
	
	.then(function(response){
		return response.json();
	}).then(function(response){
	
		html = "<tr>";
		html += "<th>Id</th>";
		html += "<th>Código</th>";
		html += "<th>Produto</th>";
		html += "<th>Preço</th>";
		html += "<th>Unidades</th>";
		html += "<th>Total</th>";
		html += "<th>Dia</th>";
		html += "<th>Hora</th>";
		html += "</tr>";
		
		let registros;
	
		response.forEach(function(vendas){
			
			registros = vendas.registros;
			
			registros.forEach(function(registro){
				
				html += "<tr>";
				html += "<td>"+registro.id+"</td>";
				html += "<td>"+registro.codigo+"</td>";
				html += "<td>"+registro.produto+"</td>";
				html += "<td>R$ "+registro.preco+"</td>";
				html += "<td>"+registro.unidades+"</td>";
				html += "<td>R$ "+registro.total+"</td>";
				html += "<td>"+registro.dia+"</td>";
				html += "<td>"+registro.hora+"</td>";
				html += "</tr>";
				
			});
			
			totalRegistros = parseInt(vendas.total);
			
		});
		
		vendasTable.innerHTML = html;
		
		paginacao(page.value);
		
		
	}).catch(function(err){
		page.value = 1;
		inicio.value = "";
		fim.value = "";
		loadVendas();
		alert("Nenhum registro encontrado! "+err);
		
	});
}


function loadPaginas(a, links){
		let i = 0;
		links.forEach(function(link){
			a[i].addEventListener('click', function(event){
				event.preventDefault();
				page.value = link;
				loadVendas();
			});
			i++;
		});
	}
	
		
		
function paginacao(atual){
		
	atual = parseInt(atual);
			
	let limit = 10;
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

loadVendas();

pesquisar.addEventListener('submit', function(event){
	event.preventDefault();
	page.value = 1;
	loadVendas();
});


