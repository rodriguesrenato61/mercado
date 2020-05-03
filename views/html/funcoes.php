<?php

	$modal_init = 0;
	
	function criarModal($tipo){
		
		global $modal_init;
		
		if($modal_init == 0){
			?>
			<div class="modal-fundo" id="modal-fundo">
			</div> <!-- class modal-fundo -->
			<?php
			$modal_init++;	
		}
		?>
		<?php
		switch($tipo){
			case "delete usuário":
				?>
				<div class="modal-linha-delete-user" id="modal-linha-delete-user">
					<div class="modal-user-delete" id="modal-user-delete">
						<div class="modal-head modal-head-delete-user">
							<h2>DELETAR USUÁRIO</h2>
						</div> <!-- class modal-head -->
						<div class="modal-body modal-user-delete-body" id="modal-user-delete-body">
							Conteúdo da modal
						</div> <!-- class modal-user-delete-body -->
						<div class="modal-bottom modal-bottom-delete-user">
							<input type="hidden" name="delete-user" id="delete-user">
							<button class="modal-user-btn-deletar" id="btn-deletar">SIM</button>
							<button class="modal-user-btn-cancelar" id="btn-cancelar" onclick="modalDeleteUserClose()">NÃO</button>
						</div>
					</div> <!-- class modal-user-delete -->
				</div> <!-- class modal-linha-delete-user -->
			
				<?php
			break;
			
			case "criar produto":
				?>
				<div class="modal-linha-criar-produto" id="modal-linha-criar-produto">
				<div class="modal-criar-produto" id="modal-criar-produto">
					<div class="modal-head modal-head-criar-produto" id="modal-head-criar-produto">
						<h2>Criar produto</h2>
					</div>
					<div class="modal-body modal-criar-produto-body">
						<div class="modal-criar-produto-items modal-criar-produto-imagem">
							<div class="produto-imagem" id="imagem">
								Imagem
							</div> <!-- class imagem -->
							<div class="produto-btn-imagem">
								<input type="file" id="carregar" class="btn-imagem" onChange="carregarImagem()">
							</div> <!-- class div-btn-imagem -->
						</div> <!-- class modal-items modal-imagem -->
						<div class="modal-criar-produto-items modal-criar-produto-campos">
							<input type="number" id="codigo_produto" placeholder="codigo"><br>
							<input type="text" id="nome_produto" placeholder="produto"><br>
							<select id="categoria_produto">
								<option value="0">--Categoria--</option>
							</select><br>
							<input type="text" id="pcusto" placeholder="preço de custo">
							<input type="text" id="pvenda" placeholder="preço de venda"><br>
							<input type="number" id="estoque" placeholder="estoque">
							
						</div> <!-- class modal-campos -->
					</div> <!-- class modal-body -->
					<div class="modal-bottom modal-criar-produto-bottom">
						<button class="btn-cadastrar" id="btn-cadastrar-salvar">cadastrar</button>
						<button class="btn-cancelar" id="btn-cancelar">cancelar</button>
					</div> <!-- class modal-criar-produto-bottom -->
				</div> <!-- class modal-criar-produto -->
				</div> <!-- class modal-linha-criar-produto -->
			<?php
			break;
			
			case "delete produto":
				?>
				<div class="modal-linha-deletar-produto" id="modal-linha-deletar-produto">
					<div class="modal-produto-delete" id="modal-produto-delete">
						<div class="modal-head modal-head-delete-produto">
							<h2>DELETAR PRODUTO</h2>
						</div> <!-- class modal-head -->
						<div class="modal-body modal-produto-delete-body" id="modal-produto-delete-body">
							Conteúdo da modal
						</div> <!-- class modal-produto-delete-body -->
						<div class="modal-bottom modal-bottom-delete-produto">
							<input type="hidden" name="delete-produto" id="delete-produto-id">
							<button class="modal-produto-btn-deletar" id="btn-deletar">SIM</button>
							<button class="modal-produto-btn-cancelar" id="btn-delete-produto-cancelar" onclick="modalDeletarProdutoClose()">NÃO</button>
						</div>
					</div> <!-- class modal-produto-delete -->
				</div> <!-- class modal-linha-deletar-produto -->
			
				<?php
			break;
			
			case "carrinho editar venda":
				?>
				<div class="modal-linha-editar-venda" id="modal-linha-editar-venda">
					<div class="modal-venda-editar" id="modal-venda-editar">
						<div class="modal-head modal-head-venda-editar">
							<h2>EDITAR VENDA</h2>
						</div>
						<div class="modal-venda-editar-body" id="modal-venda-editar-body">
							<div class="modal-venda-editar-box modal-venda-editar-imagem">
								<img src="../../../assets/imgs/produtos/refrigerante.jpeg" alt="imagem do produto">
							</div> <!-- class modal-venda-editar-imagem -->
							<div class="modal-venda-editar-box modal-venda-editar-dados" id="modal-venda-editar-dados">	
								<div class="modal-vendas-editar-info" id="modal-vendas-editar-info">
									<strong>Código: </strong>00001<br>
									<strong>Produto: </strong>Refrigerante<br>
									<strong>Preço: </strong>R$ 2,00</br>
									<strong>Estoque: </strong>25<br>
								</div>		
								<input type="number" class="modal-vendas-editar-unidades" id="unidades-editar" placeholder="unidades">
							</div> <!-- modal-venda-editar-dados -->
						</div> <!-- class modal-venda-editar-body -->
						<div class="modal-bottom modal-vendas-editar-bottom">
							<input type="hidden" id="id_venda">
							<button class="btn-venda-salvar" id="salvar">Salvar</button>
							<button class="btn-venda-cancelar" id="fechar" onclick="modalEditarVendaClose()">Cancelar</button>
						</div> <!-- class modal-venda-editar-bottom -->
					</div> <!-- class modal-venda-editar -->
				</div> <!-- class modal-linha-editar-venda -->
				<?php
			break;
			
			case "delete venda":
				?>
				<div class="modal-linha-deletar-venda" id="modal-linha-deletar-venda">
					<div class="modal-venda-delete" id="modal-venda-delete">
						<div class="modal-head modal-head-delete-venda">
							<h2>DELETAR VENDA</h2>
						</div> <!-- class modal-head -->
						<div class="modal-body modal-venda-delete-body" id="modal-venda-delete-body">
							Conteúdo da modal
						</div> <!-- class modal-venda-delete-body -->
						<div class="modal-bottom modal-bottom-delete-venda">
							<input type="hidden" name="delete-venda" id="delete-venda-id">
							<button class="modal-venda-btn-deletar" id="btn-deletar">SIM</button>
							<button class="modal-venda-btn-cancelar" id="btn-delete-venda-cancelar" onclick="modalDeletarVendaClose()">NÃO</button>
						</div>
					</div> <!-- class modal-venda-delete -->
				</div> <!-- class modal-linha-deletar-venda -->
			
				<?php
			break;
			
			case "delete carrinho":
				?>
				<div class="modal-linha-deletar-carrinho" id="modal-linha-deletar-carrinho">
					<div class="modal-carrinho-delete" id="modal-carrinho-delete">
						<div class="modal-head modal-head-delete-carrinho">
							<h2>DELETAR CARRINHO</h2>
						</div> <!-- class modal-head -->
						<div class="modal-body modal-carrinho-delete-body" id="modal-carrinho-delete-body">
							Conteúdo da modal
						</div> <!-- class modal-carrinho-delete-body -->
						<div class="modal-bottom modal-bottom-delete-carrinho">
							<input type="hidden" name="delete-carrinho" id="delete-carrinho-id">
							<button class="modal-carrinho-btn-deletar" id="btn-deletar">SIM</button>
							<button class="modal-carrinho-btn-cancelar" id="btn-delete-carrinho-cancelar" onclick="modalDeletarCarrinhoClose()">NÃO</button>
						</div>
					</div> <!-- class modal-carrinho-delete -->
				</div> <!-- class modal-linha-deletar-carrinho -->
			
				<?php
			break;
			

			
		}
		
	}
	
	function criarPaginacao(){
		?>
		<div class="paginate" id="paginate">
		</div>
		<?php
	}
	
	function mensagem(){
		?>
		<div class="msg" id="msg">			
			<div class="msg-head">
				<a href="" class="msg-fechar" id="msg-fechar"><p>x</p></a>
			</div>
			<div class="msg-body" id="msg-body">
				<h2>Conteúdo da mensagem</h2>
			</div>
		</div> <!-- class msg -->
		<?php	
	}
	
	function navbar(){
		?>
			<nav class="nav-superior">
				<ul>
					<li>
						<a href="../../carrinhos/index/index.php?page=1">CARRINHOS</a>
					</li>
					<li>
						<a href="../../produtos/index/index.php?page=1">PRODUTOS</a>
					</li>
					<li>
						<a href="../../homes/admin/index.php">HOME</a>
					</li>
				</ul>
			</nav>
			<?php
	}
		
?>
