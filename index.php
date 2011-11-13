<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Condominio Amin</title>
		<link type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
		<link type="text/css" href="css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery-1.7.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.js"></script>
		<script type="text/javascript" src="js/jquery.blockUI.js"></script>
		<script type="text/javascript" src="js/jQuery-plugin-spin.js"></script>
		<script type="text/javascript" src="js/funciones.js"></script>	
		<script type="text/javascript">
		$(function() {
			$.mostrarListado = function(datos) {
				if (datos[0] == 1) {
					 window.location = datos[3];
				} else {
					$.mensajes(datos[1]);
				}
			}
		})
		</script>
	</head>
	<body>
	<div class="ui-widget">
		<h3>Acceso a usuarios</h3>
		<p>Bienvenido al sistema de Administración del Condominio.<br>
		Ingrese su Rut y Password</p>
		<form action="app/controller/login.php" method="post" id="login" class="ajax">
			<input type="text" name="usuario" class="required"/>
			<input type="password" name="password" class="required"/>
			<input type="submit" value="Login" />
		</form>
	</div>
		<div id="dialog-message" title="Mensajes"></div>
	</body>
</html>


