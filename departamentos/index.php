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
			        url: "/app/controller/departamentos.php",
			        data: {
				        opcion: "listado"
			        },
			        success: function(data) {
				        if (data) {
							var departamentos = JSON.parse(data);
							$.mostrarListado(departamentos);
				        }
			        }
			    })
			}

			$(function() {
				$.mostrarListado = function(departamentos) {
					$("#cantidad").html("<br>Cantidad de departamentos: "+departamentos["cantidad"]);
					$("#tablaListado").remove();
					$(document.createElement("tbody")).attr("id","tablaListado").appendTo("#departamentos");
					
					for (i=0; i<departamentos["cantidad"]; i++) {
						numero = document.createElement('td');
						numero.innerHTML = departamentos[i]["numero"];
						piso = document.createElement('td');
						piso.innerHTML = departamentos[i]["piso"];
						metrosCuadrados = document.createElement('td');
						metrosCuadrados.innerHTML = departamentos[i]["metrosCuadrados"];
						porcentaje = document.createElement('td');
						porcentaje.innerHTML = departamentos[i]["porcentaje"];
						responsable = document.createElement('td');
						responsable.innerHTML = departamentos[i]["responsable"];
						
						fila = $(document.createElement('tr')).attr("id", "fila-"+departamentos[i]["numero"]).appendTo("#tablaListado");
						fila.append(numero);
						fila.append(piso);
						fila.append(metrosCuadrados);
						fila.append(porcentaje);
						fila.append(responsable);

						$.agregarAcciones(fila, "numero", departamentos[i]["numero"], "editardepartamentos.php", "/app/controller/departamentos.php");
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
						<a href="/usuarios" class="ui-menu-item">Usuarios</a>
					</dd>
				</dl>
				<dl>
					<dt style="padding-top: 50%;">Departamentos</dt>
					<dd>
						<a href="nuevodepartamento.php" class="ui-menu-item">Nuevo</a>
					</dd>
				</dl>
			</td>
			<td class="ui-widget titulo">
				<h3>Administración de Departamentos</h3>
				<p>Lista de Departamentos</p>
				<div class="contenido">
					<form class="ui-widget-content buscador ajax" action="/app/controller/departamentos.php" method="post" id="buscarPorNumero">
						Numero: 
						<input type="text" name="opcion" value="buscar" style="display:none"/>
						<input type="text" name="numero" class="required"/>
						<input type="submit" value="Buscar" />
						<input type="button" id="mostrarTodo" value="Mostrar Todo" onclick="traerTodo();">
					</form>
					<div id="cantidad"></div>
					<table id="departamentos" class="ui-widget ui-widget-content">
						<thead>
							<tr class="ui-widget-header">
								<th>Número</th>
								<th>Piso</th>
								<th>Metros Cuadrados</th>
								<th>Porcentaje</th>
								<th>Responsable</th>
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
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Está seguro que desea eliminar este Departamento?</p>
		</div>
	</body>
</html>
