<?php
	$now_at_dir = getcwd();
	chdir(realpath(dirname(__FILE__))."/../");
	include ("bd/dao/UsuariosDao.class.php");
	chdir($now_at_dir);

	$rut = $_POST['usuario'];
	$clave = $_POST['password'];
	
	$usuariosDao = UsuariosDao::getInstance();
	$usuario = $usuariosDao->getByRut($rut);
	
	$respuesta = Array(0);
	
	if($usuario->getRut() != null) {
		if($usuario->getPassword() == $clave) {
			$respuesta[0] = 1;
			$respuesta[1] = "OK";
			if ($rut == 101) {
				$respuesta[3] = "/gastos/";
			}
		} else {
			$respuesta[1] = "Password Invalida";
		}
	} else {
		$respuesta[1] = "Usuario no existe";
	}
	
	echo json_encode($respuesta);
?>