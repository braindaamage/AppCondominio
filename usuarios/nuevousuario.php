<!DOCTYPE html>
<?php
	/*session_start();
	if(!isset($_SESSION['login'])) {
  		header('Location: /'); 
  		exit();
	}*/
?>	

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Condominio Amin</title>
		<link type="text/css" href="/css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
		<link type="text/css" href="/css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="/js/jquery-1.7.js"></script>
		<script type="text/javascript" src="/js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="/js/jquery.validate.js"></script>
		<script type="text/javascript" src="/js/jquery.blockUI.js"></script>
		<script type="text/javascript" src="/js/jQuery-plugin-spin.js"></script>
		<script type="text/javascript" src="/js/funciones.js"></script>	
		<script type="text/javascript">
		
		</script>
	</head>
	<body>
		<table class="layout-grid" cellspacing="0" cellpadding="0">
		<tr>
			<td class="left-nav ui-menu menu">
				<dl>
					<dt>Navegacion</dt>
					<dd>
						<a href="/" class="ui-menu-item">Inicio</a>
						<a href="javascript:window.history.back();" class="ui-menu-item">Volver</a>
					</dd>
				</dl>
			</td>
			<td class="ui-widget titulo">
				<h3>Administración de usuarios</h3>
				<p>Creación nuevo Usuario</p>
				<div class="contenido">
					<form class="ui-widget-content texto" action="/app/controller/usuarios.php" method="post" id="nuevoUsuario">
						<input type="text" name="opcion" value="nuevo" style="display:none"/>
						<table>
							<tr>
								<td>Rut:</td>
								<td><input type="text" name="rut" /></td>
							</tr>
							<tr>
								<td>Nombres:</td>
								<td><input type="text" name="nombres" /></td>
							</tr>
							<tr>
								<td>Apellido Paterno:</td>
								<td><input type="text" name="apellidoPaterno" /></td>
							</tr>
							<tr>
								<td>Apellido Materno:</td>
								<td><input type="text" name="apellidoMaterno" /></td>
							</tr>
							<tr>
								<td>Telefono:</td>
								<td><input type="text" name="telefono" /></td>
							</tr>
							<tr>
								<td>Email:</td>
								<td><input type="text" name="email" /></td>
							</tr>
							<tr>
								<td>Password:</td>
								<td><input type="password" name="password" id="password"/></td>
							</tr>
							<tr>
								<td>Repetir Password:</td>
								<td><input type="password" name="password2" /></td>
							</tr>
							<tr>
								<td>Estado:</td>
								<td>
									<div id="format">
										<input type="radio" id="activo" name="estado" value="1" checked="checked" /><label for="activo">Activo</label>
										<input type="radio" id="bloqueado" name="estado" value="0" /><label for="bloqueado">Bloqueado</label>
									</div>
								</td>
							</tr>
						</table>
						<br>
						<input type="submit" value="Guardar" />
					</form>
				</div>
			</td>
		</tr>
		</table>
		<div id="dialog-message" title="Mensajes"></div>
	</body>
</html>
