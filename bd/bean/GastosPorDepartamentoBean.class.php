<?php
	class GastosPorDepartamentoBean {
		private $id;
		private $numeroDepartamento;
		private $periodo;
		private $numeroBoleta;
		private $monto;
		private $pagado;
		private $fechaVencimiento;
		
		public function getId() {
			return $this->id;
		}
		public function setId($id) {
			$this->id = $id;
		}
		
		public function getNumeroDepartamento() {
			return $this->numeroDepartamento;
		}
		public function setNumeroDepartamento($numeroDepartamento) {
			$this->numeroDepartamento = $numeroDepartamento;
		}
		
		public function getPeriodo() {
			return $this->periodo;
		}
		public function setPeriodo($periodo) {
			$this->periodo = $periodo;
		}
		
		public function getNumeroBoleta() {
			return $this->numeroBoleta;
		}
		public function setNumeroBoleta($numeroBoleta) {
			$this->numeroBoleta = $numeroBoleta;
		}
		
		public function getMonto() {
			return $this->monto;
		}
		public function setMonto($monto) {
			$this->monto = $monto;
		}
		
		public function getEstado() {
			return $this->pagado;
		}
		public function setEstado($pagado) {
			$this->pagado = $pagado;
		}
		
		public function getFechaVencimiento() {
			return $this->fechaVencimiento;
		}
		public function setFechaVencimiento($fechaVencimiento) {
			$this->fechaVencimiento = $fechaVencimiento;
		}
	}
?>