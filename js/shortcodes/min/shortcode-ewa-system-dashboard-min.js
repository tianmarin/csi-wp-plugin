jQuery(document).ready(function($){$(".csi-system-dashboard-alert-chart").each(function(a,r){var t=$(r).attr("id"),o=$(r).data("system-id"),e=$(r).data("chart-data"),i=window["csiEWASystemDashboard"+o],l=i[e+"_DataProvider"],s=i[e+"_Graphs"];AmCharts.makeChart(t,{borderAlpha:0,categoryAxis:{parseDates:!0,minPeriod:"DD",axisAlpha:0,fillAlpha:0,fillColor:"#000000",startOnAxis:!0},categoryField:"planned_date",balloon:{enabled:!1},columnWidth:1,dataDateFormat:"YYYY-MM-DD",dataProvider:l,graphs:s,autoMargins:!1,marginLeft:0,marginRight:0,marginTop:0,marginBottom:0,type:"serial",valueAxes:[{gridAlpha:0,axisAlpha:0}]})}),$(".csi-system-dashboard-ewa-chart").each(function(a,r){var t=$(r).attr("id"),o=$(r).data("system-id"),e=$(r).data("chart-data"),i=window["csiEWASystemDashboard"+o],l=i[e+"_DataProvider"],s=i[e+"_Graphs"];window.console.log(i),window.console.log(l),window.console.log(s),AmCharts.makeChart(t,{borderAlpha:0,categoryAxis:{parseDates:!0,minPeriod:"DD",gridAlpha:0,axisAlpha:.5,fillAlpha:.01,fillColor:"#000000",startOnAxis:!0},categoryField:"planned_date",chartCursor:{categoryBalloonDateFormat:"YYYY-MM-DD",cursorAlpha:0,valueBalloonsEnabled:!1,oneBalloonOnly:!1,categoryBalloonColor:"#161616",leaveCursor:!0},columnWidth:1,dataDateFormat:"YYYY-MM-DD",dataProvider:l,graphs:s,autoMargins:!1,marginLeft:0,marginRight:0,marginTop:0,marginBottom:20,type:"serial",valueAxes:[{gridAlpha:0,axisAlpha:0}]})})});