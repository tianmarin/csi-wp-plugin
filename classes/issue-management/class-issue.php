<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_ISSUE_CLASS extends NOVIS_CSI_CLASS{
public $format	= "%05d";
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
	$this->class_name	= 'issue';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Issue';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Issues';
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
	$this->db_version	= '0.0.1';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="(
								id bigint(20) unsigned not null auto_increment COMMENT 'Unique ID for each entry',
								title tinytext not null COMMENT 'Title of Issue',
								status_id tinyint(1) unsigned not null COMMENT 'ID of Issue status',
								owner_team tinyint(2) unsigned not null COMMENT 'Owner team of Issue',
								summary text not null COMMENT 'Summary text of Issue',
								symptom text not null COMMENT 'Symptom text of Issue',
								terms text not null COMMENT 'Other terms text of Issue',
								reason text not null COMMENT 'Reason and prerequisites text of Issue',
								solution text not null COMMENT 'Solution text of Issue',
								creation_user_id bigint(20) unsigned null COMMENT 'Id of user responsible of the creation of each record',
								creation_user_email varchar(100) null COMMENT 'Email of user. Used to track user if user id is deleted',
								creation_date date null COMMENT 'Date of the creation of this record',
								creation_time time null COMMENT 'Time of the creation of this record',
								last_modified_user_id bigint(20) unsigned null COMMENT 'Id of user responsible of the last modification of this record',
								last_modified_user_email varchar(100) null COMMENT 'Email of user. Used to track user if user id is deleted',
								last_modified_date date null COMMENT 'Date of the last modification of this record',
								last_modified_time time null COMMENT 'Time of the last modification of this record',

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
		'task_link' => array(
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
	register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install'							));
	self::db_install();
	//in a new blog creation, create the db for new blog
	//Applies only for non-network classes
	if( true != $this->network_class ){
		add_action( 'wpmu_new_blog',							array( $this , 'db_install'							));
		add_action( 'wpmu_new_blog',							array( $this , 'db_install_data'					));
	}
	if ( !is_multisite() ) {
		add_action( 'admin_menu',		 						array( $this , "register_submenu_page"				));
	}else{
		add_action( 'network_admin_menu', 						array( $this , "register_submenu_page"				));
	}
	add_shortcode( 'csi_issue_list_panel',			 			array( $this , 'shortcode_issue_panel'				));
	//Add Ajax actions
	add_action( 'wp_ajax_csi_issue_build_page_intro', 			array( $this , 'csi_issue_build_page_intro'			));
	add_action( 'wp_ajax_csi_issue_new_issue_form',	 			array( $this , 'csi_issue_new_issue_form'			));
	add_action( 'wp_ajax_csi_add_issue', 						array( $this , 'csi_add_issue'						));
	add_action( 'wp_ajax_csi_issue_build_page_search_issue', 	array( $this , 'csi_issue_build_page_search_issue'	));
	add_action( 'wp_ajax_csi_issue_filtered_issues',	 		array( $this , 'csi_issue_filtered_issues'			));
	add_action( 'wp_ajax_csi_issue_filtered_issues_pagination', array( $this , 'csi_issue_filtered_issues_pagination'));
	add_action( 'wp_ajax_csi_issue_build_page_show_issue', 		array( $this , 'csi_issue_build_page_show_issue'	));


//	add_action( 'wp_ajax_nopriv_csi_new_issue_request', 		array( $this , 'new_issue_request'		));
}

public function csi_issue_new_issue_form(){
	//Global Variables
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_USER_TEAM;
	//Local Variables
	$o				= '';
	$user_teams_opts	= '';
	//--------------------------------------------------------------------------
	$sql = 'SELECT id, short_name FROM ' . $NOVIS_CSI_COUNTRY->tbl_name . ' ORDER BY short_name';
	foreach ( $this->get_sql ( $sql ) as $country ){
		$user_teams_opts.='<optgroup label="' . $country['short_name'] . '">';
		$sql = 'SELECT id, short_name, code FROM ' . $NOVIS_CSI_USER_TEAM->tbl_name . ' WHERE country_id="' . $country['id'] . '" ORDER BY short_name';
		foreach ( $this->get_sql ( $sql ) as $user_team ){
			$user_teams_opts.='<option value="' . $user_team['id'] . '">' . $user_team['short_name'] . ' (' . strtoupper ( $user_team['code'] ) . ')</option>';
		}
		$user_teams_opts.='</optgroup>';
	}
	//--------------------------------------------------------------------------
	$o.='
	<div class="container">
		<div class="panel panel-default row">
			<div class="panel-heading">
				<h1 class="panel-title">Crear Nota de Conocimiento NOVIS</h1>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" data-function="csi_add_issue" data-next-page="showissue" style="position:relative;">
					<div class="form-group">
						<label for="owner_team" class="col-sm-2 control-label">Equipo Responsable</label>
						<div class="col-sm-10">
							<select name="owner_team" id="owner_team" class="form-control select2 " required="true" data-placeholder="Selecciona el equipo responsable" tabindex="-1" aria-hidden="true">
								<option></option>
								' . $user_teams_opts . '
							</select>
							<p class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
						</div>
					</div>
					<div class="form-group ">
						<label for="title" class="col-sm-2 control-label">Titulo</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="title" name="title" placeholder="Titulo" required="true" maxlength="255"/>
							<p class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Indicar el nombre descriptivo del Proyecto.<br>Tamaño máximo: 255 caracteres
							</p>
						</div>
					</div>
					<div class="form-group ">
						<label for="summary" class="col-sm-2 control-label">Resumen</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="summary" name="summary" placeholder="Resumen" required="true" maxlength="800"></textarea>
							<p class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Indicar el nombre descriptivo del Proyecto.<br>Tamaño máximo: 800 caracteres
							</p>
						</div>
					</div>
					<div class="form-group ">
						<label for="symptom" class="col-sm-2 control-label">Sintoma</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="symptom" name="symptom" placeholder="Sintoma" required="true" maxlength="800" rows="6"></textarea>
							<p class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Indicar el nombre descriptivo del Proyecto.<br>Tamaño máximo: 800 caracteres
							</p>
						</div>
					</div>
					<div class="form-group ">
						<label for="terms" class="col-sm-2 control-label">Otros términos</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="terms" name="terms" placeholder="Otros términos" required="true" maxlength="800"></textarea>
							<p class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Indicar el nombre descriptivo del Proyecto.<br>Tamaño máximo: 800 caracteres
							</p>
						</div>
					</div>
					<div class="form-group ">
						<label for="reason" class="col-sm-2 control-label">Causa y Pre-Requisitos</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="reason" name="reason" placeholder="Causa y Pre-Requisitos" required="true" maxlength="800" rows="6"></textarea>
							<p class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Indicar el nombre descriptivo del Proyecto.<br>Tamaño máximo: 800 caracteres
							</p>
						</div>
					</div>
					<div class="form-group ">
						<label for="solution" class="col-sm-2 control-label">Solución</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="solution" name="solution" placeholder="Solución" required="true" maxlength="800" rows="6"></textarea>
							<p class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Indicar el nombre descriptivo del Proyecto.<br>Tamaño máximo: 800 caracteres
							</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<p class=" text-justify">
								Las Notas NOVIS tiene mucha actitud.
							</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10 text-right">
							<button type="reset" class="btn btn-danger">Cancelar</button>
							<button type="submit" class="btn btn-primary">Entiendo, Crear Nota Novis</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div><!-- .container -->';

	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_add_issue(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_ISSUE_STATUS;
	//Local Variables
	$insertArray			= array();
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user			= get_userdata ( get_current_user_id() );
	$current_datetime		= new DateTime();
	$default_status_code = 'draft';
	//$status_id = $wpdb->get_var ( 'SELECT id FROM ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' WHERE code ="' . $default_status_code . '"');
	$status_id = 1;

	//self::write_log ( $post );
	$insertArray['status_id']					= intval ( $status_id );
	$insertArray['owner_team']					= intval ( $post['owner_team'] );
	$insertArray['title']						= strip_tags(stripslashes( $post['title'] ) );
	$insertArray['summary']						= strip_tags(stripslashes( $post['summary'] ) );
	$insertArray['symptom']						= strip_tags(stripslashes( $post['symptom'] ) );
	$insertArray['terms']						= strip_tags(stripslashes( $post['terms'] ) );
	$insertArray['reason']						= strip_tags(stripslashes( $post['reason'] ) );
	$insertArray['solution']					= strip_tags(stripslashes( $post['solution'] ) );

	$insertArray['creation_user_id']			= $current_user->ID;
	$insertArray['creation_user_email']			= $current_user->user_email;
	$insertArray['creation_date']				= $current_datetime->format('Y-m-d');
	$insertArray['creation_time']				= $current_datetime->format('H:i:s');
	//self::write_log ( $post );
	//self::write_log ( $editArray );
	if ( $wpdb->insert( $this->tbl_name, $insertArray ) ){
		$response['id']=$wpdb->insert_id;
		$issue_id = $wpdb->insert_id;
		//crear registro de Ejecutores
		$response['postSubmitAction']	='changeHash';
		$response['new_id']				= '#!showissue?issue_id=' . $issue_id;
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
			'content'			=> 'Has agregado un nuevo ' . $this->name_single . ' exitosamente. (ID: <code>NOV' . $issue_id . '</code>)',
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
	global $NOVIS_CSI_ISSUE_STATUS;
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
			T00.id as issue_id,
			T01.id as customer_id,
			T01.code as customer_code,
			T02.short_name as status_short_name,
			T02.css_class as status_class,
			IF ( T00.registered_customer_flag , T01.short_name, T00.non_registered_customer_name ) as customer_short_name
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T01
				ON T00.registered_customer_id = T01.id
			LEFT JOIN ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' as T02
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
						<th>KAM</th>
						<th>Fecha plan inicio</th>
						<th>Fecha plan fin</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
		';
		$issues = $this->get_sql ( $sql );
		foreach ( $issues as $issue ){
			$customer_name = ( NULL != $issue['customer_id'] ) ? $issue['customer_short_name'] : $issue['non_registered_customer_name'];
			$table.='
					<tr>
						<td class="small">' . $issue['customer_short_name'] . '</td>
						<td class="small"><a href="#!showissue?issue_id=' . $issue['issue_id'] . '">' . $issue['short_name'] . '</a></td>
						<td>PM</td>
						<td>lider</td>
						<td>kam</td>
						<td>' . $issue['planned_start_date'] . '</td>
						<td>' . $issue['planned_end_date'] . '</td>
						<td class="' . $issue['status_class'] . '">' . $issue['status_short_name'] . '</td>
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
public function csi_issue_build_page_search_issue(){
	//Global Variables
	global $NOVIS_CSI_ISSUE_STATUS;
	global $NOVIS_CSI_COUNTRY;
	//Local Variables
	//--------------------------------------------------------------------------
	$o='
	<div class="container">
		<div class="page-header row">
			<h2 class="">Notas Novis</h2>
			<p class="text-muted text-justify">Blablabla</p>
		</div>
		<div class="row">
			<form class="form-horizontal" id="csi-issue-filtered-issues-form" data-target="#csi-issue-filtered-issues,#csi-issue-filtered-issues-pagination">
				<div class="form-group col-sm-10">
						<input type="text" class="form-control input-lg" id="issue_text" name="issue_text" placeholder=""  required="true"/>
				</div>
				<div class="form-group col-sm-2">
					<button type="submit" class="refresh-button btn btn-primary btn-lg btn-block" data-refresh-elements="#csi-issue-filtered-issues,#csi-issue-filtered-issues-pagination">
						<i class="fa fa-search"></i> Buscar
					</button>
				</div>
			</form>
		</div>
		<div class="row">
			<div id="csi-issue-filtered-issues" class="table " data-action="csi_issue_filtered_issues" data-filter-form="#csi-issue-filtered-issues-form" style="position:relative;"></div>
			<div style="position:relative;">
				<div id="csi-issue-filtered-issues-pagination" class=" text-center" data-action="csi_issue_filtered_issues_pagination" data-filter-form="#csi-issue-filtered-issues-form"></div>
			</div>

		</div>
	</div>
	';
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_issue_filtered_issues(){
	//Global Variables
	global $NOVIS_CSI_ISSUE_EVENT;
	global $NOVIS_CSI_ISSUE_STATUS;
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_CUSTOMER;
	//Local Variables
	$o				= '';
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	if ( isset ( $post['issue_text'] ) AND 0 != strlen ($post['issue_text'] ) ) {
		//--------------------------------------------------------------------------
		$regex = '~"[^"]*"(*SKIP)(*F)|[ /]+~';
		$terms = preg_split ( $regex, $post['issue_text'] );
		$conditions = array();
		$results = self::csi_issue_filtered_issues_sql($post);
		//$results = $this->get_sql ( $sql );
		$o.='
		<table class="table">
			<thead>
				<tr>
					<th>id</th>
					<th>Titulo</th>
					<th>Creación</th>
					<th>Modificación</th>
				</tr>
			</thead>
			<tbody>';
		foreach ( $results['rows'] as $result ){
			$creation_date = new DateTime ( $result['creation_date'] );
			$modification_date = new DateTime ( $result['last_modified_date'] );
			$o.='
				<tr>
					<td>
						<a href="#!showissue?i=NOV' . $this->nov_id ( $result['id'] ) . '&issue_text=' . urlencode ( $post['issue_text'] ). '" target="_blank">
							NOV' . $this->nov_id ( $result['id'] ) . ' <i class="fa fa-fw fa-external-link"></i>
						</a>
					</td>
					<td>' . $result['title'] . '</td>
					<td>' . $creation_date->format('d-m-Y') . '</td>
					<td>' . $modification_date->format('d-m-Y') . '</td>
				</tr>
			';
		}
		$o.='
			</tbody>
		</table>
		';
	}else{
		$o.='<div class="well">Busca arriba</div>';
	}

	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
protected function csi_issue_filtered_issues_sql ( $post, $calculate_rows = TRUE ) {
	//Global Variables
	global $NOVIS_CSI_ISSUE_EVENT;
	global $NOVIS_CSI_ISSUE_STATUS;
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_CUSTOMER;
	global $wpdb;
	//Local Variables
	$page_size		= 20;
	$page_no		= isset ( $post['pageNo'] ) ? intval ( $post['pageNo'] ) : 1 ;
	$results		= array();
	//Execution
	$regex = '~"[^"]*"(*SKIP)(*F)|[ /]+~';
	$terms = preg_split ( $regex, $post['issue_text'] );
	$conditions = array();

	$sql = '
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_ISSUE_EVENT->tbl_name . ' as T01
				ON T01.issue_id = T00.id
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T02
				ON T01.customer_id = T02.id
		WHERE
		';
	foreach ( $terms as $term ){
		$term = str_replace ( '\"', '', $term );
		$text='
			(
			UPPER(T00.title) LIKE UPPER("%' . $term . '%")
			OR UPPER(T00.summary) LIKE UPPER("%' . $term . '%")
			OR UPPER(T00.symptom) LIKE UPPER("%' . $term . '%")
			OR UPPER(T00.terms) LIKE UPPER("%' . $term . '%")
			OR UPPER(T00.reason) LIKE UPPER("%' . $term . '%")
			OR UPPER(T00.solution) LIKE UPPER("%' . $term . '%")
			OR UPPER(T02.short_name) LIKE UPPER("%' . $term . '%")
			OR UPPER(T02.code) LIKE UPPER("%' . $term . '%")
			)
		';
		array_push ( $conditions, $text );
	}
	$sql.=implode (' AND ', $conditions );
	//self::write_log ( $sql );
	$results['total_rows']	= $wpdb->get_var ( 'SELECT COUNT(DISTINCT T00.id) as total ' . $sql );
	if ( $results['total_rows'] <= $page_size ){
		$page_no = 1;
	}
	if ( $calculate_rows ){
		$rows = 'SELECT DISTINCT T00.id, T00.title, T00.creation_date, T00.last_modified_date ';
		$limit = ' LIMIT ' . ( $page_no - 1 ) * $page_size . ',' . $page_size ;
		$results['rows']		= $this->get_sql (  $rows . $sql . $limit );
	}
	$results['pages']		= ceil ( $results['total_rows'] / $page_size );
	$results['page_no']		= $page_no;

	return $results;
}
public function csi_issue_filtered_issues_pagination(){
	//Global Variables

	//Local Variables
	$response		= array();
	$pagination		= '';
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;

	if ( isset ( $post['issue_text'] ) AND 0 != strlen ($post['issue_text'] ) ) {
		$results = self::csi_issue_filtered_issues_sql ( $post, FALSE ) ;
		self::write_log( $post );
		$page_no = $results['page_no'];
		$page_count = $results['pages'];
		if ( $page_count > 1){
			$pagination.= '
			<nav aria-label="Page navigation">
				<ul class="pagination">
					<li class="' . ( ( $page_no <= 0 ) ? 'disabled' : '' ). '">
						<button data-refresh-elements="#csi-issue-filtered-issues,#csi-issue-filtered-issues-pagination" aria-label="Previous" data-page-no="' . strval ( ( $page_no <= 0 ) ? 0 :  $page_no ) . '" class="refresh-button btn btn-default btn-sm">
							<span aria-hidden="true">&laquo;</span>
						</button>
					</li>
			';
			for ( $i = 1 ; $i <= $page_count ; $i++ ){
				$pagination.= '
					<li class="">
						<button data-refresh-elements="#csi-issue-filtered-issues,#csi-issue-filtered-issues-pagination" data-page-no="' . $i . '" class="refresh-button btn btn-' . ( $i == $page_no ? 'primary' : 'default' ). ' btn-sm">
							' .$i . '
						</button>
					</li>';
			}
			$pagination.='
					<li class="' . ( ( $page_no + 1 >= $page_count) ? 'disabled' : '' ) . '">
						<button data-refresh-elements="#csi-issue-filtered-issues,#csi-issue-filtered-issues-pagination" aria-label="Next" data-page-no="' . ( strval ( $page_no + 1 >= $page_count ) ? $page_count-1 : intval ( $page_no + 1 ) ). '" class="refresh-button btn btn-default btn-sm">
							<span aria-hidden="true">&raquo;</span>
						</button>
					</li>
				</ul>
			</nav>';
		}else{
			$pagination = '&nbsp;';
		}

		$response['message'] = $pagination;
	}else{
		$response['message'] ="fds";
	}
	echo json_encode($response);
	wp_die();
}
public function csi_issue_build_page_show_issue(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_ISSUE_STATUS;
	//Local Variables
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$o					= '';
	$issue_id = preg_replace ( '/[^0-9]/', '', $post['i'] );
	//--------------------------------------------------------------------------
	$sql = '
		SELECT
			*
		FROM
			' . $this->tbl_name . ' as T00
		WHERE
			T00.id ="' . $issue_id . '"
	';
	$issue = $wpdb->get_row ( $sql );
	//--------------------------------------------------------------------------
	if ( isset ( $post['issue_text'] ) AND 0 != strlen ($post['issue_text'] ) ) {
		$regex = '~"[^"]*"(*SKIP)(*F)|[ /]+~';
		$terms = preg_split ( $regex, urldecode ( $post['issue_text'] ) ) ;
		//self::write_log (  urldecode ( $post['issue_text'] ));
		$conditions = array();
		foreach ( $terms as $term ){
			foreach ( $issue as $key => $value ){
				if ( $key == 'id' ){
					$value = $this->nov_id ( $value);
				}
				$pattern = preg_quote($term);
				$issue->$key  = preg_replace("/($pattern)/i", '<mark>$1</mark>', $value);
			}
		}
	}
	//--------------------------------------------------------------------------
	$o = '
	<div class="container">

		<div class="page-header row">
			<a href="#!searchissues" class="hidden-print"><i class="fa fa-angle-left fa-fw"></i> Buscador de Notas Novis</a>
			<h3 class="clearfix">
				<span class="col-sm-10">NOV' . $issue->id . ' - ' . $issue->title . '</span>
				<p class="col-sm-2 text-right hidden-print">
					<a href="#!editissue?plan_id=' . $issue_id . '" class="btn btn-default">
						<i class="fa fa-pencil"></i> Editar
					</a>
				</p>
			</h3>
		</div><!-- .page-header -->
		<div class="row">
			<div class="csi-issue-summary">
				<h3 class=""><samp>Resumen</samp></h3>
				<p class="text-justify"><samp>' . $issue->summary . '</samp></p>
			</div><!-- .csi-issue-summary -->
			<div class=" csi-issue-symptom">
				<h3 class=""><samp>Sintoma</samp></h3>
				<p class="text-justify"><samp>' . $issue->symptom . '</samp></p>
			</div><!-- .csi-issue-symptom -->
			<div class=" csi-issue-terms">
				<h3 class=""><samp>Otros Términos</samp></h3>
				<p class="text-justify"><samp>' . $issue->terms . '</samp></p>
			</div><!-- .csi-issue-terms -->
			<div class=" csi-issue-reason">
				<h3 class=""><samp>Causa y Pre-Requisitos</samp></h3>
				<p class="text-justify"><samp>' . $issue->reason . '</samp></p>
			</div><!-- .csi-issue-reason -->
			<div class=" csi-issue-solution">
				<h3 class=""><samp>Solución</samp></h3>
				<p class="text-justify"><samp>' . $issue->solution . '</samp></p>
			</div><!-- .csi-issue-solution -->
			<div class=" csi-issue-event">
				<h3 class=""><samp>Eventos</samp></h3>
				<p class="help-block">Los <strong>eventos</strong> permiten registrar en que contexto se utilizó la Nota Novis, para futuras búsquedas de errores relacionados con clientes.</p>
				<table class="refreshable table table-condensed" data-action="csi_fetch_issue_event_list_info" data-issue-id="' . $issue_id . '">
					<thead>
						<tr>
							<th class="col-xs-3">Cliente</th>
							<th class="col-xs-3">Sistema</th>
							<th class="col-xs-3">Ticket</th>
							<th class="col-xs-3">Fecha</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div><!-- .csi-issue-event -->
		</div>
	</div><!-- .container -->

	';
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_issue_build_page_intro(){
	//Global Variables
	//Local Variables
	$o					= '';
	//--------------------------------------------------------------------------
	$o.='
	<div class="jumbotron">
		<div class="container">
			<h2>Gestión de Notas Novis</h2>
			<p>:)</p>
			<p><a target="_blank" href="#!listissues" class="btn btn-primary btn-lg" role="button">Aprender más</a></p>
		</div>
	</div><!-- .jumbotron -->
	<nav class="container">
		<div class="row">
			<div class="list-group col-sm-6 col-md-4">
				<a href="#!searchissues" class="list-group-item list-group-item-info">
					<h3><i class="fa fa-search"></i> Buscador de Notas</h3>
					<p class="text-justify">Notas Novis</p>
				</a>
			</div>
			<div class="list-group col-sm-6 col-md-4">
				<a href="#!addissue" class="list-group-item active">
					<h3><i class="fa fa-plus"></i> Crear nueva Nota</h3>
					<p class="text-justify">Nuevo</p>
				</a>
			</div>
			<div class="list-group col-sm-6 col-md-4">
				<a href="#!pm_dashboard" class="list-group-item list-group-item-success">
					<h3><i class="fa fa-dashboard"></i> Dashboards</h3>
					<p class="text-justify">Vsitas pre-fabricadas para la gestión de Proyectos.</p>
				</a>
			</div>
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
	<div class="csi-issue-panel" style="margin-left:' . $month_width . '%;">';
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
	//Build issues
	$customer_name = '';
	$issues = $this->get_sql ( $sql );
	$silent = FALSE;
	foreach ( $issues as $issue){
		if ( self::validate_date( $issue['planned_start_date'] ) && self::validate_date( $issue['planned_end_date'] ) ){
			$planned_start_date	= DateTime::createFromFormat('Y-m-d', $issue['planned_start_date']);
			$planned_end_date	= DateTime::createFromFormat('Y-m-d', $issue['planned_end_date']);
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
			<div class="row issue">';
			if ( !$silent ){
				/*
				if ( $customer_name == $issue['customer_short_name']){
					$display_customer_name =' &nbsp;';
				}else{
					$customer_name = $display_customer_name = $issue['customer_short_name'];
				}
				*/
				$o.='
				<div class="col-xs-12 text-left issue-options">
					<div class="btn-group btn-group-sm" style="width:' . $month_width . '%;margin-left:-' . $month_width . '%;overflow:hidden;" title="' . $issue['customer_short_name'] . '" data-toggle="tooltip" data-placement="top" >
						<small>' . $issue['customer_short_name'] . '</small>
					</div>
					<div class="month text-center" style=";width:'.$proj_prev.'%;">&nbsp;</div>
					<div class="btn-group btn-group-sm" style=";width:'.$proj_width.'%;">
						<a type="button" class="text-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<small><i class="fa fa-cog fa-fw"></i>'.$issue['short_name'].'</small>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#" title="Ver los documentos del proyecto '.$issue['short_name'].'"><i class="fa fa-tasks fa-fw" aria-hidden="true"></i> Tareas</a></li>
							<li><a href="#" title="Ver las tareas del proyecto '.$issue['short_name'].'"><i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> Documentos</a></li>
						</ul>
					</div>
					 <div class="month" style="width:'.$proj_post.'%;">&nbsp;</div>
				</div>';
			}
			$short_name= true==$silent  ? '<small style="color:#FFF;white-space: nowrap;text-overflow: ellipsis;display: block;overflow: hidden;">&nbsp;'.$issue['short_name'].'</small>':'&nbsp;';
			$start_class= (0 == $proj_prev) ? ' non_start ' : '';
			$end_class= (0 == $proj_post) ? ' non_end ' : '';
			$o.='
				<div class="col-xs-12 issue-timeline">
					<div class="month text-center" style="width:'.$proj_prev.'%;">&nbsp;</div>
					<div class="month text-center" style="width:'.$proj_width.'%;">
						<div class="progress '.$start_class.$end_class.'">
							<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$issue['percentage'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$issue['percentage'].'%;min-width:2em;">
								<small>'.$issue['percentage'].'%</small>
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
	</div><!-- .csi-issue-panel -->';
	return $o;
}
protected function nov_id ( $value ) {
	return (string) str_pad ( $value, 5, '0', STR_PAD_LEFT);
}
//END OF CLASS

}
global $NOVIS_CSI_ISSUE;
$NOVIS_CSI_ISSUE =new NOVIS_CSI_ISSUE_CLASS();
?>
