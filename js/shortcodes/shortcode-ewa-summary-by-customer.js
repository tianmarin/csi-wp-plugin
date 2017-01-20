/*
Script Name: Shortcode EWA System History
Dependencies: jquery, amcharts, amcharts-serial,amcharts-responsive
*/
/*global AmCharts*/
/*global csiEWASummary*/
jQuery(document).ready(function($){
$('.ewa_summary_graph').each(function(){
	var divId = $(this).attr('id');
	window.console.log(csiEWASummary.dataProvider);
	window.console.log(csiEWASummary.graphs);
	var chart = AmCharts.makeChart( divId , {
		"borderAlpha"										: 0,
		"categoryAxis": {
			"parseDates"									: true,
			"minPeriod"										: 'WW',
			"gridAlpha"										: 0,
		},
		"categoryField"										: "planned_date",
		"chartCursor": {
			"fullWidth"										: true,
//			"categoryBalloonEnabled"						: true,
			"categoryBalloonDateFormat"						: "YYYY-MM-DD",
			"cursorAlpha"									: 0.05,
//			"graphBulletAlpha"								: 0.8,
			"valueBalloonsEnabled"							: false,
			"oneBalloonOnly"								: true,
			"categoryBalloonColor"							: '#161616',
			"leaveCursor"									: true,
//			"bulletsEnabled"								: true,
		},
		"chartScrollbar": {
			"scrollbarHeight"								: 40,
			"oppositeAxis"									: false,
			"offset"										: 30,
			"backgroundAlpha"								: 0.25,
			"selectedBackgroundAlpha"						: 0.5,
			"selectedBackgroundColor"						: "#888888",
			"graph"											: "total",
			"graphFillAlpha"								: 1,
			"graphType"										: "line",
			"graphLineAlpha"								: 1,
			"graphLineColor"								: "#000000"
    		},
		"columnWidth"										: 0.75,
		"dataDateFormat"									: "YYYY-MM-DD",
		"dataProvider"										: csiEWASummary.dataProvider,
		"graphs"											: csiEWASummary.graphs,
//		"gridAboveGraphs"									: true,
		"legend": {
//			"align"											: 'center',
			'enabled'										: true,
			"horizontalGap"									: 10,
//			"maxColumns"									: 1,
			"periodValueText"								: '[[value.sum]]',
			"position"										: "bottom",
//			"useGraphSettings"								: false,
			"markerSize"									: 10,
			"divId"											: "ewa_summary_graph_legend",
		},
//		"marginBottom"										: 0,
//		"marginLeft"										: 0,
//		"marginRight"										: 20,
//		"marginTop"											: 0,
//		"startDuration"										: 0.25,
		"type"												: "serial",
		"AxisBase":{
			"gridAlpha"										: 0,			
		},
		"valueAxes": [
			{
			"stackType"										: "regular",
			"axisAlpha"										: 0,
			"gridAlpha"										: 0,
//			"position"										: "left",
			}
		],
	});
	
		// this method is called when chart is first inited as we listen for "rendered" event
	function zoomChart() {
		// different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
		chart.zoomToIndexes(csiEWASummary.dataProvider.length - 8, csiEWASummary.dataProvider.length );
	}
	chart.addListener("rendered", zoomChart);
	zoomChart();

});

});