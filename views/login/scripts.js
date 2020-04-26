const user = document.querySelector("#user");

const password = document.querySelector("#password");
		
const login = document.querySelector("#form-logar");
		
const usuario = new User();
		
function logar(){
			
	if(user.value != "" && password.value != ""){
		resposta = usuario.logar(user.value, password.value);
		resposta.then(function(response){
			let type, msg;
			response.forEach(function(result){
				type = result.tipo;
				msg= result.msg;
			});
			if(type){
				rota.redirect('views/homes/admin/index.php');
			}else{
				alert(msg);
			}
		}).catch(function(err){
			alert("Erro ao realizar requisição!");
		});
			
	}else{
		alert("Preencha todos os campos!");
	}
			
}
		
login.addEventListener('submit', function(event){
	event.preventDefault();
	
	logar();
});
	
