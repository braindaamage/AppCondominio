<?php
	//include ("/home/leonardo/Source/DesarrolloWeb/AppCondominio/app/bd/conexion.class.php");
	//include ("/home/leonardo/Source/DesarrolloWeb/AppCondominio/app/bd/bean/TiposGastosBean.class.php");
	$now_at_dir = getcwd();
	chdir(realpath(dirname(__FILE__))."/../");
	include ("conexion.class.php");
	include ("bean/TiposGastosBean.class.php");
	chdir($now_at_dir);
	
	define ("SELECT_ALL","SELECT * FROM TiposGastos");
	define ("COUNT","SELECT COUNT(*) FROM TiposGastos");
	define ("SELECT_BY_ID","SELECT * FROM TiposGastos WHERE id = &1");
	define ("INSERT","INSERT INTO TiposGastos (nombre, descripcion, activo) VALUES ('&1','&2','&3')");
	define ("UPDATE","UPDATE TiposGastos SET nombre = '&1', descripcion = '&2', activo = &3 WHERE id = &4");
	define ("DELETE","DELETE FROM TiposGastos WHERE id = &1");
	
	class TiposGastosDao {
		private $conexion;
		private static $instance;
		private $error;
		
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
				$this->error = $this->conexion->mensajeError();
				return false;
			}
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$tipoGasto = new TiposGastosBean();
				$tipoGasto->setId($registro['id']);
				$tipoGasto->setNombre($registro['nombre']);
				$tipoGasto->setDescripcion($registro['descripcion']);
				$tipoGasto->setEstado($registro['activo']);
				
				$lista->append($tipoGasto);
			}
			
			return $lista;
		}
		
		public function getCount() {
			$sql = COUNT;
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				$this->error = $this->conexion->mensajeError();
				return false;
			}
			
			$resultado = $this->conexion->siguiente($consulta);
			return $resultado[0];
		}
		
		public function getById($id) {
			$sql = SELECT_BY_ID;
			$sql = str_replace("&1", $id, $sql);
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				$this->error = $this->conexion->mensajeError();
				return false;
			}
			$tipoGasto = new TiposGastosBean();
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$tipoGasto->setId($registro['id']);
				$tipoGasto->setNombre($registro['nombre']);
				$tipoGasto->setDescripcion($registro['descripcion']);
				$tipoGasto->setEstado($registro['activo']);
			}
			
			return $tipoGasto;
		}
		
		public function insert($TipoGasto) {
			$sql = INSERT;
			$sql = str_replace("&1", $TipoGasto->getNombre(), $sql);
			$sql = str_replace("&2", $TipoGasto->getDescripcion(), $sql);
			$sql = str_replace("&3", $TipoGasto->getEstado(), $sql);
			
			if(!$this->conexion->consulta($sql)) {
				$this->error = $this->conexion->mensajeError();
				return false;
			}
			
			return true;
		}
		
		public function update($TipoGasto) {
			$sql = UPDATE;
			$sql = str_replace("&1", $TipoGasto->getNombre(), $sql);
			$sql = str_replace("&2", $TipoGasto->getDescripcion(), $sql);
			$sql = str_replace("&3", $TipoGasto->getEstado(), $sql);
			$sql = str_replace("&4", $TipoGasto->getId(), $sql);
			
			if(!$this->conexion->consulta($sql)) {
				$this->error = $this->conexion->mensajeError();
				return false;
			}
			
			return true;
		}
		
	public function delete($id) {
			$sql = DELETE;
			$sql = str_replace("&1", $id, $sql);
			
			if(!$this->conexion->consulta($sql)) {
				$this->error = $this->conexion->mensajeError();
				return false;
			}
			
			return true;
		}
	}
?>