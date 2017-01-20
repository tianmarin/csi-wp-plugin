/*
Script Name: Shortcode EWA Customer Block
Dependencies: jquery, bootstrap, amcharts, amcharts-serial, amcharts-responsive, amcharts-pie
*/
/*global AmCharts*/
jQuery(document).ready(function($){

$('.ewa-customer-block-ewa-chart').each(function(i,element){
	var divId			= $(element).attr('id');
//	var elementId		= $(element).data('system-id');
	var global			= window.csiEWACustomerBlock;
	var chartData		= $(element).data('chart-data');
	var dataProvider	= global[chartData+'_DataProvider'];
//	window.console.log(global);
//	window.console.log(chartData);
//	window.console.log(dataProvider);

	AmCharts.makeChart(divId, {
		"type": "pie",
		"dataProvider": dataProvider,
		"valueField": "ewas",
		"titleField": "title",
		"colorField": "color",
		"labelColorField": "color",
		"labelsEnabled": false,
		"radius": 40,
//		"balloon": { "enabled": false }
	});

});
/*
$('.ewa-customer-block-alert-chart').each(function(i,element){
	var divId			= $(element).attr('id');
//	var elementId		= $(element).data('customer-id');
	var global			= window.csiEWACustomerBlock;
	var chartData		= $(element).data('chart-data');
	var dataProvider	= global[chartData+'_DataProvider'];
	var graphs			= global[chartData+'_Graphs'];
	window.console.log(global);
//	window.console.log(chartData);
//	window.console.log(dataProvider);

	AmCharts.makeChart( divId , {
		"borderAlpha"										: 0,
//		"rotate"											: true,
		"categoryAxis": {
//			"parseDates"									: true,
//			"minPeriod"										: 'DD',
//			"gridAlpha"										: 0,
//			"axisAlpha"										: 0,
//			"fillAlpha"										: 0,
			"startOnAxis"									: true
		},
		"categoryField"										: "short_name",
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

		"columnWidth"										: 0.5,
//		"dataDateFormat"									: "YYYY-MM-DD",
		"dataProvider"										: dataProvider,
		"graphs"											: graphs,
		"autoMargins"										: false,
		"marginLeft"										: 20,
		"marginRight"										: 20,
		"marginTop"											: 20,
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
*/

});