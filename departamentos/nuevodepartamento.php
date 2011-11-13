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
				<h3>Administración de Departamentos</h3>
				<p>Creación nuevo Departamento</p>
				<div class="contenido">
					<form class="ui-widget-content texto" action="/app/controller/departamentos.php" method="post" id="nuevoDepartamento">
						<input type="text" name="opcion" value="nuevo" style="display:none"/>
						<table>
							<tr>
								<td>Numero:</td>
								<td><input type="text" name="numero" class="required" /></td>
							</tr>
							<tr>
								<td>Piso:</td>
								<td><input type="text" name="piso" class="required"/></td>
							</tr>
							<tr>
								<td>Metros Cuadrados:</td>
								<td><input type="text" name="metrosCuadrados" class="required"/></td>
							</tr>
							<tr>
								<td>Porcentaje:</td>
								<td><input type="text" name="porcentaje" class="required"/></td>
							</tr>
							<tr>
								<td>Rut Respondable:</td>
								<td><input type="text" name="rutResponsable" class="required"/></td>
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
