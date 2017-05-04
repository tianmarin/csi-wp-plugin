<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_PROJECT_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'project';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Proyecto';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Proyecto';
	//Identificador de menú padre
	$this->parent_slug	= $novis_csi_vars['network_menu_slug'];
	//Identificador de submenú de la clase
	$this->menu_slug	= $novis_csi_vars[$this->class_name.'_menu_slug'];
	//Utilizadp para validaciones
	$this->plugin_post	= $novis_csi_vars['plugin_post'];
	//Permisos de usuario a nivel de backend WordPRess
	$this->capability	= $novis_csi_vars[$this->class_name.'_menu_cap'];
	//Network Activated Class
	$this->network_class= $novis_csi_vars[$this->class_name.'_network_class'];
	//Plugintable_prefix
	$this->table_prefix=$novis_csi_vars['table_prefix'];
	//Tabla de la clase
	if( true == $this->network_class ){
		$this->tbl_name = $wpdb->base_prefix	.$this->table_prefix	.$this->class_name;
	}else{
		$this->tbl_name = $wpdb->prefix			.$this->table_prefix	.$this->class_name;
	}
	//Versión de DB (para registro y actualización automática)
	$this->db_version	= '0.0.8';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="
		(
			id bigint(20) unsigned not null auto_increment,
			registered_customer_flag tinyint(1) unsigned null COMMENT 'Indicates if customer is already registered',
			registered_customer_id bigint unsigned null COMMENT 'Customer Id',
			non_registered_customer_name varchar(50) null COMMENT 'Name of unregistered customer',
			short_name varchar(100) not null,
			description text null,
			scope text null,
			capacity text null,
			planned_start_date date null,
			planned_end_date date null,
			status_id tinyint(2) unsigned not null,
			phase_id tinyint(2) unsigned not null,
			plan_percentage tinyint(2) unsigned not null DEFAULT '0',
			real_percentage tinyint(2) unsigned not null DEFAULT '0',
			pm_user_id bigint(20) unsigned null COMMENT 'Id of user for Project Manager',
			tl_user_id bigint(20) unsigned null COMMENT 'Id of user for Technical Leader',
			doc_link varchar(255) null,
			plan_link varchar(255) null,
			creation_user_id bigint(20) unsigned null COMMENT 'Id of user responsible of the creation of each record',
			creation_user_email varchar(100) null COMMENT 'Email of user. Used to track user if user id is deleted',
			creation_datetime datetime null COMMENT 'Date of the creation of this record',
			last_modified_user_id bigint(20) unsigned null COMMENT 'Id of user responsible of the last modification of this record',
			last_modified_user_email varchar(100) null COMMENT 'Email of user. Used to track user if user id is deleted',
			last_modified_datetime datetime null COMMENT 'Date and Time of the last modification of this record',

			UNIQUE KEY id (id)
		) $charset_collate;";
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql	=	"CREATE TABLE ".$this->tbl_name." ".$this->crt_tbl_sql_wt;
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
			'user_input'				=>false,
		),
		'customer_id' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>true,
			'backend_wp_table_lead'		=>true,
			'data_required'				=>false,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>'disabled',
			'form_help_text'			=>"El ID de Cliente debe ser desplegado de la lista actual. Por ahora está deshabilitado",
			'form_input_size'			=>false,
			'form_label'				=>'Cliente',
			'form_options'				=>false,
			'form_placeholder'			=>'Cliente',
			'form_special_form'			=>false,
			'form_show_field'			=>false,
			'user_input'				=>true,
		),
		'customer_name' => array(
			'type'						=>'select',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>true,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>50,
			'form_disabled'				=>false,
			'form_help_text'			=>'En el caso que el cliente no esté registrado, indicar el nombre del cliente para el cual se solicita el Proyecto.<br/>Tama&ntilde;o m&aacute;ximo: 50 caracteres.',
			'form_input_size'			=>false,
			'form_label'				=>'Nombre de Cliente',
			'form_options'				=>array(),
			'form_placeholder'			=>'Nombre de Cliente',
			'form_special_form'			=>true,
			'form_show_field'			=>true,
			'user_input'				=>true,
		),
		'short_name' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>100,
			'form_disabled'				=>false,
			'form_help_text'			=>"Indicar el nombre descriptivo del Proyecto.<br/>Tama&ntilde;o m&aacute;ximo: 100 caracteres",
			'form_input_size'			=>false,
			'form_label'				=>'Nombre del Proyecto',
			'form_options'				=>false,
			'form_placeholder'			=>'Nombre del Proyecto',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
			'user_input'				=>true,
		),
		'description' => array(
			'type'						=>'textarea',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Indicar el detalle del Proyecto solicitado.",
			'form_input_size'			=>false,
			'form_label'				=>'Descripci&oacute;n del Proyecto',
			'form_options'				=>false,
			'form_placeholder'			=>'Descripci&oacute;n del Proyecto',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
			'user_input'				=>true,
		),
		'requested_user_id' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Identificador de usuario solicitante.",
			'form_input_size'			=>false,
			'form_label'				=>"Solicitante.",
			'form_options'				=>false,
			'form_placeholder'			=>"Solicitante.",
			'form_special_form'			=>true,
			'form_show_field'			=>false,
			'user_input'				=>false,
		),
		'requested_date' => array(
			'type'						=>'date',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Fecha de Solicitud.",
			'form_input_size'			=>false,
			'form_label'				=>"Fecha de Solicitud.",
			'form_options'				=>false,
			'form_placeholder'			=>"Fecha de Solicitud.",
			'form_special_form'			=>false,
			'form_show_field'			=>false,
			'user_input'				=>false,
		),
		'requested_time' => array(
			'type'						=>'timestamp',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Hora de Solicitud.",
			'form_input_size'			=>false,
			'form_label'				=>"Hora de Solicitud.",
			'form_options'				=>false,
			'form_placeholder'			=>"Hora de Solicitud.",
			'form_special_form'			=>false,
			'form_show_field'			=>false,
			'user_input'				=>false,
		),
		'requested_start_date' => array(
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
			'form_help_text'			=>"Fecha estimada de inicio del Proyecto.",
			'form_input_size'			=>false,
			'form_label'				=>"Fecha estimada de inicio del Proyecto.",
			'form_options'				=>false,
			'form_placeholder'			=>"Fecha estimada de inicio del Proyecto.",
			'form_special_form'			=>false,
			'form_show_field'			=>false,
			'user_input'				=>true,
		),
		'requested_end_date' => array(
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
			'form_help_text'			=>"Fecha estimada de finalizaci&oacute;n o cierre del Proyecto.",
			'form_input_size'			=>false,
			'form_label'				=>"Fecha estimada de fin del Proyecto.",
			'form_options'				=>false,
			'form_placeholder'			=>"Fecha estimada de fin del Proyecto.",
			'form_special_form'			=>false,
			'form_show_field'			=>false,
			'user_input'				=>true,
		),
		'requested_urgency_id' => array(
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
			'form_help_text'			=>"Urgencia del Proyecto",
			'form_input_size'			=>false,
			'form_label'				=>"Urgencia del Proyecto",
			'form_options'				=>array(),
			'form_placeholder'			=>"Urgencia del Proyecto",
			'form_special_form'			=>false,
			'form_show_field'			=>true,
			'user_input'				=>true,
		),
		'status_id' => array(
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
			'form_help_text'			=>"Status del Proyecto",
			'form_input_size'			=>false,
			'form_label'				=>"Status del Proyecto",
			'form_options'				=>array(),
			'form_placeholder'			=>"Status del Proyecto",
			'form_special_form'			=>true,
			'form_show_field'			=>false,
			'user_input'				=>false,
		),
		'planned_start_date' => array(
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
			'form_help_text'			=>"Fecha real de inicio del Proyecto.",
			'form_input_size'			=>false,
			'form_label'				=>"Fecha real de inicio del Proyecto.",
			'form_options'				=>false,
			'form_placeholder'			=>"Fecha real de inicio del Proyecto.",
			'form_special_form'			=>true,
			'form_show_field'			=>true,
			'user_input'				=>true,
		),
		'planned_end_date' => array(
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
			'form_help_text'			=>"Fecha real de fin del Proyecto.",
			'form_input_size'			=>false,
			'form_label'				=>"Fecha real de fin del Proyecto.",
			'form_options'				=>false,
			'form_placeholder'			=>"Fecha real de fin del Proyecto.",
			'form_special_form'			=>true,
			'form_show_field'			=>true,
			'user_input'				=>true,
		),
		'percentage' => array(
			'type'						=>'percentage',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>true,
			'data_validation_min'		=>0,
			'data_validation_max'		=>100,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Porcentaje de Avance del Proyecto.",
			'form_input_size'			=>false,
			'form_label'				=>"Porcentaje de Avance del Proyecto.",
			'form_options'				=>false,
			'form_placeholder'			=>"Porcentaje de Avance del Proyecto.",
			'form_special_form'			=>true,
			'form_show_field'			=>true,
			'user_input'				=>true,
		),
		'last_modified_user_id' => array(
			'type'						=>'current_user_id',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Identificador de usuario solicitante.",
			'form_input_size'			=>false,
			'form_label'				=>"Identificador de usuario solicitante.",
			'form_options'				=>false,
			'form_placeholder'			=>"Identificador de usuario solicitante.",
			'form_special_form'			=>true,
			'form_show_field'			=>false,
			'user_input'				=>false,
		),
		'last_modified_date' => array(
			'type'						=>'date',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Fecha de Solicitud.",
			'form_input_size'			=>false,
			'form_label'				=>"Fecha de Solicitud.",
			'form_options'				=>false,
			'form_placeholder'			=>"Fecha de Solicitud.",
			'form_special_form'			=>false,
			'form_show_field'			=>false,
			'user_input'				=>false,
		),
		'last_modified_time' => array(
			'type'						=>'timestamp',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Hora de Solicitud.",
			'form_input_size'			=>false,
			'form_label'				=>"Hora de Solicitud.",
			'form_options'				=>false,
			'form_placeholder'			=>"Hora de Solicitud.",
			'form_special_form'			=>false,
			'form_show_field'			=>true,
			'user_input'				=>false,
		),
		'doc_link' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Enlace a la documentaci&oacute;n.",
			'form_input_size'			=>false,
			'form_label'				=>"Enlace a la documentaci&oacute;n.",
			'form_options'				=>false,
			'form_placeholder'			=>"Enlace a la documentaci&oacute;n.",
			'form_special_form'			=>false,
			'form_show_field'			=>true,
			'user_input'				=>true,
		),
		'plan_link' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Enlace al detalle de las tareas del Proyecto.",
			'form_input_size'			=>false,
			'form_label'				=>"Enlace al detalle de las tareas del Proyecto.",
			'form_options'				=>false,
			'form_placeholder'			=>"Enlace al detalle de las tareas del Proyecto.",
			'form_special_form'			=>false,
			'form_show_field'			=>true,
			'user_input'				=>true,
		),
	);
	add_action( 'plugins_loaded',	array( $this , 'db_install' ) );
	add_action( 'plugins_loaded',	array( $this , 'csi_define_capabilities' ) );
	add_shortcode( 'csi_project_list_panel',			 		array( $this , 'shortcode_project_panel'			));
	//Add Ajax actions
	add_action( 'wp_ajax_csi_new_project_request', 				array( $this , 'csi_new_project_request'			));
	add_action( 'wp_ajax_csi_user_project_request_status', 		array( $this , 'csi_user_project_request_status'	));
	add_action( 'wp_ajax_csi_pm_build_page_intro', 				array( $this , 'csi_pm_build_page_intro'			));
	add_action( 'wp_ajax_csi_pm_new_project_form', 				array( $this , 'csi_pm_new_project_form'			));
	add_action( 'wp_ajax_csi_pm_new_project', 					array( $this , 'csi_pm_new_project'					));
	add_action( 'wp_ajax_csi_pm_build_page_list_projects', 		array( $this , 'csi_pm_build_page_list_projects'	));
	add_action( 'wp_ajax_csi_pm_filtered_panel', 				array( $this , 'csi_pm_filtered_panel'				));
	add_action( 'wp_ajax_csi_pm_build_page_show_project', 		array( $this , 'csi_pm_build_page_show_project'		));
	add_action( 'wp_ajax_csi_pm_build_page_edit_project_form', 	array( $this , 'csi_pm_build_page_edit_project_form'));
}
public function csi_define_capabilities(){
	global $csi_capabilities;
	$cap_group = 'Project Capabilities';
	$key = array_search( $cap_group, array_column( $csi_capabilities, 'name' ) );
	if ( FALSE === $key ) {
		$class_cap = array(
			'name'	=> $cap_group,
			'caps'	=> array(
				'csi_create_projects',
				'csi_edit_projects',
			),
		);
		array_push ( $csi_capabilities, $class_cap);
	}else{
		array_push ( $csi_capabilities[$key]['caps'] ,'csi_create_projects' );
		array_push ( $csi_capabilities[$key]['caps'] ,'csi_edit_projects' );
	}
}
protected function backend_wp_sp_table_code($code){
	return '<code>'.$code.'</code>';
}
protected function backend_wp_sp_table_short_name($text,$element){
	return $text;
}
public function shortcode_project_panel($atts){
	global $wpdb;
	global $novis_csi_vars;
	define('DAYS_PER_MONTH', 30);
	define('DURATION', 6);
	$error		= false;
	$err_msg	='';
	//wrap plugins shortcodes
	$output		='<div class="csi-shortcode">';
	if ( isset($atts['customer']) ){
		if( is_numeric($atts['customer']) ){
			$customer =$atts['customer'];
		}else{
			$customer_list = explode(',', $atts['customer']);
			if( count($customer_list)>1 ){
				if ( is_multisite() ){
					foreach($customer_list as $i => $customer){
						if ( !is_numeric($customer) ){
							unset($customer_list[$i]);
						}
					}
					$customer = $customer_list;
				}else{
					$customer=false;
				}
			}elseif( 'all' == $atts['customer']){
				$customer = false;
			}elseif( 'current' == $atts['customer']){
				if( is_multisite() ){
					$customer = get_current_blog_id();
				}else{
					$customer=false;
				}
			}else{
				$error=true;
			}
		}
	}else{
		if( is_multisite() ){
			$customer = get_current_blog_id();
		}else{
			$customer=false;
		}
	}
	if ( isset ( $atts['silent'] ) && $atts['silent'] == 'yes'){
		$silent=true;
	}else{
		$silent=false;
	}
	//duration validation
	if ( isset ( $atts['duration'] )){
		if ( is_numeric($atts['duration']) && $atts['duration'] > 1 && $atts['duration'] <= 12 ){
			$duration = $atts['duration'];
		}else{
			$err_msg .=" La duraci&oacute;n debe estar definida entre 1 & 12.";
			$error = true;
		}
	}else{
		$duration = DURATION;
	}
	//start_date validation
	if ( isset( $atts['start_date'] ) ){
		if ( self::validate_date( $atts['start_date'] ) ){
			$date = explode('-', $atts['start_date']);
			$date=array($date[0],$date[1],'01');
			$tl_start_date = DateTime::createFromFormat('Y-m-d', implode('-',$date));
		}else{
			$err_msg .=" La fecha de inicio debe ser válida y estar en el formato YYYY-MM-DD.";
			$error = true;
		}
	}else{
		$tl_start_date = new DateTime();
		$tl_start_date->modify('-1 month');
	}
	if ( false == $error ){
		//for bootstrap's .dropdown-toggle class
		wp_enqueue_script('bootstrap');
		wp_register_style(
			"csi_client_style",
			CSI_PLUGIN_URL.'/css/client.css' ,
			null,
			"1.0",
			"all"
		);
		wp_enqueue_style("csi_client_style" );
		//register and enqueue bootstrap javascript
		$start_month_name	= $tl_start_date->format('F');
		$year				= $tl_start_date->format('Y');
		$month				= $tl_start_date->format('m');
		$day				= $tl_start_date->format('d');
		$tl_end_date		= DateTime::createFromFormat('Y-m-d', $year.'-'.intval($month+$duration-1).'-28');
		$month_width		= 100 / $duration;
		//Print months header
		$style= $silent ? ' style="color:#FFF" ' : "";
		$output.='<h2 '.$style.'>Proyectos en curso</h2>';
		$output.='
		<div class="csi-project-panel">
		';
		if ( !$silent ){
			//$output.='
			//<div class="hidden-xs col-md-2">&nbsp;</div>';
		}
		$output.='<div class="col-xs-12 timeline-header">';
		for ( $i = 0 ; $i < $duration ; $i++ ){
			$date = DateTime::createFromFormat('Y-m-d', $year.'-'.intval($month+$i).'-01');
			$date_header_long='<span '.$style.'>'.$date->format('F').'<br/><small class="text-muted">'.$date->format('Y').'</small></span>';
			$date_header_short='<span '.$style.'>'.$date->format('M').'<br/><small class="text-muted">'.$date->format('Y').'</small></span>';
			$output.='<div class="month text-center hidden-xs" style="width:'.$month_width.'%;">'.$date_header_long.'</div>';
			$output.='<div class="month text-center visible-xs" style="width:'.$month_width.'%;">'.$date_header_short.'</div>';
		}//end for $i counter
		$output.='</div>';##timeline-header
		if ( false == $customer ){
			$sql = "SELECT * FROM ".$this->tbl_name." ORDER BY customer_id DESC";
		}else{
			if ( 'array' == gettype($customer) ){
				$sql = "SELECT * FROM ".$this->tbl_name;
				$sql.=" WHERE customer_id=".implode(" OR customer_id=", $customer);
				$sql.=" ORDER BY customer_id";
			}else{
				$sql = "SELECT * FROM ".$this->tbl_name;
				$sql.=" WHERE customer_id=$customer ORDER BY customer_id DESC";
			}
		}
		//PROJECTS Timelines
		$customer_id=null;
		$projects = self::get_sql($sql);
		$MONTH = 100/$duration;
		foreach ( $projects as $project){
			if ( self::validate_date( $project['planned_start_date'] ) && self::validate_date( $project['planned_end_date'] ) ){
				if(!$silent){
					if( is_multisite() ){
						if ( $customer_id != $project['customer_id']){
							$customer_id = $project['customer_id'];
							if (0 == $customer_id){
								$output.='<div class="col-xs-12 customer"><p class="lead text-center" '.$style.'>Clientes fuera de Operaci&oacute;n</p></div>';
							}else{
								$blog_details = get_blog_details($customer_id);
								$output.='<div class="col-xs-12 customer"><div class="lead text-center">'.$blog_details->blogname.'</div></div>';
							}
						}
					}
				}
				$planned_start_date	= DateTime::createFromFormat('Y-m-d', $project['planned_start_date']);
				$planned_end_date	= DateTime::createFromFormat('Y-m-d', $project['planned_end_date']);
				if( $tl_start_date < $planned_start_date){
					$month_diff = new DateTime;
					$month_diff = date_diff ( $planned_start_date,$tl_start_date);
					//add months
					$proj_prev = floatval ( intval( $month_diff->format('%m') ) * $month_width );
					//self::write_log($month_diff);
					//add days
					$proj_prev = $proj_prev + intval( $month_diff->format('%d') ) / DAYS_PER_MONTH * $month_width;
				}else{
					$proj_prev = 0;
				}
				if( $tl_end_date > $planned_end_date){
					$month_diff = new DateTime;
					$month_diff = date_diff ( $planned_end_date,$tl_end_date);
					//add months
					$proj_post = floatval ( intval( $month_diff->format('%m') ) * $month_width );
					//add days
					$proj_post = $proj_post + $month_width / ( DAYS_PER_MONTH / intval( $planned_end_date->format('d') ) );
					//self::write_log( $month_width / ( DAYS_PER_MONTH / intval( $planned_end_date->format('d') ) ) );
				}else{
					$proj_post=0;
				}
				$proj_width = 100 - ($proj_prev + $proj_post);
				//self::write_log($proj_prev.' - '.$proj_width.' - '.$proj_post);
				$output.='
				<div class="row project">';
				if ( !$silent ){
					$output.='
					<div class="col-xs-12 text-left project-options">
						<div class="month text-center" style=";width:'.$proj_prev.'%;">&nbsp;</div>
						<div class="btn-group btn-group-sm" style=";width:'.$proj_width.'%;">
							<a type="button" class="text-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="fa fa-cog fa-fw"></span>'.$project['short_name'].'
							</a>
							<ul class="dropdown-menu">
								<li><a href="#" title="Ver los documentos del proyecto '.$project['short_name'].'"><i class="fa fa-tasks fa-fw" aria-hidden="true"></i> Tareas</a></li>
								<li><a href="#" title="Ver las tareas del proyecto '.$project['short_name'].'"><i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> Documentos</a></li>
							</ul>
						</div>
						<div class="month" style="width:'.$proj_post.'%;">'.$project['short_name'].'</div>
					</div>';
				}
				$short_name= true==$silent  ? '<small style="color:#FFF;white-space: nowrap;text-overflow: ellipsis;display: block;overflow: hidden;">&nbsp;'.$project['short_name'].'</small>':'&nbsp;';
				$start_class= (0 == $proj_prev) ? ' non_start ' : '';
				$end_class= (0 == $proj_post) ? ' non_end ' : '';
				$output.='
					<div class="col-xs-12 project-timeline">
						<div class="month text-center" style="width:'.$proj_prev.'%;">&nbsp;</div>
						<div class="month text-center" style="width:'.$proj_width.'%;">
							<div class="progress '.$start_class.$end_class.'">
								<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$project['percentage'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$project['percentage'].'%;">
									<span>'.$project['percentage'].'%</span>
								</div>
							</div>
						</div>
						<div class="month" style="width:'.$proj_post.'%;">'.$short_name.'</div>
					</div>
				</div>';
			}else{
				//No se muestra el proyecto, ya que no tiene fechas valida planificadas
			}
		}
		$output.="</div>";
	}else{
		$output.='<div class="well">';
			$output.='<p class="h3"><i class="fa fa-exclamation-circle fa-sm text-danger"></i> Error</p>';
			$output.='<p>Ha ocurrido un error, o probablemente no est&aacute;s usando de modo correcto el <code>shortcode</code>.</p>';
			$output.='<p><code>[csi_project_list_panel duration=<kbd>meses</kbd> start_date=<kbd>yyyy-mm-dd</kbd></code></p>';
			$output.='<p class=""text-muted">'.$err_msg.'</p>';
			$output.='<a href="'.get_site_option('ics_shortcode_help_url','#').'" class="btn btn-sm btn-primary">Aprender m&aacute;s</a>';
		$output.='</div>';

	}
	$output.='</div>';#wrap plugin shortcode csi-shortcode
	return $output;
}
public function csi_new_project_request(){
	$insertArray			= array();
	$response				= array();
	$post					= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	# Validate user capability ??
	$user_id				= get_current_user_id();
	$current_datetime		= new DateTime();
	$new_status_code		='revision';
	global $NOVIS_CSI_PROJECT_STATUS;
	global $wpdb;
	$sql					= "SELECT id FROM ".$NOVIS_CSI_PROJECT_STATUS->tbl_name.' WHERE code ="'.$new_status_code.'"';
	$status_id				=intval ( $wpdb->get_var($sql) );

	foreach ( $this->db_fields as $key => $field){
		if ( true == $field['user_input'] ){
			if ( isset($post[$key]) ){
				$insertArray[$key] = strip_tags(stripslashes( $post[$key] ));
			}
		}
	}
	$insertArray['requested_user_id']		= $user_id;
	$insertArray['requested_date']			= $current_datetime->format('Y-m-d');
	$insertArray['requested_time']			= $current_datetime->format('H:i:s');
	$insertArray['status_id']				= $status_id;
	$insertArray['last_modified_user_id']	= $user_id;
	$insertArray['last_modified_date']		= $current_datetime->format('Y-m-d');
	$insertArray['last_modified_time']		= $current_datetime->format('H:i:s');
	if ( $wpdb->insert( $this->tbl_name, $insertArray ) ){
		$response['id']=$wpdb->insert_id;
		$response['message']="El nuevo ".$this->name_single." ha sido guardado.";
	}else{
		$response['error']=true;
		$response['message']="Hubo un error al agregar el nuevo ".$this->name_single."; intenta nuevamente. :)";
	}
	echo json_encode($response);
	wp_die();
}
public function csi_pm_new_project(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_PROJECT_STATUS;
	//Local Variables
	$insertArray			= array();
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user			= get_userdata ( get_current_user_id() );
	$current_datetime		= new DateTime();
	$planned_dates			= explode ( ' - ', $post['planned_dates'] );
	//Execution
	self::write_log ( $post );

	$insertArray['registered_customer_flag']	= isset ( $post['registered_customer_flag'] ) && 1 == $post['registered_customer_flag'] ? 1 : NULL ;
	$insertArray['registered_customer_id']		= $insertArray['registered_customer_flag'] ? intval ( $post['registered_customer_id'] ) : NULL;
	$insertArray['non_registered_customer_name']= !$insertArray['registered_customer_flag'] ? htmlentities( $post['non_registered_customer_name'] ) : NULL;
	$insertArray['short_name']					= htmlentities ( $post['short_name'] );
	$insertArray['description']					= htmlentities ( $post['description'] );
	$insertArray['scope']						= htmlentities ( $post['scope'] );
	$insertArray['capacity']					= htmlentities ( $post['capacity'] );
	$insertArray['planned_start_date']			= $planned_dates[0];
	$insertArray['planned_end_date']			= $planned_dates[1];
	$insertArray['status_id']					= intval ( $post['status_id'] );
	$insertArray['phase_id']					= intval ( $post['phase_id'] );
	$insertArray['plan_percentage']				= intval ( $post['plan_percentage'] );
	$insertArray['real_percentage']				= intval ( $post['real_percentage'] );
	$insertArray['pm_user_id']					= intval ( $post['pm_user_id'] );
	$insertArray['tl_user_id']					= intval ( $post['tl_user_id'] );
	$insertArray['doc_link']					= htmlentities ( $post['doc_link'] );
	$insertArray['plan_link']					= htmlentities ( $post['plan_link'] );
	$insertArray['creation_user_id']			= $current_user->ID;
	$insertArray['creation_user_email']			= $current_user->user_email;
	$insertArray['creation_datetime']			= $current_datetime->format('Y-m-d H:i:s');

	//self::write_log ( $post );
	//self::write_log ( $editArray );
	if ( $wpdb->insert( $this->tbl_name, $insertArray ) ){
		$response['id']=$wpdb->insert_id;
		$service_id = $wpdb->insert_id;
		//crear registro de Ejecutores
		$response['postSubmitAction']	='changeHash';
		$response['notification']=array(
			'buttons'			=> array(
				'OK'			=> array(
					'text'		=> 'OK',
					'btnClass'	=> 'btn-success',
				),
			),
			'icon'				=> 'fa fa-check fa-sm',
			'closeIcon'			=> true,
			'columnClass'		=> 'large',
			'content'			=> 'Has agregado un nuevo ' . $this->name_single . ' exitosamente. (ID: <code>#' . $service_id . '</code>)',
			'title'				=> 'Bien!',
			'type'				=> 'green',
			'autoClose'			=> 'OK|3000',
		);
	}else{
		$response['error']=true;
		$response['notifStopNextPage'] = true;
		$response['notification']=array(
			'buttons'			=> array(
				'OK'			=> array(
					'text'		=> 'OK',
					'btnClass'	=> 'btn-danger',
				),
			),
			'icon'				=> 'fa fa-exclamation-triangle fa-sm text-danger',
			'closeIcon'			=> true,
			'columnClass'		=> 'large',
			'content'			=> 'Hubo un error al agregar el nuevo ' . $this->name_single . '; intenta nuevamente. :)<p><small><code>' . htmlspecialchars( $wpdb->last_error, ENT_QUOTES ) . '</code></small></p>',
			'title'				=> 'Error!',
			'type'				=> 'red',
			'autoClose'			=> 'OK|3000',
		);
	}
	echo json_encode($response);
	wp_die();

}
public function csi_user_project_request_status(){
	global $NOVIS_CSI_PROJECT_STATUS;
	$user_id = get_current_user_id();
	$response = array();
	$output = '';
	$sql = "SELECT * FROM ".$this->tbl_name." WHERE requested_user_id=".$user_id." ORDER BY requested_date, customer_id ASC";
	$projects = $this->get_sql($sql);
	if ( 0 == count($projects)){
		$output.= '<tr>';
			$output.= '	<td colspan="5">
							<p class="text-center lead">No tienes Solicitudes de Proyecto</p>
							<div class="text-center">
								<a class="btn btn-success csi-project-request-button animated flipInX" href="#project_request_form" role="button">Nueva solicitud</a>
							</div>
						</td>';
		$output.= '</tr>';
	}else{
		foreach ( $projects as $project ){
			$output.= '<tr>';
				$output.= '<td class="text-center">'.$project['id'].'</td>';
			if ( is_multisite() ){
				if ( 0 == $project['customer_id'] ){
					$output.= '<td class="text-left">...</td>';
				}else{
					$customer_name = get_blog_details($project['customer_id'])->blogname;
					$output.= '<td class="text-left">'.$customer_name.'</td>';
				}
			}
				$output.= '<td class="text-left">'.$project['short_name'].'</td>';
				$output.= '<td class="text-center">'.$project['requested_date'].'</td>';
				$status = $NOVIS_CSI_PROJECT_STATUS->get_single($project['status_id']);
				$output.= '<td class=" text-center '.$status['css_class'].'"><span class="text-'.$status['css_class'].'">'.$status['short_name'].'</span></td>';
			$output.= '</tr>';
		}
	}
	$response['message']=$output;
	echo json_encode($response);
	wp_die();
}
public function csi_pm_build_page_edit_project_form(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_PROJECT_STATUS;
	global $NOVIS_CSI_PROJECT_PHASE;
	global $NOVIS_CSI_USER;
	global $NOVIS_CSI_USER_TEAM;
	//Local Variables
	$o				= '';
	$customer_opts	= '';
	$phase_opts		= '';
	$status_opts	= '';
	$pm_user_opts	= '';
	$tl_user_opts	= '';
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$project_id = intval ( $post['p'] );
	//--------------------------------------------------------------------------
	$sql = 'SELECT * FROM ' . $this->tbl_name . ' WHERE id = "' . $project_id . '" ';
	$project = $wpdb->get_row ( $sql );
	//--------------------------------------------------------------------------
	$sql = 'SELECT id, short_name FROM ' . $NOVIS_CSI_COUNTRY->tbl_name . ' ORDER BY short_name';
	foreach ( $this->get_sql ( $sql ) as $country ){
		$customer_opts.='<optgroup label="' . $country['short_name'] . '">';
		$sql = 'SELECT id, short_name, code FROM ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' WHERE country_id="' . $country['id'] . '" ORDER BY short_name';
		foreach ( $this->get_sql ( $sql ) as $customer ){
			$selected = ( $project->registered_customer_id == $customer['id'] ) ? 'selected' : '';
			$customer_opts.='<option value="' . $customer['id'] . '" ' . $selected . '>' . $customer['short_name'] . ' (' . strtoupper ( $customer['code'] ) . ')</option>';
		}
		$customer_opts.='</optgroup>';
	}
	//--------------------------------------------------------------------------
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_PROJECT_PHASE->tbl_name . '';
	$phases = $this->get_sql ( $sql );
	foreach ( $phases as $phase ){
		$selected = ( $project->phase_id == $phase['id'] ) ? 'selected' : '';
		$phase_opts .= '<option value="' . $phase['id'] . '" ' . $selected . '>' . $phase['short_name'] . '</option>';
	}
	//--------------------------------------------------------------------------
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_PROJECT_STATUS->tbl_name . '';
	$status = $this->get_sql ( $sql );
	foreach ( $status as $status_det ){
		$selected = ( $project->status_id == $status_det['id'] ) ? 'selected' : '';
		$status_opts .= '<option value="' . $status_det['id'] . '" ' . $selected . '>' . $status_det['short_name'] . '</option>';
	}
	//--------------------------------------------------------------------------
	$sql = 'SELECT id,short_name FROM ' . $NOVIS_CSI_USER_TEAM->tbl_name . ' ';
	$user_teams = $this->get_sql ( $sql);
	foreach ( $user_teams as $user_team ){
		$sql = 'SELECT
					T00.id as user_id,
					T01.display_name as display_name,
					T01.user_email as user_email
				FROM
					' . $NOVIS_CSI_USER->tbl_name . ' as T00
					LEFT JOIN ' . $wpdb->base_prefix . 'users as T01
						ON T00.id = T01.ID
				WHERE
					T00.active_flag = 1 AND
					T00.team_id = "' . $user_team['id'] . '"
		';
		$users = $this->get_sql ( $sql );
		$pm_user_opts .= '<optgroup label="' . $user_team['short_name'] . '">';
		$tl_user_opts .= '<optgroup label="' . $user_team['short_name'] . '">';
		foreach ( $users as $user ){
			$selected = ( $user['user_id'] == $project->pm_user_id ) ? ' selected ' : '';
			$pm_user_opts .= '<option value="' . $user['user_id'] . '" ' . $selected . '>' . $user['display_name'] . '</option>';

			$selected = ( $user['user_id'] == $project->tl_user_id ) ? ' selected ' : '';
			$tl_user_opts .= '<option value="' . $user['user_id'] . '" ' . $selected  . '>' . $user['display_name'] . '</option>';
		}
		$pm_user_opts .= '</optgroup>';
		$tl_user_opts .= '</optgroup>';
	}
	//--------------------------------------------------------------------------
	if ( current_user_can_for_blog ( 1, 'csi_create_projects' ) ){
		$o.='
		<div class="container">
			<div class="panel panel-default row">
				<div class="panel-heading">
					<h1 class="panel-title">Editar Proyecto: <code>' . $project->id . '</code></h1>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" data-function="csi_pm_new_project" data-next-page="listprojects" style="position:relative;">
						<h4>Definición del Proyecto</h4>
						<div class="form-group">
							<label for="customer_id" class="col-sm-2 control-label">Cliente</label>
							<div class="col-sm-10">
								<div class="input-group select2-bootstrap-append select2-bootstrap-prepend">
									<span class="input-group-addon"><small><samp>&nbsp;&nbsp;&nbsp;Registrado</samp></small></span>
									<span class="input-group-addon">
										<input type="radio" name="registered_customer_flag" class="csi-switchable-radio-button" value="1" ' . ( $project->registered_customer_flag ? 'checked' : '') . '>
									</span>
									<select name="registered_customer_id" class="form-control select2 ' . ( !$project->registered_customer_flag ? 'disabled' : '') . '" required="true" data-placeholder="Selecciona el cliente registrado" style="width:100%;" ' . ( !$project->registered_customer_flag ? 'disabled' : '') . '>
										<option></option>
										' . $customer_opts . '
									</select>
								</div><!-- .input-group -->
								<div class="input-group">
									<span class="input-group-addon"><small><samp>No registrado</samp></small></span>
									<span class="input-group-addon">
										<input type="radio" class="csi-switchable-radio-button" name="registered_customer_flag" value="0" ' . ( !$project->registered_customer_flag ? 'checked' : '') . '>
									</span>
									<input type="text" name="non_registered_customer_name" required="true" class="form-control ' . ( $project->registered_customer_flag ? 'disabled' : '') . '" ' . ( $project->registered_customer_flag ? 'disabled' : '') . ' placeholder="[Nombre de Cliente]" value="' . $project->non_registered_customer_name . '">
								</div><!-- .input-group -->
								<p class="help-block">
									<small class="text-warning pull-right">(requerido)</small>
									Si el cliente no existe en nuestra Base de Datos (campo <strong>Cliente registrado</strong> puedes agregar la referencia con un texto que identifique al cliente.<br/>
									Por ejemplo: <i>Soluciones Industriales</i></p>
							</div>
						</div>
						<div class="form-group ">
							<label for="short_name" class="col-sm-2 control-label">Nombre del Proyecto</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="short_name" name="short_name" placeholder="Nombre del Proyecto" required="true" value="' . $project->short_name . '">
								<p class="help-block">
									<small class="text-warning pull-right">(requerido)</small>
								</p>
							</div>
						</div>
						<div class="form-group ">
							<label for="description" class="col-sm-2 control-label">Descripci&oacute;n</label>
							<div class="col-sm-10">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs">
									<li role="presentation" class="active">
										<a href="#csi-issue-input-description" data-toggle="tab" data-function="editor">
											Escribir
										</a>
									</li>
									<li role="presentation">
										<a href="#csi-issue-preview-description" data-toggle="tab" data-function="mdPreview" data-text-field="#description" data-action="csi_issue_new_issue_form_md_preview">
											Previsualizar
										</a>
									</li>
								</ul><!-- .nav-tabs -->
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="csi-issue-input-description">
										<div class="list-group" style="margin-bottom:0px;">
											<a href="#" class="list-group-item list-group-item-success small csi-popup" data-action="csi_issue_popup_markdown_info">
												Modo de edici&oacute;n: Markdown habilitado <i class="fa fa-question-circle"></i>
											</a>
										</div>
										<textarea class="form-control" id="description" name="description" placeholder="Descripci&oacute;n" rows="6">' . $project->description . '</textarea>
										<p class="help-block collapse in">
										</p>
									</div>
									<div role="tabpanel" class="tab-pane" id="csi-issue-preview-description" style="position:relative;min-height:100px;"></div>
								</div><!-- .tab-content -->
							</div><!-- .col-sm-10 -->
						</div><!-- .form-group -->
						<div class="form-group ">
							<label for="scope" class="col-sm-2 control-label">Alcance</label>
							<div class="col-sm-10">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs">
									<li role="presentation" class="active">
										<a href="#csi-issue-input-scope" data-toggle="tab" data-function="editor">
											Escribir
										</a>
									</li>
									<li role="presentation">
										<a href="#csi-issue-preview-scope" data-toggle="tab" data-function="mdPreview" data-text-field="#scope" data-action="csi_issue_new_issue_form_md_preview">
											Previsualizar
										</a>
									</li>
								</ul><!-- .nav-tabs -->
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="csi-issue-input-scope">
										<div class="list-group" style="margin-bottom:0px;">
											<a href="#" class="list-group-item list-group-item-success small csi-popup" data-action="csi_issue_popup_markdown_info">
												Modo de edici&oacute;n: Markdown habilitado <i class="fa fa-question-circle"></i>
											</a>
										</div>
										<textarea class="form-control" id="scope" name="scope" placeholder="Alcance" rows="6">' . $project->scope . '</textarea>
										<p class="help-block collapse in">
										</p>
									</div>
									<div role="tabpanel" class="tab-pane" id="csi-issue-preview-scope" style="position:relative;min-height:100px;"></div>
								</div><!-- .tab-content -->
							</div><!-- .col-sm-10 -->
						</div><!-- .form-group -->
						<div class="form-group ">
							<label for="capacity" class="col-sm-2 control-label">Capacidad RRHH</label>
							<div class="col-sm-10">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs">
									<li role="presentation" class="active">
										<a href="#csi-issue-input-capacity" data-toggle="tab" data-function="editor">
											Escribir
										</a>
									</li>
									<li role="presentation">
										<a href="#csi-issue-preview-capacity" data-toggle="tab" data-function="mdPreview" data-text-field="#capacity" data-action="csi_issue_new_issue_form_md_preview">
											Previsualizar
										</a>
									</li>
								</ul><!-- .nav-tabs -->
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="csi-issue-input-capacity">
										<div class="list-group" style="margin-bottom:0px;">
											<a href="#" class="list-group-item list-group-item-success small csi-popup" data-action="csi_issue_popup_markdown_info">
												Modo de edici&oacute;n: Markdown habilitado <i class="fa fa-question-circle"></i>
											</a>
										</div>
										<textarea class="form-control" id="capacity" name="capacity" placeholder="Capacidad" rows="6">' . $project->capacity . '</textarea>
										<p class="help-block collapse in">
										</p>
									</div>
									<div role="tabpanel" class="tab-pane" id="csi-issue-preview-capacity" style="position:relative;min-height:100px;"></div>
								</div><!-- .tab-content -->
							</div><!-- .col-sm-10 -->
						</div><!-- .form-group -->
						<div class="form-group">
							<label for="planned_dates" class="col-sm-2 control-label">Duraci&oacute;n</label>
							<div class="col-sm-10">
								<input type="text" class="form-control csi-date-range-input" id="planned_dates" name="planned_dates" required="true" data-auto-apply="true" data-show-dropdowns="true" value="' . $project->planned_start_date . ' - ' . $project->planned_end_date . '"/>
								<span class="help-block">
									<small class="text-warning pull-right">(requerido)</small>
								</span>
							</div>
						</div>
						<div class="well well-sm row">
							<h4>Status del Proyecto</h4>
							<div class="form-group">
								<label for="status_id" class="col-sm-2 control-label">Status del Proyecto</label>
								<div class="col-sm-10">
									<select id="status_id" name="status_id" class="form-control select2" data-placeholder="Selecciona el Status" style="width:100%;" required="true">
										<option></option>
										' . $status_opts . '
									</select>
									<span class="help-block">
										<small class="text-warning pull-right">(requerido)</small>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label for="phase_id" class="col-sm-2 control-label">Fase del Proyecto</label>
								<div class="col-sm-10">
									<select id="phase_id" name="phase_id" class="form-control select2" data-placeholder="Selecciona la Fase" style="width:100%;" required="true">
										<option></option>
										' . $phase_opts . '
									</select>
									<span class="help-block">
										<small class="text-warning pull-right">(requerido)</small>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Avance del Proyecto</label>
								<div class="col-sm-10">
									<div class="input-group">
										<span class="input-group-addon" style="width:45%;">Avance Planificado</span>
										<input type="number" class="form-control" name="plan_percentage" value="' . $project->plan_percentage . '" />
										<span class="input-group-addon">%</span>
									</div>
									<div class="input-group">
										<span class="input-group-addon" style="width:45%;">Avance Real</span>
										<input type="number" class="form-control" name="real_percentage" value="' . $project->real_percentage . '"/>
										<span class="input-group-addon">%</span>
									</div>
								</div>
							</div>
						</div>
						<h4>Responsables del Proyecto</h4>
						<div class="form-group">
							<label for="pm_user_id" class="col-sm-2 control-label">Project Manager</label>
							<div class="col-sm-10">
								<select id="pm_user_id" name="pm_user_id" class="form-control select2" data-placeholder="Selecciona el Project Manager" style="width:100%;" data-allow-clear="true">
									<option></option>
									' . $pm_user_opts . '
								</select>
								<span class="help-block">
								</span>
							</div>
						</div>
						<div class="form-group">
							<label for="tl_user_id" class="col-sm-2 control-label">L&iacute;der T&eacute;cnico</label>
							<div class="col-sm-10">
								<select id="tl_user_id" name="tl_user_id" class="form-control select2" data-placeholder="Selecciona el L&iacute;der T&eacute;cnico" style="width:100%;" data-allow-clear="true">
									<option></option>
									' . $tl_user_opts . '
								</select>
								<span class="help-block">
								</span>
							</div>
						</div>
						<h4>Documentación del Proyecto</h4>
						<p>Los repositorios de documentación del proyecto deben estar creados acorde a las <a href="#" target="_blank">reglas de documentación de proyecto <i class="fa fa-fw fa-external-link"></i></a>.
						<div class="form-group">
							<label for="doc_link" class="col-sm-2 control-label">Enlace de Documentaci&oacute;n</label>
							<div class="col-sm-10">
								<input type="url" id="doc_link" name="doc_link" class="form-control" placeholder="Enlace de Documentaci&oacute;n" value="' . $project->doc_link . '">
									<option></option>
								</select>
								<span class="help-block">
								</span>
							</div>
						</div>
						<div class="form-group">
							<label for="plan_link" class="col-sm-2 control-label">Enlace de Planificac&oacute;n</label>
							<div class="col-sm-10">
								<input type="url" id="plan_link" name="plan_link" class="form-control" placeholder="Enlace de Planificac&oacute;n" value="' . $project->plan_link . '">
									<option></option>
								</select>
								<span class="help-block">
								</span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10 text-right">
								<button type="reset" class="btn btn-default"><i class="fa fa-fw fa-history"></i>Cancelar</button>
								<button type="submit" class="btn btn-primary " ><i class="fa fa-fw fa-plus"></i>Crear Proyecto</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div><!-- .container -->';
	}else{
		$o.=self::no_permissions_msg();
	}

	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_pm_new_project_form(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_PROJECT_STATUS;
	global $NOVIS_CSI_PROJECT_PHASE;
	global $NOVIS_CSI_USER;
	global $NOVIS_CSI_USER_TEAM;
	//Local Variables
	$o				= '';
	$customer_opts	= '';
	$phase_opts		= '';
	$status_opts	= '';
	$pm_user_opts	= '';
	$tl_user_opts	= '';
	//--------------------------------------------------------------------------
	$sql = 'SELECT id, short_name FROM ' . $NOVIS_CSI_COUNTRY->tbl_name . ' ORDER BY short_name';
	foreach ( $this->get_sql ( $sql ) as $country ){
		$customer_opts.='<optgroup label="' . $country['short_name'] . '">';
		$sql = 'SELECT id, short_name, code FROM ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' WHERE country_id="' . $country['id'] . '" ORDER BY short_name';
		foreach ( $this->get_sql ( $sql ) as $customer ){
			$customer_opts.='<option value="' . $customer['id'] . '">' . $customer['short_name'] . ' (' . strtoupper ( $customer['code'] ) . ')</option>';
		}
		$customer_opts.='</optgroup>';
	}
	//--------------------------------------------------------------------------
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_PROJECT_PHASE->tbl_name . '';
	$phases = $this->get_sql ( $sql );
	foreach ( $phases as $phase ){
		$phase_opts .= '<option value="' . $phase['id'] . '">' . $phase['short_name'] . '</option>';
	}
	//--------------------------------------------------------------------------
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_PROJECT_STATUS->tbl_name . '';
	$status = $this->get_sql ( $sql );
	foreach ( $status as $status_det ){
		$status_opts .= '<option value="' . $status_det['id'] . '">' . $status_det['short_name'] . '</option>';
	}
	//--------------------------------------------------------------------------
	$sql = 'SELECT id,short_name FROM ' . $NOVIS_CSI_USER_TEAM->tbl_name . ' ';
	$user_teams = $this->get_sql ( $sql);
	foreach ( $user_teams as $user_team ){
		$sql = 'SELECT
					T00.id as user_id,
					T01.display_name as display_name,
					T01.user_email as user_email
				FROM
					' . $NOVIS_CSI_USER->tbl_name . ' as T00
					LEFT JOIN ' . $wpdb->base_prefix . 'users as T01
						ON T00.id = T01.ID
				WHERE
					T00.active_flag = 1 AND
					T00.team_id = "' . $user_team['id'] . '"
		';
		$users = $this->get_sql ( $sql );
		$pm_user_opts .= '<optgroup label="' . $user_team['short_name'] . '">';
		$tl_user_opts .= '<optgroup label="' . $user_team['short_name'] . '">';
		foreach ( $users as $user ){
			$selected = ( $user['user_id'] == get_current_user_id() ) ? ' selected ' : '';
			$pm_user_opts .= '<option value="' . $user['user_id'] . '" ' . $selected . '>' . $user['display_name'] . '</option>';
			$tl_user_opts .= '<option value="' . $user['user_id'] . '" >' . $user['display_name'] . '</option>';
		}
		$pm_user_opts .= '</optgroup>';
		$tl_user_opts .= '</optgroup>';
	}
	//--------------------------------------------------------------------------
	if ( current_user_can_for_blog ( 1, 'csi_create_projects' ) ){
		$o.='
		<div class="container">
			<div class="panel panel-default row">
				<div class="panel-heading">
					<h1 class="panel-title">Crear Proyecto</h1>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" data-function="csi_pm_new_project" data-next-page="listprojects" style="position:relative;">
						<h4>Definición del Proyecto</h4>
						<div class="form-group">
							<label for="customer_id" class="col-sm-2 control-label">Cliente</label>
							<div class="col-sm-10">
								<div class="input-group select2-bootstrap-append select2-bootstrap-prepend">
									<span class="input-group-addon"><small><samp>&nbsp;&nbsp;&nbsp;Registrado</samp></small></span>
									<span class="input-group-addon">
										<input type="radio" name="registered_customer_flag" class="csi-switchable-radio-button" value="1" checked>
									</span>
									<select name="registered_customer_id" class="form-control select2 " required="true" data-placeholder="Selecciona el cliente registrado" style="width:100%;">
										<option></option>
										' . $customer_opts . '
									</select>
								</div><!-- .input-group -->
								<div class="input-group">
									<span class="input-group-addon"><small><samp>No registrado</samp></small></span>
									<span class="input-group-addon">
										<input type="radio" class="csi-switchable-radio-button" name="registered_customer_flag" value="0">
									</span>
									<input type="text" name="non_registered_customer_name" required="true" class="form-control disabled" disabled="" placeholder="[Nombre de Cliente]" value="">
								</div><!-- .input-group -->
								<p class="help-block">
									<small class="text-warning pull-right">(requerido)</small>
									Si el cliente no existe en nuestra Base de Datos (campo <strong>Cliente registrado</strong> puedes agregar la referencia con un texto que identifique al cliente.<br/>
									Por ejemplo: <i>Soluciones Industriales</i></p>
							</div>
						</div>
						<div class="form-group ">
							<label for="short_name" class="col-sm-2 control-label">Nombre del Proyecto</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="short_name" name="short_name" placeholder="Nombre del Proyecto" required="true">
								<p class="help-block">
									<small class="text-warning pull-right">(requerido)</small>
								</p>
							</div>
						</div>
						<div class="form-group ">
							<label for="description" class="col-sm-2 control-label">Descripci&oacute;n</label>
							<div class="col-sm-10">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs">
									<li role="presentation" class="active">
										<a href="#csi-issue-input-description" data-toggle="tab" data-function="editor">
											Escribir
										</a>
									</li>
									<li role="presentation">
										<a href="#csi-issue-preview-description" data-toggle="tab" data-function="mdPreview" data-text-field="#description" data-action="csi_issue_new_issue_form_md_preview">
											Previsualizar
										</a>
									</li>
								</ul><!-- .nav-tabs -->
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="csi-issue-input-description">
										<div class="list-group" style="margin-bottom:0px;">
											<a href="#" class="list-group-item list-group-item-success small csi-popup" data-action="csi_issue_popup_markdown_info">
												Modo de edici&oacute;n: Markdown habilitado <i class="fa fa-question-circle"></i>
											</a>
										</div>
										<textarea class="form-control" id="description" name="description" placeholder="Descripci&oacute;n" rows="6"></textarea>
										<p class="help-block collapse in">
										</p>
									</div>
									<div role="tabpanel" class="tab-pane" id="csi-issue-preview-description" style="position:relative;min-height:100px;"></div>
								</div><!-- .tab-content -->
							</div><!-- .col-sm-10 -->
						</div><!-- .form-group -->
						<div class="form-group ">
							<label for="scope" class="col-sm-2 control-label">Alcance</label>
							<div class="col-sm-10">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs">
									<li role="presentation" class="active">
										<a href="#csi-issue-input-scope" data-toggle="tab" data-function="editor">
											Escribir
										</a>
									</li>
									<li role="presentation">
										<a href="#csi-issue-preview-scope" data-toggle="tab" data-function="mdPreview" data-text-field="#scope" data-action="csi_issue_new_issue_form_md_preview">
											Previsualizar
										</a>
									</li>
								</ul><!-- .nav-tabs -->
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="csi-issue-input-scope">
										<div class="list-group" style="margin-bottom:0px;">
											<a href="#" class="list-group-item list-group-item-success small csi-popup" data-action="csi_issue_popup_markdown_info">
												Modo de edici&oacute;n: Markdown habilitado <i class="fa fa-question-circle"></i>
											</a>
										</div>
										<textarea class="form-control" id="scope" name="scope" placeholder="Alcance" rows="6"></textarea>
										<p class="help-block collapse in">
										</p>
									</div>
									<div role="tabpanel" class="tab-pane" id="csi-issue-preview-scope" style="position:relative;min-height:100px;"></div>
								</div><!-- .tab-content -->
							</div><!-- .col-sm-10 -->
						</div><!-- .form-group -->
						<div class="form-group ">
							<label for="capacity" class="col-sm-2 control-label">Capacidad RRHH</label>
							<div class="col-sm-10">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs">
									<li role="presentation" class="active">
										<a href="#csi-issue-input-capacity" data-toggle="tab" data-function="editor">
											Escribir
										</a>
									</li>
									<li role="presentation">
										<a href="#csi-issue-preview-capacity" data-toggle="tab" data-function="mdPreview" data-text-field="#capacity" data-action="csi_issue_new_issue_form_md_preview">
											Previsualizar
										</a>
									</li>
								</ul><!-- .nav-tabs -->
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="csi-issue-input-capacity">
										<div class="list-group" style="margin-bottom:0px;">
											<a href="#" class="list-group-item list-group-item-success small csi-popup" data-action="csi_issue_popup_markdown_info">
												Modo de edici&oacute;n: Markdown habilitado <i class="fa fa-question-circle"></i>
											</a>
										</div>
										<textarea class="form-control" id="capacity" name="capacity" placeholder="Capacidad" rows="6"></textarea>
										<p class="help-block collapse in">
										</p>
									</div>
									<div role="tabpanel" class="tab-pane" id="csi-issue-preview-capacity" style="position:relative;min-height:100px;"></div>
								</div><!-- .tab-content -->
							</div><!-- .col-sm-10 -->
						</div><!-- .form-group -->
						<div class="form-group">
							<label for="planned_dates" class="col-sm-2 control-label">Duraci&oacute;n</label>
							<div class="col-sm-10">
								<input type="text" class="form-control csi-date-range-input" id="planned_dates" name="planned_dates" required="true" data-auto-apply="true" data-show-dropdowns="true"/>
								<span class="help-block">
									<small class="text-warning pull-right">(requerido)</small>
								</span>
							</div>
						</div>
						<div class="well well-sm row">
							<h4>Status del Proyecto</h4>
							<div class="form-group">
								<label for="status_id" class="col-sm-2 control-label">Status del Proyecto</label>
								<div class="col-sm-10">
									<select id="status_id" name="status_id" class="form-control select2" data-placeholder="Selecciona el Status" style="width:100%;" required="true">
										<option></option>
										' . $status_opts . '
									</select>
									<span class="help-block">
										<small class="text-warning pull-right">(requerido)</small>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label for="phase_id" class="col-sm-2 control-label">Fase del Proyecto</label>
								<div class="col-sm-10">
									<select id="phase_id" name="phase_id" class="form-control select2" data-placeholder="Selecciona la Fase" style="width:100%;" required="true">
										<option></option>
										' . $phase_opts . '
									</select>
									<span class="help-block">
										<small class="text-warning pull-right">(requerido)</small>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Avance del Proyecto</label>
								<div class="col-sm-10">
									<div class="input-group">
										<span class="input-group-addon" style="width:45%;">Avance Planificado</span>
										<input type="number" class="form-control" name="plan_percentage"/>
										<span class="input-group-addon">%</span>
									</div>
									<div class="input-group">
										<span class="input-group-addon" style="width:45%;">Avance Real</span>
										<input type="number" class="form-control" name="real_percentage"/>
										<span class="input-group-addon">%</span>
									</div>
								</div>
							</div>
						</div>
						<h4>Responsables del Proyecto</h4>
						<div class="form-group">
							<label for="pm_user_id" class="col-sm-2 control-label">Project Manager</label>
							<div class="col-sm-10">
								<select id="pm_user_id" name="pm_user_id" class="form-control select2" data-placeholder="Selecciona el Project Manager" style="width:100%;" data-allow-clear="true">
									<option></option>
									' . $pm_user_opts . '
								</select>
								<span class="help-block">
								</span>
							</div>
						</div>
						<div class="form-group">
							<label for="tl_user_id" class="col-sm-2 control-label">L&iacute;der T&eacute;cnico</label>
							<div class="col-sm-10">
								<select id="tl_user_id" name="tl_user_id" class="form-control select2" data-placeholder="Selecciona el L&iacute;der T&eacute;cnico" style="width:100%;" data-allow-clear="true">
									<option></option>
									' . $tl_user_opts . '
								</select>
								<span class="help-block">
								</span>
							</div>
						</div>
						<h4>Documentación del Proyecto</h4>
						<p>Los repositorios de documentación del proyecto deben estar creados acorde a las <a href="#" target="_blank">reglas de documentación de proyecto <i class="fa fa-fw fa-external-link"></i></a>.
						<div class="form-group">
							<label for="doc_link" class="col-sm-2 control-label">Enlace de Documentaci&oacute;n</label>
							<div class="col-sm-10">
								<input type="url" id="doc_link" name="doc_link" class="form-control" placeholder="Enlace de Documentaci&oacute;n">
									<option></option>
								</select>
								<span class="help-block">
								</span>
							</div>
						</div>
						<div class="form-group">
							<label for="plan_link" class="col-sm-2 control-label">Enlace de Planificac&oacute;n</label>
							<div class="col-sm-10">
								<input type="url" id="plan_link" name="plan_link" class="form-control" placeholder="Enlace de Planificac&oacute;n">
									<option></option>
								</select>
								<span class="help-block">
								</span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10 text-right">
								<button type="reset" class="btn btn-default"><i class="fa fa-fw fa-history"></i>Cancelar</button>
								<button type="submit" class="btn btn-primary " ><i class="fa fa-fw fa-plus"></i>Crear Proyecto</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div><!-- .container -->';
	}else{
		$o.=self::no_permissions_msg();
	}

	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_pm_filtered_panel(){
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$o = $this->csi_pm_panel_builder ( $post );
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
protected function csi_pm_panel_builder ( $post ) {
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_PROJECT_STATUS;
	//Local Variables

	//self::write_log ( $post );

	$status					= $post['status'];
	$show_plan				= isset ( $post['show_plan'] ) ? TRUE : NULL ;
	$plan					= '';
	$show_table				= isset ( $post['show_table'] ) ? TRUE : NULL ;
	$table					= '';
	$group_by				= '';
	$order_by				= '';
	$start_date				= new DateTime ( explode ( ' - ', $post['date_range'] )[0] );
	$end_date				= new DateTime ( explode ( ' - ', $post['date_range'] )[1] );
	//--------------------------------------------------------------------------
	$sql = '
		SELECT
			T00.*,
			T00.id as project_id,
			T01.id as customer_id,
			T01.code as customer_code,
			T02.short_name as status_short_name,
			T02.css_class as status_class,
			IF ( T00.registered_customer_flag , T01.short_name, T00.non_registered_customer_name ) as customer_short_name
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T01
				ON T00.registered_customer_id = T01.id
			LEFT JOIN ' . $NOVIS_CSI_PROJECT_STATUS->tbl_name . ' as T02
				ON T00.status_id = T02.id
		WHERE
			T00.status_id IN (' . $status . ')
			AND T00.planned_end_date > "' . $start_date->format('Y-m-d') . '"
			AND T00.planned_start_date < "' . $end_date->format('Y-m-d') . '"
	';
	//--------------------------------------------------------------------------
	if ( $show_plan ){
		$plan.=$this->csi_pm_build_gantt ( $sql, $post, $start_date, $end_date );
	}
	//--------------------------------------------------------------------------
	if ( $show_table ){
		$table.='
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th>Cliente</th>
						<th>Nombre de Proyecto</th>
						<th>PM</th>
						<th>L&iacute;der T&eacute;cnico</th>
						<th>Fecha plan inicio</th>
						<th>Fecha plan fin</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
		';
		$projects = $this->get_sql ( $sql );
		foreach ( $projects as $project ){
			$customer_name = ( NULL != $project['customer_id'] ) ? $project['customer_short_name'] : $project['non_registered_customer_name'];
			$table.='
					<tr>
						<td class="small">' . $project['customer_short_name'] . '</td>
						<td class="small"><a href="#!showproject?project_id=' . $project['project_id'] . '">' . $project['short_name'] . '</a></td>
						<td>PM</td>
						<td>lider</td>
						<td>' . $project['planned_start_date'] . '</td>
						<td>' . $project['planned_end_date'] . '</td>
						<td class="' . $project['status_class'] . '">' . $project['status_short_name'] . '</td>
					</tr>
			';
		}
		$table.='
				</tbody>
			</table>
		';
	}
	$o=$plan;
	$o.=$table;
	return $o;
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_pm_build_page_list_projects(){
	//Global Variables
	global $NOVIS_CSI_PROJECT_STATUS;
	global $NOVIS_CSI_COUNTRY;
	//Local Variables
	$pm_status_opt			= '';
	$country_opt			= '';
	//--------------------------------------------------------------------------
	foreach ( $NOVIS_CSI_COUNTRY->get_all() as $country ){
		$country_opt.='<option value="' . $country['id'] . '" selected>' . $country['short_name'] . '</option>';
	}
	//--------------------------------------------------------------------------
	$default_status_codes = array ( 'executing', 'revision');
	foreach ( $NOVIS_CSI_PROJECT_STATUS->get_all() as $pm_status ){
		$selected = in_array ( $pm_status['code'], $default_status_codes ) ? 'selected' : '';
		$pm_status_opt.='<option value="' . $pm_status['id'] . '" ' . $selected . '>' . $pm_status['short_name'] . '</option>';
	}
	//--------------------------------------------------------------------------
	$start_date = new DateTime();
	$start_date->modify('-3 months');
	$end_date = new DateTime();
	$end_date->modify('+3 months');
	//--------------------------------------------------------------------------
	$o='
	<div class="container">
		<div class="page-header row">
			<h3 class="col-sm-10">Proyectos</h3>';
	if ( current_user_can_for_blog ( 1, 'csi_create_projects' ) ){
		$o.='
			<h3 class="col-sm-2">
				<a href="#!newproject" class="btn btn-success">
					<i class="fa fa-plus"></i> Nuevo Proyecto
				</a>
			</h3>
		';
	}
	$o.='
		</div>
		<div class="panel panel-default row">
			<div class="panel-heading">
				<a data-toggle="collapse" href="#csi-pm-panel-filter" role="button">
					<i class="fa fa-filter"></i> Filtros
				</a>
				<div class="pull-right">
					<a data-toggle="collapse" href="#csi-pm-panel-filter" role="button">
						<i class="fa fa-fw fa-caret-down"></i>
					</a>
				</div>
			</div>
			<div class="panel-body collapse" id="csi-pm-panel-filter">
				<form class="form-horizontal" id="csi-pm-filtered-pm-panel-form" data-target="#csi-pm-filtered-pm-panel">
					<div class="form-group">
						<label for="status" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10">
							<select class="form-control select2" multiple="multiple" style="width:100%;" name="status" id="status">
								' . $pm_status_opt . '
							</select>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Rango de Fechas</label>
						<div class="col-sm-10">
							<input type="text" class="form-control csi-date-range-input" name="date_range" id="date_range" value="' . $start_date->format('Y-m') . '-01 - ' . $end_date->format('Y-m-t') . '"" data-show-dropdowns="true" data-auto-apply="true" data-show-dropdowns="true"/>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Despliegue</label>
						<div class="col-sm-10">
							<div class="">
								<input type="checkbox" name="show_plan" id="show_plan" value="1" class="form-control csi-cool-checkbox" >
								<label for="show_plan">Desplegar Plan</label>
							</div>
							<div class="">
								<input type="checkbox" name="show_table" id="show_table" value="0" class="form-control csi-cool-checkbox" checked>
								<label for="show_table">Desplegar Tabla</label>
							</div>
							<p class="help-block">
								Indica que elementos mostrar
							</p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Agrupar por</label>
						<div class="col-sm-10">
							<div class="">
								<input type="radio" name="group_by" id="group_by_1" value="1" class="csi-cool-radio" checked>
								<label for="group_by_1">Cliente</label>
							</div>
							<div class="">
								<input type="radio" name="group_by" id="group_by_2" value="2" class="csi-cool-radio">
								<label for="group_by_2">Status</label>
							</div>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Ordernar por</label>
						<div class="col-sm-10">
							<div class="">
								<input type="radio" name="order_by" id="order_by_1" value="1" class="csi-cool-radio" checked>
								<label for="order_by_1">Cliente</label>
							</div>
							<div class="">
								<input type="radio" name="order_by" id="order_by_2" value="2" class="csi-cool-radio">
								<label for="order_by_2">Status</label>
							</div>
							<div class="">
								<input type="radio" name="order_by" id="order_by_3" value="3" class="csi-cool-radio" checked>
								<label for="order_by_3">Fecha Inicio</label>
							</div>
							<div class="">
								<input type="radio" name="order_by" id="order_by_4" value="4" class="csi-cool-radio" checked>
								<label for="order_by_4">Fecha Fin</label>
							</div>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group ">
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10 text-center">
							<a class="refresh-button btn btn-primary" data-refresh-table="" href="#csi-pm-filtered-pm-panel">
								<i class="fa fa-filter"></i> Filtrar
							</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="panel panel-default row">
			<div class="panel-heading">
				<strong class="">
					<i class="fa fa-tasks"></i>
					Panel de Resumen de Proyectos
				</strong>
				<div class="pull-right">
					<a class="refresh-button" data-refresh-table="" href="#csi-pm-filtered-pm-panel">
						<i class="fa fa-fw fa-refresh"></i>
					</a>
				</div>
			</div>
			<div id="csi-pm-filtered-pm-panel" class="table refreshable" data-action="csi_pm_filtered_panel" data-filter-form="#csi-pm-filtered-pm-panel-form" style="position:relative;"></div>
		</div>
	</div>
	';
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_pm_build_page_show_project(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_PROJECT_STATUS;
	//Local Variables
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$o					= '';
	$project_id = $post['project_id'];
	//--------------------------------------------------------------------------
	$sql = '
		SELECT
			T00.pm_user_id,
			T00.tl_user_id,
			T00.short_name as short_name,
			T00.description as description,
			T00.id as project_id,
			T00.real_percentage,
			T00.plan_percentage,
			T00.planned_start_date,
			T00.planned_end_date,
			T01.id as customer_id,
			T01.code as customer_code,
			T02.id as status_id,
			T02.short_name as status_short_name,
			T02.css_class as status_class,
			IF ( T00.registered_customer_flag , T01.short_name, T00.non_registered_customer_name ) as customer_short_name
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T01
				ON T00.registered_customer_id = T01.id
			LEFT JOIN ' . $NOVIS_CSI_PROJECT_STATUS->tbl_name . ' as T02
				ON T00.status_id = T02.id
		WHERE
			T00.id ="' . $project_id . '"
	';
	$project = $wpdb->get_row ( $sql );
	//--------------------------------------------------------------------------
	$sql = 'SELECT
				id,
				short_name,
				IF(id = ' . $project->status_id . ', "selected", "") as selected
	 		FROM ' . $NOVIS_CSI_PROJECT_STATUS->tbl_name . ' ';
	$status_inline_options = '';
	foreach ( $this->get_sql ( $sql ) as $status ){
		$status_inline_options.='<option value="' . $status['id'] . ' ' . $status['selected'] . '">' . $status['short_name'] . '</option>';
	}
	//--------------------------------------------------------------------------
	$o = '
	<div class="container">

		<div class="page-header row">
			<a href="#!listprojects"><i class="fa fa-angle-left fa-fw"></i> Proyectos</a>
			<h3 class="clearfix">
				<span class="col-sm-10">' . $project->short_name . ' <small>' . $project->customer_short_name . '</small></span>
				<p class="col-sm-2 text-right">
					<a href="#!editproject?p=' . $project_id . '" class="btn btn-default">
						<i class="fa fa-pencil"></i> Editar
					</a>
				</p>
			</h3>
		</div><!-- .page-header -->
		<div class="row">
			<h4 class="col-sm-3">Ficha del Proyecto</h4>
			<div class="col-sm-9">
				<table class="table table-condensed">
					<tbody>
						<tr>
							<th class="small text-muted">Cliente</th>
							<td>' . $project->customer_short_name . '</td>
						</tr>
						<tr>
							<th class="small text-muted">Titulo del Proyecto</th>
							<td><i>' . $project->short_name . '</i></td>
						</tr>
						<tr>
							<th class="small text-muted">Status</th>
							<td>' . $project->status_short_name . '</td>
						</tr>
						<tr>
							<th class="small text-muted">Fechas del Proyecto</th>
							<td>
								' . $project->planned_start_date .
								'<i class="fa fa-fw fa-angle-right"></i>' .
								$project->planned_end_date . '
							</td>
						</tr>
						<tr>
							<th class="small text-muted">Avance Planificado</th>
							<td>
								<div class="progress" style="margin-bottom:0px;">
  									<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;width: ' . $project->plan_percentage . '%;">
										' . $project->plan_percentage . '%
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<th class="small text-muted">Avance Real</th>
							<td>
								<div class="progress" style="margin-bottom:0px;">
  									<div class="progress-bar progress-bar-' . ( $project->plan_percentage <= $project->real_percentage ? 'success' : 'warning' ) . ' " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;width: ' . $project->real_percentage . '%;">
										' . $project->real_percentage . '%
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<th class="small text-muted">Project Manager</th>
							<td>' . get_userdata ( $project->pm_user_id )->display_name . '</td>
						</tr>
						<tr>
							<th class="small text-muted">Líder Técnico</th>
							<td>' . get_userdata ( $project->tl_user_id )->display_name . '</td>
						</tr>
						<tr>
							<th class="small text-muted">Planificación</th>
							<td>
								<a target="_blank" href="#">
									Enlace al plan de Actividades <i class="fa fa-external-link"></i>
								</a>
							</td>
						</tr>
						<tr>
							<th class="small text-muted">Documentos</th>
							<td>
								<a target="_blank" href="#">
									Enlace al Documentaci&oacute;n del Proyecto <i class="fa fa-external-link"></i>
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div><!-- .row -->
		<div class="row">
			<h4 class="col-sm-3">Descripci&oacute;n del Proyecto</h4>
			<div class="col-sm-9">
				<p id="csi-pm-project-description-short" class="text-justify collapse in">
					' . nl2br ( substr ( $project->description, 0, 400 ) );
	if ( 200 < strlen ( $project->description) ){
		$o.='
					<button class="hidden-print btn btn-success btn-xs" type="button" data-toggle="collapse" data-target="#csi-pm-project-description-short,#csi-pm-project-description-long" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-expand"></i></button>
				</p>
				<p id="csi-pm-project-description-long" class="text-justify collapse" >' . nl2br ( $project->description ) . '
					<button class="hidden-print btn btn-danger btn-xs" type="button" data-toggle="collapse" data-target="#csi-pm-project-description-short,#csi-pm-project-description-long" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-compress"></i></button>
				';
	}
	$o.='
				</p>
			</div>
		</div><!-- .row -->
		<div class="row">
			<div class="panel panel-info">
				<div class="panel-heading">
					<i class="fa fa-fw fa-info"></i> Informaci&oacute;n
					<div class="pull-right  text-info">
						<a href="#csi-fetch-project-info-list-info" class="refresh-button text-info"><i class="fa fa-fw fa-refresh"></i></a>
						|
						<a data-toggle="collapse" href="#project-' . $project->project_id . '-infos" role="button" class="collapsed text-info" aria-expanded="false">
							<i class="fa fa-fw fa-caret-down"></i>
						</a>
					</div>
				</div>
				<div id="project-' . $project->project_id . '-infos" class="collapse">
					<table class="table  refreshable" id="csi-fetch-project-info-list-info" data-action="csi_fetch_project_info_list_info" data-project-id="' . $project->project_id . '" style="position:relative; margin-bottom:0;">
						<thead>
							<tr>
								<th class="col-xs-1">&nbsp;</th>
								<th class="col-xs-2">Fecha</th>
								<th class="col-xs-9">Informaci&oacute;n</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div><!-- #project-' . $project->project_id . '-infos -->
			</div><!-- .panel -->
		</div><!-- .row -->
		<div class="row">
			<div class="panel panel-success">
				<div class="panel-heading">
					<i class="fa fa-fw fa-usd"></i> Hitos de Facturaci&oacute;n
					<div class="pull-right  text-invoice">
						<a href="#csi-fetch-project-invoice-list-invoice" class="refresh-button text-success"><i class="fa fa-fw fa-refresh"></i></a>
						|
						<a data-toggle="collapse" href="#project-' . $project->project_id . '-invoices" role="button" class="collapsed text-success" aria-expanded="false">
							<i class="fa fa-fw fa-caret-down"></i>
						</a>
					</div>
				</div>
				<div id="project-' . $project->project_id . '-invoices" class="collapse">
					<table class="table  refreshable" id="csi-fetch-project-invoice-list-invoice" data-action="csi_fetch_project_invoice_list_info" data-project-id="' . $project->project_id . '" style="position:relative; margin-bottom:0;">
						<thead>
							<tr>
								<th class="col-xs-1">&nbsp;</th>
								<th class="col-xs-2">Fecha</th>
								<th class="col-xs-2">Monto</th>
								<th class="col-xs-2">OK</th>
								<th class="col-xs-6">Hito de Facturaci&oacute;n</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div><!-- #project-' . $project->project_id . '-invoices -->
			</div><!-- .panel -->
		</div><!-- .row -->
		<div class="row">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<i class="fa fa-fw fa-exclamation-triangle"></i> Riesgos
					<div class="pull-right  text-warning">
						<a href="#csi-fetch-project-risk-list-info" class="refresh-button text-warning"><i class="fa fa-fw fa-refresh"></i></a>
						|
						<a data-toggle="collapse" href="#project-' . $project->project_id . '-risks" role="button" class="collapsed text-warning" aria-expanded="false">
							<i class="fa fa-fw fa-caret-down"></i>
						</a>
					</div>
				</div>
				<div id="project-' . $project->project_id . '-risks" class="collapse">
					<table class="table  refreshable" id="csi-fetch-project-risk-list-info" data-action="csi_fetch_project_risk_list_info" data-project-id="' . $project->project_id . '" style="position:relative; margin-bottom:0;">
						<thead>
							<tr>
								<th class="col-xs-1">&nbsp;</th>
								<th class="col-xs-2">Fecha</th>
								<th class="col-xs-1"><i class="fa fa-fw fa-check-square-o"></i></th>
								<th class="col-xs-8">Riesgo</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div><!-- #project-' . $project->project_id . '-risks -->
			</div><!-- .panel -->
		</div><!-- .row -->
	</div><!-- .container -->

	';
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_pm_build_page_intro(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_PROJECT_REQUEST_STATUS;
	global $NOVIS_CSI_PROJECT_REQUEST;
	//Local Variables
	$o					= '';
	//--------------------------------------------------------------------------
	$o.='
	<div class="jumbotron">
		<div class="container">
			<h2>Gestión de Proyectos Novis</h2>
			<p>Módulo de registro y control de proyectos.</p>
			<p><a class="btn btn-primary btn-lg" href="#!listplans" role="button">Aprender más</a></p>
		</div>
	</div><!-- .jumbotron -->
	<nav class="container">
		<div class="row">
			<div class="list-group col-sm-6 col-md-4">
				<a href="#!listprojects" class="list-group-item list-group-item-info">
					<h3><i class="fa fa-fw fa-tasks"></i>Proyectos</h3>
					<p class="text-justify">Proyectos Novis.</p>
				</a>
			</div>';
	if ( current_user_can_for_blog ( 1, 'csi_create_projects' ) ){
		$o.='
			<div class="list-group col-sm-6 col-md-4">
				<a href="#!newproject" class="list-group-item active">
					<h3><i class="fa fa-fw fa-plus"></i>Nuevo Proyecto</h3>
					<p class="text-justify">Aqui puedes solicitar o proponer un nuevo Proyecto.</p>
				</a>
			</div>
		';
	}
	$o.='
			<div class="list-group col-sm-6 col-md-4">
				<a href="#!pm_dashboard" class="list-group-item list-group-item-success">
					<h3><i class="fa fa-fw fa-dashboard"></i>Dashboards</h3>
					<p class="text-justify">Vsitas pre-fabricadas para la gestión de Proyectos.</p>
				</a>
			</div>
			';
	$o.='
			<div class="list-group col-sm-6 col-md-4">
				<a href="#!pm_dashboard" class="list-group-item list-group-item-warning">
					<h3><i class="fa fa-fw fa-bolt"></i>Línea de Tiempo</h3>
					<p class="text-justify">Vsitas pre-fabricadas para la gestión de Proyectos.</p>
				</a>
			</div>
	';
	if ( current_user_can_for_blog ( 1, 'csi_edit_project_request_restricted_fields' ) ){
		$status_code = array ('"new"');

		$sql = 'SELECT T01.code, T01.short_name, T01.css_class, COUNT(T01.code) as sum FROM ' . $NOVIS_CSI_PROJECT_REQUEST->tbl_name . ' as T00 LEFT JOIN ' . $NOVIS_CSI_PROJECT_REQUEST_STATUS->tbl_name . ' as T01 ON T00.status_id = T01.id GROUP BY T01.code';
		$status = $this->get_sql ( $sql );
		$text = '';
		foreach ($status as $stat){
			if ( $stat['code'] == 'new' ){
				$class= 'label-info';
			}else{
				$class= 'label-default';
			}
			$text .= '<li><span class="label ' . $class . '">' . $stat['sum'] . '</span> ' . $stat['short_name'] . '</li>';
		}
		$o.='
			<div class="list-group col-sm-6 col-md-4">
				<a href="#!listprojectrequests" class="list-group-item">
					<h3><i class="fa fa-fw fa-folder"></i>Solicitudes de Proyecto</h3>
					<ul class="list-unstyled">' . $text . '</ul>
				</a>
			</div>
		';
	}
	$o.='
		</div>
	</nav><!-- .container -->
	';
	$response['message']=$o;
	echo json_encode($response);
	wp_die();

}
protected function csi_pm_build_gantt ( $sql, $post, $start_date, $end_date ) {
	//Global Variables
	//Local Variables
	$o				= '';
	define('DAYS_PER_MONTH', 30);
	define('DURATION', 6);
	$start_date->modify('first day of this month');
	$end_date->modify('last day of this month');
	$year				= $start_date->format('Y');
	$month				= $start_date->format('m');
	$date_diff			= date_diff ( $end_date, $start_date );
	$months				= $date_diff->y * 12 + $date_diff->m + 1; //5 months 20 days -> 6 months
	$month_width		= 100 / $months;
	$o.='
	<div class="csi-project-panel" style="margin-left:' . $month_width . '%;">';
	//Build Frame
	$o.='
		<div class="col-xs-12 timeline-header">';
	$o.='
			<div style="position:absolute;width:' . $month_width . '%;margin-left:-' . $month_width . '%;">Cliente</div>
	';
	for ( $i = 0 ; $i < $months ; $i++ ){
		$date = DateTime::createFromFormat('Y-m-d', $year.'-'.intval($month+$i).'-01');
		$date_header_long='<span>'.$date->format('F').'<br/><small class="text-muted">'.$date->format('Y').'</small></span>';
		$date_header_short='<span>'.$date->format('M').'<br/><small class="text-muted">'.$date->format('Y').'</small></span>';
		$o.='
			<div class="month text-center hidden-xs" style="width:'.$month_width.'%;">
				'.$date_header_long.'
			</div>';
		$o.='
			<div class="month text-center visible-xs" style="width:'.$month_width.'%;">
				'.$date_header_short.'
			</div>';
	}
	$o.='
		</div><!-- #timeline-header -->';
	//Build projects
	$customer_name = '';
	$projects = $this->get_sql ( $sql );
	$silent = FALSE;
	foreach ( $projects as $project){
		if ( self::validate_date( $project['planned_start_date'] ) && self::validate_date( $project['planned_end_date'] ) ){
			$planned_start_date	= DateTime::createFromFormat('Y-m-d', $project['planned_start_date']);
			$planned_end_date	= DateTime::createFromFormat('Y-m-d', $project['planned_end_date']);
			if( $start_date < $planned_start_date){
				$month_diff = new DateTime;
				$month_diff = date_diff ( $planned_start_date,$start_date);
				//add months
				$proj_prev = floatval ( intval ( $month_diff->y * 12 + $month_diff->m ) * $month_width );
				//add days
				$proj_prev = $proj_prev + intval( $month_diff->d ) / DAYS_PER_MONTH * $month_width;
			}else{
				$proj_prev = 0;
			}
			if( $end_date > $planned_end_date){
				$month_diff = new DateTime;
				$month_diff = date_diff ( $planned_end_date,$end_date);
				//add months
				$proj_post = floatval ( intval( $month_diff->y * 12 + $month_diff->m ) * $month_width );
				//add days
				$proj_post = $proj_post + $month_width / ( DAYS_PER_MONTH / intval( $planned_end_date->format('d') ) );
				//self::write_log( $month_width / ( DAYS_PER_MONTH / intval( $planned_end_date->format('d') ) ) );
			}else{
				$proj_post=0;
			}
			$proj_width = 100 - ($proj_prev + $proj_post);
			//self::write_log($proj_prev.' - '.$proj_width.' - '.$proj_post);
			$o.='
			<div class="row project">';
			if ( !$silent ){
				/*
				if ( $customer_name == $project['customer_short_name']){
					$display_customer_name =' &nbsp;';
				}else{
					$customer_name = $display_customer_name = $project['customer_short_name'];
				}
				*/
				$o.='
				<div class="col-xs-12 text-left project-options">
					<div class="btn-group btn-group-sm" style="width:' . $month_width . '%;margin-left:-' . $month_width . '%;overflow:hidden;" title="' . $project['customer_short_name'] . '" data-toggle="tooltip" data-placement="top" >
						<small>' . $project['customer_short_name'] . '</small>
					</div>
					<div class="month text-center" style=";width:'.$proj_prev.'%;">&nbsp;</div>
					<div class="btn-group btn-group-sm" style=";width:'.$proj_width.'%;">
						<a type="button" class="text-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<small><i class="fa fa-cog fa-fw"></i>'.$project['short_name'].'</small>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#" title="Ver los documentos del proyecto '.$project['short_name'].'"><i class="fa fa-tasks fa-fw" aria-hidden="true"></i> Tareas</a></li>
							<li><a href="#" title="Ver las tareas del proyecto '.$project['short_name'].'"><i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> Documentos</a></li>
						</ul>
					</div>
					 <div class="month" style="width:'.$proj_post.'%;">&nbsp;</div>
				</div>';
			}
			$short_name= true==$silent  ? '<small style="color:#FFF;white-space: nowrap;text-overflow: ellipsis;display: block;overflow: hidden;">&nbsp;'.$project['short_name'].'</small>':'&nbsp;';
			$start_class= (0 == $proj_prev) ? ' non_start ' : '';
			$end_class= (0 == $proj_post) ? ' non_end ' : '';
			$o.='
				<div class="col-xs-12 project-timeline">
					<div class="month text-center" style="width:'.$proj_prev.'%;">&nbsp;</div>
					<div class="month text-center" style="width:'.$proj_width.'%;">
						<div class="progress '.$start_class.$end_class.'">
							<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$project['percentage'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$project['percentage'].'%;min-width:2em;">
								<small>'.$project['percentage'].'%</small>
							</div>
						</div>
					</div>
					<div class="month" style="width:'.$proj_post.'%;">'.$short_name.'</div>
				</div>
			</div>';
		}else{
			//No se muestra el proyecto, ya que no tiene fechas valida planificadas
		}
	}
	$o.='
	</div><!-- .csi-project-panel -->';
	return $o;
}
//END OF CLASS

}
global $NOVIS_CSI_PROJECT;
$NOVIS_CSI_PROJECT =new NOVIS_CSI_PROJECT_CLASS();
?>
