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
	AmCharts.makeChart( divId , {
		"borderAlpha"										: 0,
		"categoryAxis": {
			"parseDates"									: true,
			"minPeriod"										: 'WW',
		},
		"categoryField"										: "planned_date",
		"chartCursor": {
			"fullWidth"										: true,
			"categoryBalloonEnabled"						: true,
			"categoryBalloonDateFormat"						: "YYYY-MM-DD",
			"cursorAlpha"									: 0.05,
			"graphBulletAlpha"								: 0.1,
			"valueBalloonsEnabled"							: false,
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
		"gridAboveGraphs"									: true,
		"legend": {
//			"align"											: 'center',
			'enabled'										: true,
			"horizontalGap"									: 10,
			"maxColumns"									: 1,
			"periodValueText"								: '[[value.sum]]',
			"position"										: "bottom",
			"useGraphSettings"								: true,
			"markerSize"									: 10,
			"divId"											: "ewa_summary_graph_legend",
		},
		"marginBottom"										: 0,
		"marginLeft"										: 0,
		"marginRight"										: 0,
		"marginTop"											: 0,
//		"startDuration"										: 1,
		"type"												: "serial",
		"valueAxes": [
			{
			"stackType"										: "regular",
//			"axisAlpha"										: 0.3,
//			"gridAlpha"										: 0.07,
//			"position"										: "left",
			}
		],
	});
});

});