/*global icsWPADMIN*/
jQuery(document).ready(function($){
var ppost=icsWPADMIN.ppost;
var ajaxurl=icsWPADMIN.ajaxurl;

window.console.log(ppost);
window.console.log(ajaxurl);

$('form').submit(function(event){
	var required=true;
	$(this).find(':input[type!="hidden"]').not(':input[type=button], :input[type=submit], :input[type=reset]').each(function() {
		if ( $(this).data('required') === true ) {
			if ( $(this).val() === '' ||  $(this).val() === 0 ) {
				$(this).parent().parent().addClass('has-error');
				required=false;			
			}
		}
		if ( $(this).data('validation') === 'true' ) {
			if ( $.isNumeric( $(this).data('validation-min') ) ) {
				if ( $(this).data('validation-min') >= $(this).val() ) {
					$(this).parent().parent().addClass('has-warning');
					required=false;			
				}
			}
			if ( $.isNumeric( $(this).data('validation-max') ) ) {
				if ( $(this).data('validation-max') <= $(this).val() ) {
					$(this).parent().parent().addClass('has-warning');
					required=false;			
				}
			}
			if ( $.isNumeric( $(this).data('validation-maxchar') ) ) {
				if ( $(this).data('validation-maxchar') <= $(this).length() ) {
					$(this).parent().parent().addClass('has-warning');
					required=false;			
				}
			}
		}
	});
	if ( true !== required ) {
		event.preventDefault();
	}
});

});