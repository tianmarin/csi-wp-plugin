/*global csiWPCLIENT*/
/*global AmCharts*/
jQuery(document).ready(function($){
//var ppost		=csiWPCLIENT.ppost;
//var ajaxurl		=csiWPCLIENT.ajaxurl;
//var php_script	=csiWPCLIENT.php_script;
window.console.log(csiWPCLIENT);
$('.csi_ewa_system_panel').each(function(i,element){
//	window.console.log(i);
//	window.console.log(element);
	var element_id=$(element).attr('id');
	window.console.log(element_id);
	var data = window["csiWPCLIENT_"+element_id];
	data = data[element_id];
	window.console.log(data);
//	window.console.log(element_id);
//	window.console.log(csiWPCLIENT[element_id]);
	csi_ewa_system_panel(element_id,data);
});

function csi_ewa_system_panel(id, dataProvider){
//	var panel_id=$(id);
	var chart = AmCharts.makeChart(id, {
//		"backgroundAlpha":1,
//		"backgroundColor":"#dddddd",
		"categoryAxis": {
//			"fillAlpha":1,
//			"fillColor":"#dddddd",
			"parseDates": true,
		},
		"categoryField": "date",
		"dataDateFormat": "YYYY-MM-DD",
		"dataProvider": JSON.parse(dataProvider),
		"graphs": [
			{
				"bezierX":3,
				"bezierY":100,
				"bullet": "round",
				"bulletBorderAlpha":1,
				"bulletBorderColor":"#cc0000",
				"bulletBorderThickness":2,
				"bulletColor":"#FFFFFF",
				"bulletSize":10,
				"id": "g1",
				"fillAlphas":0.25,	
				"fillColors":"#cc0000",
				"lineColor":"#cc0000",
				"title": "Critical",
				"type": "smoothedLine",
				"useLineColorForBulletBorder": true,
				"valueField": "critical",
			},
			{
				"bezierX":3,
				"bezierY":100,
				"bullet": "round",
				"bulletBorderAlpha":1,
				"bulletBorderColor":"#cccc00",
				"bulletBorderThickness":2,
				"bulletColor":"#FFFFFF",
				"bulletSize":10,
				"id": "g2",
				"fillAlphas":0.4,
				"fillColors":"#cccc00",
				"lineColor":"#cccc00",
				"title": "Warning",
				"type": "smoothedLine",
				"useLineColorForBulletBorder": true,
				"valueField": "warning",
			},
		],
		"legend": {
			"align":"center",
			"position":'top',
			"useGraphSettings": true,
		},
		"type": "serial",
		"theme": "dark",
		"valueAxes": [{
			"axisAlpha": 0,
			"gridAlpha": 0,
			"labelsEnabled": false,
		}],
	});	
	window.console.log(chart);
}
$('form').submit(function(event){
	var required=true;
	$(this).find(':input[type!="hidden"]').not(':input[type=button], :input[type=submit], :input[type=reset]').each(function() {
		if ( $(this).data('required') === true ) {
			if ( $(this).val() === '' ||  $(this).val() === 0 ) {
				$(this).parent().parent().addClass('has-error');
				required=false;			
			}
		}
		if ( $(this).data('validation') === 'true' ) {
			if ( $.isNumeric( $(this).data('validation-min') ) ) {
				if ( $(this).data('validation-min') >= $(this).val() ) {
					$(this).parent().parent().addClass('has-warning');
					required=false;			
				}
			}
			if ( $.isNumeric( $(this).data('validation-max') ) ) {
				if ( $(this).data('validation-max') <= $(this).val() ) {
					$(this).parent().parent().addClass('has-warning');
					required=false;			
				}
			}
			if ( $.isNumeric( $(this).data('validation-maxchar') ) ) {
				if ( $(this).data('validation-maxchar') <= $(this).length() ) {
					$(this).parent().parent().addClass('has-warning');
					required=false;			
				}
			}
		}
	});
	if ( true !== required ) {
		event.preventDefault();
	}
});
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

});