/*
Script Name: Shortcode EWA System History
Dependencies: jquery, amcharts, amcharts-serial,amcharts-responsive
*/
/*global AmCharts*/
jQuery(document).ready(function($){
$('.ewa_system_history_graph').each(function(){
	var systemId = $(this).data('system-id');
	var csiEWASystemHistory = window['csiEWASystemHistory'+'_system_'+systemId];
	var divId = $(this).attr('id');
	window.console.log(csiEWASystemHistory.dataProvider);
	window.console.log(csiEWASystemHistory.graphs);
	AmCharts.makeChart( divId , {
		"type": "serial",
		"legend": {
			"horizontalGap": 10,
			"maxColumns": 1,
			"position": "bottom",
			"useGraphSettings": true,
			"markerSize": 10,
			"divId": divId+"_legend",

		},
		"dataProvider": csiEWASystemHistory.dataProvider,
		"valueAxes": [
			{
			"stackType": "regular",
			"axisAlpha": 0.3,
			"gridAlpha": 0
			}
		],
		"graphs": csiEWASystemHistory.graphs,
		"categoryField": "planned_date",
		"categoryAxis": {
			"parseDates": true,
//			"gridPosition": "start",
//			"axisAlpha": 0,
//			"gridAlpha": 0,
//			"position": "left"
		},
		"columnWidth": 1, 
		"chartCursor": {
			"fullWidth":true,
//			"categoryBalloonEnabled":false,
			"categoryBalloonDateFormat": "YYYY-MM-DD",
			"cursorAlpha": 0.05,
			"graphBulletAlpha": 0.1,
			"valueBalloonsEnabled":false,
			
		},
		"dataDateFormat": "YYYY-MM-DD",
		"gridAboveGraphs": true,
		"startDuration": 1,
	});
});

});
