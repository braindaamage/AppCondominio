<?php
	$now_at_dir = getcwd();
	chdir(realpath(dirname(__FILE__))."/../");
	include ("bd/dao/UsuariosDao.class.php");
	chdir($now_at_dir);
	
	if (isset($_POST['opcion'])) {
		if ($_POST['opcion'] == "listado") {
			listado();
		}
		if ($_POST['opcion'] == "buscar") {
			if (isset($_POST['rut'])) {
				listadoPorRut($_POST['rut']);
			} else {
				echo "0";
			}
		}
		if ($_POST['opcion'] == "nuevo") {
			nuevoUsuario();
		}
		if ($_POST['opcion'] == "editar") {
			editarUsuario();
		}
		if ($_POST['opcion'] == "eliminar"){
			eliminarUsuario();
		}
	} else {
  		//header('Location: /'); 
	}
	
	function eliminarUsuario() {
		$respuesta = Array();
		
		$usuariosDao = UsuariosDao::getInstance();
		
		$ejecucion = $usuariosDao->delete($_POST['rut']);
		$respuesta[0] = $ejecucion;
		
		if ($ejecucion == 1) {
			$respuesta[1] =  "Usuario Eliminado OK";
		} else {
			$error = $usuariosDao->getError();
			if ($error[0] == 1451) {
				$respuesta[1] = "Usuario no se puede eliminar, ya que tiene 1 o mas departamentos asignados. Modifique responsable de departamento(s) y vuelva a intentarlo.";
			} else {
				$respuesta[1] = "Error: ".$error[0]." - ".$error[1];
			}
		}
		
		echo json_encode($respuesta);
	}
	
	function editarUsuario() {
		$usuariosDao = UsuariosDao::getInstance();
		$editar = $usuariosDao->getByRut($_POST['rut']);
		
		$editar->setNombres($_POST['nombres']);
		$editar->setApellidoPaterno($_POST['apellidoPaterno']);
		$editar->setApellidoMaterno($_POST['apellidoMaterno']);
		$editar->setTelefono($_POST['telefono']);
		$editar->setEmail($_POST['email']);
		if ($_POST['estado'] == "1") {
			$editar->setEstado(1);
		} else {
			$editar->setEstado(0);
		}
		
		$ejecucion = $usuariosDao->update($editar);
		if ($ejecucion == 1) {
			echo "Usuario Editaro OK";
		} else {
			$error = $usuariosDao->getError();
			
			echo "Error: ".$error[0]." - ".$error[1];
		}
	}
	
	function nuevoUsuario() {
		$usuariosDao = UsuariosDao::getInstance();
		$nuevo = new UsuariosBean();
		
		$nuevo->setRut($_POST['rut']);
		$nuevo->setNombres($_POST['nombres']);
		$nuevo->setApellidoPaterno($_POST['apellidoPaterno']);
		$nuevo->setApellidoMaterno($_POST['apellidoMaterno']);
		$nuevo->setTelefono($_POST['telefono']);
		$nuevo->setEmail($_POST['email']);
		$nuevo->setPassword($_POST['password']);
		$nuevo->setEstado($_POST['estado']);
		
		$ejecucion = $usuariosDao->insert($nuevo);
		if ($ejecucion == 1) {
			echo "Nuevo Usuario creado OK";
		} else {
			$error = $usuariosDao->getError();
			if($error[0] == 1062) {
				echo "El Rut ingresado ya existe";
			} else {
				echo "Error: ".$error[0]." - ".$error[1];
			}
		}
	}
	
	function listado() {
		$usuariosDao = UsuariosDao::getInstance();
		$lista = $usuariosDao->getAll();
		$registro= Array();
		$listaEnviar = Array();
		$listaEnviar["cantidad"] = $lista->count(); 
		foreach($lista as $nuevo) {
			$registro["rut"] = $nuevo->getRut();
			$registro["nombres"] = $nuevo->getNombres();
			$registro["apellidoPaterno"] = $nuevo->getApellidoPaterno();
			$registro["apellidoMaterno"] = $nuevo->getApellidoMaterno();
			$registro["telefono"] = $nuevo->getTelefono();
			$registro["email"] = $nuevo->getEmail();
			$registro["estado"] = $nuevo->getEstado();
			
			$listaEnviar[] = $registro;
		}
		
		echo json_encode($listaEnviar);
	}
	
	function listadoPorRut($rut) {
		$registro= Array();
		$listaEnviar = Array();
		
		$usuariosDao = UsuariosDao::getInstance();
		$nuevo = $usuariosDao->getByRut($rut);
		if ($nuevo->getRut() != null) {
			
			$listaEnviar["cantidad"] = "1";
			
			$registro["rut"] = $nuevo->getRut();
			$registro["nombres"] = $nuevo->getNombres();
			$registro["apellidoPaterno"] = $nuevo->getApellidoPaterno();
			$registro["apellidoMaterno"] = $nuevo->getApellidoMaterno();
			$registro["telefono"] = $nuevo->getTelefono();
			$registro["email"] = $nuevo->getEmail();
			$registro["estado"] = $nuevo->getEstado();
			
			$listaEnviar[] = $registro;
			
		} else {
			$listaEnviar["cantidad"] = "0";
		}
		
		echo json_encode($listaEnviar);
	}
?>