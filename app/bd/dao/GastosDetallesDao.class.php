<?php
	//include ("/home/leonardo/Source/DesarrolloWeb/AppCondominio/app/bd/conexion.class.php");
	//include ("/home/leonardo/Source/DesarrolloWeb/AppCondominio/app/bd/bean/GastosDetallesBean.class.php");
	$now_at_dir = getcwd();
	chdir(realpath(dirname(__FILE__))."/../");
	include ("conexion.class.php");
	include ("bean/GastosDetallesBean.class.php");
	chdir($now_at_dir);
	
	define ("SELECT_ALL","SELECT * FROM  GastosDetalle");
	define ("COUNT","SELECT COUNT(*) FROM GastosDetalle");
	define ("SELECT_BY_ID","SELECT * FROM GastosDetalle WHERE id = &1");
	define ("SELECT_BY_PERIODO","SELECT * FROM GastosDetalle WHERE periodo = &1");
	define ("INSERT","INSERT INTO GastosDetalle (idTipoGasto, periodo, monto) VALUES (&1,&2,&3)");
	define ("UPDATE","UPDATE GastosDetalle SET idTipoGasto = &1, periodo = &2, monto = &3 WHERE id = &4");
	define ("DELETE","DELETE FROM GastosDetalle WHERE id = &1");
	
	class GastosDetallesDao {
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
				return false;
			}
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$detalleGasto = new GastosDetallesBean();
				$detalleGasto->setId($registro['id']);
				$detalleGasto->setIdTipoGasto($registro['idTipoGasto']);
				$detalleGasto->setPeriodo($registro['periodo']);
				$detalleGasto->setMonto($registro['monto']);
				
				$lista->append($detalleGasto);
			}
			
			return $lista;
		}
		
		public function getCount() {
			$sql = COUNT;
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return false;
			}
			
			$resultado = $this->conexion->siguiente($consulta);
			return $resultado[0];
		}
		
		public function getById($id) {
			$sql = SELECT_BY_ID;
			$sql = str_replace("&1", $id, $sql);
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return false;
			}
			$detalleGasto = new GastosDetallesBean();
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$detalleGasto->setId($registro['id']);
				$detalleGasto->setIdTipoGasto($registro['idTipoGasto']);
				$detalleGasto->setPeriodo($registro['periodo']);
				$detalleGasto->setMonto($registro['monto']);
			}
			
			return $detalleGasto;
		}
		
		public function getByPeriodo($periodo) {
			$lista = new ArrayObject();
			
			$sql = SELECT_BY_PERIODO;
			$sql = str_replace("&1", $periodo, $sql);
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return false;
			}
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$detalleGasto = new GastosDetallesBean();
				$detalleGasto->setId($registro['id']);
				$detalleGasto->setIdTipoGasto($registro['idTipoGasto']);
				$detalleGasto->setPeriodo($registro['periodo']);
				$detalleGasto->setMonto($registro['monto']);
				
				$lista->append($detalleGasto);
			}
			
			return $lista;
		}
		
		public function insert($detalleGasto) {
			$sql = INSERT;
			$sql = str_replace("&1", $detalleGasto->getIdTipoGasto(), $sql);
			$sql = str_replace("&2", $detalleGasto->getPeriodo(), $sql);
			$sql = str_replace("&3", $detalleGasto->getMonto(), $sql);
			
			if(!$this->conexion->consulta($sql)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return false;
			}
			
			return true;
		}
		
		public function update($detalleGasto) {
			$sql = UPDATE;
			$sql = str_replace("&1", $detalleGasto->getIdTipoGasto(), $sql);
			$sql = str_replace("&2", $detalleGasto->getPeriodo(), $sql);
			$sql = str_replace("&3", $detalleGasto->getMonto(), $sql);
			$sql = str_replace("&4", $detalleGasto->getId(), $sql);
			
			if(!$this->conexion->consulta($sql)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return false;
			}
			
			return true;
		}
		
	public function delete($id) {
			$sql = DELETE;
			$sql = str_replace("&1", $id, $sql);
			
			if(!$this->conexion->consulta($sql)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return false;
			}
			
			return true;
		}
	}
?>