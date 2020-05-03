<?php

	require_once("database/Mensagem.php");

	class Sessao{
		
		private $msg;
		
		public function __construct(){
			
			session_start();
			
			$this->msg = new Mensagem;
			
		}
		
		public function setUser_id($user_id){
			$_SESSION['user_id'] = $user_id;
		}
		
		public function getUser_id(){
			
			if(isset($_SESSION['user_id'])){
				$retorno = $_SESSION['user_id'];
			}else{
				$retorno = false;
			}
			
			return $retorno;
		} 
		
		public function setMercado_id($mercado_id){
			$_SESSION['mercado_id'] = $mercado_id;
		}
		
		public function setMsg($sucess, $msg){
			$_SESSION['msg']['sucess'] = $sucess;
			$_SESSION['msg']['msg'] = $msg;
		}
		
		public function getMercado_id(){
			if(isset($_SESSION['mercado_id'])){
				$retorno = $_SESSION['mercado_id'];
			}else{
				$retorno = false;
			}
			
			return $retorno;
		} 
		
		public function getMsg(){
			
			if(isset($_SESSION['msg'])){
				$this->msg->set($_SESSION['msg']['sucess'], $_SESSION['msg']['msg']);
			}else{
				$this->msg->set(false, "Nenhuma mensagem encontrada!");
			}
			
			return $this->msg->get();
		} 
		
		public function anular(){
			unset($_SESSION['user_id']);
			unset($_SESSION['mercado_id']);
			unset($_SESSION['msg']);
		}
		
		
		
	}

?>
