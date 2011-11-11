<?php
	//include ("/home/leonardo/Source/DesarrolloWeb/AppCondominio/app/bd/conexion.class.php");
	//include ("/home/leonardo/Source/DesarrolloWeb/AppCondominio/app/bd/bean/DepartamentosBean.class.php");
	$now_at_dir = getcwd();
	chdir(realpath(dirname(__FILE__))."/../");
	include ("conexion.class.php");
	include ("bean/DepartamentosBean.class.php");
	chdir($now_at_dir);
	
	define ("SELECT_ALL","SELECT * FROM Departamentos");
	define ("COUNT","SELECT COUNT(*) FROM Departamentos");
	define ("COUNT_BY_USUARIO","SELECT COUNT(*) FROM Departamentos WHERE idUsuario = &1");
	define ("SELECT_BY_NUMERO","SELECT * FROM Departamentos WHERE numero = &1");
	define ("SELECT_BY_USUARIO","SELECT * FROM Departamentos WHERE idUsuario = &1");
	define ("INSERT","INSERT INTO Departamentos (numero, piso, metrosCuadrados, porcentaje, idUsuario) VALUES ('&1','&2','&3','&4',&5)");
	define ("UPDATE","UPDATE Departamentos SET piso = &1, metrosCuadrados = &2, porcentaje = &3, idUsuario = &4 WHERE numero = &5");
	define ("DELETE","DELETE FROM Departamentos WHERE numero = &1");
	
	class DepartamentosDao {
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
				$departamento = new DepartamentosBean();
				$departamento->setNumero($registro['numero']);
				$departamento->setPiso($registro['piso']);
				$departamento->setMetrosCuadrados($registro['metrosCuadrados']);
				$departamento->setPorcentaje($registro['porcentaje']);
				$departamento->setIdUsuario($registro['idUsuario']);
								
				$lista->append($departamento);
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
		
		public function getCountByUsuario ($idUsuario) {
			$sql = COUNT_BY_USUARIO;
			$sql = str_replace("&1", $idUsuario, $sql);
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				$this->error = $this->conexion->mensajeError();
				return false;
			}
			
			$resultado = $this->conexion->siguiente($consulta);
			return $resultado[0];
		}
		
		public function getByNumero($numero) {
			$sql = SELECT_BY_NUMERO;
			$sql = str_replace("&1", $numero, $sql);
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				$this->error = $this->conexion->mensajeError();
				return false;
			}
			$departamento = new DepartamentosBean();
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$departamento->setNumero($registro['numero']);
				$departamento->setPiso($registro['piso']);
				$departamento->setMetrosCuadrados($registro['metrosCuadrados']);
				$departamento->setPorcentaje($registro['porcentaje']);
				$departamento->setIdUsuario($registro['idUsuario']);
			}
			
			return $departamento;
		}
		
		public function getByUsuario($idUsuario) {
			$lista = new ArrayObject();
			
			$sql = SELECT_BY_USUARIO;
			$sql = str_replace("&1", $idUsuario, $sql);
			
			if (!$consulta = $this->conexion->consulta($sql)) {
				$this->error = $this->conexion->mensajeError();
				return false;
			}
			
			$lista = new ArrayObject();
			
			while ($registro = $this->conexion->siguiente($consulta)) {
				$departamento = new DepartamentosBean();
				$departamento->setNumero($registro['numero']);
				$departamento->setPiso($registro['piso']);
				$departamento->setMetrosCuadrados($registro['metrosCuadrados']);
				$departamento->setPorcentaje($registro['porcentaje']);
				$departamento->setIdUsuario($registro['idUsuario']);
								
				$lista->append($departamento);
			}
			
			return $lista;
		}
		
		public function insert($departamento) {
			$sql = INSERT;
			$sql = str_replace("&1", $departamento->getNumero(), $sql);
			$sql = str_replace("&2", $departamento->getPiso(), $sql);
			$sql = str_replace("&3", $departamento->getMetrosCuadrados(), $sql);
			$sql = str_replace("&4", $departamento->getPorcentaje(), $sql);
			$sql = str_replace("&5", $departamento->getIdUsuario(), $sql);
			
			if(!$this->conexion->consulta($sql)) {
				$this->error = $this->conexion->mensajeError();
				return false;
			}
			
			return true;
		}
		
		public function update($departamento) {
			$sql = UPDATE;
			$sql = str_replace("&1", $departamento->getPiso(), $sql);
			$sql = str_replace("&2", $departamento->getMetrosCuadrados(), $sql);
			$sql = str_replace("&3", $departamento->getPorcentaje(), $sql);
			$sql = str_replace("&4", $departamento->getIdUsuario(), $sql);
			$sql = str_replace("&5", $departamento->getNumero(), $sql);
						
			if(!$this->conexion->consulta($sql)) {
				$this->error = $this->conexion->mensajeError();
				return false;
			}
			
			return true;
		}
		
	public function delete($numero) {
			$sql = DELETE;
			$sql = str_replace("&1", $numero, $sql);
			
			if(!$this->conexion->consulta($sql)) {
				$this->error = $this->conexion->mensajeError();
				return false;
			}
			
			return true;
		}
	}
?>