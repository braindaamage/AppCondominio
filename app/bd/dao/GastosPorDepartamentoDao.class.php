<?php
	//include ("/home/leonardo/Source/DesarrolloWeb/AppCondominio/app/bd/conexion.class.php");
	//include ("/home/leonardo/Source/DesarrolloWeb/AppCondominio/app/bd/bean/GastosPorDepartamentoBean.class.php");
	$now_at_dir = getcwd();
	chdir(realpath(dirname(__FILE__))."/../");
	include ("conexion.class.php");
	include ("bean/GastosPorDepartamentoBean.class.php");
	chdir($now_at_dir);
	
	define ("SELECT_ALL","SELECT * FROM GastosPorDepartamento");
	define ("COUNT","SELECT COUNT(*) FROM GastosPorDepartamento");
	define ("COUNT_BY_NUMERO","SELECT COUNT(*) FROM GastosPorDepartamento WHERE numeroDepartamento = &1");
	define ("SELECT_BY_ID","SELECT * FROM GastosPorDepartamento WHERE id = &1");
	define ("SELECT_BY_NUMERO","SELECT * FROM GastosPorDepartamento WHERE numeroDepartamento = &1");
	define ("INSERT","INSERT INTO GastosPorDepartamento (numeroDepartamento, periodo, numeroBoleta, monto, pagado, fechaVencimiento) VALUES (&1,&2,&3,&4,&5,&6)");
	define ("UPDATE","UPDATE GastosPorDepartamento SET numeroDepartamento = &1, periodo = &2, numeroBoleta = &3, monto = &4, pagado = &5, fechaVencimiento = &6 WHERE id = &7");
	define ("DELETE","DELETE FROM GastosPorDepartamento WHERE id = &1");
	
	class GastosPorDepartamentoDAO {
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
				$gastosPorDepartamento = new GastosPorDepartamentoBean();
				$gastosPorDepartamento->setId($registro['id']);
				$gastosPorDepartamento->setNumeroDepartamento($registro['numeroDepartamento']);
				$gastosPorDepartamento->setPeriodo($registro['periodo']);
				$gastosPorDepartamento->setNumeroBoleta($registro['numeroBoleta']);
				$gastosPorDepartamento->setMonto($registro['monto']);
				$gastosPorDepartamento->setEstado($registro['pagado']);
				$gastosPorDepartamento->setFechaVencimiento(str_replace("-", "", $registro['fechaVencimiento']));
				
				$lista->append($gastosPorDepartamento);
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
		
		public function getCountByDepartamento($numero) {
			$sql = COUNT_BY_NUMERO;
			$sql = str_replace("&1", $numero, $sql);
			
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
			$gastosPorDepartamento = new GastosPorDepartamentoBean();
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$gastosPorDepartamento = new GastosPorDepartamentoBean();
				$gastosPorDepartamento->setId($registro['id']);
				$gastosPorDepartamento->setNumeroDepartamento($registro['numeroDepartamento']);
				$gastosPorDepartamento->setPeriodo($registro['periodo']);
				$gastosPorDepartamento->setNumeroBoleta($registro['numeroBoleta']);
				$gastosPorDepartamento->setMonto($registro['monto']);
				$gastosPorDepartamento->setEstado($registro['pagado']);
				$gastosPorDepartamento->setFechaVencimiento(str_replace("-", "", $registro['fechaVencimiento']));
			}
			
			return $gastosPorDepartamento;
		}
		
		public function getByNumero($numero) {
			$sql = SELECT_BY_NUMERO;
			$sql = str_replace("&1", $numero, $sql);
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				return $this->conexion->mensajeError();
			}
			
			$lista = new ArrayObject();
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$gastosPorDepartamento = new GastosPorDepartamentoBean();
				$gastosPorDepartamento->setId($registro['id']);
				$gastosPorDepartamento->setNumeroDepartamento($registro['numeroDepartamento']);
				$gastosPorDepartamento->setPeriodo($registro['periodo']);
				$gastosPorDepartamento->setNumeroBoleta($registro['numeroBoleta']);
				$gastosPorDepartamento->setMonto($registro['monto']);
				$gastosPorDepartamento->setEstado($registro['pagado']);
				$gastosPorDepartamento->setFechaVencimiento(str_replace("-", "", $registro['fechaVencimiento']));
				
				$lista->append($gastosPorDepartamento);
			}
			
			return $lista;
				
		}
		
		public function insert($gastosPorDepartamento) {
			$sql = INSERT;
			$sql = str_replace("&1", $gastosPorDepartamento->getNumeroDepartamento(), $sql);
			$sql = str_replace("&2", $gastosPorDepartamento->getPeriodo(), $sql);
			$sql = str_replace("&3", $gastosPorDepartamento->getNumeroBoleta(), $sql);
			$sql = str_replace("&4", $gastosPorDepartamento->getMonto(), $sql);
			$sql = str_replace("&5", $gastosPorDepartamento->getEstado(), $sql);
			$sql = str_replace("&6", $gastosPorDepartamento->getFechaVencimiento(), $sql);
			
			if(!$this->conexion->consulta($sql)) {
				return $this->conexion->mensajeError();
			}
			
			return null;
		}
		
		public function update($gastosPorDepartamento) {
			$sql = UPDATE;
			$sql = str_replace("&1", $gastosPorDepartamento->getNumeroDepartamento(), $sql);
			$sql = str_replace("&2", $gastosPorDepartamento->getPeriodo(), $sql);
			$sql = str_replace("&3", $gastosPorDepartamento->getNumeroBoleta(), $sql);
			$sql = str_replace("&4", $gastosPorDepartamento->getMonto(), $sql);
			$sql = str_replace("&5", $gastosPorDepartamento->getEstado(), $sql);
			$sql = str_replace("&6", $gastosPorDepartamento->getFechaVencimiento(), $sql);
			$sql = str_replace("&7", $gastosPorDepartamento->getId(), $sql);
			
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