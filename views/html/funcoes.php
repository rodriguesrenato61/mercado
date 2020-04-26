<?php

	function criarModal($tipo){
		?>
		<div class="modal-fundo" id="modal-fundo">
		</div> <!-- class modal-fundo -->
		<div class="modal-meio" id="modal-meio">
		<?php
		switch($tipo){
			case "delete usuário":
				?>
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
						<button class="modal-user-btn-cancelar" id="btn-cancelar" onclick="fecharModal()">NÃO</button>
					</div>
				</div> <!-- class modal-user-delete -->
			
				<?php
			break;
			
		}
		?>
		</div> <!-- class modal-meio -->
		<?php
	}
	
	function criarPaginacao(){
		?>
		<div class="paginate" id="paginate">
		</div>
		<?php
	}
		
?>
