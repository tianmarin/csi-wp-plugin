jQuery(document).ready(function($){var a=icsWPADMIN.ppost,t=icsWPADMIN.ajaxurl;window.console.log(a),window.console.log(t),$("form").submit(function(a){var t=!0;$(this).find(':input[type!="hidden"]').not(":input[type=button], :input[type=submit], :input[type=reset]").each(function(){$(this).data("required")===!0&&(""===$(this).val()||0===$(this).val())&&($(this).parent().parent().addClass("has-error"),t=!1),"true"===$(this).data("validation")&&($.isNumeric($(this).data("validation-min"))&&$(this).data("validation-min")>=$(this).val()&&($(this).parent().parent().addClass("has-warning"),t=!1),$.isNumeric($(this).data("validation-max"))&&$(this).data("validation-max")<=$(this).val()&&($(this).parent().parent().addClass("has-warning"),t=!1),$.isNumeric($(this).data("validation-maxchar"))&&$(this).data("validation-maxchar")<=$(this).length()&&($(this).parent().parent().addClass("has-warning"),t=!1))}),!0!==t&&a.preventDefault()})});