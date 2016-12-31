<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_PROJECT_STATUS_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'project_status';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Estado de Proyecto';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Estados de Proyecto';
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
	$this->db_version	= '0.2';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql	=	"CREATE TABLE ".$this->tbl_name." (
								id tinyint(2) unsigned not null auto_increment,
								short_name varchar(50) not null,
								code varchar(20) not null,
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
			'backend_wp_sp_table'		=>true,
			'backend_wp_table_lead'		=>true,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>50,
			'form_disabled'				=>false,
			'form_help_text'			=>'Nombre Corto.<br/>Tama&ntilde;o m&aacute;ximo: 50 caracteres.',
			'form_input_size'			=>false,
			'form_label'				=>'Nombre Corto',
			'form_options'				=>false,
			'form_placeholder'			=>'Nombre Corto',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'code' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>true,		//Show as <code></code>
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>30,
			'form_disabled'				=>false,
			'form_help_text'			=>'C&oacute;digo.<br/>Tama&ntilde;o m&aacute;ximo: 20 caracteres.',
			'form_input_size'			=>false,
			'form_label'				=>'C&oacute;digo',
			'form_options'				=>false,
			'form_placeholder'			=>'C&oacute;digo',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'css_class' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
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
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
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

	if ( !is_multisite() ) {
		add_action( 'admin_menu',		 						array( $this , "register_submenu_page"		));
	}else{
		add_action( 'network_admin_menu', 						array( $this , "register_submenu_page"		));
	}
//	add_action( 'wp_ajax_search_system_users', 					array( $this , 'search_system_users'		));
//	add_action( 'wp_ajax_fe_system_list',						array( $this , 'fe_system_list'				));
//	add_action( 'wp_ajax_fe_system_info',						array( $this , 'fe_system_info'				));
//	add_action( 'wp_ajax_fe_quick_system_info',					array( $this , 'fe_quick_system_info'		));
//	add_action( 'wp_ajax_fe_system_show_form',					array( $this , 'fe_system_show_form'		));
//	add_action( 'wp_ajax_fe_create_system',						array( $this , 'fe_create_system'			));
}
protected function backend_wp_sp_table_code($code){
	return '<code>'.$code.'</code>';
}
protected function backend_wp_sp_table_short_name($text,$element){
	$element=self::get_single($element['id']);
	$text = '<p class="bg-'.$element['css_class'].' text-'.$element['css_class'].'">'.$text.'</p>';
	return $text;
//	return '<code>'.$code.'</code>';
}
public function db_install_data(){
	global $wpdb;
	$count =intval($wpdb->get_var( "SELECT COUNT(*) FROM ".$this->tbl_name));
	if ( $count != 0){
		$delete = "DELETE FROM ".$this->tbl_name;
		self::get_sql($delete);
	}
	$wpdb->insert(
		$this->tbl_name,
		array(
			'id'			=> 1,
			'short_name'	=> 'Revisi&oacute;n PMO',
			'code'			=> 'revision',
			'css_class'		=> 'info',
			'hex_color'		=> 'a94442',
		) 
	);
	$wpdb->insert(
		$this->tbl_name,
		array(
			'id'			=> 2,
			'short_name'	=> 'Rechazado',
			'code'			=> 'rejected',
			'css_class'		=> 'danger',
			'hex_color'		=> 'a94442',
		) 
	);
	$wpdb->insert(
		$this->tbl_name,
		array(
			'id'			=> 3,
			'short_name'	=> 'Planificado',
			'code'			=> 'planned',
			'css_class'		=> 'primary',
			'hex_color'		=> 'a94442',
		) 
	);
	$wpdb->insert(
		$this->tbl_name,
		array(
			'id'			=> 4,
			'short_name'	=> 'En Ejecuci&oacute;n',
			'code'			=> 'executing',
			'css_class'		=> 'warning',
			'hex_color'		=> 'a94442',
		) 
	);
	$wpdb->insert(
		$this->tbl_name,
		array(
			'id'			=> 5,
			'short_name'	=> 'Cancelado',
			'code'			=> 'cancelled',
			'css_class'		=> 'default',
			'hex_color'		=> 'a94442',
		) 
	);
	$wpdb->insert(
		$this->tbl_name,
		array(
			'id'			=> 6,
			'short_name'	=> 'Finalizado',
			'code'			=> 'finished',
			'css_class'		=> 'success',
			'hex_color'		=> 'a94442',
		) 
	);
}

//END OF CLASS	
}

global $NOVIS_CSI_PROJECT_STATUS;
$NOVIS_CSI_PROJECT_STATUS =new NOVIS_CSI_PROJECT_STATUS_CLASS();
?>