/*
Script Name: Template Project Request
Dependencies: jquery, bootstrap
*/
/*global csiTemplateEwaUpload*/
jQuery(document).ready(function($){
var ajaxUrl		=csiTemplateEwaUpload.ajaxUrl;

$('#csi-ewa-upload-print').click(function(){
     window.print();
});

$('#csi-ewa-upload-form').submit(function(event){
	var submit_btn = $(this).find(':input[type=submit]');
	submit_btn.html(submit_btn.data('loading-text'));
	submit_btn.addClass('disabled');

	event.preventDefault();
	var form = this;
	var file = $(this).find('input[type=file]')[0].files[0];


	if(undefined === typeof file || 'undefined' === typeof file){
		$(this).find('input[type=file]').parent().parent().addClass('has-error');
		submit_btn.html(submit_btn.data('normal-text'));
		submit_btn.removeClass('disabled');
		window.console.log('No hay archivo. Undefined');
		return this;
	}
	$(this).find('input[type=file]').parent().parent().removeClass('has-error');
	if (file.name.trim() === ''){
		submit_btn.html(submit_btn.data('normal-text'));
		submit_btn.removeClass('disabled');
		$.alert("No has seleccionado un archivo.");
		window.console.log("No file selected");
		return this;
	}
	window.console.log('Archivo a evaluar: '+file.name+' '+file.type+' '+file.size);
	var allowedMimeType = ['text/csv','text/plain'];
	if( -1 >= $.inArray(file.type, allowedMimeType)){
		submit_btn.html(submit_btn.data('normal-text'));
		submit_btn.removeClass('disabled');
		window.console.log(file.type);
		$.alert("Recuerda que debes cargar archivos guardados como CSV","Error");
		return this;
	}
	

	var data = new FormData();
	data.append('action', 'csi_ajax_upload_ewa_file');
	data.append('file',file);
	$.ajax({
		url: ajaxUrl,
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		beforeSend: function () {
			//statusMsg.html(uploading+" "+inputDay+'/'+inputMonth+'/'+inputYear+' Comienza la carga del archivo <small>'+file.name+'</small>').fadeIn(500);
		},
		xhr: function () {
			var xhr = new window.XMLHttpRequest();
			//Upload progress
			xhr.upload.addEventListener("progress", function(evt){
				if (evt.lengthComputable) {
					var percentComplete = Math.round(evt.loaded / evt.total * 100);
					window.console.log('Porcentaje: '+percentComplete);
				}
			}, false);
			//success upload
			xhr.upload.addEventListener("load", function(evt){
				if (evt.lengthComputable) {
				//	statusMsg.html(processing+" "+inputDay+'/'+inputMonth+'/'+inputYear+' Procesando la informaci&oacute;n cargada');
				}
			}, false);
			//Download progress
			//If this is removed, the process is dead
			xhr.addEventListener("progress", function(evt){
				if (evt.lengthComputable) {
					window.console.log("Respuesta descargada: "+Math.round(evt.loaded / evt.total * 100)+'%');
				}else{
					window.console.log("Respuesta descargada: "+Math.round(evt.loaded / evt.total * 100)+'%');					
				}
			}, false);
			return xhr;
		},
		success: function(response){
			window.console.log(JSON.stringify(response));
			var status_block=$('#csi-ewa-upload-status');
			status_block.append(response.message);
			$(form).fadeOut('400',function(){
				status_block.fadeIn();
			});
		},
		error: csiAjaxError,
	});		
});
var csiAjaxError;
if( (typeof csiAjaxError) === undefined){
	csiAjaxError = function(jqXHR, textStatus, errorThrown){
		var msg = '';
		window.console.log(typeof(jqXHR));
		if ("undefined" !== typeof(jqXHR)) {
			if (jqXHR.status === 0) {
				msg = 'Not connect.\n Verify Network.';
			} else if (jqXHR.status === 404) {
				msg = 'Requested page not found. [404]';
			} else if (jqXHR.status === 500) {
				msg = 'Internal Server Error [500].';
			} else if (textStatus === 'parsererror') {
				msg = 'Requested JSON parse failed.';
			} else if (textStatus === 'timeout') {
				msg = 'Time out error.';
			} else if (textStatus === 'abort') {
				msg = 'Ajax request aborted.';
			} else {
				msg = 'Uncaught Error.\n' + jqXHR.responseText;
			}
		}
		window.console.log("ERROR: ");
		window.console.log(jqXHR);
		window.console.log(textStatus+" - "+errorThrown);
		var text="Este error de conexión con el servidor de fondo, regularmente indica que no has iniciado sesión en Wordpress.<br/>";
		window.console.log(ajaxUrl);
		var url = ajaxUrl.replace("admin-ajax.php", "");
		text=text+"Intenta <strong><a href='"+url+"'>iniciar sesi&oacute;n</a></strong>. En caso que esto no funcione, por favor contacta al adminsitrador.";
		text=text+"<code>"+msg+"</code>";
		var title = "Error de conexión as&iacute;ncrona";
		$.alert({
			buttons:{
				heyThere: {
					text: 'OK',
					btnClass: 'btn-danger',
				},
			},
			closeIcon: true,
			columnClass: 'large',
			content:text,
			title: title,
			type:'red',
		});
	};
}


});