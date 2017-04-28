/*
Script Name: Shortcode EWA Control Center
Dependencies: jquery, bootstrap, amcharts, amcharts-serial, amcharts-responsive, amcharts-pie
*/
/*global document*/
/*global csiTemplateScript*/
/*global FormData*/
/*global jconfirm*/
/*global moment*/
/*global AmCharts*/
jQuery(document).ready(function($){
/*
* Global Variables
*/
var cmpMainContent 	=	$('.csi-template-main-content');
var ajaxPages={
	'intro'	 		:   'csi_cmp_build_page_intro',
	'listplans'		:	'csi_cmp_build_page_list_plans',
	'addplan'		:	'csi_cmp_build_page_new_plan_form',
	'editplan'		:	'csi_cmp_build_page_edit_cmp_form',
	'showplan'  	:   'csi_cmp_build_page_show_plan',
	'addtask'   	:   'csi_cmp_build_page_new_task_form',
	'showtask'		:	'csi_cmp_build_page_show_task',
	'edittask'		:	'csi_cmp_build_page_edit_task_form',
	'listservices'	:	'csi_cmp_build_page_list_services',
	'showservice'	:	'csi_cmp_build_page_show_service',
	'editservice'	:	'csi_cmp_build_page_edit_service_form',
	'edittaskplan'	:	'csi_cmp_build_page_task_steps_import',
	'scheduletask'	:	'csi_cmp_build_page_schedule_task',
	'addservice'	:	'csi_cmp_build_page_new_service_form',
	'dashboard'		:	'csi_cmp_dashboard_build_page',
	'capacity'		:	'csi_cmp_capacity_build_page',
	'keynote'		:	'csi_cmp_keynote_build_page',
	//Project Management Module
	'newprojectrequest'		:	'csi_pm_new_pr_form',
	'ownprojectrequest'		:	'csi_pm_build_page_own_project_request',
	'showprojectrequest'	:	'csi_pm_build_page_show_project_request',
	'editprojectrequest'	:	'csi_pm_build_page_edit_project_request_form',
	'listprojectrequests'	:	'csi_pm_build_page_list_project_requests',
	'newproject'	:	'csi_pm_new_project_form',
	'editproject'	:	'csi_pm_build_page_edit_project_form',
	'listprojects'	:	'csi_pm_build_page_list_projects',
	'showproject'  	:   'csi_pm_build_page_show_project',
	'addissue'		:	'csi_issue_create_issue_form',
	'searchissues'	:	'csi_issue_build_page_search_issue',
	'showissue'  	:   'csi_issue_build_page_show_issue',
	'editissue'		:	'csi_issue_edit_issue_form',
	'ownissues'		:	'csi_issue_my_issues',
	'issuerevprev'	:	'csi_issue_build_page_preview_issue_rev',
	'issueiab'		:	'csi_issue_iab_list',

	'ewaanalyzer'	:	'csi_ewa_build_page_ewa_analyzer',
	'ewauploader'	:	'csi_ewa_build_page_ewa_uploader',
	'ewaloads'		:	'csi_ewa_build_page_ewa_loads',
};
ajaxPages.intro		=	cmpMainContent.data('default-action');

var changeHash = function ( nextPage ) {
	if ( undefined !== nextPage &&  '' !== nextPage ){
		window.location.hash='#!' + nextPage.replace('#!','');
	}
	return true;
};



$(document).on({
	ajaxStart	: function() {
		$('#csi-template-cmp-control-center-ajax').fadeIn();
	},
	ajaxStop	: function() {
		setTimeout(function(){
			$('#csi-template-cmp-control-center-ajax').fadeOut();
		}, 1000);
	}
});
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
	window.console.log('ERROR: ');
	window.console.log(jqXHR);
	window.console.log(textStatus+' - '+errorThrown);
	var text='Este error de conexión con el servidor de fondo, regularmente indica que no has iniciado sesión en Wordpress.<br/>';
	window.console.log(csiTemplateScript.ajaxUrl);
	var url = csiTemplateScript.ajaxUrl.replace('admin-ajax.php', '');
	text=text+'Intenta <strong><a href="' + url + '">iniciar sesi&oacute;n</a></strong>. En caso que esto no funcione, por favor contacta al adminsitrador.';
	text=text+'<code>' + msg + '</code>';
	var title = 'Error de conexión as&iacute;ncrona';
	$.alert({
		buttons:{
			OK: {
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

//llamada Ajax para cargar contenido.
	//si sale bien
		//si hay error
		//sino
			//apagar lo actual
	//si sale mal
		//$.alert
		//guardar log (sm21)
var parseQueryString = function(url) {
	var urlParams = {};
	url.replace(
		new RegExp('([^?=&]+)(=([^&]*))?', 'g'),
		function($0, $1, $2, $3) {
			urlParams[$1] = $3;
		}
	);
	return urlParams;
};
$(window).bind( 'hashchange', function(event) {
	event.preventDefault();
	//eval hash in the url
	var hash = '';
	var hashRegEx = /\#\!(\w+)/;
	if ( hashRegEx.test(window.location.hash) ){
		hash = window.location.hash.match(hashRegEx)[1];
	}else{
		return false;
	}
	//eval GET Variables in the URL
	//https://cmatskas.com/get-url-parameters-using-javascript/
	var GET = parseQueryString ( window.location.hash) ;
	//eval softGET Variables in the URL
	var sGetRegEx = /\/(\w+)/g;
	var sGET=[];
	if ( sGetRegEx.test(window.location.hash) ){
		sGET = window.location.hash.match( sGetRegEx );
	}else{
		sGET = null;
	}

	switch ( hash ){
		case '':
			$.alert({
				closeIcon: true,
				columnClass: 'large',
				content:'He ocurrido un error al llamar al enlace.',
				title: 'Acceso incorrecto',
				type:'red',
			});
			break;
		default:
			loadPageContent(hash, GET, sGET);
	}
	return true;
});
if( window.location.hash === '' ){
	window.location.hash='#!intro';
	$(window).trigger( 'hashchange' ); // user refreshed the browser, fire the appropriate function
}else{
	$(window).trigger( 'hashchange' ); // user refreshed the browser, fire the appropriate function
}

function loadPageContent ( hash, get ) {
	var GET = get;
	var data = new FormData();
	console.log ( 'Llamando a pagina : ' + ajaxPages[hash] + '(' + hash + ')');
	data.append ( 'action', ajaxPages[hash] );
	if ( null !== GET ){
		for ( var item in GET){
			data.append ( item, GET[item] );
		}
	}
	$.ajax({
		url: csiTemplateScript.ajaxUrl,
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		beforeSend: function () {
		},
		success: function(response){
			//console.log(response);
			$('html, body').animate({ scrollTop: 0 }, '300');
			var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
			cmpMainContent.addClass('quick-animated ' + 'fadeOutDown').one(animationEnd, function() {
				$(this).removeClass('quick-animated ' + 'fadeOutDown');
				$(this).html(response.message);
				csiHardRefreshEventListener(response);
				cmpMainContent.addClass('quick-animated ' + 'fadeInUp').one(animationEnd, function() {
					$(this).removeClass('quick-animated ' + 'fadeInUp');
					if ( undefined !== GET.scrollTo ){
						if ( undefined !== $( '#' + GET.scrollTo ) ) {
							$('html,body').animate({
								scrollTop: $( '#' + GET.scrollTo ).offset().top
							});
							/*
							$( '#' + GET.scrollTo ).addClass('animated ' + 'pulse').one(animationEnd, function() {
								$(this).removeClass('animated ' + 'pulse');
							});
							*/
						}
					}
				});
			});
		},
		error: aaAjaxError,
	});
}
function csiTemplateCmpFetchTableContent( tableSelector ){
	var table = tableSelector;
	var data = new FormData();
	console.log ( 'Refrescando: ' + table.prop('id') );
	$.each(table.data(),function(index,val){
		data.append(index,val);
	});
	if ( undefined !== table.data('filter-form') ){
		$( table.data('filter-form') ).find('input, select, textarea, checkbox').each(function(){
			if ( $(this).is(':checkbox, :radio') ) {
				if ( $(this).prop('checked') ) {
					data.append($(this).attr('name'),$(this).val());
				}
			}else{
				data.append($(this).attr('name'),$(this).val());
			}
		});
	}
	$.ajax({
		url: csiTemplateScript.ajaxUrl,
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		beforeSend: function () {
			table.addClass('ajax-loading');
		},
		success: function(response){
			setTimeout(function(){
				table.removeClass('ajax-loading');
			}, 500);
			if ( 0 === response ){
				console.log ( 'No se recibó respuesta válida de : ' + table.data('action') );
			}else{
				if ( undefined !== response.chart){
					console.log ( response );
					var allCharts = AmCharts.charts;
					var chartIndex = null;
					$.each(allCharts,function(i,val){
						if (table.attr('id') === val.div.id ) {
							chartIndex = i;
							return i;
						}
					});
					if ( null === chartIndex ){
						AmCharts.makeChart( table.attr('id') , response.chart );
						table.removeClass('ajax-loading');
					}else{
//						allCharts[chartIndex].graphs			= response.graphs;
						allCharts[chartIndex].dataProvider		= response.dataProvider;
						allCharts[chartIndex].validateData();
						allCharts[chartIndex].invalidateSize();
					}
				}else{
					if ( 'TABLE' === table.prop('tagName') ){
						table.find('tbody').html(response.tbody);
					}else{
						table.html('');
						table.append(response.message);
					}
				}
				csiSoftRefreshEventListener(response);
			}
		},
		error: aaAjaxError,
	});
}

function csiTemplateCmpFetchUserData ( userId ){
	var user = userId;
	var data = new FormData();
	//filters related to this table
	data.append('action', 'csi_cmp_fetch_user_data' );
	data.append('user-id', user );
	$.ajax({
		url: csiTemplateScript.ajaxUrl,
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		beforeSend: function () {},
		success: function(response){
			if ( 0 === response ){
				console.log ( 'what?' );
			}else{
				if ( undefined !== response.notification ) {
					jconfirm ( response.notification );
					csiSoftRefreshEventListener(response);
				}
			}
		},
		error: aaAjaxError,
	});
}
function csiInfoPopup(elementData){
	var element = elementData;
	var data = new FormData();
	$.each(element.data(),function(index,val){
		data.append(index,val);
	});
	$.ajax({
		url: csiTemplateScript.ajaxUrl,
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false,
		contentType: false,
		beforeSend: function () {
		},
		success: function(response){
		//	console.log ( response );
			if ( 0 === response ){
			}else{
				if ( undefined !== response.notification ) {
					jconfirm ( response.notification );
				}// response.notification
				csiSoftRefreshEventListener(response);
			}
		},
		error: aaAjaxError,
	});
}
function csiLoadPopUpPage ( triggerElement ) {
	var trigger = triggerElement;
	var data = new FormData();
	$.each( trigger.data(), function(index,val){
		data.append(index,val);
	});
	jconfirm ({
		title: trigger.data('title'),
		backgroundDismiss: trigger.data('background-dismiss'),
		type: trigger.data('type'),
		icon: trigger.data('icon'),
		columnClass: trigger.data('column-class'),
		containerFluid: trigger.data('container-fluid'),
		buttons:{
			ok:{

			}
		},
		content: function(){
			var self = this;
			return  $.ajax({
			 	url: csiTemplateScript.ajaxUrl,
			 	type: 'POST',
			 	data: data,
			 	cache: false,
			 	dataType: 'json',
			 	processData: false,
			 	contentType: false,
			 	success: function(response){
					self.setContent(response.content);
					self.setTitle(response.title);
					setTimeout(function(){
						csiSoftRefreshEventListener(response);
					}, 300);

			 	},
			 	error: aaAjaxError,
			 });
		},
	});
	return true;
}
function csiSoftRefreshEventListener(pageResponse){
	var response = pageResponse;
	$('[data-toggle="tooltip"]').tooltip();
	//Execution
	$('.select2').each(function(i,val){
		$(this).select2({
			tokenSeparators: [',', ' '],
			theme: 'bootstrap',
			templateSelection: csiSelect2Format,
			templateResult: csiSelect2Format,
		});
	});
	$('input.csi-datetime-range-input').daterangepicker({
		timePicker: true,
		timePicker24Hour: true,
		//timePickerIncrement: 10,
		cancelClass: 'btn-danger',
		opens: 'center',
		//autoUpdateInput: false,
		dateLimit: {
			days: 30
		},
		locale: {
			format: 'YYYY-MM-DD HH:mm',
			applyLabel: 'Aceptar',
			cancelLabel: 'Cancelar',
		}
	});
	$('input.csi-date-range-input').each(function(){
		if ( undefined === $(this).data('hasdatepicker') ){
			$(this).data( 'hasdatepicker', true );
			var options = {
				cancelClass: 'btn-danger',
				opens: 'center',
				locale: {
					format: 'YYYY-MM-DD',
					applyLabel: 'Aceptar',
					cancelLabel: 'Cancelar',
				},
			};
			if ( true === $(this).data('ranges') ){
				options.ranges			= {
					'Semana actual'		: [moment().startOf('week').add(1, 'days'), moment().endOf('week').add(1, 'days')],
					'Semana anterior'	: [moment().subtract(1, 'week').startOf('week').add(1, 'days'), moment().subtract(1, 'week').endOf('week').add(1, 'days')],
					'Ultimos 30 Days'	: [moment().subtract(29, 'days'), moment().endOf('week')],
					'Ultimos 2 meses'	: [moment().subtract(2, 'month').startOf('month'), moment().endOf('week')],
					'Ultimos 4 meses'	: [moment().subtract(4, 'month').startOf('month'), moment().endOf('week')],
					'Ultimos 6 meses'	: [moment().subtract(6, 'month').startOf('month'), moment().endOf('week')],
				};
			}
			$(this).daterangepicker( options );
		}
	});
	$('.front-end-editable').each(function(){
		var editLink = $('<i class="fa fa-pencil front-end-editable-button"></i>')
		.css ( 'cursor', 'pointer' )
		.css( 'line-height', $(this).css('line-height') )
		.css ( 'position', 'absolute' )
		.css ( 'right', '0' )
		.css ( 'top', '0' )
		.css ( 'width', '1em' )
		.click(function(event){
			event.preventDefault();
			$(this).prev().prop('contenteditable','true').focus();
		});
		$(this).parent().css('position','relative');
		$(this).css ( 'padding-right', '1em' );
		$(this).after(editLink);
	});
	$('.csi-delete-dynamic-field-button').off('click').click(function(event){
		event.preventDefault();
		$(this).closest('.input-group').remove();
	});
	$('.input-dynamic').each( function(){
		if ( undefined !== response.dynamicFields ){
			if ( undefined !== $(this).data('dynamic-input') ){
				var inputField = $(this).data('dynamic-input');
				if ( undefined !== response.dynamicFields[inputField] ){
					inputField = response.dynamicFields[inputField];
					var inputBox = $(this);
					$(this).next().html(inputField.addButton).click(function(event){
						event.preventDefault();
						var count = $(this).closest('.form-group').find('.input-group').size();
						if ( count < inputField.maxFields ){
							inputBox.append(inputField.fieldBox);
							inputBox.find('.select2').select2({
								tokenSeparators: [',', ' '],
								templateSelection: csiSelect2Format,
								templateResult: csiSelect2Format,
								theme: 'bootstrap',
							});

							$('.csi-delete-dynamic-field-button').off('click').click(function(event){
								event.preventDefault();
								$(this).closest('.input-group').remove();
							});
						}else{
							$.alert({
								icon					: 'fa fa-exclamation-triangle fa-sm',
								closeIcon				: true,
								columnClass				: 'large',
								content					: 'Solo puedes agregar ' + inputField.maxFields + ' elementos.',
								title					: 'Advertencia!',
								type					: 'orange',
								backgroundDismiss		: true,
								scrollToPreviousElement	: false,
							});
							console.log ('ya son muchos');
						}
					});
				}
			}
		}
	});
	$('.csi-cmp-keynote-slide-gauge').each(function(){
		var container = $(this);
		AmCharts.makeChart( $(this).prop('id'), {
			'type': 'gauge',
			'theme': 'light',
			'axes': [ {
				'axisThickness'				: 0,
				'axisAlpha'					: 1,
				'startAngle'				: 0,
    			'endAngle'					: 360,
				//'unit'						: '%',
				//'tickAlpha': 0.2,
				'valueInterval'				: 100,
				'radius'					: '125%',
				'gridInside'				: true,
				//'bottomText': '0 %',
				//'bottomTextYOffset': -20,
				'endValue'					: container.data('end-value'),
				'tickAlpha'					: 0,
				//'minorTickInterval'			: 10,
				'showFirstLabel'			: false,
				'showLastLabel'				: false,
				'topText'					: container.data('top-text'),
				'topTextYOffset'			: 25,
				//'topTextBold'				: false,
				'bands'	:[{
					'color'					: container.data('back-color'),
      				'startValue'			: 0,
      				'endValue'				: 100,
      				'radius'				: '100%',
      				'innerRadius'			: '80%',
				},{
					'color'					: container.data('front-color'),
      				'startValue'			: 0,
      				'endValue'				: container.data('value'),
      				'radius'				: '100%',
      				'innerRadius'			: '80%',
				},
			],
			} ],
		});
	});
	//Event Handlers
	$('.csi-get-variable').off('change').change(function(event){

		//var name = $(this).prop('name');
		//var value = $(this).val();
		//var query = { [name] : value };
		//var uri = $.jurlp ( window.location.href );
		//uri.query ( query );
		//history.pushState({}, null, uri.fragment() + uri.query() );
	});
	$('[type="reset"]').off('click').click(function(event){
		event.preventDefault();
		window.history.back();
	});
	$('.nav-tabs a').on('shown.bs.tab', function(event) {
		if ( 'mdPreview' === $(this).data('function') ){
			var target = $( $(this).attr('href') );
			var dataInput = $( $(this).data('text-field') );
			var data = new FormData();
			$.each($(this).data(),function(index,val){
				data.append(index,val);
			});
			data.append ( 'dataInput', dataInput.val() );
			$.ajax({
				url: csiTemplateScript.ajaxUrl,
				type: 'POST',
				data: data,
				cache: false,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					target.addClass('ajax-loading');
				},
				success: function(response){
					setTimeout(function(){
						target.removeClass('ajax-loading');

					}, 300);
					target.html(response.message);
				},
				error: aaAjaxError,
			});
		}
	});
	$('.csi-form-additional-fields').off('hidden.bs.collapse').on('hidden.bs.collapse', function () {
		$(this).find('input, select').each(function(){
			if ( $(this).hasClass('select2') ) {
				$(this).select2('enable',false);
				$(this).addClass('disabled').prop('disabled',true).val('');
				//nextInput.select2('val', '');
				$(this).val('').trigger('change');
			}else{
				$(this).addClass('disabled').prop('disabled',true).prop('checked',false).val('');
			}
		});
	});
	$('.csi-form-additional-fields').off('shown.bs.collapse').on('shown.bs.collapse', function () {
		$(this).find('input, select').each(function(){
			if ( $(this).hasClass('select2') ) {
				$(this).select2('enable',true);
				$(this).removeClass('disabled').prop('disabled',false);
				//nextInput.select2('val', '');
				$(this).val('').trigger('change');
			}else{
				$(this).removeClass('disabled').prop('disabled',false);
			}
		});
	});
	$('.csi-popup-page').off('click').click(function(event){
		event.preventDefault();
		csiLoadPopUpPage ( $(this) );
	});
	$('.csi-popup').off('click').click(function(event){
		event.preventDefault();
		csiInfoPopup ( $(this) );
	});
	$('.refresh-button').off('click').click( function(event){
		event.preventDefault();
		if( undefined !== $(this).attr('href') ){
			csiTemplateCmpFetchTableContent ( $( $(this).attr('href') ) );
		}
		if( undefined !== $(this).data('refresh-elements') ){
			var trigger = $(this);
			$( $(this).data('refresh-elements') ).each(function(){
				var dest = $(this);
				$.each ( trigger.data(), function ( index, val ){
					dest.data ( index, val );
				});
				csiTemplateCmpFetchTableContent ( $( this ) );
			});
		}
	});
	$('.csi-2ble-click').off('dblclick').dblclick(function(event){
		var element = $(this);
		if( false === element.hasClass('active') ){
			element.children().toggle();
			element.find('select').focus();
			element.find('select').change(function(){
				$(this).trigger('blur');
				$(this).closest('form').submit();
				element.find('.csi-2ble-click-front').html( $(this).find(':selected').text() );
			});
			element.find('select').blur(function(){
				element.children().toggle();
			});
		}
	});
	$('.csi-switchable-radio-button').off('change').change(function (event) {
		csiSwitchableRadioButton ( this );
	});
	$('.csi-cmp-keynote-option').off('change').change( function(event){
		csiCmpKeynoteOption ( this );
	});
	$('.edit-table-button').off('click').click( function(event){
		event.preventDefault();
		if (  undefined !== $(this).attr('href') ) {
			var target = $( $(this).attr('href') );
			if ( undefined !== target.data('action') && undefined !== $(this).data('action') ) {
				if ( target.data('action') !== $(this).data('action') ){
					target.data( 'action', $(this).data('action') );
				}else{
					target.data( 'action', $(this).data('old-action') );
				}
				csiTemplateCmpFetchTableContent ( target );
			}else{
				console.log ( target );
			}
		}else{
			console.log ( '.edit-table-button href attribute not defined.');
			console.log ( $(this) );
		}
	});
	$('.user-data').off('click').click( function(event){
		event.preventDefault();
		csiTemplateCmpFetchUserData( $(this).data('user-id') );
	});
	$('.csi-cmp-keynote-sortable').sortable({
		axis: 'y',
		placeholder: 'placeholder',
		opacity: 0.8,
		start:function(){
		},
		stop:function(){
			csiCmpKeynoteOption ( this );
		},
		change:function(){
		},
		update: function( ) {
		},
	});
	$('input.csi-datetime-range-input').on('apply.daterangepicker', function(ev, picker) {
		$(this).val ( picker.startDate.format('YYYY-MM-DD HH:mm') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm') );
		var ms = picker.endDate.diff(picker.startDate);
		var d = moment.duration(ms);
		var s = Math.round(d.asHours() * 10) / 10;
		$(this).next().html( s + ' horas');
		if (10 < s || 0 === s ){
			$.alert({
				buttons					: {
					OK					: {
						text			: 'OK',
						btnClass		: 'btn-warning',
					},
				},
				icon					: 'fa fa-exclamation-triangle fa-sm',
				closeIcon				: true,
				columnClass				: 'large',
				content					: 'Estas seleccionando una duración ' + s + ' horas.',
				title					: 'Cuidado',
				type					: 'orange',
				scrollToPreviousElement	: false,
			});
		}
	});
	$('.in-table-info-button').off('click').click(function(event){
		event.preventDefault();
		var button = $(this);
		var data = new FormData();
		$.each($(this).data(),function(index,val){
			data.append(index,val);
		});
		var cell = button.closest('tr');
		$.ajax({
			url: csiTemplateScript.ajaxUrl,
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				cell.addClass('ajax-loading');
			},
			success: function(response){
				setTimeout(function(){
					cell.removeClass('ajax-loading');
				}, 300);
				if ( 0 === response ){
					console.log( $(response.message) );
				}else{
				}
			},
			error: aaAjaxError,
		});
	});
	$('.in-table-form-button').off('click').click(function(event){
		event.preventDefault();
		var button = $(this);
		var data = new FormData();
		$.each($(this).data(),function(index,val){
			data.append(index,val);
		});
		var cell = button.closest('tr');
		$.ajax({
			url: csiTemplateScript.ajaxUrl,
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				button.closest('.in-table-form-button-wrapper').addClass('ajax-loading');
			},
			success: function(response){
				setTimeout(function(){
					button.closest('.in-table-form-button-wrapper').removeClass('ajax-loading');
				}, 300);
				if ( 0 === response ){
				}else{
					cell.html ( $('<td colspan="999" class="active">' + response.message + '</td>' ) );
					csiSoftRefreshEventListener(response);
					cell.find('.in-table-form-cancel').off('click').click(function(event){
						event.preventDefault();
						csiTemplateCmpFetchTableContent( $(this).closest('.refreshable') );
					});
					cell.find('.csi-switchable-radio-button').off('change').change(function(){
						csiSwitchableRadioButton ( this );
					});
				}
			},
			error: aaAjaxError,
		});
	});
	$(':file').off('change').change(function(event){
		var file = this.files[0];
		var target = $( $(this).data('label') );
		console.log ( target );
		if ( undefined === file ){
			target.html( '' );
		}else{
			target.html( file.name );
		}
	});
	$('.csi-refreshable-filter-form').off('submit').submit(function(event){
		event.preventDefault();
		if ( undefined !== $(this).data('target') ){
			$( $(this).data('target') ).each(function(){
				csiTemplateCmpFetchTableContent ( $( this ) );
			});
			//console.log ( $( $(this).data('target') ) );
		}
	});
	$('form').not('.csi-refreshable-filter-form').off('submit').submit(function(event){
		event.preventDefault();
		var form = $(this);
		var submit = form.find(':submit').attr('disabled', true).addClass('disabled');
		var data = new FormData();
		data.append('action', form.data('function'));
		$(this).find('input, select, textarea, checkbox, file').each(function(){
			if ( $(this).is(':checkbox, :radio') ) {
				if ( $(this).prop('checked') ) {
					data.append($(this).attr('name'),$(this).val());
				}
			}else{
				if ( $(this).is(':file') ) {
					var file = this.files[0];
					data.append ( $(this).attr('name'), file );
				}else{
					data.append ( $(this).attr('name'), $(this).val() );
				}
			}
		});
		if ( undefined !== form.data('progress') ){
			var progress = $('<div></div>').addClass( 'progress' );
			var progressBar = $( '<div></div>' ).addClass( 'progress-bar' ).css( 'min-width', '2em').append( '0%' );
			progress.append ( progressBar );
			console.log ( $( form.data('progress') ) );
			$( form.data('progress') ).append ( progress );
			var progressMsg = $('<div><i class="fa fa-fw fa-lg fa-circle-o-notch fa-spin"></i>Posterior a la carga de informaci&oacute;n al servidor, debes esperar el procesamiento de la carga.</div>').addClass('alert alert-info');
		}
		$.ajax({
			url: csiTemplateScript.ajaxUrl,
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				form.addClass('ajax-loading');
			},
			xhr: function () {
				var xhr = new window.XMLHttpRequest();
				if ( undefined !== form.data('progress') ){
					//Upload progress
					xhr.upload.addEventListener("progress", function(evt){
						if (evt.lengthComputable) {
							var percentComplete = Math.round(evt.loaded / evt.total * 100);
							window.console.log('Porcentaje: '+percentComplete);
							progressBar.css( 'width', percentComplete + '%' ).html( percentComplete + '%');
						}
					}, false);
					//success upload
					xhr.upload.addEventListener("load", function(evt){
						if (evt.lengthComputable) {
						//	statusMsg.html(processing+" "+inputDay+'/'+inputMonth+'/'+inputYear+' Procesando la informaci&oacute;n cargada');
						setTimeout(function(){
							progress.after( progressMsg );
							progress.fadeOut( 'slow' );
						}, 1000);


						}
					}, false);
					//Download progress
					//If this is removed, the process is dead
					xhr.addEventListener("progress", function(evt){
						if (evt.lengthComputable) {
							window.console.log("Respuesta descargada: "+Math.round(evt.loaded / evt.total * 100)+'%');
						}else{
							window.console.log("Respuesta descargada: "+Math.round(evt.loaded / evt.total * 100)+'%');
						}
					}, false);
				}
				return xhr;
			},
			success: function(response){
				form.removeClass('ajax-loading');
				console.log ( response );
				if ( 0 === response ){
				}else{
					if ( undefined !== response.error){
						submit.attr('disabled', false).removeClass('disabled');
					}else{
						//plan creado correctamente
					}
					if ( undefined != progressMsg ) {
						setTimeout(function(){
							progressMsg.fadeOut( 'slow' );
						}, 5000);
					}
					if ( form.data('auto-hide') ){
						form.fadeOut();
					}
					if ( undefined !== $( form.data( 'upload-msg' ) ) ){
						var uploadMsg = $( form.data( 'upload-msg' ) );
						if ( undefined !== response.message ){
							uploadMsg.html( response.message );
						}
					}
					if ( undefined !== response.notification ) {
						switch ( response.postSubmitAction ){
							case 'changeHash':
								if ( undefined === response.notifStopNextPage ){
									//http://stackoverflow.com/a/34567019/5129222
									if ( undefined !== response.newId){
										response.notification.onClose = changeHash.bind(null,response.newId );
									}else{
										response.notification.onClose = changeHash.bind(null,form.data('next-page') );
									}

								}
								break;
							case 'refreshParent':
								response.notification.onClose = csiTemplateCmpFetchTableContent.bind(null,form.closest('.refreshable'));
								break;
							case 'changeURL':
								response.notification.onClose = function() {window.location.href = response.newUrl;};
								break;
							default:
								response.notification.onClose = function(){};
						}
						jconfirm ( response.notification );
					}else{
						if ( undefined !== response.postSubmitAction ){
							switch ( response.postSubmitAction ){
								case 'changeHash':
									changeHash( form.data('next-page') );
									break;
								case 'refreshParent':
									csiTemplateCmpFetchTableContent( form.closest('.refreshable') );
									break;
								case 'changeURL':
									window.location(response.newUrl);
									break;
							}
						}
					}
				}
			},
			error: aaAjaxError,
		});
		return false;
	});
}
function csiSwitchableRadioButton ( radio ) {
	var radioBtn = $( radio );

	radioBtn.closest('.form-group').find('.csi-switchable-radio-button').each(function(){
		var nextInput = $(this).parent().next('input, select').first();
		if ( $(this).is(':checked') ){
			if ( nextInput.hasClass('select2') ) {
				nextInput.select2('enable');
			}else{
				nextInput.removeClass('disabled').prop('disabled',false);
			}
		}else{
			if ( nextInput.hasClass('select2') ) {
				nextInput.select2('enable',false);
				nextInput.addClass('disabled').prop('disabled',true).val('');
				//nextInput.select2('val', '');
				nextInput.val('').trigger('change');
			}else{
				nextInput.addClass('disabled').prop('disabled',true).val('');
			}
		}
	});
}
function csiHardRefreshEventListener(pageResponse){
	var response = pageResponse;
	$('.refreshable').each(function(){
		csiTemplateCmpFetchTableContent ( $(this) );
	});
	$.each ( $('.auto-refreshable'), function(){
		if (undefined !== $(this).data('auto-refresh-timelapse') ){
			var element = $(this);
			var interval = setInterval(function(){
				if ( $.contains(window.document, element[0]) ){
					csiTemplateCmpFetchTableContent ( element );
				}else{
					clearInterval ( interval );
				}
			}, $(this).data('auto-refresh-timelapse') );
		}
	});
	csiSoftRefreshEventListener(response);
}
function csiCmpKeynoteOption( trigger ){
	var element = $(trigger);
	var parent = element.parent();
	var target = $( parent.find('.csi-cmp-keynote-option').data('keynote-target') );
	var tasks = [];
	element.closest('form').find('.csi-cmp-keynote-option').each( function(){
		if ( $(this).is(':checked') ){
			tasks.push ( $(this).prop('name') );
		}
	});
	target.data ( 'tasks', tasks );
	csiTemplateCmpFetchTableContent ( target );

}
function csiSelect2Format(option) {
    var opt = option.element;
	var response=$('<span class="csi-cmp-online-form-select"></span>');
	if ( undefined === $(opt).data('icon') ) {
		return option.text;
	}
	if ( undefined !== $(opt).data('icon') ) {
		response.append ( '<i class="' + $(opt).data('icon') + '"></i>&nbsp;' );
	}
	if ( undefined !== $(opt).data('txt-color') ) {
		response.css ( 'color', $(opt).data('color') );
	}
	if ( undefined !== $(opt).data('bg-color') ) {
		response.css ( 'background-color', $(opt).data('bg-color') );
	}
	response.append ( option.text );
	return response;
    //return '<span style="color:' + $(originalOption).data('color') + '"><i class="fa ' + $(originalOption).data('icon') + '"></i> ' + icon.text + '</span>';
}

});
