<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_ISSUE_EVENT_CLASS extends NOVIS_CSI_CLASS{
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
	$this->class_name	= 'issue_event';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Evento de Issue';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Eventos de Issue';
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
	$this->crt_tbl_sql_wt	="
		(
			id bigint(20) unsigned not null auto_increment COMMENT 'Unique ID for each entry',
			issue_id bigint(20) unsigned not null COMMENT 'ID of issue',
			customer_id tinyint(3) unsigned not null COMMENT 'Customer id of event',
			system varchar(50) not null COMMENT 'System text of event',
			ticket_no varchar(50) not null COMMENT 'Incident reference of event',
			reg_date date not null COMMENT 'Incident date',
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
	add_action( 'wp_ajax_csi_fetch_issue_event_list_info',		array( $this , 'csi_fetch_issue_event_list_info'));
	add_action( 'wp_ajax_csi_create_issue_event_form',			array( $this , 'csi_create_issue_event_form'	));
	add_action( 'wp_ajax_csi_create_issue_event',				array( $this , 'csi_create_issue_event'		));

	//add_action( 'wp_ajax_nopriv_csi_new_issue_event_request', 		array( $this , 'new_issue_event_request'		));
}

public function csi_fetch_issue_event_list_info(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_CUSTOMER;
	//Local Variables
	$response			= array();
	$o					= '';
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//--------------------------------------------------------------------------
	$issue_id = $post['issueId'];
	//--------------------------------------------------------------------------
	$sql = 'SELECT
				T00.*,
				T01.short_name as customer_short_name,
				T01.code as customer_code
			FROM
				' . $this->tbl_name . ' as T00
				LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T01
					ON T01.id = T00.customer_id
			WHERE
				T00.issue_id="' . $issue_id . '"
			ORDER BY
				T00.reg_date
	';
	$issue_events = $this->get_sql ( $sql );
	//--------------------------------------------------------------------------
	$o.='
	<tr>
		<td colspan="999" class="text-right">
			<div style="position:relative;" class="in-table-form-button-wrapper">
				<a
					href="#"
					class="in-table-form-button btn btn-success btn-sm"
					data-action="csi_create_issue_event_form"
					data-issue-id="' . $issue_id . '"
					>
					<i class="fa fa-plus"></i> Agregar evento
				</a>
			</div>
		</td>
	</tr>
	';
	//--------------------------------------------------------------------------
	foreach ( $issue_events as $issue_event ){
		$reg_date = new DateTime($issue_event['reg_date']);
		//----------------------------------------------------------------------
		$o.='
			<tr class="small">
				<td>' . $issue_event['customer_short_name'] . '</td>
				<td>' . $issue_event['system'] . '</td>
				<td>' . $issue_event['ticket_no'] . '</td>
				<td>' . $reg_date->format('d-m-Y') . '</td>
			</tr>
		';
	}
	$response['tbody']		= $o;

	echo json_encode($response);
	wp_die();
}
public function csi_create_issue_event_form(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_COUNTRY;
	//Local Variables
	$customer_opts			= '';
	$o						= '';
	$response				= array();
	$post = isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//--------------------------------------------------------------------------
	$sql = 'SELECT id,code,short_name FROM ' . $NOVIS_CSI_COUNTRY->tbl_name . ' ORDER BY code ASC';
	$countries = $this->get_sql ( $sql );
	foreach ( $countries as $country ){
		$customer_opts .= '<optgroup label="' . $country['short_name'] . '">';
		$sql = 'SELECT id,code,short_name FROM ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' WHERE country_id="' . $country['id'] . '" ORDER BY code ASC';
		$customers = $this->get_sql($sql);
		foreach ( $customers as $customer ){
			$customer_opts .= '<option value="' . $customer['id'] . '">' . $customer['short_name'] . ' (' . $customer['code'] . ')</option>';
		}
		$customer_opts .= '</optgroup>';
	}
	$current_date = new DateTime();
	//--------------------------------------------------------------------------
	$o='<div class="clearfix">
			<form class="in-table-form" data-function="csi_create_issue_event">
				<input type="hidden" id="issue_id" name="issue_id" value="' . $post['issueId'] . '"/>
				<table class="table">
					<tbody>
						<tr>
							<td class="col-xs-3">
								<select class="form-control select2" id="customer_id" name="customer_id" required="true" data-placeholder="Selecciona el cliente" style="width:100%;">
									<option></option>
									' . $customer_opts . '
								</select>
								<span class="help-block small">Indica el cliente de Operación que tuvo la afectación</span>
							</td>
							<td class="col-xs-3">
								<input type="text" class="form-control" id="system" name="system" required="true" maxlength="50" placeholder="AMBIENTE - SID"/>
								<span class="help-block small">Indica el cliente de Operación que tuvo la afectación</span>
							</td>
							<td class="col-xs-3">
								<input type="text" class="form-control" id="ticket_no" name="ticket_no" required="true" maxlength="50"/>
								<span class="help-block small">Indica el cliente de Operación que tuvo la afectación</span>
							</td>
							<td class="col-xs-3">
								<input type="text" name="reg_date" id="reg_date" class="form-control input-sm csi-date-range-input" required="true" data-single-date-picker="true" value="' . $current_date->format('Y-m-d') . '"/>
							</td>
						</tr>
						<tr>
							<td colspan="999" class="text-right">
								<button type="button" class="btn btn-warning btn-sm in-table-form-cancel">
									<i class="fa fa-history"></i> Cancelar
								</button>
								<button type="submit" class="btn btn-success btn-sm">
									<i class="fa fa-history"></i> Crear
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	';
	$response['message']	= $o;
	echo json_encode($response);
	wp_die();
}// csi_create_issue_event_form
public function csi_create_issue_event(){
	//Globa Variables
	global $wpdb;
	//Local Variables
	$insertArray		= array();
	$response			= array();
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user		= get_userdata ( get_current_user_id() );
	$current_datetime	= new DateTime();
	$reg_date			= new DateTime ( $post['reg_date'] );

	$insertArray['issue_id']				= intval ( $post['issue_id'] );
	$insertArray['customer_id']				= intval ( $post['customer_id'] );
	$insertArray['system']					= strip_tags(stripslashes( $post['system'] ));
	$insertArray['ticket_no']				= strip_tags(stripslashes( $post['ticket_no'] ));
	$insertArray['reg_date']				= $reg_date->format ( 'Y-m-d' );

	$insertArray['creation_user_id']		= $current_user->ID;
	$insertArray['creation_user_email']		= $current_user->user_email;
	$insertArray['creation_date']			= $current_datetime->format('Y-m-d');
	$insertArray['creation_time']			= $current_datetime->format('H:i:s');
	//	self::write_log ( $post );
	//	self::write_log ( $insertArray );
	if ( $wpdb->insert( $this->tbl_name, $insertArray ) ){
		$response['id']=$wpdb->insert_id;
		$plan_id = $wpdb->insert_id;
		//crear registro de Ejecutores
		$response['postSubmitAction']	='refreshParent';
		/*
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
			'content'			=> 'Has agregado un nuevo ' . $this->name_single . ' exitosamente. (ID: <code>#' . $plan_id . '</code>)',
			'title'				=> 'Bien!',
			'type'				=> 'green',
			'autoClose'			=> 'OK|3000',
		);
		*/
	}else{
		$response['error']=true;
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
			//'autoClose'			=> 'OK|3000',
		);
	}
	echo json_encode($response);
	wp_die();
}// csi_create_issue_event


//END OF CLASS

}
global $NOVIS_CSI_ISSUE_EVENT;
$NOVIS_CSI_ISSUE_EVENT =new NOVIS_CSI_ISSUE_EVENT_CLASS();
?>
