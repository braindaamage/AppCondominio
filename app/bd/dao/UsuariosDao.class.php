<?php
	//include ("/home/leonardo/Source/DesarrolloWeb/AppCondominio/app/bd/conexion.class.php");
	//include ("/home/leonardo/Source/DesarrolloWeb/AppCondominio/app/bd/bean/UsuariosBean.class.php");
	$now_at_dir = getcwd();
	chdir(realpath(dirname(__FILE__))."/../");
	include ("conexion.class.php");
	include ("bean/UsuariosBean.class.php");
	chdir($now_at_dir);
	
	define ("SELECT_ALL","SELECT * FROM Usuarios");
	define ("COUNT","SELECT COUNT(*) FROM Usuarios");
	define ("SELECT_BY_RUT","SELECT * FROM Usuarios WHERE rut = &1");
	define ("INSERT","INSERT INTO Usuarios (rut, nombres, apellidoPaterno, apellidoMaterno, telefono, email, password, activo) VALUES ('&1','&2','&3','&4',&5,'&6','&7',&8)");
	define ("UPDATE","UPDATE Usuarios SET nombres = '&1', apellidoPaterno = '&2', apellidoMaterno = '&3', telefono = &4, email = '&5', password = '&6', activo = &7 WHERE rut = '&8' ");
	define ("DELETE","DELETE FROM Usuarios WHERE rut = &1");
	
	class UsuariosDao {
		private $conexion;
		private static $instance;
		private $error = Array();
		
		public function __construct() {
			$this->conexion = Conexion::getInstance();
		}
		
		public static function getInstance() {
			if (!isset(self::$instance)) {
				$c = __CLASS__;
				self::$instance = new $c;
			}
			return self::$instance;
		}
		
		public function __clone() {
			trigger_error('Clone no se permite.', E_USER_ERROR);
		}
		
		public function getError() {
			return $this->error;
		}
		
		public function getAll() {
			$lista = new ArrayObject();
			
			if (!$consulta = $this->conexion->consulta(SELECT_ALL)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return 0;
			}
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$usuario = new UsuariosBean();
				$usuario->setRut($registro['rut']);
				$usuario->setNombres($registro['nombres']);
				$usuario->setApellidoPaterno($registro['apellidoPaterno']);
				$usuario->setApellidoMaterno($registro['apellidoMaterno']);
				$usuario->setTelefono($registro['telefono']);
				$usuario->setEmail($registro['email']);
				$usuario->setPassword($registro['password']);
				$usuario->setEstado($registro['activo']);
				
				$lista->append($usuario);
			}
			
			return $lista;
		}
		
		public function getCount() {
			$sql = COUNT;
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return 0;
			}
			
			$resultado = $this->conexion->siguiente($consulta);
			return $resultado[0];
		}
		
		public function getByRut($rut) {
			$sql = SELECT_BY_RUT;
			$sql = str_replace("&1", $rut, $sql);
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return 0;
			}
			$usuario = new UsuariosBean();
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$usuario->setRut($registro['rut']);
				$usuario->setNombres($registro['nombres']);
				$usuario->setApellidoPaterno($registro['apellidoPaterno']);
				$usuario->setApellidoMaterno($registro['apellidoMaterno']);
				$usuario->setTelefono($registro['telefono']);
				$usuario->setEmail($registro['email']);
				$usuario->setPassword($registro['password']);
				$usuario->setEstado($registro['activo']);
			}
			
			return $usuario;
		}
		
		public function insert($usuario) {
			$sql = INSERT;
			$sql = str_replace("&1", $usuario->getRut(), $sql);
			$sql = str_replace("&2", $usuario->getNombres(), $sql);
			$sql = str_replace("&3", $usuario->getApellidoPaterno(), $sql);
			$sql = str_replace("&4", $usuario->getApellidoMaterno(), $sql);
			$sql = str_replace("&5", $usuario->getTelefono(), $sql);
			$sql = str_replace("&6", $usuario->getEmail(), $sql);
			$sql = str_replace("&7", $usuario->getPassword(), $sql);
			$sql = str_replace("&8", $usuario->getEstado(), $sql);
			
			$resultado = $this->conexion->consulta($sql);
			
			if($resultado != 1) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
			}
			
			return $resultado;
		}
		
		public function update($usuario) {
			$sql = UPDATE;
			
			$sql = str_replace("&1", $usuario->getNombres(), $sql);
			$sql = str_replace("&2", $usuario->getApellidoPaterno(), $sql);
			$sql = str_replace("&3", $usuario->getApellidoMaterno(), $sql);
			$sql = str_replace("&4", $usuario->getTelefono(), $sql);
			$sql = str_replace("&5", $usuario->getEmail(), $sql);
			$sql = str_replace("&6", $usuario->getPassword(), $sql);
			$sql = str_replace("&7", $usuario->getEstado(), $sql);
			$sql = str_replace("&8", $usuario->getRut(), $sql);
			
			$resultado = $this->conexion->consulta($sql);
			
			if($resultado != 1) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
			}
			
			return $resultado;
		}
		
		public function delete($rut) {
			$sql = DELETE;
			$sql = str_replace("&1", $rut, $sql);
			
			$resultado = $this->conexion->consulta($sql);
			
			if($resultado != 1) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
			}
			
			return $resultado;
		}
	}
?>