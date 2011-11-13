<?php
	$now_at_dir = getcwd();
	chdir(realpath(dirname(__FILE__))."/../");
	include ("bd/dao/DepartamentosDao.class.php");
	chdir($now_at_dir);
	
	if (isset($_POST['opcion'])) {
	if ($_POST['opcion'] == "listado") {
			listado();
		}
		if ($_POST['opcion'] == "buscar") {
			listadoPorNumero($_POST['numero']);
		}
		if ($_POST['opcion'] == "nuevo") {
			nuevoDepartamento();
		}
		if ($_POST['opcion'] == "editar") {
			editarDepartamento();
		}
		if ($_POST['opcion'] == "eliminar") {
			eliminarDepartamento();
		}
	}
	
	function eliminarDepartamento() {
		$respuesta = Array();
		
		$departamentosDAO = DepartamentosDao::getInstance();
		
		$ejecucion = $departamentosDAO->delete($_POST['numero']);
		$respuesta[0] = $ejecucion;
		
		if ($ejecucion == 1) {
			$respuesta[1] =  "Usuario Eliminado OK";
		} else {
			$error = $departamentosDAO->getError();
			if ($error[0] == 1451) {
				$respuesta[1] = "Departamento no se puede eliminar, ya que tiene 1 o mas gastos comunes asociados.";
			} else {
				$respuesta[1] = "Error: ".$error[0]." - ".$error[1];
			}
		}
		
		echo json_encode($respuesta);
	}
	
	function editarDepartamento() {
		$departamentosDAO = DepartamentosDao::getInstance();
		$editar = $departamentosDAO->getByNumero($_POST['numero']);
		
		$editar->setPiso($_POST['piso']);
		$editar->setMetrosCuadrados($_POST['metrosCuadrados']);
		$editar->setPorcentaje($_POST['porcentaje']);
		$editar->setUsuario($_POST['usuario']);
		
		$ejecucion = $departamentosDAO->update($editar);
		
		if ($ejecucion == 1) {
			echo "Departamento Editaro OK";
		} else {
			$error = $departamentosDAO->getError();
			
			if ($error[0] == 1452) {
				echo "El Rut de Usuario responsable no existe en el sistema. Ingrese al responsable al sistema y vuelva a intentarlo";
			} else {
				echo "Error: ".$error[0]." - ".$error[1];
			}
		}
	}
	
	function nuevoDepartamento() {
		$departamentosDAO = DepartamentosDao::getInstance();
		$nuevo = new DepartamentosBean();
		
		$nuevo->setNumero($_POST['numero']);
		$nuevo->setPiso($_POST['piso']);
		$nuevo->setMetrosCuadrados($_POST['metrosCuadrados']);
		$nuevo->setPorcentaje($_POST['porcentaje']);
		$nuevo->setUsuario($_POST['rutResponsable']);
		
		$ejecucion = $departamentosDAO->insert($nuevo);
		if ($ejecucion == 1) {
			echo "Nuevo Departamento creado OK";
		} else {
			$error = $departamentosDAO->getError();
			if($error[0] == 1062) {
				echo "El número de Departamento ingresado ya existe";
			} else if ($error[0] == 1452) {
				echo "El Rut de Usuario responsable no existe en el sistema. Ingrese al responsable al sistema y vuelva a intentarlo";
			} else {
				echo "Error: ".$error[0]." - ".$error[1];
			}
		}
	}
	
	function listadoPorNumero($numero) {
		$registro= Array();
		$listaEnviar = Array();
		
		$departamentosDAO = DepartamentosDao::getInstance();
		$nuevo = $departamentosDAO->getByNumero($numero);
		if ($nuevo->getNumero() != null) {
			
			$listaEnviar["cantidad"] = "1";
			
			$registro["numero"] = $nuevo->getNumero();
			$registro["piso"] = $nuevo->getPiso();
			$registro["metrosCuadrados"] = $nuevo->getMetrosCuadrados();
			$registro["porcentaje"] = $nuevo->getPorcentaje();
			$registro["responsable"] = $nuevo->getUsuario();
			
			$listaEnviar[] = $registro;
			
		} else {
			$listaEnviar["cantidad"] = "0";
		}
		
		echo json_encode($listaEnviar);
	}
	
	function listado() {
		$departamentosDAO = DepartamentosDao::getInstance();
		
		$lista = $departamentosDAO->getAll();
		
		$registro= Array();
		$listaEnviar = Array();
		
		$listaEnviar["cantidad"] = $lista->count(); 
		
		foreach($lista as $nuevo) {
			$registro["numero"] = $nuevo->getNumero();
			$registro["piso"] = $nuevo->getPiso();
			$registro["metrosCuadrados"] = $nuevo->getMetrosCuadrados();
			$registro["porcentaje"] = $nuevo->getPorcentaje();
			$registro["responsable"] = $nuevo->getUsuario();
			
			$listaEnviar[] = $registro;
		}
		
		echo json_encode($listaEnviar);
	}
?>