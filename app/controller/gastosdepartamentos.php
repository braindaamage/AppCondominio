<?php
	$now_at_dir = getcwd();
	chdir(realpath(dirname(__FILE__))."/../");
	include ("bd/dao/GastosPorDepartamentoDao.class.php");
	chdir($now_at_dir);
	
	if (isset($_POST['opcion'])) {
		if ($_POST['opcion'] == "listadoperiodo") {
			listadoperiodo();
		}
	} else {
  		//header('Location: /'); 
	}
	
	function listadoperiodo() {
		$registro= Array();
		$listaEnviar = Array();
		
		$gastosDao = GastosPorDepartamentoDAO::getInstance();
		
		$lista = $gastosDao->getByPeriodo($_POST['periodo']);
		$registro= Array();
		$listaEnviar = Array();
		$listaEnviar["cantidad"] = $lista->count(); 
		
		foreach($lista as $nuevo) {
			$registro["id"] = $nuevo->getId();
			$registro["numeroDepartamento"] = $nuevo->getNumeroDepartamento();
			$registro["periodo"] = $nuevo->getPeriodo();
			$registro["numeroBoleta"] = $nuevo->getNumeroBoleta();
			$registro["monto"] = $nuevo->getMonto();
			$registro["estado"] = $nuevo->getEstado();
			$registro["fechaVencimiento"] = $nuevo->getFechaVencimiento();
			
			$listaEnviar[] = $registro;
		}
		
		echo json_encode($listaEnviar);
	}
?>