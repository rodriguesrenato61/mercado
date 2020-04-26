<?php

	class Mensagem{
		
		private $tipo, $msg;
		
		public function set($tipo, $msg){
			$this->tipo = $tipo;
			$this->msg = $msg;
		}
		
		public function get(){
			$retorno[] = array(
				"tipo" => $this->tipo,
				"msg" => $this->msg
			);
			
			return $retorno;
		}
		
	}

?>
