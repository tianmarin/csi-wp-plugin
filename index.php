<?php
/*
Plugin Name: Continual Service Improvement
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: Poner algo interesante
Version:     0.5
Author:      Cristian Marin
Author URI:  https://github.com/tianmarin/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/



//http://www.onextrapixel.com/2013/01/08/how-to-properly-code-your-plugin-for-a-wordpress-multisite/
//best guide for multi site
defined('ABSPATH') or die("No script kiddies please!");

//require functions and config classes
//require_once("external/pagetemplater/pagetemplater.php");

global $wpdb;
//Global variable for Class, useful for accessing class functions as well as a global variable store
global $novis_csi_vars;

//define( 'CSI_PLUGIN_DIR', WP_PLUGIN_DIR."/CSI-wp-plugin/");
define( 'CSI_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'CSI_PLUGIN_URL', plugins_url( '' ,  __FILE__ ) );

$novis_csi_vars = array(
//Plugin Conf. Variables
	'DEBUG'										=> TRUE,
	'plugin_option_name'						=> 'csi_options',							//Plugin Option (Wordpress default) name
	'plugin_post'								=> 'Y21hcmlu',								//(base64_encode(cmarin) security 'from' request
	'plugin_shortcode'							=> 'csi',									//used by plugin association in shortcodes
	'table_prefix'								=>'z_csi_',
//DATABASE TABLES
	'customer'						."_network_class"	=> TRUE,
	'country'						."_network_class"	=> TRUE,
	'user'							."_network_class"	=> TRUE,
	'user_team'						."_network_class"	=> TRUE,
	##Service Catalog Module
	'service'						."_network_class"	=> TRUE,
	##Landscape Module
	'sapcustno'						."_network_class"	=> TRUE,
	'customer_system_environment'	."_network_class"	=> TRUE,
	'customer_system'				."_network_class"	=> TRUE,
	##EWA Module
	'ewa_alert_action_party'		."_network_class"	=> TRUE,
	'ewa_alert_priority'			."_network_class"	=> TRUE,
	'ewa_alert_rating'				."_network_class"	=> TRUE,
	'ewa_alert'						."_network_class"	=> TRUE,
	'ewa_rating'					."_network_class"	=> TRUE,
	'ewa_status'					."_network_class"	=> TRUE,
	'ewa'							."_network_class"	=> TRUE,
	##Project Management Module
	'project_urgency'				."_network_class"	=> TRUE,
	'project_status'				."_network_class"	=> TRUE,
	'project'						."_network_class"	=> TRUE,
	##Change MAnagement Module
	'cmp'							."_network_class"	=> TRUE,
	'cmp_task'						."_network_class"	=> TRUE,
	'cmp_task_doc'					."_network_class"	=> TRUE,
	'cmp_task_type'					."_network_class"	=> TRUE,
	'cmp_task_status'				."_network_class"	=> TRUE,
	'cmp_task_step'					."_network_class"	=> TRUE,
	'cmp_task_step_type'			."_network_class"	=> TRUE,

//MENU SLUGS
	'main'							."_menu_slug"	=> 'csi_'		.'main',
	'network'						."_menu_slug"	=> 'csi_'		.'network',
	'customer'						."_menu_slug"	=> 'csi_'		.'customer',
	'country'						."_menu_slug"	=> 'csi_'		.'country',
	'user'							."_menu_slug"	=> 'csi_'		.'user_team',
	'user_team'						."_menu_slug"	=> 'csi_'		.'user_team',
	##Service Catalog Module
	'service'						."_menu_slug"	=> 'csi_'		.'service',
	##Landscape Module
	'sapcustno'						."_menu_slug"	=> 'csi_'		.'sapcustno',
	'customer_system_environment'	."_menu_slug"	=> 'csi_'		.'customer_system_environment',
	'customer_system'				."_menu_slug"	=> 'csi_'		.'customer_system',
	##EWA Module
	'ewa_alert_action_party'		."_menu_slug"	=> 'csi_'		.'ewa_alert_action_party',
	'ewa_alert_priority'			."_menu_slug"	=> 'csi_'		.'ewa_alert_priority',
	'ewa_alert_rating'				."_menu_slug"	=> 'csi_'		.'ewa_alert_rating',
	'ewa_alert'						."_menu_slug"	=> 'csi_'		.'ewa_alert',
	'ewa_rating'					."_menu_slug"	=> 'csi_'		.'ewa_rating',
	'ewa_status'					."_menu_slug"	=> 'csi_'		.'ewa_status',
	'ewa'							."_menu_slug"	=> 'csi_'		.'ewa',
	##Project Management Module
	'project_status'				."_menu_slug"	=> 'csi_'		.'project_status',
	'project_urgency'				."_menu_slug"	=> 'csi_'		.'project_urgency',
	'project'						."_menu_slug"	=> 'csi_'		.'project',
	##Change Management Module
	'cmp'							."_menu_slug"	=> 'csi_'		.'cmp',
	'cmp_task'						."_menu_slug"	=> 'csi_'		.'cmp_task',
	'cmp_task_doc'					."_menu_slug"	=> 'csi_'		.'cmp_task_doc',
	'cmp_task_type'					."_menu_slug"	=> 'csi_'		.'cmp_task_type',
	'cmp_task_status'				."_menu_slug"	=> 'csi_'		.'cmp_task_status',
	'cmp_task_step'					."_menu_slug"	=> 'csi_'		.'cmp_task_step',
	'cmp_task_step_type'			."_menu_slug"	=> 'csi_'		.'cmp_task_step_type',

//MENU CAPABILITIES
	'main'							."_menu_cap"		=> 'manage_options',
	'network'						."_menu_cap"		=> 'manage_options',
	'customer'						."_menu_cap"		=> 'manage_options',
	'country'						."_menu_cap"		=> 'manage_options',
	'user'							."_menu_cap"		=> 'manage_options',
	'user_team'						."_menu_cap"		=> 'manage_options',
	##Service Catalog Module
	'service'						."_menu_cap"		=> 'manage_options',
	##Landscape Module
	'sapcustno'						."_menu_cap"		=> 'manage_options',
	'customer_system_environment'	."_menu_cap"		=> 'manage_options',
	'customer_system'				."_menu_cap"		=> 'manage_options',
	##EWA Module
	'ewa_alert_action_party'		."_menu_cap"		=> 'manage_options',
	'ewa_alert_priority'			."_menu_cap"		=> is_multisite()?'manage_network':'manage_options',
	'ewa_alert_rating'				."_menu_cap"		=> 'manage_options',
	'ewa_alert'						."_menu_cap"		=> 'manage_options',
	'ewa_rating'					."_menu_cap"		=> 'manage_options',
	'ewa_status'					."_menu_cap"		=> 'manage_options',
	'ewa'							."_menu_cap"		=> 'manage_options',
	##Project Management Module
	'project_status'				."_menu_cap"		=> 'manage_options',
	'project_urgency'				."_menu_cap"		=> 'manage_options',
	'project'						."_menu_cap"		=> 'manage_options',
	##Change MAnagement Module
	'cmp'							."_menu_cap"		=> 'manage_options',
	'cmp_task'						."_menu_cap"		=> 'manage_options',
	'cmp_task_doc'					."_menu_cap"		=> 'manage_options',
	'cmp_task_type'					."_menu_cap"		=> 'manage_options',
	'cmp_task_status'				."_menu_cap"		=> 'manage_options',
	'cmp_task_step'					."_menu_cap"		=> 'manage_options',
	'cmp_task_step_type'			."_menu_cap"		=> 'manage_options',
);





//---------------------------------------------------------------------------------------------------------------------------------------------------------
//if($csi_vars['DEBUG']):
//	define( 'DIEONDBERROR', true );
//endif;




//---------------------------------------------------------------------------------------------------------------------------------------------------------
/**
* Registra el estilo (CSS) de adminsitración en el backend de WordPress
*
*/
add_action( 'admin_menu', 'csi_register_admin_style' );
function csi_register_admin_style(){
	wp_register_style('csi_admin_style', plugins_url('css/admin.css', __FILE__) );
	wp_enqueue_style('csi_admin_style');
}
/**
* Registra el menú básico de Adminsitración en el backend de WordPress
*
*/
if( !is_multisite() ) {
	add_action( 'admin_menu', 'csi_register_network_menu' );

}else{
	add_action( 'network_admin_menu', 'csi_register_network_menu' );
}
function csi_register_network_menu(){
	global $novis_csi_vars;
	$page_title	="CSI Network";
	$menu_title	="CSI Network";
	$capability	=$novis_csi_vars['network_menu_cap'];
	$menu_slug	=$novis_csi_vars['network_menu_slug'];
	$function	="csi_network_menu";
	$icon_url	='dashicons-admin-multisite';
	$icon_url	='dashicons-products';
	$position	="102";
	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}

add_action( 'admin_menu', 'csi_register_main_menu' );
function csi_register_main_menu(){
	global $novis_csi_vars;
	$page_title	="CSI";
	$menu_title	="CSI";
	$capability	=$novis_csi_vars['main_menu_cap'];
	$menu_slug	=$novis_csi_vars['main_menu_slug'];
	$function	="csi_main_menu";
	$icon_url	='dashicons-admin-generic';
	$position	="103";
	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}

/**
* Despliega el menú básico de Adminsitración en el backend de WordPress
*
*/
function csi_network_menu() {
	echo '<div class="wrap">';
	echo '<h2>NETWORK</h2>';
//	require_once("intro.php");
	echo '</div>';
}
/**
* Despliega el menú básico de Adminsitración en el backend de WordPress
*
*/
function csi_main_menu() {
	echo '<div class="wrap">';
	echo '<h2>Menú Iincial</h2>';
//	require_once("intro.php");
	echo '</div>';
}
add_action( 'wp_enqueue_scripts', 'csi_enqueue_external_scripts', 1);

function csi_enqueue_external_scripts() {
/*
	wp_register_script(
		'bootstrap',
		CSI_PLUGIN_URL.'/bower_components/bootstrap/dist/js/bootstrap.js' ,
		array('jquery'),
		'3.3.7'
	);
*/
/*
	wp_register_script(
		'amcharts',
		CSI_PLUGIN_URL.'/external/amcharts/amcharts/amcharts.js' ,
		array('jquery'),
		'1.1.2'
	);
*/
	wp_register_script(
		'amcharts',
		CSI_PLUGIN_URL.'/bower_components/amcharts3/amcharts/amcharts.js' ,
		array('jquery'),
		'1.1.2'
	);
	wp_register_script(
		'amcharts-serial',
		CSI_PLUGIN_URL.'/bower_components/amcharts3/amcharts/serial.js' ,
		array('amcharts'),
		'1.1.2'
	);
	wp_register_script(
		'amcharts-pie',
		CSI_PLUGIN_URL.'/bower_components/amcharts3/amcharts/pie.js' ,
		array('amcharts'),
		'1.1.2'
	);
	wp_register_script(
		'amcharts-gauge',
		CSI_PLUGIN_URL.'/bower_components/amcharts3/amcharts/gauge.js' ,
		array('amcharts'),
		'1.1.2'
	);
	wp_register_script(
		'amcharts-responsive',
		CSI_PLUGIN_URL.'/bower_components/amcharts3/amcharts/plugins/responsive/responsive.min.js' ,
		array('amcharts'),
		'1.1.2'
	);
	wp_register_script(
		'amcharts-light',
		CSI_PLUGIN_URL.'/bower_components/amcharts3/amcharts/themes/light.js' ,
		array('amcharts'),
		'1.1.2'
	);
	wp_register_script(
		'amcharts-chalk',
		CSI_PLUGIN_URL.'/bower_components/amcharts3/amcharts/themes/chalk.js' ,
		array('amcharts'),
		'1.1.2'
	);
	wp_register_script(
		'amcharts-dark',
		CSI_PLUGIN_URL.'/bower_components/amcharts3/amcharts/themes/dark.js' ,
		array('amcharts'),
		'1.1.2'
	);
	wp_register_script(
		'amcharts-patterns',
		CSI_PLUGIN_URL.'/bower_components/amcharts3/amcharts/themes/patterns.js' ,
		array('amcharts'),
		'1.1.2'
	);
	wp_register_script(
		'amcharts-black',
		CSI_PLUGIN_URL.'/bower_components/amcharts3/amcharts/themes/black.js' ,
		array('amcharts'),
		'1.1.2'
	);
/*	wp_register_script(
		'jquery-confirm',
		CSI_PLUGIN_URL.'/bower_components/jquery-confirm2/dist/jquery-confirm.min.js' ,
		array('jquery'),
		'3.0.3'
	);
*/	wp_register_script(
		'raphael',
		CSI_PLUGIN_URL.'/external/justgage/raphael-2.1.4.min.js' ,
		array(),
		'2.1.4'
	);
	wp_register_script(
		'justgage',
		CSI_PLUGIN_URL.'/external/justgage/justgage.js' ,
		array('raphael'),
		'1.2.2'
	);
	wp_register_script(
		'momentjs',
		CSI_PLUGIN_URL.'/bower_components/moment/moment.js' ,
		array(),
		'2.17.1'
	);
	wp_register_script(
		'daterangepicker',
		CSI_PLUGIN_URL.'/bower_components/bootstrap-daterangepicker/daterangepicker.js' ,
		array('bootstrap','momentjs'),
		'2.1.25'
	);
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------
# Parent Class
require_once(CSI_PLUGIN_DIR."/classes/class-base.php");

# Extended Classes
## Cross Module Classes
require_once(CSI_PLUGIN_DIR."/classes/system-wide/class-country.php");
require_once(CSI_PLUGIN_DIR."/classes/system-wide/class-user-team.php");
require_once(CSI_PLUGIN_DIR."/classes/system-wide/class-user.php");
require_once(CSI_PLUGIN_DIR."/classes/system-wide/class-customer.php");
##Service Catalog Module Classes
require_once(CSI_PLUGIN_DIR."/classes/service-catalog/class-service.php");
## Landscape Module Classes
require_once(CSI_PLUGIN_DIR."/classes/landscape/class-sapcustno.php");
require_once(CSI_PLUGIN_DIR."/classes/landscape/class-customer-system-environment.php");
require_once(CSI_PLUGIN_DIR."/classes/landscape/class-customer-system.php");
## Alert Module Classes
require_once(CSI_PLUGIN_DIR."/classes/ewa-management/class-ewa-alert-action-party.php");
require_once(CSI_PLUGIN_DIR."/classes/ewa-management/class-ewa-alert-priority.php");
require_once(CSI_PLUGIN_DIR."/classes/ewa-management/class-ewa-alert-rating.php");
require_once(CSI_PLUGIN_DIR."/classes/ewa-management/class-ewa-alert.php");
require_once(CSI_PLUGIN_DIR."/classes/ewa-management/class-ewa-rating.php");
require_once(CSI_PLUGIN_DIR."/classes/ewa-management/class-ewa-status.php");
require_once(CSI_PLUGIN_DIR."/classes/ewa-management/class-ewa.php");
## Change Management Module Classes
require_once(CSI_PLUGIN_DIR."/classes/change-management/class-cmp-task-step-type.php");
require_once(CSI_PLUGIN_DIR."/classes/change-management/class-cmp-task-step.php");
require_once(CSI_PLUGIN_DIR."/classes/change-management/class-cmp-task-type.php");
require_once(CSI_PLUGIN_DIR."/classes/change-management/class-cmp-task-status.php");
require_once(CSI_PLUGIN_DIR."/classes/change-management/class-cmp-task-doc.php");
require_once(CSI_PLUGIN_DIR."/classes/change-management/class-cmp-task.php");
require_once(CSI_PLUGIN_DIR."/classes/change-management/class-cmp.php");

require_once(CSI_PLUGIN_DIR."/classes/project-management/class-project-status.php");
require_once(CSI_PLUGIN_DIR."/classes/project-management/class-project-urgency.php");
require_once(CSI_PLUGIN_DIR."/classes/project-management/class-project.php");

##External Classes
require_once(CSI_PLUGIN_DIR."/pagetemplater.php");
?>
