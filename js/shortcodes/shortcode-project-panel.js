/*
Script Name: Shortcode Project Panel
Dependencies: jquery, amcharts, amcharts-serial,amcharts-responsive
*/
/*global AmCharts*/
jQuery(document).ready(function($){
$('.csi_ewa_system_panel').each(function(i,element){
	var element_id=$(element).attr('id');
	window.console.log(element_id);
	var data = window["csiShortcodeProjectPanel_"+element_id];
	window.console.log(data);
	data = data[element_id];
	csi_ewa_system_panel(element_id,data);
});

function csi_ewa_system_panel(id, dataProvider){
	var chart = AmCharts.makeChart(id, {
		"categoryAxis": {
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
});