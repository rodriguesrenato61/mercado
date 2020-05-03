
	function paginacao(atual, limit, totalRegistros, divPaginacao){
		let links = new Array();
		let htmlCode = "<h2>";
		if(limit > 0){
			atual = parseInt(atual);
				
			let colunas = 5;
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
	
				let num;
				
				for(i = pagina_inicial; i <= pagina_final; i++){
					
					if(i == pagina_inicial){
						
						if(i > colunas){
							htmlCode += "<a class='pagina seta' href=''><<<</a>";
							num = i - 1;
							links.push(num);
						}
					}
					
					if(i == atual){
						
						htmlCode += " <strong><a class='pagina escolhido' href=''>"+i+"</a></strong>";
						num = i;
						links.push(num);
					}else{
						htmlCode += " <a class='pagina comum' href=''>"+i+"</a>";
						num = i;
						links.push(num);
					}
					
					if(i == pagina_final){
						if(i < paginas){
							htmlCode += " <a class='pagina seta' href=''>>>></a>";
							num = i + 1;
							links.push(num);
						}
					}
					
				}
				
				htmlCode += "</h2>";
				
				
			}else{
				htmlCode += " <strong><a class='pagina escolhido' href=''>1</a></strong>";
				links.push(1);
			}
			divPaginacao.innerHTML = htmlCode;
			return links;
			
		}
