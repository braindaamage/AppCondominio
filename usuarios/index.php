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
			$(document).ready(traerTodo())
			
			function traerTodo() {
				$.ajax({
			        type: 'POST',
			        url: "/app/controller/usuarios.php",
			        data: {
				        opcion: "listado"
			        },
			        success: function(data) {
				        if (data) {
							var usuarios = JSON.parse(data);
							$.mostrarListado(usuarios);
				        }
			        }
			    })
			}

			$(function() {
				$.mostrarListado = function (usuarios) {
					$("#cantidad").html("<br>Cantidad de usuarios: "+usuarios["cantidad"]);
					$("#tablaListado").remove();
					$(document.createElement("tbody")).attr("id","tablaListado").appendTo("#usuarios");
					
					for (i=0; i<usuarios["cantidad"]; i++) {
						rut = document.createElement('td');
						rut.innerHTML = usuarios[i]["rut"];
						nombres = document.createElement('td');
						nombres.innerHTML = usuarios[i]["nombres"];
						appPat = document.createElement('td');
						appPat.innerHTML = usuarios[i]["apellidoPaterno"];
						appMat = document.createElement('td');
						appMat.innerHTML = usuarios[i]["apellidoMaterno"];
						telefono = document.createElement('td');
						telefono.innerHTML = usuarios[i]["telefono"];
						email = document.createElement('td');
						email.innerHTML = usuarios[i]["email"];
						estado = document.createElement('td');
						if (usuarios[i]["estado"] == "0") {
							estado.innerHTML = "bloqueado";
						} else {
							estado.innerHTML = "activo";
						}
						
						fila = $(document.createElement('tr')).attr("id", "fila-"+usuarios[i]["rut"]).appendTo("#tablaListado");
						fila.append(rut);
						fila.append(nombres);
						fila.append(appPat);
						fila.append(appMat);
						fila.append(telefono);
						fila.append(email);
						fila.append(estado);

						$.agregarAcciones(fila, "rut", usuarios[i]["rut"], "editarusuario.php", "/app/controller/usuarios.php");
					}
				}
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
						<a href="/gastos" class="ui-menu-item">Gastos</a>
						<a href="/departamentos" class="ui-menu-item">Departamentos</a>
					</dd>
				</dl>
				<dl>
					<dt style="padding-top: 50%;">Usuarios</dt>
					<dd>
						<a href="nuevousuario.php" class="ui-menu-item">Nuevo</a>
					</dd>
				</dl>
			</td>
			<td class="ui-widget titulo">
				<h3>Administración de usuarios</h3>
				<p>Lista de Usuarios del sistema</p>
				<div class="contenido">
					<form class="ui-widget-content buscador ajax" action="/app/controller/usuarios.php" method="post" id="buscarPorRut">
						Rut: 
						<input type="text" name="opcion" value="buscar" style="display:none"/>
						<input type="text" name="rut" />
						<input type="submit" value="Buscar" />
						<input type="button" id="mostrarTodo" value="Mostrar Todo" onclick="traerTodo();">
					</form>
					<div id="cantidad"></div>
					<table id="usuarios" class="ui-widget ui-widget-content">
						<thead>
							<tr class="ui-widget-header">
								<th>Rut</th>
								<th>Nombres</th>
								<th>Apellido Paterno</th>
								<th>Apellido Materno</th>
								<th>Teléfono</th>
								<th>Email</th>
								<th>Estado</th>
								<th>Acciones</th>
							</tr>
						</thead>

					</table>
				</div>
			</td>
		</tr>
		</table>
		<div id="dialog-message" title="Mensajes"></div>
		<div id="dialog-confirm" title="Confirmación" style="display: none;">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Está seguro que desea eliminar al usuario?</p>
		</div>
	</body>
</html>
