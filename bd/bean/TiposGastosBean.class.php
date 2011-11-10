<?php
	class TiposGastosBean {
		private $id;
		private $nombre;
		private $descripcion;
		private $activo;
		
		public function __construct() {
			$this->id = null;
			$this->nombre = null;
			$this->descripcion = null;
			$this->activo = null;
		}
		
		public function getId() {
			return $this->id;
		}
		public function setId($id) {
			$this->id = $id;
		}
		
		public function getNombre() {
			return $this->nombre;
		}
		public function setNombre($nombre) {
			$this->nombre = $nombre;
		}
		
		public function getDescripcion() {
			return $this->descripcion;
		}
		public function setDescripcion($descripcion) {
			$this->descripcion = $descripcion;
		}
		
		public function getEstado() {
			return $this->activo;
		}
		public function setEstado($activo) {
			$this->activo = $activo;
		}
	}
?>