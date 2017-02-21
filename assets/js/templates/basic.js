/*
Script Name: Shortcode EWA Control Center
Dependencies: jquery, bootstrap, amcharts, amcharts-serial, amcharts-responsive, amcharts-pie
*/
/*global document*/
/*global csiTemplateScript*/
/*global FormData*/
/*global jconfirm*/
jQuery(document).ready(function($){
/*
* Global Variables
*/
var cmpMainContent = $('#csi-template-cmp-control-center-main');
var ajaxPages={
    'intro'     :   'csi_cmp_build_page_intro',
	'listplans'	:	'csi_cmp_build_page_list_plans',
	'addplan'	:	'csi_cmp_build_page_new_plan_form',
    'showplan'  :   'csi_cmp_build_page_show_plan',
    'addtask'   :   'csi_cmp_build_page_new_task_form',
};

var changeHash = function ( nextPage ) {
	if ( undefined !== nextPage &&  '' !== nextPage ){
		window.location.hash='#!' + nextPage;
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
    var getRegEx = /(\w+=\w+)+/g;
    var GET=[];
    if ( getRegEx.test(window.location.hash) ){
        $.each( window.location.hash.match( getRegEx ), function ( key, val ) {
            var parameter = val.split('=');
            GET[parameter[0]] = parameter[1];
        });
    }else{
        GET = null;
    }
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
//    console.log ( 'Llamando a pagina : ' + ajaxPages[hash] + '(' + hash + ')');
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
			var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
			cmpMainContent.addClass('quick-animated ' + 'fadeOutDown').one(animationEnd, function() {
				$('html, body').animate({ scrollTop: 0 }, 'slow');
				$(this).removeClass('quick-animated ' + 'fadeOutDown');
				$(this).html(response.message);
				csiRefreshEventListener();
				cmpMainContent.addClass('quick-animated ' + 'fadeInUp').one(animationEnd, function() {
					$(this).removeClass('quick-animated ' + 'fadeInUp');
				});
			});
		},
		error: aaAjaxError,
	});
}
function csiTemplateCmpFetchTableContent( tableSelector ){
    var table = tableSelector;
    var data = new FormData();
    $.each(table.data(),function(index,val){
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
            table.addClass('ajax-loading');
        },
        success: function(response){
            setTimeout(function(){
    			table.removeClass('ajax-loading');
    		}, 500);
        //    console.log ( response );
            if ( 0 === response ){
                //console.log ( table.data('refresh-action') );
            }else{
                if ( 'TABLE' === table.prop("tagName") ){
                    table.find('tbody').html(response.tbody);
                }else{
                    table.html('');
                    table.append(response.tbody);
                }
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
                }
            }
        },
        error: aaAjaxError,
    });
}

function csiRefreshEventListener(){
	$('[type="reset"]').click(function(event){
		event.preventDefault();
		window.history.back();
	});

    $.each ( $('.refreshable'), function(){
        csiTemplateCmpFetchTableContent ( $(this) );
    });
    $('.refresh-button').click( function(event){
        event.preventDefault();
        csiTemplateCmpFetchTableContent ( $('#' + $(this).attr('href').replace( '#', '') ) );
        //console.log( e );
    });
    $('.user-data').click( function(event){
        event.preventDefault();
        csiTemplateCmpFetchUserData( $(this).data('user-id') );
    });
	$('.select2').select2({
		tokenSeparators: [',', ' '],
	});
	$('form').submit(function(){
		var form = $(this);
		console.log ( $(this).data('next-page') );
		var data = new FormData();
		data.append('action', form.data('function'));
		$(this).find('input, select, textarea, checkbox').each(function(){
			data.append($(this).attr('name'),$(this).val());
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
				form.addClass('ajax-loading');
			},
			success: function(response){
				form.removeClass('ajax-loading');
				console.log ( response );
				if ( 0 === response ){
					aaAjaxError();
				}else{
                    if ( undefined !== response.error){
                        //error al crear plan
    				}else{
                        //plan creado correctamente
                    }

                    if ( undefined !== response.notification ) {
                        switch ( response.postSubmitAction ){
                            case 'changeHash':
                                if ( undefined === response.notifStopNextPage ){
                                    //http://stackoverflow.com/a/34567019/5129222
                                    response.notification.onClose = changeHash.bind(null,form.data('next-page') );
                                }
                                break;
                                default:
                                    response.notification.onClose = function(){};
                        }
                        jconfirm ( response.notification );
                    }// response.notification
                }
			},
			error: aaAjaxError,
		});
		return false;
	});

}



});
