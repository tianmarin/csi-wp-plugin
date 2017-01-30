/*
Script Name: Shortcode EWA Control Center
Dependencies: jquery, bootstrap, amcharts, amcharts-serial, amcharts-responsive, amcharts-pie
*/
/*global csiTemplateEwaControlCenter*/
/*global JustGage*/

jQuery(document).ready(function($){
//Global Variables	
var ajaxUrl		=csiTemplateEwaControlCenter.ajaxurl;

$( "#csi-ewa-template-control-center-date-input" ).datepicker({
	onSelect: function(dateText) {
		$('#csi-ewa-template-control-center-date-input').val(dateText);
		csiEwaControlCenterFetchAlerts();
	},
	dateFormat: "yy-mm-dd",
	firstDay: 1,
	showWeek: true,
});
$( "#csi-ewa-template-control-center-date-input + label" ).click(function(){
	$( "#csi-ewa-template-control-center-date-input" ).datepicker('show');
});

$('#csi-ewa-template-control-center-action-checkbox').change(function() {
	csiEwaControlCenterFetchAlerts();
});
$('#csi-ewa-template-control-center-filter-customer').change(function() {
	csiEwaControlCenterFetchAlerts();
});

$('#csi-ewa-template-control-center-filter-sid').change(function() {
	csiEwaControlCenterFetchAlerts();
});

$('#csi-ewa-template-control-center-filter-alert-group').change(function() {
	csiEwaControlCenterFetchAlerts();
});

$('#csi-ewa-template-control-center-filter-alert-text').change(function() {
	csiEwaControlCenterFetchAlerts();
});

$(document).on({
	ajaxStart	: function() {
		$('#csi-ewa-template-control-center-ajax').addClass("csi-ajax-loading");
	},
	ajaxStop	: function() {
		$('#csi-ewa-template-control-center-ajax').removeClass("csi-ajax-loading");
	}
});


function csiEwaControlCenterFetchAlerts(){
	//get oanel variables
	//date
	//action flag
	var tbody = $('#csi-ewa-template-control-center-alerts tbody');
	var data = new FormData();
	data.append('action', 'csi_ajax_template_ewa_control_center_fetch_alerts');
	data.append('date', $('#csi-ewa-template-control-center-date-input').val() );
	data.append('action_flag', $('#csi-ewa-template-control-center-action-checkbox').is(':checked') );
	data.append('filter_customer', $('#csi-ewa-template-control-center-filter-customer').val() );
	data.append('filter_sid', $('#csi-ewa-template-control-center-filter-sid').val() );
	data.append('filter_group', $('#csi-ewa-template-control-center-filter-alert-group').val() );
	data.append('filter_text', $('#csi-ewa-template-control-center-filter-alert-text').val() );

	$.ajax({
		url: ajaxUrl,
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		beforeSend: function () {
			tbody.addClass('loading');
		},
		success: function(response){
//			window.console.log(JSON.stringify(response));
			if ( undefined === response.error){
				tbody.fadeOut(400, function(){
					tbody.html(response.tbody);
					tbody.fadeIn();
					tbody.find('form.csi-ewa-template-control-center-alert-form').submit(function(event){
						event.preventDefault();
						csiEWAControlCenterUpdateAction( $(this) );
					});	
				});
				$( "#csi-ewa-template-control-center-date-input + label" ).html(response.date);
				var infoGraphics = $('#csi-ewa-template-control-center-infographics');
				infoGraphics.html(response.graphsContainer);
				var graphs = $(response.graphs);
				graphs.each(function(i,val){
					/* jshint -W031 */
					new JustGage(val);
				});

//		   		$(".collapse").collapse();
	   		}
		},
		error: aaAjaxError,
	});// $.ajax
}// function csiEwaControlCenterFetchAlerts
csiEwaControlCenterFetchAlerts();
	
function csiEWAControlCenterUpdateAction(form){
	window.console.log ( form );
	if ( '' === form.find('input[type=text]').val() ){
		form.find('input[type=text]').parent().parent().addClass('has-error');
		return false;
	}
	var data = new FormData();
	data.append('action',			'csi_ajax_template_ewa_control_center_update_alerts');
	data.append('alert_id', 		form.data('alert-id') );
	data.append('action_party_id', 	form.find('select[name=action_party_id]').val() );
	data.append('action_id',		form.find('input[name=action_id]').val() );
	data.append('customer_flag',	form.find('input[name=customer_flag]').is(':checked') );
	$.ajax({
		url: ajaxUrl,
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		success: function(response){
			window.console.log(JSON.stringify(response));
			if ( undefined === response.error){
				csiEwaControlCenterFetchAlerts();
	   		}
		},
		error: aaAjaxError,
	});// $.ajax
}
	
var aaAjaxError = function(jqXHR, textStatus, errorThrown){
	var msg = '';
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