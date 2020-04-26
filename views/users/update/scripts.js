const user_id = document.querySelector("#user_id");
const nome = document.querySelector("#nome");
const email = document.querySelector("#email");
const user_name = document.querySelector("#user_name");
const tipo = document.querySelector("#tipo");
const fone = document.querySelector("#fone");
const zap = document.querySelector("#zap");
const passwd = document.querySelector("#passwd");

const ulErros = document.querySelector("#ul-erros");

const formAtualizar = document.querySelector("#form-atualizar");

const modalFundo = document.querySelector("#modal-fundo");
const modalMeio = document.querySelector("#modal-meio");

const users = new User();

function msgErros(){
	modalFundo.style.display = "block";
	modalMeio.style.display = "block";
}

function closeErros(){
	modalFundo.style.display = "none";
	modalMeio.style.display = "none";
}

function preencheDados(){
	nome.value = "Renato Rodrigues";
	email.value = "rodriguesrenato61@gmail.com";
	tipo.value = "3";
	user_name.value = "rodriguesrenato61";
	passwd.value = "123";
	fone.value = "98988258639";
	zap.value = "98999812283";
}

function atualizar(){
	if(user_id.value!= "" && nome.value != "" && email.value != "" && tipo.value != "0" && user_name.value != "" && fone.value != "" && zap.value != "" && passwd.value != ""){
		let resposta;
		let html_erros = "";
		
		resposta = users.update(user_id.value, nome.value, email.value, user_name.value, passwd.value, fone.value, zap.value, tipo.value);
			
		resposta.then(function(response){
			let sucess, msg;
			
			response.forEach(function(retorno){
				sucess = retorno.tipo;
				msg = retorno.msg;
			});
				
			if(sucess){		
				rota.redirect('views/users/index/index.php?page=1');
			}else{
				html_erros = "<li>"+msg+"</li>";
				ulErros.innerHTML = html_erros;
				msgErros();
			}
				
		}).catch(function(err){
			html_erros = "<li>Erro ao enviar dados</li>";
			ulErros.innerHTML = html_erros;
			msgErros();
		});
		
	}else{
		alert("Preencha todos os campos!");
	}
}


formAtualizar.addEventListener('submit', function(event){
	event.preventDefault();
	atualizar();
});







