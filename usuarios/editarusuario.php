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
		$(document).ready(function() {
			$.ajax({
		        type: 'POST',
		        url: "/app/controller/usuarios.php",
		        data: {
			        opcion: 'buscar',
				 	rut: <?php echo $_POST['rut']?>
		        },
		        success: function(data) {
			        if (data) {
						var usuario = JSON.parse(data);
						if (usuario["cantidad"] == 1) {
							$("#rut").attr('value', usuario[0]["rut"]);
							$("#nombres").attr('value', usuario[0]["nombres"]);
							$("#apellidoPaterno").attr('value', usuario[0]["apellidoPaterno"]);
							$("#apellidoMaterno").attr('value', usuario[0]["apellidoMaterno"]);
							$("#telefono").attr('value', usuario[0]["telefono"]);
							$("#email").attr('value', usuario[0]["email"]);
							if (usuario[0]['estado'] == "1") {
								$("#activo").attr('value', usuario[0]['estado']);
								$("#labActivo").attr('class', 'ui-button ui-widget ui-state-default ui-button-text-only ui-corner-left ui-state-active');
								$("#labBloqueado").attr("class", "ui-button ui-widget ui-state-default ui-button-text-only ui-corner-right");
								$("#labActivo").attr('aria-pressed', 'true');
								$("#labBloqueado").attr('aria-pressed', 'false');
							} else {
								$("#bloqueado").attr('value', usuario[0]['estado']);
								$("#labBloqueado").attr("class", "ui-button ui-widget ui-state-default ui-button-text-only ui-corner-right ui-state-active");
								$("#labActivo").attr("class", "ui-button ui-widget ui-state-default ui-button-text-only ui-corner-left");
								$("#labBloqueado").attr('aria-pressed', 'true');
								$("#labActivo").attr('aria-pressed', 'false');
							}
						}
			        }
		        }
		    })
		})
		
		</script>
	</head>
	<body>
		<table class="layout-grid">
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
				<p>Editar Usuario Usuario</p>
				<div class="contenido">
					<form class="ui-widget-content texto" action="/app/controller/usuarios.php" method="post" id="editarUsuario">
						<input type="text" name="opcion" value="editar" style="display:none"/>
						<table>
							<tr>
								<td>Rut:</td>
								<td><input type="text" name="rut" id="rut" readonly="readonly"/></td>
							</tr>
							<tr>
								<td>Nombres:</td>
								<td><input type="text" name="nombres" id="nombres"/></td>
							</tr>
							<tr>
								<td>Apellido Paterno:</td>
								<td><input type="text" name="apellidoPaterno" id="apellidoPaterno"/></td>
							</tr>
							<tr>
								<td>Apellido Materno:</td>
								<td><input type="text" name="apellidoMaterno" id="apellidoMaterno"/></td>
							</tr>
							<tr>
								<td>Telefono:</td>
								<td><input type="text" name="telefono" id="telefono"/></td>
							</tr>
							<tr>
								<td>Email:</td>
								<td><input type="text" name="email" id="email"/></td>
							</tr>
							<tr>
								<td>Estado:</td>
								<td>
									<div id="format">
										<input type="radio" id="activo" name="estado" value="1" /><label for="activo" id="labActivo">Activo</label>
										<input type="radio" id="bloqueado" name="estado" value="0" /><label for="bloqueado" id="labBloqueado">Bloqueado</label>
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
