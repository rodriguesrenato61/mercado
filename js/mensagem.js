const msgBox = document.querySelector("#msg");
const msgBody = document.querySelector("#msg-body");
const msgFechar = document.querySelector("#msg-fechar");

function loadMensagem(sucess, texto){
	if(sucess){
		msgBox.style.backgroundColor = "green";
	}else{
		msgBox.style.backgroundColor = "red";
	}
	msgBody.innerHTML = "<p>"+texto+"</p>";
	msgBox.style.display = "block";
}

function closeMensagem(){
	msgBox.style.display = "none";
}

msgFechar.addEventListener('click', function(event){
	event.preventDefault();
	closeMensagem();
});

function Mensagem(){

	this.get = function(){
		rota.setUrl('json/users.php?opcao=msg');
		return fetch(rota.getUrl())
		.then(function(response){
			return response.json();
		});
	}
	
}
