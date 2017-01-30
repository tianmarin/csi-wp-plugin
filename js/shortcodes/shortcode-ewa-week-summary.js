/*
Script Name: Shortcode EWA System History
Dependencies: jquery, bootstrap, jquery-confirm, amcharts, amcharts-serial,amcharts-responsive
*/
/*global AmCharts*/
jQuery(document).ready(function($){
	$('[data-toggle="tooltip"]').tooltip();
	$('.ewa-week-summary-sql-code-button').click(function(){
		var systemNo = $(this).data('system-no');
		$.alert('SELECT * from '+systemNo);
	});
});