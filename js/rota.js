function Rota(baseUrl){
	let url;
	let routes = new Array();
	let names = new Array();
	let i = 0;
	
	this.setUrl = function(link){
		url = baseUrl+"/"+link;
	}
	
	this.getUrl = function(){
		return url;
	}
	
	this.setRoute = function(link, name){
		routes[i] = baseUrl+"/"+link;
		names[i] = name;
		i++;
	}
	
	this.getRoute = function(name){
		let j, retorno;
		for(j = 0; j < i; j++){
			if(names[j] == name){
				retorno = routes[j];
				break;
			}
		}
		return retorno;
	}
	
	this.redirect = function(link){
		url = baseUrl+"/"+link;
		window.location.href = url;
	}
	
}

const rota = new Rota("http://localhost/carrinho");

rota.setRoute("assets/imgs/icons/edit-2.svg", "editar-icon");

rota.setRoute("assets/imgs/icons/trash-2.svg", "remover-icon");

