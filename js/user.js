function User(){

	this.create = function(nome, email, user_name, password, fone, zap, tipo){
	
		let form = new FormData();
		form.append('opcao', 'create');
		form.append('nome', nome);
		form.append('email', email);
		form.append('user_name', user_name);
		form.append('password', password);
		form.append('fone', fone);
		form.append('zap', zap);
		form.append('tipo', tipo);
		
		rota.setUrl('json/users.php');
	
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		}).then(function(response){
		
			return response.json();
		});
	}
	
	this.logar = function(user, password){
		let form = new FormData();
		form.append('opcao', 'login');
		form.append('user', user);
		form.append('password', password);
		rota.setUrl('json/users.php');
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		})
		.then(function(response){
			return response.json();
		});
	}
	
	this.index = function(nome_user, tipo_id, pagina){
		rota.setUrl('json/users.php?opcao=index&nome='+nome_user+'&nivel='+tipo_id+'&page='+pagina);
		return fetch(rota.getUrl())
		.then(function(response){
			return response.json();
		});
	} 
	
	this.update = function(id, nome, email, user_name, password, fone, zap, tipo){
	
		let form = new FormData();
		form.append('opcao', 'update');
		form.append('id', id);
		form.append('nome', nome);
		form.append('email', email);
		form.append('user_name', user_name);
		form.append('password', password);
		form.append('fone', fone);
		form.append('zap', zap);
		form.append('tipo', tipo);
		
		rota.setUrl('json/users.php');
	
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		}).then(function(response){
		
			return response.json();
		});
	}
	
	this.delete = function(id_usuario){
		let form = new FormData();
		form.append('opcao', 'delete');
		form.append('id', id_usuario);
		
		rota.setUrl('json/users.php');
		
		return fetch(rota.getUrl(), {
			method: 'POST',
			body: form
		})
		.then(function(response){
			return response.json();
		});
	}
	
}
