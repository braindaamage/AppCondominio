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
	define ("SELECT_BY_ID","SELECT * FROM Usuarios WHERE id = &1");
	define ("INSERT","INSERT INTO Usuarios (rut, nombres, apellidoPaterno, apellidoMaterno, telefono, email, password, activo) VALUES ('&1','&2','&3','&4',&5,'&6','&7',&8)");
	define ("UPDATE","UPDATE Usuarios SET rut = '&1', nombres = '&2', apellidoPaterno = '&3', apellidoMaterno = '&4', telefono = &5, email = '&6', password = '&7', activo = &8 WHERE id = &9");
	define ("DELETE","DELETE FROM Usuarios WHERE id = &1");
	
	class UsuariosDao {
		private $conexion;
		private static $instance;
		
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
		
		public function getAll() {
			$lista = new ArrayObject();
			
			if (!$consulta = $this->conexion->consulta(SELECT_ALL)) {
				return $this->conexion->mensajeError();
			}
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$usuario = new UsuariosBean();
				$usuario->setId($registro['id']);
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
				return $this->conexion->mensajeError();
			}
			
			$resultado = $this->conexion->siguiente($consulta);
			return $resultado[0];
		}
		
		public function getById($id) {
			$sql = SELECT_BY_ID;
			$sql = str_replace("&1", $id, $sql);
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				return $this->conexion->mensajeError();
			}
			$usuario = new UsuariosBean();
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$usuario->setId($registro['id']);
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
			
			if(!$this->conexion->consulta($sql)) {
				return $this->conexion->mensajeError();
			}
			
			return null;
		}
		
		public function update($usuario) {
			$sql = UPDATE;
			$sql = str_replace("&1", $usuario->getRut(), $sql);
			$sql = str_replace("&2", $usuario->getNombres(), $sql);
			$sql = str_replace("&3", $usuario->getApellidoPaterno(), $sql);
			$sql = str_replace("&4", $usuario->getApellidoMaterno(), $sql);
			$sql = str_replace("&5", $usuario->getTelefono(), $sql);
			$sql = str_replace("&6", $usuario->getEmail(), $sql);
			$sql = str_replace("&7", $usuario->getPassword(), $sql);
			$sql = str_replace("&8", $usuario->getEstado(), $sql);
			$sql = str_replace("&9", $usuario->getId(), $sql);
			
			if(!$this->conexion->consulta($sql)) {
				return $this->conexion->mensajeError();
			}
			
			return null;
		}
		
	public function delete($id) {
			$sql = DELETE;
			$sql = str_replace("&1", $id, $sql);
			
			if(!$this->conexion->consulta($sql)) {
				return $this->conexion->mensajeError();
			}
			
			return null;
		}
	}
?>