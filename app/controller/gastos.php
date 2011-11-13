<?php
	$now_at_dir = getcwd();
	chdir(realpath(dirname(__FILE__))."/../");
	include ("bd/dao/GastosDetallesDao.class.php");
	chdir($now_at_dir);
	
	if (isset($_POST['opcion'])) {
		if ($_POST['opcion'] == "listadoperiodos") {
			listadoperiodos();
		}
		if ($_POST['opcion'] == "listado") {
			listado();
		}
		if ($_POST['opcion'] == "rendir") {
			rendirGasto();
		}
		if ($_POST['opcion'] == "generar") {
			generarGastos();
		}
	}
	
	function generarGastos() {
		$gastosDao = GastosDetallesDao::getInstance();
		$ejecucion = $gastosDao->generarGastos($_POST['periodo'], $_POST['total']);
		
		if ($ejecucion == 1) {
			echo "Gastos Comunes generados correctamente";
		} else {
			echo "Error: ".$error[0]." - ".$error[1];
		}
	}
	
	function rendirGasto() {
		if ($_POST['id'] == "0") {
			nuevoGasto();
		} else {
			editarGasto();
		}
	}
	
	function editarGasto() {
	   	$gastosDao = GastosDetallesDao::getInstance();
		$editar = new GastosDetallesBean();
		
		$editar->setId($_POST['id']);
		$editar->setIdTipoGasto($_POST['idgasto']);
		$editar->setPeriodo($_POST['periodo']);
		$editar->setMonto($_POST['monto']);
		
		$ejecucion = $gastosDao->update($editar);
		
		if ($ejecucion == 1) {
			echo "Rendición Editada OK";
		} else {
			$error = $departamentosDAO->getError();
			
			echo "Error: ".$error[0]." - ".$error[1];
		}
	}
	
	function nuevoGasto() {
		$gastosDao = GastosDetallesDao::getInstance();
		$nuevo = new GastosDetallesBean();
		
		$nuevo->setIdTipoGasto($_POST['idgasto']);
		$nuevo->setPeriodo($_POST['periodo']);
		$nuevo->setMonto($_POST['monto']);
		
		$ejecucion = $gastosDao->insert($nuevo);
		if ($ejecucion == 1) {
			echo "Gasto Rendido OK";
		} else {
			$error = $departamentosDAO->getError();
			
			echo "Error: ".$error[0]." - ".$error[1];
		}
	}
	
	function listado() {
		$gastosDao = GastosDetallesDao::getInstance();
		
		$lista = $gastosDao->getARendir($_POST['periodo']);
		
		$registro= Array();
		$listaEnviar = Array();
		
		$listaEnviar["cantidad"] = $lista->count(); 
		
		foreach($lista as $nuevo) {
			$registro["id"] = $nuevo->getId();
			$registro["idgasto"] = $nuevo->getIdTipoGasto();
			$registro["nombre"] = $nuevo->getNombre();
			$registro["periodo"] = $nuevo->getPeriodo();
			$registro["monto"] = $nuevo->getMonto();
			
			$listaEnviar[] = $registro;
		}
		
		echo json_encode($listaEnviar);
	}
	
	function listadoperiodos() {
		$gastosDao = GastosDetallesDao::getInstance();
		
		$listado = $gastosDao->getPeriodos();
		
		echo json_encode($listado);
	}
?>