const nome = document.querySelector("#nome");
const email = document.querySelector("#email");
const user_name = document.querySelector("#user_name");
const tipo = document.querySelector("#tipo");
const fone = document.querySelector("#fone");
const zap = document.querySelector("#zap");
const passwd = document.querySelector("#passwd");
const passwd2 = document.querySelector("#passwd2");

const ulErros = document.querySelector("#ul-erros");

const formCadastrar = document.querySelector("#form-cadastrar");

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
	passwd2.value = "321";
	fone.value = "98988258639";
	zap.value = "98999812283";
}

function cadastrar(){
	if(nome.value != "" && email.value != "" && tipo.value != "0" && user_name.value != "" && fone.value != "" && zap.value != "" && passwd.value != "" && passwd2.value != ""){
		let passwd_valido, resposta;
		let html_erros = "";
		if(passwd.value == passwd2.value){
			passwd_valido = true;
		}else{
			passwd_valido = false;
			html_erros += "<li>A senha e o confirmar senha não correspondem</li>";
		}
		
		if(passwd_valido){
			
			resposta = users.create(nome.value, email.value, user_name.value, passwd.value, fone.value, zap.value, tipo.value);
			
			resposta.then(function(response){
				
				let sucess, msg;
			
				response.forEach(function(retorno){
					sucess = retorno.tipo;
					msg = retorno.msg;
				});
				
				if(sucess){
					
					console.log(msg);
					
					let opc = parseInt(tipo.value);
					
					switch(opc){
						case 2:
						
							rota.redirect('views/mercados/create/index.php');
						
						break;
						
						case 3:
						
							rota.redirect('views/login/index.php');
						
						break;
					}
					
				}else{
					html_erros = "<li>"+msg+"</li>";
					ulErros.innerHTML = html_erros;
					msgErros();
				}
				
			}).catch(function(err){
				html_erros = "<li>Erro ao enviar dados</li>";
				ulErros.innerHTML = html_erros;
			});
			
		}else{
			ulErros.innerHTML = html_erros;
			msgErros();
		}
		
		
	}else{
		alert("Preencha todos os campos!");
	}
}

preencheDados();

formCadastrar.addEventListener('submit', function(event){
	event.preventDefault();
	cadastrar();
});







