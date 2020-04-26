

const nome = document.querySelector("#nome");
const email = document.querySelector("#email");
const endereco = document.querySelector("#endereco");
const cnpj = document.querySelector("#cnpj");
const fone = document.querySelector("#fone");
const zap = document.querySelector("#zap");

const formCadastrar = document.querySelector("#form-cadastrar");

const mercado = new Mercado();

function preencheDados(){
	nome.value = "Mateus Supermercados";
	email.value = "mateus04@gmail.com";
	endereco.value = "Av Guajajaras , São Cristovão n34";
	cnpj.value = "76790123035";
	fone.value = "98932439876";
	zap.value = "98988233307";
}

function cadastrarMercado(){
	if(nome.value != "" && email.value != "" && endereco.value != "" && cnpj.value != "" && fone.value != "" && zap.value != ""){
		
		resposta = mercado.create(nome.value, email.value, endereco.value, cnpj.value, fone.value, zap.value);
		
		resposta.then(function(response){
			let type, msg;
			response.forEach(function(result){
				type = result.tipo;
				msg = result.msg;
			});
			
			if(type){
				rota.redirect('views/homes/admin/index.php');
			}else{
				alert(msg);
			}
			
		}).catch(function(err){
			alert("Erro ao enviar reuisição!");
		});
	}else{
		alert("Preencha todos os campos!");
	}
}

preencheDados();

formCadastrar.addEventListener('submit', function(event){
	event.preventDefault();
	cadastrarMercado();
})
