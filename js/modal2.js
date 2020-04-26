const modalFundo = document.querySelector("#modal-fundo");
const modalMeio = document.querySelector("#modal-meio");

function abrirModal(){
	modalFundo.style.display = "block";
	modalMeio.style.display = "block";
}

function fecharModal(){
	modalFundo.style.display = "none";
	modalMeio.style.display = "none";
}
