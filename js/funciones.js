/**
 * 
 */

$(function() {
	$("#dialog-message").hide();
	$().ajaxStart(function() {
		$.blockUI( {message:null} );
		$('body').fadeTo(2000, "fast",0.5).spin(opts);
	}).ajaxStop(function() {
		$('body').spin(false).fadeTo("fast",1);
	 	$.unblockUI();
	});
	$("input:submit, input:button, a, button").button();
	$("#format").buttonset();
	var validaFormularios = $("form.texto").validate({
		messages: {
			required: "Requerido"
		}
	});
	$('form.texto').submit(function() {
		if (validaFormularios.valid()) {
		    $.ajax({
		        type: 'POST',
		        url: $(this).attr('action'),
		        data: $(this).serialize(),
		        success: function(data) {
		            $.mensajes(data);
		        }
		    })
		}
	    return false;
	});
	
	var validaFormulariosAjax = $("form.ajax").validate({
		messages: {
			required: "Requerido"
		}
	});
	$('form.ajax').submit(function() {
		if (validaFormulariosAjax.valid()) {
		    $.ajax({
		        type: 'POST',
		        url: $(this).attr('action'),
		        data: $(this).serialize(),
		        success: function(data) {
		            var datos = JSON.parse(data);
					$.mostrarListado(datos);
		        }
		    })
		}
	    return false;
	});
	
	$.mensajes = function (data) {
		icon = document.createElement('span');
		icon.class = "ui-icon ui-icon-circle-check";
		icon.css = "float:left; margin:0 7px 50px 0;";
		
		texto = document.createElement('p');
		texto.innerHTML = data;
		
		contenedor = document.getElementById('dialog-message');
		
		contenedor.appendChild(icon);
		contenedor.appendChild(texto);
		
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
    	
		$( "#dialog-message" ).dialog({
			modal: true,
			resizable: false,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
					a = document.getElementById('dialog-message');
					while(a.hasChildNodes())
						a.removeChild(a.firstChild);	
				}
			}
		});
		
	}
	
	$.agregarAcciones = function(fila, campo, valor, urlEdit, urlElim) {
		acciones = $(document.createElement("div")).appendTo(fila);
		
		formEdit = $(document.createElement("form"))
						.attr({ action: urlEdit, method: "post", id: "editar-"+valor })
						.appendTo(acciones);
		$(document.createElement("input"))
			.attr({ type: "text", name: campo, value: valor, style: "display:none" })
			.appendTo(formEdit);
		$(document.createElement("input"))
			.attr({ type: "submit", value: "Editar" })
			.appendTo(formEdit);
		
		formElim = $(document.createElement("form"))
				.attr({ action: urlElim, method: "post", id: "eliminar-"+valor, class: "texto" })
				.appendTo(acciones)
		$(document.createElement("input"))
			.attr({ type: "text", name: "opcion", value: "eliminar", style: "display:none" })
			.appendTo(formElim);
		$(document.createElement("input"))
			.attr({ type: "text", name: campo, value: valor, style: "display:none" })
			.appendTo(formElim);
		$(document.createElement("input"))
			.attr({ type: "button", value: "Eliminar" })
			.appendTo(formElim)
			.click(function () {
				$( "#dialog:ui-dialog" ).dialog( "destroy" );
				
				$( "#dialog-confirm" ).dialog({
					resizable: false,
					height: "auto",
					modal: true,
					buttons: {
						"Eliminar": function() {
							$.ajax({
						        type: 'POST',
						        url: $('#eliminar-'+valor).attr('action'),
						        data: $('#eliminar-'+valor).serialize(),
						        success: function(data) {
						        	respuesta = JSON.parse(data);
						        	$.mensajes(respuesta[1]);
						        	
						        	if (respuesta[0] == "1") {
						        		$("#fila-"+valor).remove();
						        	}
						        }
						    })
						    
							$( this ).dialog( "close" );
						},
						"Cancelar": function() {
							$( this ).dialog( "close" );
						}
					}
				});
			});
	}
})
