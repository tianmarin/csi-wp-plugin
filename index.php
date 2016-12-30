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
	'DEBUG'								=> TRUE,
	'plugin_option_name'				=> 'csi_options',							//Plugin Option (Wordpress default) name
	'plugin_post'						=> 'Y21hcmlu',								//(base64_encode(cmarin) security 'from' request
	'plugin_shortcode'					=> 'aa',									//used by plugin association in shortcodes
	
// ALERTS
	'action_party'			."_tbl_name"	=> $wpdb->prefix		.'z_csi_'	.'action_party',
	'alert_priority'		."_tbl_name"	=> $wpdb->base_prefix	.'z_csi_'	.'alert_priority',
	'alert'					."_tbl_name"	=> $wpdb->prefix		.'z_csi_'	.'alert',
//	'customer'				."_tbl_name"	=> $wpdb->base_prefix	.'z_csi_'	.'customer',
//Menu Slugs
	'main'					."_menu_slug"	=> 'csi_'		.'main',
	'network'				."_menu_slug"	=> 'csi_'		.'network',
	'action_party'			."_menu_slug"	=> 'csi_'		.'action_party',
	'alert_priority'		."_menu_slug"	=> 'csi_'		.'alert_priority',
	'alert'					."_menu_slug"	=> 'csi_'		.'alert',
//Menu Capabilities
	'main'					."_menu_cap"		=> 'manage_options',
	'network'				."_menu_cap"		=> 'manage_options',
	'action_party'			."_menu_cap"		=> 'manage_options',
	'alert_priority'		."_menu_cap"		=> 'manage_options',
	'alert'					."_menu_cap"		=> 'manage_options',
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
//---------------------------------------------------------------------------------------------------------------------------------------------------------
# Parent Class
require_once(CSI_PLUGIN_DIR."/classes/class-base.php");

# Extended Classes
## Cross Module Classes
## Landscape Module Classes
## Alert Module Classes
require_once(CSI_PLUGIN_DIR."/classes/alerts/class-action-party.php");
require_once(CSI_PLUGIN_DIR."/classes/alerts/class-alert-priority.php");
require_once(CSI_PLUGIN_DIR."/classes/alerts/class-alert.php");

?>