<?php
	class GastosDetallesBean {
		private $id;
		private $idTipoGasto;
		private $periodo;
		private $monto;
		
		public function __construct() {
			$this->id = null;
			$this->idTipoGasto = null;
			$this->periodo = null;
			$this->monto = null;
		}
		
		public function getId() {
			return $this->id;
		}
		public function setId($id) {
			$this->id = $id;
		}
		
		public function getIdTipoGasto() {
			return $this->idTipoGasto;
		}
		public function setIdTipoGasto($idTipoGasto) {
			$this->idTipoGasto = $idTipoGasto;
		}
		
		public function getPeriodo() {
			return $this->periodo;
		}
		public function setPeriodo($periodo) {
			$this->periodo = $periodo;
		}
		
		public function getMonto() {
			return $this->monto;
		}
		public function setMonto($monto) {
			$this->monto = $monto;
		}
	}
?>