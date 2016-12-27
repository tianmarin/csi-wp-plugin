<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_ALERT_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'alert';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Alertas';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Alertas';
	//Identificador de menú padre
	$this->parent_slug	= $novis_csi_vars['main_menu_slug'];
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
								id int(4) unsigned not null auto_increment,
								system_id int(4) unsigned not null,
								alert_priority_id tinyint(2) unsigned not null,
								issued_date date not null,
								last_modified_user_id bigint(20) unsigned null,
								last_modified_date date null,
								alert_message tinytext not null,
								action_party_id tinyint(2) unsigned null,
								action_id varchar(50) null
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
		'system_id' => array(
			'type'						=>'select',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'ID del sistema en el cual se gener&oacute; la alerta',
			'form_input_size'			=>false,
			'form_label'				=>'Identificador de Sistema',
			'form_options'				=>false,
			'form_placeholder'			=>'Identificador de Sistema',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'alert_priority_id' => array(
			'type'						=>'select',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'ID de la prioridad de la alerta',
			'form_input_size'			=>false,
			'form_label'				=>'Identificador de Prioridad de Alerta',
			'form_options'				=>false,
			'form_placeholder'			=>'Identificador de Prioridad de Alerta',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'issued_date' => array(
			'type'						=>'date',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'Fecha en la cual se gener&oacute; la alerta',
			'form_input_size'			=>false,
			'form_label'				=>'Fecha de generaci&oacute;n',
			'form_options'				=>false,
			'form_placeholder'			=>'Fecha de generaci&oacute;n',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'last_modified_user_id' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'ID del usuario modificador',
			'form_input_size'			=>false,
			'form_label'				=>'ID de usuario modificador',
			'form_options'				=>false,
			'form_placeholder'			=>'ID de usuario modificador',
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'last_modified_date' => array(
			'type'						=>'date',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'Fecha de &uacute;ltima modificaci&oacute;n',
			'form_input_size'			=>false,
			'form_label'				=>'Fecha de &uacute;ltima modificaci&oacute;',
			'form_options'				=>false,
			'form_placeholder'			=>'Fecha de &uacute;ltima modificaci&oacute;',
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'alert_message' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'Mensaje de Error',
			'form_input_size'			=>false,
			'form_label'				=>'Mensaje de Error',
			'form_options'				=>false,
			'form_placeholder'			=>'Mensaje de Error',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'action_party_id' => array(
			'type'						=>'select',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'Identificador del Sistema de Ticket',
			'form_input_size'			=>false,
			'form_label'				=>'ID del Sistema de Ticket',
			'form_options'				=>false,
			'form_placeholder'			=>'ID del Sistema de Ticket',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'action_id' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>50,
			'form_disabled'				=>false,
			'form_help_text'			=>'Identificador del Ticket',
			'form_input_size'			=>false,
			'form_label'				=>'ID del Ticket',
			'form_options'				=>false,
			'form_placeholder'			=>'ID del Ticket',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
	);
	
	register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install'					));
}
//END OF CLASS	
}

global $NOVIS_CSI_ALERT;
$NOVIS_CSI_ALERT =new NOVIS_CSI_ALERT_CLASS();
?>