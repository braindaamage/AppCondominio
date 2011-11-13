<?php
	//include ("/home/leonardo/Source/DesarrolloWeb/AppCondominio/app/bd/conexion.class.php");
	//include ("/home/leonardo/Source/DesarrolloWeb/AppCondominio/app/bd/bean/GastosDetallesBean.class.php");
	$now_at_dir = getcwd();
	chdir(realpath(dirname(__FILE__))."/../");
	include ("conexion.class.php");
	include ("bean/GastosDetallesBean.class.php");
	chdir($now_at_dir);
	
	define ("SELECT_ALL","SELECT * FROM  GastosDetalle");
	define ("SELECT_DEPARTAMENTOS","SELECT * FROM  Departamentos");
	define ("COUNT","SELECT COUNT(*) FROM GastosDetalle");
	define ("PERIODOS","SELECT periodo FROM GastosDetalle GROUP BY periodo");
	define ("SELECT_BY_ID","SELECT * FROM GastosDetalle WHERE id = &1");
	define ("SELECT_BY_PERIODO","SELECT * FROM GastosDetalle WHERE periodo = &1");
	define ("SELECT_A_RENDIR", "SELECT b.id id, a.id idgasto, a.nombre nombre, b.periodo periodo, b.monto monto FROM TiposGastos a LEFT JOIN GastosDetalle b ON a.id = b.idTipoGasto WHERE a.activo = 1 ORDER BY a.nombre");
	define ("INSERT","INSERT INTO GastosDetalle (idTipoGasto, periodo, monto) VALUES (&1,&2,&3)");
	define ("INSERT_GASTOS_DEPARTAMENTO","INSERT INTO GastosPorDepartamento (numeroDepartamento, periodo, monto, fechaVencimiento) VALUES (&1,&2,&3,&4)");
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
		
		public function generarGastos($periodo, $total) {
			
			$eliminar = str_replace("&1", $periodo, "delete from GastosPorDepartamento where periodo = &1");
			$consulta = $this->conexion->consulta($eliminar);
			
  			$fechaVencimiento = str_replace("&1", ($periodo+1), "&115");
			
			if (!$consulta = $this->conexion->consulta(SELECT_DEPARTAMENTOS)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return $this->error;
			}
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$sql = INSERT_GASTOS_DEPARTAMENTO;
				$sql = str_replace("&1", $registro['numero'], $sql);
				$sql = str_replace("&2", $periodo, $sql);
				$monto = ($registro['porcentaje']*$total)/100;
				$sql = str_replace("&3", $monto, $sql);
				$sql = str_replace("&4", $fechaVencimiento, $sql);
				
				$ejecutar = $this->conexion->consulta($sql);
				
				if($ejecutar != 1) {
					$this->error[0] = $this->conexion->numeroError();
					$this->error[1] = $this->conexion->mensajeError();
					return $this->error;
				}
			}
			
			return 1;
		}
		
		public function getPeriodos() {
			$fecha=getdate();
  			$anio=$fecha["year"];
  			$mes=$fecha["mon"]; 
  			
			$lista = Array();
			$lista[] = $anio.$mes;
			
			$sql = PERIODOS;
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return $this->error;
			}
			
			while ($resultado = $this->conexion->siguiente($consulta)) {
				if ($lista[0] != $resultado[0]) {
					$lista[] = $resultado[0];
				}
			}
			
			return $lista;
		}
		
		public function getAll() {
			$lista = new ArrayObject();
			
			if (!$consulta = $this->conexion->consulta(SELECT_ALL)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return $this->error;
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
		
		public function getARendir($periodo) {
			$lista = new ArrayObject();
			
			if (!$consulta = $this->conexion->consulta(SELECT_A_RENDIR)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return $this->error;
			}
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$detalleGasto = new GastosDetallesBean();
				$detalleGasto->setIdTipoGasto($registro['idgasto']);
				$detalleGasto->setNombre($registro['nombre']);
				$detalleGasto->setPeriodo($periodo);
				if ($registro['periodo'] == $periodo) {
					$detalleGasto->setId($registro['id']);
					$detalleGasto->setMonto($registro['monto']);
				}
				
				$lista->append($detalleGasto);
			}
			
			return $lista;
		}
		
		public function getCount() {
			$sql = COUNT;
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return $this->error;
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
				return $this->error;
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
				return $this->error;
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
			
			$ejecutar = $this->conexion->consulta($sql);
			
			if($ejecutar != 1) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return $this->error;
			}
			
			return $ejecutar;
		}
		
		public function update($detalleGasto) {
			$sql = UPDATE;
			$sql = str_replace("&1", $detalleGasto->getIdTipoGasto(), $sql);
			$sql = str_replace("&2", $detalleGasto->getPeriodo(), $sql);
			$sql = str_replace("&3", $detalleGasto->getMonto(), $sql);
			$sql = str_replace("&4", $detalleGasto->getId(), $sql);
			
			$ejecutar = $this->conexion->consulta($sql);
			
			if($ejecutar != 1) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return $this->error;
			}
			
			return $ejecutar;
		}
		
	public function delete($id) {
			$sql = DELETE;
			$sql = str_replace("&1", $id, $sql);
			
			$ejecutar = $this->conexion->consulta($sql);
			
			if($ejecutar != 1) {
				$this->error[0] = $this->conexion->numeroError();
				$this->error[1] = $this->conexion->mensajeError();
				return false;
			}
			
			return $ejecutar;
		}
	}
?>