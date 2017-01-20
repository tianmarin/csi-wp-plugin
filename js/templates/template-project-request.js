/*
Script Name: Template Project Request
Dependencies: jquery, bootstrap, jquery-ui-datepicker, jquery-confirm
*/
/*global csiTemplateProjectRequest*/
jQuery(document).ready(function($){
var ajaxUrl		=csiTemplateProjectRequest.ajaxUrl;

$('a[href*=#]').on('click', function(event){     
    $('html,body').animate({scrollTop:$(this.hash).offset().top}, 500);
    event.preventDefault();
});

$('input[type=date]').datepicker({
	dateFormat:"yy-mm-dd",
	showButtonPanel: true,
	closeText : "Cerrar",
	currentText: "Now",
});

$('#project_request_form form').submit(function(event){
	var form = $(this);
	event.preventDefault();
	var valid_form=true;
	$(this).find(':input[type!="hidden"]').not(':input[type=button], :input[type=submit], :input[type=reset]').each(function() {
		if ( $(this).data('required') === true ) {
			if ( $(this).val() === '' ||  $(this).val() === 0 ) {
				$(this).parent().parent().addClass('has-error');
				valid_form=false;
			}
		}
		if ( $(this).data('validation') === 'true' ) {
			if ( $.isNumeric( $(this).data('validation-min') ) ) {
				if ( $(this).data('validation-min') >= $(this).val() ) {
					$(this).parent().parent().addClass('has-warning');
					valid_form=false;
				}
			}
			if ( $.isNumeric( $(this).data('validation-max') ) ) {
				if ( $(this).data('validation-max') <= $(this).val() ) {
					$(this).parent().parent().addClass('has-warning');
					valid_form=false;
				}
			}
			if ( $.isNumeric( $(this).data('validation-maxchar') ) ) {
				if ( $(this).data('validation-maxchar') <= $(this).length() ) {
					$(this).parent().parent().addClass('has-warning');
					valid_form=false;
				}
			}
		}
	});
	if ( true === valid_form ) {
//		$(this).find(':input').prop("disabled",true);
//		$(this).find(':input[type=submit]').prop("disabled",true);
		var submit_btn = $(this).find(':input[type=submit]');
		submit_btn.button('loading');
//		setTimeout(function() {
//			submit_btn.button('reset');			
//		}, 8000);
		form.addClass('loading');
		var data = new FormData();
		//Por cada input o select append
		data.append('action', 'csi_new_project_request');
		$(this).find("input, select").each(function(){
			data.append($(this).attr('name'),$(this).val());
		});
		window.console.log(data);
		$.ajax({
			url: ajaxUrl,
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
			},
			success: function(response){
				submit_btn.button('reset');
				window.console.log(JSON.stringify(response));
				form.removeClass('loading');
				if('0' === JSON.stringify(response)){
					csiAjaxError();
					return false;
				}
				if(true === response.error){
					$.alert({
						buttons:{
							error: {
								text: 'OK',
								btnClass: 'btn-danger',
							},
						},
						closeIcon: true,
						columnClass: 'large',
						content:response.message,
						title: 'Error',
						type:'red',
					});
					
				}else{
					$.alert({
						buttons:{
							ok: {
								text: 'OK',
								btnClass: 'btn-success',
								action: function(){
									form.fadeOut();
									csiCurrentProjectRequest();
									//actualizar la lista de Solicitudes
									$('html,body').animate({scrollTop:$('#user-project-request-status').offset().top}, 500);
								},
							},
						},
						closeIcon: true,
						columnClass: 'large',
						content:response.message,
						title: 'OK',
						type:'green',
					});
				}
			},
		error: csiAjaxError,
		});
	}else{
		$.alert('no es valida la wea');
	}
});

var csiCurrentProjectRequest = function(){
	var data = new FormData();
	data.append('action', 'csi_user_project_request_status');
	$.ajax({
		url: ajaxUrl,
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		beforeSend: function () {
		},
		success: function(response){
			window.console.log(JSON.stringify(response));
			if('0' === JSON.stringify(response)){
				csiAjaxError();
				return false;
			}
			if(true === response.error){
			}else{
				$('#user-project-request-status table tbody').html(response.message);
			}
		},
	error: csiAjaxError,
	});
};
csiCurrentProjectRequest();
var csiAjaxError = function(jqXHR, textStatus, errorThrown){
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

});