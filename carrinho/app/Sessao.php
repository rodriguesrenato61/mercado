<?php

	class Sessao{
		
		public function __construct(){
			
			session_start();
			
			if(!isset($_SESSION['user_id'])){
				$_SESSION['user_id'] = false;
			}
			
			if(!isset($_SESSION['mercado_id'])){
				$_SESSION['mercado_id'] = false;
			}
			
		}
		
		public function setUser_id($user_id){
			$_SESSION['user_id'] = $user_id;
		}
		
		public function getUser_id(){
			return $_SESSION['user_id'];
		} 
		
		public function setMercado_id($mercado_id){
			$_SESSION['mercado_id'] = $mercado_id;
		}
		
		public function getMercado_id(){
			return $_SESSION['mercado_id'];
		} 
		
		public function anular(){
			$this->setUser_id(false);
			$this->setMercado_id(false);
		}
		
		
		
	}

?>
