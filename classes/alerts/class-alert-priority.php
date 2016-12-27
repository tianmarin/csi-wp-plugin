<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_ALERT_PRIORITY_CLASS extends NOVIS_CSI_CLASS{

/**
* __construct
*
* Esta función es llamada apenas se crea la clase.
* Es utilizada para instanciar las diferentes clases con su información vital.
*
*
*
*/
public function __construct(){
	global $wpdb;
	global $novis_csi_vars;
	//como se definió en novis_csi_vars
	$this->class_name	= 'alert_priority';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Prioridad de Alerta';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Prioridades de Alerta';
	//Identificador de menú padre
	$this->parent_slug	= $novis_csi_vars['network_menu_slug'];
	//Identificador de submenú de la clase
	$this->menu_slug	= $novis_csi_vars[$this->class_name.'_menu_slug'];
	//Utilizadp para validaciones
	$this->plugin_post	= $novis_csi_vars['plugin_post'];
	//Permisos de usuario a nivel de backend WordPRess
	$this->capability	= $novis_csi_vars[$this->class_name.'_menu_cap'];
	//Tabla de la clase
	$this->tbl_name		= $novis_csi_vars[$this->class_name.'_tbl_name'];
	//Versión de DB (para registro y actualización automática)
	$this->db_version	= '0.1';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql	=	"CREATE TABLE ".$this->tbl_name." (
								id tinyint(2) unsigned not null auto_increment,
								short_name varchar(15) not null,
								icon varchar(50) null,
								css_class varchar(100) null,
								hex_color varchar(6) null,
								
								UNIQUE KEY id (id)
							) $charset_collate;";
	$this->db_fields	= array(
		/*	
		type					: Tipo de Dato para validacion
									- id
									- text
									- percentage
									- number
									- nat_number
									- timestamp
									- date
									- time
									- bool
									- radio
									- select
									- dual_id
		backend_wp_in_table		: Flag de mostrar el campo en las tablas de 
									true|false
		backend_wp_sp_table		: If true, 'sp_wp_table'+field_id function will be executed to show special content
		backend_wp_table_lead	: If true, 'Edit'button will be shown below field values in backend table
		form_disabled			: Show the field as a disabled or static input
									- false
									- disabled
									- static
		form_help_text			: Text showing guide to users
		form_input_size			: Form input size (bootstrap in form-group class)
									form-group-lg
									false
									form-group-sm
		form_label				: Label text
		form_options			: Value for options
									blank array()
									key => array(val,disabled)
		form_placeholder		: Placeholder for inputs
		form_special_form		: If true validates and execute a special function for form display (usually for select fields)
		form_show_field			: If false, field will be a 'hidden input'
									true|false
		data_required			: If true, form will not succed if field value is empty or 0
								  If true, 'insert' or 'update' evaluation will not succeed if field value is empty or 0
									true|false
		data_validation			: Check for specific values (javascript and PHP)
									true|alse
		data_validation_min		: Minumum numeric value
		data_validation_max		: Maximum numeric value
		data_validation_maxchar	: Maximum charcount for text inputs
		*/
		'id' => array(
			'type'						=>'id',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>'static',
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>'ID',
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'short_name' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>true,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>30,
			'form_disabled'				=>false,
			'form_help_text'			=>'Nombre corto para identificar el tipo de Sistema.<br/>Tama&ntilde;o m&aacute;ximo: 30 caracteres.',
			'form_input_size'			=>false,
			'form_label'				=>'Nombre Corto',
			'form_options'				=>false,
			'form_placeholder'			=>'Nombre Corto',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'icon' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>true,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'Nombre del icono a ser desplegado.<br/>Los nombres de iconos son parte de <a href="http://fontawesome.io/icons" target="_blank">FontAwesome</a> el nombre del icono debe ser sin el c&oacute;digo: <code>fa-</code>.',
			'form_input_size'			=>false,
			'form_label'				=>'Icono',
			'form_options'				=>false,
			'form_placeholder'			=>'Nombre del icono',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'css_class' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,	//It should be
			'backend_wp_sp_table'		=>false,	//It should be
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>100,
			'form_disabled'				=>false,
			'form_help_text'			=>'Estilo de Prioridad (<code>danger</code>, <code>warning</code>).<br/>Tama&ntilde;o m&aacute;ximo: 30 caracteres.',
			'form_input_size'			=>false,
			'form_label'				=>'Icono',
			'form_options'				=>false,
			'form_placeholder'			=>'Estilo CSS',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'hex_color' => array(
			'type'						=>'hex',
			'backend_wp_in_table'		=>false,	//It should be
			'backend_wp_sp_table'		=>false,	//It should be
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>6,
			'form_disabled'				=>false,
			'form_help_text'			=>'Color Hexadecimal.<br/>Tama&ntilde;o m&aacute;ximo: 6 caracteres.',
			'form_input_size'			=>false,
			'form_label'				=>'Color Hexadecimal',
			'form_options'				=>false,
			'form_placeholder'			=>'Color Hexadecimal',
			'form_special_form'			=>true,
			'form_show_field'			=>true,
		),
	);
	register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install'					));
	register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this, 'db_install_data'				));

//	if ( !is_multisite() ) {
//		add_action( 'admin_menu',		 						array( $this , "register_submenu_page"		));
//	}else{
//		add_action( 'network_admin_menu', 						array( $this , "register_submenu_page"		));
//	}
//	add_action( 'wp_ajax_search_system_users', 					array( $this , 'search_system_users'		));
//	add_action( 'wp_ajax_fe_system_list',						array( $this , 'fe_system_list'				));
//	add_action( 'wp_ajax_fe_system_info',						array( $this , 'fe_system_info'				));
//	add_action( 'wp_ajax_fe_quick_system_info',					array( $this , 'fe_quick_system_info'		));
//	add_action( 'wp_ajax_fe_system_show_form',					array( $this , 'fe_system_show_form'		));
//	add_action( 'wp_ajax_fe_create_system',						array( $this , 'fe_create_system'			));
}
protected function backend_wp_sp_table_icon($icon,$element){
	$style=self::get_single($element['id'])['css_class'];
	$style=($style!='')?'text-'.$style:'';
	$output='<i class="fa fa-'.$element['icon'].' fa-fw fa-lg '.$style.'"></i>';	
	return $output;
}
protected function form_special_form_hex_color($array){
	$output='';
	$output.='<div class="input-group">';
		$output.='<div class="input-group-addon" id="basic-addon2">#</div>';
		$output.='<input
					type="text"
					class="form-control"
					id="'.$array['id'].'"
					name="'.$array['id'].'"
					'.$array['form_placeholder'].'
					'.$array['data_validation'].'
					'.$array['data_validation_min'].'
					'.$array['data_validation_max'].'
					'.$array['data_validation_maxchar'].'
					'.$array['data_required'].'
					'.$array['value'].'
					data-target="#hex-color"
					data-function="hex-color"
					/>';
		$space='';
		for($i=0;$i<20;$i++){
			$space.='&nbsp;';
		}
		$output.='<div class="input-group-addon" id="hex-color">'.$space.'</div>';
	$output.='</div>';
	return $output;
}
protected function backend_wp_sp_table_code($code){
	return '<code>'.$code.'</code>';
}
public function db_install_data(){
	global $wpdb;
	$count =intval($wpdb->get_var( "SELECT COUNT(*) FROM ".$this->tbl_name));
	if($count == 0){
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'			=> 1,
				'short_name'	=> 'Critical',
				'icon'			=> 'exclamation-circle',
				'css_class'		=> 'danger',
				'hex_color'		=> 'a94442',
			) 
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'			=> 2,
				'short_name'	=> 'Warning',
				'icon'			=> 'exclamation-triangle',
				'css_class'		=> 'warning',
				'hex_color'		=> '8a6d3b',
			) 
		);
	}
}

//END OF CLASS	
}

global $NOVIS_CSI_ALERT_PRIORITY_CLASS;
$NOVIS_CSI_ALERT_PRIORITY_CLASS =new NOVIS_CSI_ALERT_PRIORITY_CLASS();
?>