<?php
	class DepartamentosBean {
		private $numero;
		private $piso;
		private $metrosCuadrados;
		private $porcentaje;
		private $idUsuario;
		
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
		
		public function getIdUsuario() {
			return $this->idUsuario;
		}
		public function setIdUsuario($idUsuario) {
			$this->idUsuario = $idUsuario;
		}
	}
?>