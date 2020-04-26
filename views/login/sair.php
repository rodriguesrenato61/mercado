<?php

	require_once("../../app/Sessao.php");
	
	$sessao = new Sessao();
	
	$sessao->anular();
	
	header("Location: index.php");

?>
