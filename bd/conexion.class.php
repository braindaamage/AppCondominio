<?php
	define ("SERVIDOR","localhost");  
	define ("USUARIO","root");  
	define ("PASS","123456");  
	define ("BASE","condominiobd");  
	
	class Conexion {  
		private $conn;
		private static $instance;
		
		public function __construct()  
		{  
			$this->conn=mysql_connect(SERVIDOR,USUARIO,PASS) 
									or die("Imposible conectar con ". SERVIDOR);  
			mysql_select_db(BASE,$this->conn) or die(BASE." no existe...");  
		}
		
		public static function getInstance()
		{
			if (!isset(self::$instance)) {
				$c = __CLASS__;
				self::$instance = new $c;
			}
			return self::$instance;
		}
		
		public function __clone()
		{
			trigger_error('Clone no se permite.', E_USER_ERROR);
		}
		
		public function __destruct()  
		{  
			mysql_close($this->conn);  
		}  
		
		public function consulta($sql)  
		{  
			return mysql_query($sql,$this->conn);  
		}  
		
		public function elemento($id)  
		{  
			$line=mysql_fetch_array($id);  
			return $line;  
		}  
		
		public function mensajeError()  
		{  
			return mysql_error($this->conn);  
		}  
		
		public function numeroError(){  
			return mysql_errno($this->conn);  
		}  
	}
?>