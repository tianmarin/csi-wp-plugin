/*
Script Name: Shortcode EWA Control Center
Dependencies: jquery, bootstrap, amcharts, amcharts-serial, amcharts-responsive, amcharts-pie
*/
/*global csiTemplateEwaMgmtControlCenter*/
/*global moment*/
/*global AmCharts*/
jQuery(document).ready(function($){
//Global Variables	
var ajaxUrl		=csiTemplateEwaMgmtControlCenter.ajaxurl;
var start	= moment().subtract(2, 'month').startOf('month');
var end		= moment();
function cb(start, end) {
	$('#filter-date-range span').html(start.format('YYYY-MM-DD') + ' <i class="fa fa-angle-right fa-fw"></i><br/> ' + end.format('YYYY-MM-DD'));
	$('#filter-date-start').val(start.format('YYYY-MM-DD'));
	$('#filter-date-end').val(end.format('YYYY-MM-DD'));
	window.console.log($('#filter-date-start').val());
	window.console.log($('#filter-date-end').val());
	refreshData();
}
$('#filter-date-range').daterangepicker({
	startDate				: start,
	endDate					: end,
	ranges					: {
//		'Today'				: [moment(), moment()],
//		'Yesterday'			: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
//		'Last 7 Days'		: [moment().subtract(6, 'days'), moment()],
		'Ultimos 30 Days'		: [moment().subtract(29, 'days'), moment()],
		'Ultimos 2 meses'	: [moment().subtract(2, 'month').startOf('month'), moment().endOf('month')],
		'Ultimos 4 meses'	: [moment().subtract(4, 'month').startOf('month'), moment().endOf('month')],
		'Ultimos 6 meses'	: [moment().subtract(6, 'month').startOf('month'), moment().endOf('month')]
	}
}, cb);
cb(start, end);

function fetch_ewas(){
	var panelTitle						= $('#panel-title-date');
	var tbody							= $('#csi-template-ewa-mgmt-control-center-table tbody');
	var data							= new FormData();
	
	data.append('action',				'csi_ajax_template_ewa_mgmt_control_center_fetch_alerts'	);
	data.append('filter_start_date',	$('#filter-date-start').val()								);
	data.append('filter_end_date',		$('#filter-end-start').val()								);
	data.append('filter_customer',		$('#filter-customer').val()									);
	data.append('filter_sid',			$('#filter-sid').val()										);
	data.append('filter_alert_group',	$('#filter-alert-group').val()								);
	data.append('filter_alert_text',	$('#filter-alert-text').val()								);
	data.append('filter_action',		$('#filter-action').val()									);
	data.append('filter_customer_flag',	$('#filter-customer-flag').val()							);
	$.ajax({
		url: ajaxUrl,
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		beforeSend: function () {
			tbody.addClass('ajax-loading');
		},
		success: function(response){
//			window.console.log(JSON.stringify(response));
			if ( undefined === response.error){
				tbody.fadeOut(400, function(){
					tbody.html(response.tbody);
					tbody.fadeIn(400,function(){
						tbody.removeClass('ajax-loading');
					});
				});
				panelTitle.html(response.panelTitleDates);
			}
		},
		error: aaAjaxError,
	});// $.ajax	
}// function fetch_ewas

function fetchAlertChartData(){
	var parentDiv= $('#csi-template-ewa-mgmt-control-center-infographics-alert');
	var chartDiv = $('#csi-template-ewa-mgmt-control-center-infographics-alert-chart');
	var data = new FormData();
	data.append('action',				'csi_ajax_template_ewa_mgmt_control_center_alert_chart'		);
	data.append('filter_start_date',	$('#filter-date-start').val()								);
	data.append('filter_end_date',		$('#filter-end-start').val()								);
	data.append('filter_customer',		$('#filter-customer').val()									);
	data.append('filter_sid',			$('#filter-sid').val()										);
	data.append('filter_alert_group',	$('#filter-alert-group').val()								);
	data.append('filter_alert_text',	$('#filter-alert-text').val()								);
	data.append('filter_action',		$('#filter-action').val()									);
	data.append('filter_customer_flag',	$('#filter-customer-flag').val()							);
	parentDiv.on('shown.bs.collapse', function () {
		var allCharts = AmCharts.charts;
		var chartIndex = null;
		$.each(allCharts,function(i,val){
			if (chartDiv.attr('id') === val.div.id ) {
				chartIndex = i;
				return i;
			}
		});
		if ( null !== chartIndex ){
			allCharts[chartIndex].invalidateSize();
		}
	});
	$.ajax({
		url: ajaxUrl,
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		beforeSend: function () {
			chartDiv.addClass('ajax-loading');
		},
		success: function(response){
			if ( undefined === response.error){
//				window.console.log(JSON.stringify(response.chart));
//				window.console.log(response.chart);
				var allCharts = AmCharts.charts;
				var chartIndex = null;
				$.each(allCharts,function(i,val){
					if (chartDiv.attr('id') === val.div.id ) {
						chartIndex = i;
						return i;
					}
				});
				if ( null === chartIndex ){
					AmCharts.makeChart( chartDiv.attr('id') , response.chart );
					chartDiv.removeClass('ajax-loading');
				}else{
					allCharts[chartIndex].graphs			= response.graphs;
					allCharts[chartIndex].dataProvider		= response.dataProvider;
					allCharts[chartIndex].validateData();
					allCharts[chartIndex].invalidateSize();
					chartDiv.removeClass('ajax-loading');
				}

			}
		},
		error: aaAjaxError,
	});// $.ajax	
}// function fetchAlertChartData

function fetchEWAStatusChartData(){
	var parentDiv= $('#csi-template-ewa-mgmt-control-center-infographics-ewa-status');
	var chartDiv = $('#csi-template-ewa-mgmt-control-center-infographics-ewa-status-chart');
	var data = new FormData();
	data.append('action',				'csi_ajax_template_ewa_mgmt_control_center_ewa_status_chart');
	data.append('filter_start_date',	$('#filter-date-start').val()								);
	data.append('filter_end_date',		$('#filter-end-start').val()								);
	data.append('filter_customer',		$('#filter-customer').val()									);
	data.append('filter_sid',			$('#filter-sid').val()										);
	data.append('filter_alert_group',	$('#filter-alert-group').val()								);
	data.append('filter_alert_text',	$('#filter-alert-text').val()								);
	data.append('filter_action',		$('#filter-action').val()									);
	data.append('filter_customer_flag',	$('#filter-customer-flag').val()							);
	parentDiv.on('shown.bs.collapse', function () {
		var allCharts = AmCharts.charts;
		var chartIndex = null;
		$.each(allCharts,function(i,val){
			if (chartDiv.attr('id') === val.div.id ) {
				chartIndex = i;
				return i;
			}
		});
		if ( null !== chartIndex ){
			allCharts[chartIndex].invalidateSize();
		}
	});
	$.ajax({
		url: ajaxUrl,
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		beforeSend: function () {
			chartDiv.addClass('ajax-loading');
		},
		success: function(response){
			if ( undefined === response.error){
//				window.console.log(JSON.stringify(response.chart));
//				window.console.log(response.chart);
				var allCharts = AmCharts.charts;
				var chartIndex = null;
				$.each(allCharts,function(i,val){
					if (chartDiv.attr('id') === val.div.id ) {
						chartIndex = i;
						return i;
					}
				});
				if ( null === chartIndex ){
					AmCharts.makeChart( chartDiv.attr('id') , response.chart );
					chartDiv.removeClass('ajax-loading');
				}else{
					allCharts[chartIndex].graphs			= response.graphs;
					allCharts[chartIndex].dataProvider		= response.dataProvider;
					allCharts[chartIndex].validateData();
					allCharts[chartIndex].invalidateSize();
					chartDiv.removeClass('ajax-loading');
				}

			}
		},
		error: aaAjaxError,
	});// $.ajax	
}// function fetchEWAStatusChartData

function fetchActionChartData(){
	var chartDiv = $('#csi-template-ewa-mgmt-control-center-infographics-action-percentage-chart');
	var data = new FormData();
	data.append('action',				'csi_ajax_template_ewa_mgmt_control_center_action_gauge'	);
	data.append('filter_start_date',	$('#filter-date-start').val()								);
	data.append('filter_end_date',		$('#filter-end-start').val()								);
	data.append('filter_customer',		$('#filter-customer').val()									);
	data.append('filter_sid',			$('#filter-sid').val()										);
	data.append('filter_alert_group',	$('#filter-alert-group').val()								);
	data.append('filter_alert_text',	$('#filter-alert-text').val()								);
	data.append('filter_action',		$('#filter-action').val()									);
	data.append('filter_customer_flag',	$('#filter-customer-flag').val()							);
	$.ajax({
		url: ajaxUrl,
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		beforeSend: function () {
			chartDiv.addClass('ajax-loading');
		},
		success: function(response){
			if ( undefined === response.error){
//				window.console.log(response);
				chartDiv.html(response.chartsContainer);
				var charts = $(response.charts);
				charts.each(function(i,val){
					AmCharts.makeChart( val.divId, val);
				});
				chartDiv.removeClass('ajax-loading');
			}
		},
		error: aaAjaxError,
	});// $.ajax	
}// function fetchActionChartData

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

function refreshData(){
	fetch_ewas();		
	fetchAlertChartData();
	fetchActionChartData();
	fetchEWAStatusChartData();
}

$('form.table-filter-form').submit(function(event){
	event.preventDefault();
	refreshData();
});
$('form.table-filter-form select').change(function(){
	refreshData();
});




});