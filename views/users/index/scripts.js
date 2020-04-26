const usersTable = document.querySelector("#users-table");
const nivel = document.querySelector("#nivel");
const nome = document.querySelector("#nome");
const page = document.querySelector("#page");
const pesquisar = document.querySelector("#form-pesquisar");
const paginate = document.querySelector("#paginate");
const mensagem = document.querySelector("#msg");
const inputDelete = document.querySelector("#delete-user");
const modalUserDeleteBody = document.querySelector("#modal-user-delete-body");
const btnDeletar = document.querySelector("#btn-deletar");

var html, total;

const user = new User();

function loadMsg(){
	rota.setUrl('json/users.php?opcao=msg');
	fetch(rota.getUrl())
	
	.then(function(response){
		return response.json();
	}).then(function(response){
		let sucess, msg;
		response.forEach(function(conteudo){
			sucess = conteudo.tipo;
			msg = conteudo.msg;
		});
		if(sucess){
			html = "";
			html += "<div class='msg-head'>";
			html += "<a href='' class='msg-fechar' id='msg-fechar'>X</a>";
			html += "</div>";
			html += "<div class='msg-body'>";
			html += "<h2>"+msg+"</h2>";
			html += "</div>";
			mensagem.innerHTML = html;
			mensagem.style.visibility = "visible";
			let aFechar = document.querySelector("#msg-fechar");
			aFechar.addEventListener('click', function(event){
				event.preventDefault();
				mensagem.style.visibility = "hidden";
			});
		}else{
			console.log(msg);
		}
	});
}

loadMsg();

function modalDeleteUser(usuarioId){
	abrirModal();
}
function loadRemover(usersId){
	let removeLinks = document.querySelectorAll(".remover");
	let i = 0;
	usersId.forEach(function(usuario_id){
		removeLinks[i].addEventListener('click', function(event){
			event.preventDefault();
			inputDelete.value = usuario_id.id;
			html = "<h2>Você tem certeza de que deseja excluir o usuário "+usuario_id.user_name+"?</h2>";
			modalUserDeleteBody.innerHTML = html;
			modalDeleteUser();
		});
		i++;
	});
}

function loadUsers(){

	resposta = user.index(nome.value, nivel.value, page.value);
	
	resposta.then(function(response){
		html = '<tr>';
		html += '<th>Id</th>';
		html += '<th>Nome</th>';
		html += '<th>Usuário</th>';
		html += '<th>Nível</th>';
		html += '<th>Email</th>';
		html += '<th>Fone</th>';
		html += '<th>Whatszapp</th>';
		html += "<th colspan='2'>Ação</th>";
		html += '</tr>';
		
		let registros;
		let usersId = new Array();
		response.forEach(function(dado){
			registros = dado.registros;
			registros.forEach(function(usuario){
				html += '<tr>';
				html += '<td>'+usuario.id+'</td>';
				html += '<td>'+usuario.nome+'</td>';
				html += '<td>'+usuario.user_name+'</td>';
				html += '<td>'+usuario.nivel+'</td>';
				html += '<td>'+usuario.email+'</td>';
				html += '<td>'+usuario.fone+'</td>';
				html += '<td>'+usuario.zap+'</td>';
				rota.setUrl('views/users/update/index.php?id='+usuario.id);
				html += "<td><a href='"+rota.getUrl()+"' class='editar'><img src='"+rota.getRoute('editar-icon')+"'></a></td>";
				html += "<td><a href='' class='remover'><img src='"+rota.getRoute('remover-icon')+"'></a></td>";
				html += '</tr>';
				usersId.push({id: usuario.id, user_name: usuario.user_name});
			});
			total = parseInt(dado.total);
		});
		
		usersTable.innerHTML = html;
		let links = paginacao(page.value, total, paginate);
		loadPaginas(links);
		loadRemover(usersId);
		
	}).catch(function(err){
		alert('Nenhum usuário encontrado!');
	});
	
}


function loadPaginas(links){
	let i = 0;
	let a = document.querySelectorAll(".pagina");
	links.forEach(function(link){
		a[i].addEventListener('click', function(event){
			event.preventDefault();
			page.value = link;
			loadUsers();
		});
		i++;
	});
}
	
		
function deleteUser(){
	
	let resposta = user.delete(inputDelete.value);
	
	resposta.then(function(response){
		let sucess, msg;
		response.forEach(function(resultado){
			sucess = resultado.tipo;
			msg = resultado.msg;
		});
		if(sucess){
			fecharModal();
			loadUsers();
			alert(msg);
		}else{
			alert(msg);
		}
	});
}

pesquisar.addEventListener('submit', function(event){
	event.preventDefault();
	page.value = 1;
	loadUsers();
});

btnDeletar.addEventListener('click', function(){
	deleteUser();
});

loadUsers();
