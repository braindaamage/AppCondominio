<?php
	$now_at_dir = getcwd();
	chdir(realpath(dirname(__FILE__))."/../");
	include ("bd/dao/TiposGastosDao.class.php");
	chdir($now_at_dir);
	
	if (isset($_POST['opcion'])) {
	if ($_POST['opcion'] == "listado") {
			listado();
		}
		if ($_POST['opcion'] == "buscar") {
			listadoPorId($_POST['id']);
		}
		if ($_POST['opcion'] == "buscarnombre") {
			listadoPorNombre($_POST['nombre']);
		}
		if ($_POST['opcion'] == "nuevo") {
			nuevoTipoGasto();
		}
		if ($_POST['opcion'] == "editar") {
			editarTipoGasto();
		}
		if ($_POST['opcion'] == "eliminar") {
			eliminarTipoGasto();
		}
	}
	
	function eliminarTipoGasto() {
		$respuesta = Array();
		
		$tiposGastosDao = TiposGastosDao::getInstance();
		
		$ejecucion = $tiposGastosDao->delete($_POST['id']);
		$respuesta[0] = $ejecucion;
		
		if ($ejecucion == 1) {
			$respuesta[1] =  "Tipo de Gasto Eliminado OK";
		} else {
			$error = $tiposGastosDao->getError();
			if ($error[0] == 1451) {
				$respuesta[1] = "Tipo de Gasto no se puede eliminar, ya que tiene 1 o mas gastos asociados.";
			} else {
				$respuesta[1] = "Error: ".$error[0]." - ".$error[1];
			}
		}
		
		echo json_encode($respuesta);
	}
	
	function editarTipoGasto() {
	   	$tiposGastosDao = TiposGastosDao::getInstance();
		$editar = new TiposGastosBean();
		
		$editar->setId($_POST['id']);
		$editar->setNombre($_POST['nombre']);
		$editar->setDescripcion($_POST['descripcion']);
		if ($_POST['estado'] == "1") {
			$editar->setEstado(1);
		} else {
			$editar->setEstado(0);
		}
		
		$ejecucion = $tiposGastosDao->update($editar);
		
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
	
	function nuevoTipoGasto() {
		$tiposGastosDao = TiposGastosDao::getInstance();
		$nuevo = new TiposGastosBean();
		
		$nuevo->setNombre($_POST['nombre']);
		$nuevo->setDescripcion($_POST['descripcion']);
		$nuevo->setEstado($_POST['estado']);
		
		$ejecucion = $tiposGastosDao->insert($nuevo);
		if ($ejecucion == 1) {
			echo "Nuevo Tipo de Gasto creado OK";
		} else {
			$error = $departamentosDAO->getError();
			
			echo "Error: ".$error[0]." - ".$error[1];
		}
	}
	
	function listadoPorNombre($nombre) {
		$tiposGastosDao = TiposGastosDao::getInstance();
		
		$lista = $tiposGastosDao->getByNombre($nombre);
		
		$registro= Array();
		$listaEnviar = Array();
		
		$listaEnviar["cantidad"] = $lista->count(); 
		
		foreach($lista as $nuevo) {
			$registro["id"] = $nuevo->getId();
			$registro["nombre"] = $nuevo->getNombre();
			$registro["descripcion"] = $nuevo->getDescripcion();
			$registro["estado"] = $nuevo->getEstado();
			
			$listaEnviar[] = $registro;
		}
		
		echo json_encode($listaEnviar);
	}
	
	function listadoPorId($id) {
		$registro= Array();
		$listaEnviar = Array();
		
		$tiposGastosDao = TiposGastosDao::getInstance();
		$nuevo = $tiposGastosDao->getById($id);
		if ($nuevo->getId() != null) {
			
			$listaEnviar["cantidad"] = "1";
			
			$registro["id"] = $nuevo->getId();
			$registro["nombre"] = $nuevo->getNombre();
			$registro["descripcion"] = $nuevo->getDescripcion();
			$registro["estado"] = $nuevo->getEstado();
			
			$listaEnviar[] = $registro;
			
		} else {
			$listaEnviar["cantidad"] = "0";
		}
		
		echo json_encode($listaEnviar);
	}
	
	function listado() {
		$tiposGastosDao = TiposGastosDao::getInstance();
		
		$lista = $tiposGastosDao->getAll();
		
		$registro= Array();
		$listaEnviar = Array();
		
		$listaEnviar["cantidad"] = $lista->count(); 
		
		foreach($lista as $nuevo) {
			$registro["id"] = $nuevo->getId();
			$registro["nombre"] = $nuevo->getNombre();
			$registro["descripcion"] = $nuevo->getDescripcion();
			$registro["estado"] = $nuevo->getEstado();
			
			$listaEnviar[] = $registro;
		}
		
		echo json_encode($listaEnviar);
	}
?>