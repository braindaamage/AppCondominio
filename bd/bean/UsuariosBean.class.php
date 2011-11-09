<?php
	class UsuariosBean {
		private $id;
		private $rut;
		private $nombres;
		private $apellidoPaterno;
		private $apellidoMaterno;
		private $telefono;
		private $email;
		private $password;
		private $activo;
		
		public function getId() {
			return $this->id;
		}
		public function setId($id) {
			$this->id = $id;
		}
		
		public function getNombres() {
			return $this->nombres;
		}
		public function setNombres($nombres) {
			$this->nombres = $nombres;
		}
		
		public function getApellidoPaterno() {
			return $this->apellidoPaterno;
		}
		public function setApellidoPaterno($apellidoPaterno) {
			$this->apellidoPaterno = $apellidoPaterno;
		}
		
		public function getApellidoMaterno() {
			return $this->apellidoMaterno;
		}
		public function setApellidoMaterno($apellidoMaterno) {
			$this->apellidoMaterno = $apellidoMaterno;
		}
		
		public function getTelefono() {
			return $this->telefono;
		}
		public function setTelefono($telefono) {
			$this->telefono = $telefono;
		}
		
		public function getEmail() {
			return $this->email;
		}
		public function setEmail($email) {
			$this->email = $email;
		}
		
		public function getPassword() {
			return $this->password;
		}
		public function setPassword($password) {
			$this->password = $password;
		}
		
		public function getEstado() {
			return $this->activo;
		}
		public function setEstado($activo) {
			$this->activo = $activo;
		}
	}
?>