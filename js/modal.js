
const modalFundo = document.querySelector("#modal-fundo");

const modalBoxDeleteUser = document.querySelector("#modal-linha-delete-user");
const modalBodyDeleteUser = document.querySelector("#modal-user-delete-body");

const modalBoxCriarProduto = document.querySelector("#modal-linha-criar-produto");
const modalHeadCriarProduto = document.querySelector("#modal-head-criar-produto");

const modalBoxDeletarProduto = document.querySelector("#modal-linha-deletar-produto");
const modalHeadDeletarProduto = document.querySelector("#modal-head-delete-produto");
const modalBodyDeletarProduto = document.querySelector("#modal-produto-delete-body");

const modalBoxEditarVenda = document.querySelector("#modal-linha-editar-venda");
const modalEditarVendaDados = document.querySelector("#modal-vendas-editar-info");

const modalBoxDeletarCarrinho = document.querySelector("#modal-linha-deletar-carrinho");
const modalBodyDeletarCarrinho = document.querySelector("#modal-carrinho-delete-body");

const modalBoxDeletarVenda = document.querySelector("#modal-linha-deletar-venda");
const modalBodyDeletarvenda = document.querySelector("#modal-venda-delete-body");

function modalDeleteUserShow(){
	modalFundo.style.display = "block";
	modalBoxDeleteUser.style.display = "block";
}

function modalDeleteUserClose(){
	modalFundo.style.display = "none";
	modalBoxDeleteUser.style.display = "none";
}

function modalCriarProdutoShow(){
	modalHeadCriarProduto.innerHTML = "<h2>CADASTRAR PRODUTO</h2>";
	modalFundo.style.display = "block";
	modalBoxCriarProduto.style.display = "block";
}

function modalCriarProdutoClose(){
	modalFundo.style.display = "none";
	modalBoxCriarProduto.style.display = "none";
}

function modalEditarProdutoShow(){
	modalHeadCriarProduto.innerHTML = "<h2>ATUALIZAR PRODUTO</h2>";
	modalFundo.style.display = "block";
	modalBoxCriarProduto.style.display = "block";
}

function modalEditarProdutoClose(){
	modalFundo.style.display = "none";
	modalBoxCriarProduto.style.display = "none";
}

function modalDeletarProdutoShow(){
	modalFundo.style.display = "block";
	modalBoxDeletarProduto.style.display = "block";
}

function modalDeletarProdutoClose(){
	modalFundo.style.display = "none";
	modalBoxDeletarProduto.style.display = "none";
}

function modalEditarVendaShow(){
	modalFundo.style.display = "block";
	modalBoxEditarVenda.style.display = "block";
}

function modalEditarVendaClose(){
	modalFundo.style.display = "none";
	modalBoxEditarVenda.style.display = "none";
}

function modalDeletarCarrinhoShow(){
	modalFundo.style.display = "block";
	modalBoxDeletarCarrinho.style.display = "block";
}

function modalDeletarCarrinhoClose(){
	modalFundo.style.display = "none";
	modalBoxDeletarCarrinho.style.display = "none";
}

function modalDeletarVendaShow(){
	modalFundo.style.display = "block";
	modalBoxDeletarVenda.style.display = "block";
}

function modalDeletarVendaClose(){
	modalFundo.style.display = "none";
	modalBoxDeletarVenda.style.display = "none";
}


