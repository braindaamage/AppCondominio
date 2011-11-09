<?php
	class TiposGastosBean {
		private $id;
		private $nombre;
		private $descripcion;
		private $activo;
		
		public static function getId() {
			return $this->id;
		}
		public static function setId($id) {
			$this->id = $id;
		}
		
		public static function getNombre() {
			return $this->nombre;
		}
		public static function setNombre($nombre) {
			$this->nombre = $nombre;
		}
		
		public static function getDescripcion() {
			return $this->descripcion;
		}
		public static function setDescripcion($descripcion) {
			$this->descripcion = $descripcion;
		}
		
		public static function getEstado() {
			return $this->activo;
		}
		public static function setEstado($activo) {
			$this->activo = $activo;
		}
	}
?>