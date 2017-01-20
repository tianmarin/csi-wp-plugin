/*
Script Name: Shortcode EWA System Dashboard
Dependencies: jquery, bootstrap, amcharts, amcharts-serial, amcharts-responsive
*/
/*global AmCharts*/
jQuery(document).ready(function($){
	
$('.csi-system-dashboard-alert-chart').each(function(i,element){
	var divId			=$(element).attr('id');
	var elementId		=$(element).data('system-id');
	var chartData		=$(element).data('chart-data');
	var global			=window['csiEWASystemDashboard' + elementId ];
	var dataProvider	= global[chartData+'_DataProvider'];
	var graphs			= global[chartData+'_Graphs'];
//	window.console.log(dataProvider);
//	window.console.log(graphs);
	AmCharts.makeChart( divId , {
		"borderAlpha"										: 0,
		"categoryAxis": {
			"parseDates"									: true,
			"minPeriod"										: 'DD',
//			"gridAlpha"										: 0,
			"axisAlpha"										: 0,
			"fillAlpha"										: 0,
			"fillColor"										: "#000000",
			"startOnAxis"									: true
		},
		"categoryField"										: "planned_date",
		"balloon": {
//			"drop"											: true,
			"enabled"										:false,
		},
/*		"chartCursor": {
//			"categoryBalloonEnabled"						: true,
			"categoryBalloonDateFormat"						: "YYYY-MM-DD",
			"cursorAlpha"									: 0,
//			"graphBulletAlpha"								: 0.8,
			"valueBalloonsEnabled"							: false,
			"oneBalloonOnly"								: false,
			"categoryBalloonColor"							: '#161616',
			"leaveCursor"									: true,
//			"bulletsEnabled"								: true,
		},
*/
		"columnWidth"										: 1,
		"dataDateFormat"									: "YYYY-MM-DD",
		"dataProvider"										: dataProvider,
		"graphs"											: graphs,
		"autoMargins"										: false,
		"marginLeft"										: 0,
		"marginRight"										: 0,
		"marginTop"											: 0,
		"marginBottom"										: 0,
//		"startDuration"										: 0.25,
		"type"												: "serial",
		"valueAxes": [
			{
			"gridAlpha"										: 0,
			"axisAlpha"										: 0,
			}
		],
	});
});

$('.csi-system-dashboard-ewa-chart').each(function(i,element){
	var divId			=$(element).attr('id');
	var elementId		=$(element).data('system-id');
	var chartData		=$(element).data('chart-data');
	var global			=window['csiEWASystemDashboard' + elementId ];
	var dataProvider	= global[chartData+'_DataProvider'];
	var graphs			= global[chartData+'_Graphs'];
	window.console.log(global);	
	window.console.log(dataProvider);
	window.console.log(graphs);
	AmCharts.makeChart( divId , {
		"borderAlpha"										: 0,
		"categoryAxis": {
			"parseDates"									: true,
			"minPeriod"										: 'DD',
			"gridAlpha"										: 0,
			"axisAlpha"										: 0.5,
			"fillAlpha"										: 0.01,
			"fillColor"										: "#000000",
			"startOnAxis"									: true
		},
		"categoryField"										: "planned_date",
		"chartCursor": {
//			"categoryBalloonEnabled"						: true,
			"categoryBalloonDateFormat"						: "YYYY-MM-DD",
			"cursorAlpha"									: 0,
//			"graphBulletAlpha"								: 0.8,
			"valueBalloonsEnabled"							: false,
			"oneBalloonOnly"								: false,
			"categoryBalloonColor"							: '#161616',
			"leaveCursor"									: true,
//			"bulletsEnabled"								: true,
		},

		"columnWidth"										: 1,
		"dataDateFormat"									: "YYYY-MM-DD",
		"dataProvider"										: dataProvider,
		"graphs"											: graphs,
		"autoMargins"										: false,
		"marginLeft"										: 0,
		"marginRight"										: 0,
		"marginTop"											: 0,
		"marginBottom"										: 20,
//		"startDuration"										: 0.25,
		"type"												: "serial",
		"valueAxes": [
			{
			"gridAlpha"										: 0,
			"axisAlpha"										: 0,
			}
		],
	});
});


});