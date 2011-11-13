<?php
	class DepartamentosBean {
		private $numero;
		private $piso;
		private $metrosCuadrados;
		private $porcentaje;
		private $idUsuario;
		
		public function __construct() {
			$this->numero = null;
			$this->piso = null;
			$this->metrosCuadrados = null;
			$this->porcentaje = null;
			$this->usuario = null;
		}
		
		public function getNumero() {
			return $this->numero;
		}
		public function setNumero($numero) {
			$this->numero = $numero;
		}
		
		public function getPiso() {
			return $this->piso;
		}
		public function setPiso($piso) {
			$this->piso = $piso;
		}
		
		public function getMetrosCuadrados() {
			return $this->metrosCuadrados;
		}
		public function setMetrosCuadrados($metrosCuadrados) {
			$this->metrosCuadrados = $metrosCuadrados;
		}
		
		public function getPorcentaje() {
			return $this->porcentaje;
		}
		public function setPorcentaje($porcentaje) {
			$this->porcentaje = $porcentaje;
		}
		
		public function getUsuario() {
			return $this->usuario;
		}
		public function setUsuario($usuario) {
			$this->usuario = $usuario;
		}
	}
?>