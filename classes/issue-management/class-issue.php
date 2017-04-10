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
	add_action( 'wp_ajax_csi_issue_edit_issue_form',			array( $this , 'csi_issue_edit_issue_form'			));
	add_action( 'wp_ajax_csi_issue_edit_issue', 				array( $this , 'csi_issue_edit_issue'				));
	add_action( 'wp_ajax_csi_issue_build_page_search_issue', 	array( $this , 'csi_issue_build_page_search_issue'	));
	add_action( 'wp_ajax_csi_issue_filtered_issues',	 		array( $this , 'csi_issue_filtered_issues'			));
	add_action( 'wp_ajax_csi_issue_filtered_issues_pagination', array( $this , 'csi_issue_filtered_issues_pagination'));
	add_action( 'wp_ajax_csi_issue_build_page_show_issue', 		array( $this , 'csi_issue_build_page_show_issue'	));
	add_action( 'wp_ajax_csi_issue_new_issue_form_md_preview', 	array( $this , 'csi_issue_new_issue_form_md_preview'));
	add_action( 'wp_ajax_csi_issue_popup_markdown_info',	 	array( $this , 'csi_issue_popup_markdown_info'		));


//	add_action( 'wp_ajax_nopriv_csi_new_issue_request', 		array( $this , 'new_issue_request'		));
}
public function csi_issue_popup_markdown_info(){
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	//Local Variables
	$response			= array();
	$o = '';

	$sql = 'SELECT * FROM ' . $this->tbl_name . ' ';
	$task_types = $this->get_sql($sql);
	$o.='
	<p><a target="_blank" href="http://daringfireball.net/projects/markdown/">Markdown <i class="fa fa-external-link"></i></a> es un m&eacute;todo (sencillo y seguro) de poner estilos en la web.</p>

	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Estilo</th>
				<th>Sintaxis</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><strong>negrita</strong></td>
				<td>
					<code>**texto**</code><br/>
					<code>__texto__</code>
				</td>
			</tr>
			<tr>
				<td><i>it&aacute;lica</i></td>
				<td>
					<code>*texto*</code><br/>
					<code>_texto_</code>
				</td>
			</tr>
			<tr>
				<td>
					Lista desordenada
					<ul>
						<li>Item 1</li>
						<li>Item 2
							<ul>
								<li>Item 2a</li>
								<li>Item 2b</li>
							</ul>
						</li>
					</ul>
				</td>
				<td>
<pre>* Item 1
* Item 2
  * Item 2a
  * Item 2b</pre>
				</td>
			</tr>
			<tr>
				<td>
					Lista ordenada
					<ol>
						<li>Item 1</li>
						<li>Item 2
							<ol>
								<li>Item 2a</li>
								<li>Item 2b</li>
							</ol>
						</li>
					</ol>
				</td>
				<td>
<pre>1. Item 1
1. Item 2
   1. Item 2a
   1. Item 2b</pre>
				</td>
			</tr>
			<tr>
				<td>Enlace: <a href="http://www.google.com" target="_blank">Google</a></td>
				<td>[Google](http://www.google.com)</td>
			</tr>
			<tr>
				<td>
					<table class="table">
						<thead>
							<tr><th>Header 1</th><th>Header 2</th></tr>
						</thead>
						<tbody>
							<tr><td>Cell 1</td><td>Cell 2</td></tr>
							<tr><td>Cell 3</td><td>Cell 4</td></tr>
						</tbody>
					</table>
				<td>
<pre>Header 1 | Header 2
------------ | -------------
Cell 1 | Cell 2
Cell 3 | Cell 4</pre>
				</td>
			</tr>
		</tbody>
	</table>';
	$response['notification']=array(
		'buttons'			=> array(
			'OK'			=> array(
				'text'		=> '<small> Gracias por la informaci&oacute;n</small> <i class="fa fa-thumbs-up"></i>',
				'btnClass'	=> 'btn-info',
			),
		),
		'backgroundDismiss' =>true,
		'icon'				=> 'fa fa-info text-info',
		'columnClass'		=> 'large',
		'content'			=> $o,
		'title'				=> 'Markdown',
		'type'				=> 'blue',
	);

	echo json_encode($response);
	wp_die();
}
public function csi_issue_new_issue_form_md_preview(){
	//Global Variables
	//Loval Variables
	$pd = new Parsedown();
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//Execution
	$response['message']='
		<div class="panel panel-default">
			<div class="panel-body" style="min-height:100px;">
				<samp>
					' . $pd->text( $post['dataInput'] ) . '
				</samp>
			</div>
		</div>
		';
	$response['message'] = str_replace ( '<table>', '<table class="table">', $response['message']);
	echo json_encode($response);
	wp_die();
}
protected function csi_issue_new_issue_form_textarea ( $var = array() ){
	$ta='
	<div class="form-group ">
		<label for="' . $var['id'] . '" class="col-sm-2 control-label">' . $var['title'] . '</label>
		<div class="col-sm-10">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs">
				<li role="presentation" class="active">
					<a href="#csi-issue-input-' . $var['id'] . '" data-toggle="tab" data-function="editor">
						Escribir
					</a>
				</li>
				<li role="presentation">
					<a href="#csi-issue-preview-' . $var['id'] . '" data-toggle="tab" data-function="mdPreview" data-text-field="#' . $var['id'] . '" data-action="csi_issue_new_issue_form_md_preview">
						Previsualizar
					</a>
				</li>
			</ul><!-- .nav-tabs -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="csi-issue-input-' . $var['id'] . '">
					<div class="list-group" style="margin-bottom:0px;">
						<a href="#" class="list-group-item list-group-item-success small csi-popup" data-action="csi_issue_popup_markdown_info">
							Modo de edici&oacute;n: Markdown habilitado <i class="fa fa-question-circle"></i>
						</a>
					</div>
					<textarea class="form-control" id="' . $var['id'] . '" name="' . $var['id'] . '" placeholder="' . $var['placeholder'] . '" required="true" maxlength="' . $var['maxlength'] . '" rows="' . $var['rows'] . '">' . $var['value'] . '</textarea>
					<p class="help-block">
						<small class="text-warning pull-right">(requerido)</small>
						' . $var['help'] . '<br>Tamaño máximo: ' . $var['maxlength'] . ' caracteres
					</p>
				</div>
				<div role="tabpanel" class="tab-pane" id="csi-issue-preview-' . $var['id'] . '" style="position:relative;min-height:100px;" ></div>
			</div><!-- .tab-content -->
		</div><!-- .col-sm-10 -->
	</div><!-- .form-group -->
	';
	return $ta;
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
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">T&iacute;tulo</label>
						<div class="col-sm-10">
							<input type="text" name="title" id="title" class="form-control" required="true" placeholder="T&iacute;tulo" aria-hidden="true"/>
							<p class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
						</div>
					</div>
	';
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'summary',
		'title'			=> 'Resumen',
		'placeholder'	=> 'Resumen',
		'maxlength'		=> 1000,
		'rows'			=> 6,
		'required'		=> true,
		'help'			=> 'Resumen del Issue',
		'value'			=> null,
	)) ;
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'symptom',
		'title'			=> 'S&iacute;ntomas',
		'placeholder'	=> 'S&iacute;ntomas',
		'maxlength'		=> 1000,
		'rows'			=> 6,
		'required'		=> true,
		'help'			=> 'hola',
		'value'			=> null,
	)) ;
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'terms',
		'title'			=> 'Otros t&eacute;rminos',
		'placeholder'	=> 'Otros t&eacute;rminos',
		'maxlength'		=> 500,
		'rows'			=> 4,
		'required'		=> true,
		'help'			=> 'hola',
		'value'			=> null,
	)) ;
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'reason',
		'title'			=> 'Causa y Pre-Requisitos',
		'placeholder'	=> 'Soluci&oacute;n',
		'maxlength'		=> 1000,
		'rows'			=> 6,
		'required'		=> true,
		'help'			=> 'hola',
		'value'			=> null,
	)) ;
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'solution',
		'title'			=> 'Soluci&oacute;n',
		'placeholder'	=> 'Soluci&oacute;n',
		'maxlength'		=> 1000,
		'rows'			=> 6,
		'required'		=> true,
		'help'			=> 'hola',
		'value'			=> null,
	)) ;
	$o.='
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
		$response['newId']				= '#!showissue?i=' . $issue_id;
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
			'content'			=> 'Has agregado un nuevo ' . $this->name_single . ' exitosamente. (ID: <code>' . $this->nov_id ( $issue_id ) . '</code>)',
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
						<input type="checkbox" class="hidden" value="1" id="date_sort" name="date_sort"/>
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
	self::write_log ( $post );
	if ( isset ( $post['issue_text'] ) AND 0 != strlen ($post['issue_text'] ) ) {
		//--------------------------------------------------------------------------
		$regex = '~"[^"]*"(*SKIP)(*F)|[ /]+~';
		$terms = preg_split ( $regex, $post['issue_text'] );
		$conditions = array();
		$results = self::csi_issue_filtered_issues_sql($post);
		//$results = $this->get_sql ( $sql );
		$o.='
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>Resultados</th>
				</tr>
			</thead>
			<tbody>';
		foreach ( $results['rows'] as $result ){
			$creation_date = new DateTime ( $result['creation_date'] );
			$modification_date = new DateTime ( $result['last_modified_date'] );
			$regex = '~"[^"]*"(*SKIP)(*F)|[ /]+~';
			$terms = preg_split ( $regex, urldecode ( $post['issue_text'] ) ) ;
			foreach ( $terms as $term ){
				//self::write_log (  urldecode ( $post['issue_text'] ));
				$conditions = array();
				$pattern = preg_quote($term);
				$result['summary']  = preg_replace("/($pattern)/i", '<mark>$1</mark>', $result['summary']);
			}
			$o.='
				<tr>
					<td>
						<div>
							<a href="#!showissue?i=' . $this->nov_id ( $result['id'] ) . '&issue_text=' . urlencode ( $post['issue_text'] ). '" target="_blank">
								' . $this->nov_id ( $result['id'] ) . ' - ' . $result['title'] . ' <i class="fa fa-fw fa-external-link"></i>
							</a>
						</div>
						<div>
							<!-- <small>' . $result['summary'] . '</small> -->
						</div>
						<div>
							<strong>Creaci&oacute;n</strong> : <span>' . $creation_date->format('d-m-Y') . '</span>
						</div>
					</td>
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
		$rows = 'SELECT DISTINCT T00.id, T00.title, T00.creation_date, T00.last_modified_date, T00.summary ';
		$limit = ' LIMIT ' . ( $page_no - 1 ) * $page_size . ',' . $page_size ;
		$order = ' ORDER BY T00.creation_date DESC ';
		$results['rows']		= $this->get_sql (  $rows . $sql . $order . $limit );
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
	$pd = new Parsedown();
	//--------------------------------------------------------------------------
	foreach ( $issue as $key => $value ){
		if ( $key == 'id' ){
			$issue->$key = $this->nov_id ( $value );
		}
		$issue->$key = $pd->text( $issue->$key );
		$issue->$key = str_replace ( '<table>', '<table class="table">', $issue->$key);
		if ( isset ( $post['issue_text'] ) AND 0 != strlen ($post['issue_text'] ) ) {
			$regex = '~"[^"]*"(*SKIP)(*F)|[ /]+~';
			$terms = preg_split ( $regex, urldecode ( $post['issue_text'] ) ) ;
			foreach ( $terms as $term ){
				//self::write_log (  urldecode ( $post['issue_text'] ));
				$conditions = array();
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
			<h3 class="">
				<samp class="col-sm-10">
					<span class="text-muted small">' . $issue->id . '</span>
					' . $issue->title . '
				</samp>
				<p class="col-sm-2 text-right hidden-print">
					<a href="#!editissue?issue_id=' . $issue_id . '" class="btn btn-default">
						<i class="fa fa-pencil"></i> Editar
					</a>
				</p>
			</h3>
		</div><!-- .page-header -->
		<div class="row csi-issue-display-note">
			<div class="csi-issue-summary">
				<div class="page-header">
					<h3 class=""><strong><samp>Resumen</samp></strong></h3>
				</div>
				<div class="text-justify"><samp>' . $issue->summary . '</samp></div>
			</div><!-- .csi-issue-summary -->
			<div class=" csi-issue-symptom">
				<div class="page-header">
					<h3 class=""><strong><samp>Sintoma</samp></strong></h3>
				</div>
				<div class="text-justify"><samp>' . $issue->symptom . '</samp></div>
			</div><!-- .csi-issue-symptom -->
			<div class=" csi-issue-terms">
				<div class="page-header">
					<h3 class=""><strong><samp>Otros Términos</samp></strong></h3>
				</div>
				<div class="text-justify"><samp>' . $issue->terms . '</samp></div>
			</div><!-- .csi-issue-terms -->
			<div class=" csi-issue-reason">
				<div class="page-header">
					<h3 class=""><strong><samp>Causa y Pre-Requisitos</samp></strong></h3>
				</div>
				<div class="text-justify"><samp>' .  $issue->reason . '</samp></div>
			</div><!-- .csi-issue-reason -->
			<div class=" csi-issue-solution">
				<div class="page-header">
					<h3 class=""><strong><samp>Solución</samp></strong></h3>
				</div>
				<dov class="text-justify"><samp>' . $issue->solution . '</samp></div>
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
public function csi_issue_edit_issue_form(){
	//Global Variables
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_USER_TEAM;
	global $wpdb;
	//Local Variables
	$o				= '';
	$user_teams_opts	= '';
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//--------------------------------------------------------------------------
	$issue_id = $post['issue_id'];
	$sql = 'SELECT * FROM ' . $this->tbl_name . ' WHERE id = "' . $issue_id . '"';
	$issue = $wpdb->get_row ( $sql );
	//--------------------------------------------------------------------------
	$sql = 'SELECT id, short_name FROM ' . $NOVIS_CSI_COUNTRY->tbl_name . ' ORDER BY short_name';
	foreach ( $this->get_sql ( $sql ) as $country ){
		$user_teams_opts.='<optgroup label="' . $country['short_name'] . '">';
		$sql = 'SELECT id, short_name, code FROM ' . $NOVIS_CSI_USER_TEAM->tbl_name . ' WHERE country_id="' . $country['id'] . '" ORDER BY short_name';
		foreach ( $this->get_sql ( $sql ) as $user_team ){
			$selected = ($user_team['id'] == $issue->owner_team ) ? 'selected' : '';
			$user_teams_opts.='<option value="' . $user_team['id'] . '" ' . $selected . '>' . $user_team['short_name'] . ' (' . strtoupper ( $user_team['code'] ) . ')</option>';
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
				<form class="form-horizontal" data-function="csi_issue_edit_issue" style="position:relative;">
					<input type="hidden" name="issue_id" id="issue_id" value="' . $issue_id . '"/>
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
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">T&iacute;tulo</label>
						<div class="col-sm-10">
							<input type="text" name="title" id="title" class="form-control" required="true" placeholder="T&iacute;tulo" aria-hidden="true" value="' . $issue->title . '"/>
							<p class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
						</div>
					</div>
	';
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'summary',
		'title'			=> 'Resumen',
		'placeholder'	=> 'Resumen',
		'maxlength'		=> 1000,
		'rows'			=> 6,
		'required'		=> true,
		'help'			=> 'Resumen del Issue',
		'value'			=> $issue->summary,
	)) ;
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'symptom',
		'title'			=> 'S&iacute;ntomas',
		'placeholder'	=> 'S&iacute;ntomas',
		'maxlength'		=> 1000,
		'rows'			=> 6,
		'required'		=> true,
		'help'			=> 'hola',
		'value'			=> $issue->symptom,
	)) ;
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'terms',
		'title'			=> 'Otros t&eacute;rminos',
		'placeholder'	=> 'Otros t&eacute;rminos',
		'maxlength'		=> 500,
		'rows'			=> 4,
		'required'		=> true,
		'help'			=> 'hola',
		'value'			=> $issue->terms,
	)) ;
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'reason',
		'title'			=> 'Causa y Pre-Requisitos',
		'placeholder'	=> 'Soluci&oacute;n',
		'maxlength'		=> 1000,
		'rows'			=> 6,
		'required'		=> true,
		'help'			=> 'hola',
		'value'			=> $issue->reason,
	)) ;
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'solution',
		'title'			=> 'Soluci&oacute;n',
		'placeholder'	=> 'Soluci&oacute;n',
		'maxlength'		=> 1000,
		'rows'			=> 6,
		'required'		=> true,
		'help'			=> 'hola',
		'value'			=> $issue->solution,
	)) ;
	$o.='
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
							<button type="submit" class="btn btn-primary">Entiendo, Editar Nota Novis</button>
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
public function csi_issue_edit_issue(){
	//Globa Variables
	global $wpdb;
	//Local Variables
	$editArray			= array();
	$whereArray			= array();
	$response			= array();
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	self::write_log ( $post );
	$current_user		= get_userdata ( get_current_user_id() );
	$current_datetime	= new DateTime();

	$whereArray['id']						= intval ( $post['issue_id'] );

	$editArray['owner_team']				= intval ( $post['owner_team'] );
	$editArray['title']						= strip_tags(stripslashes( $post['title'] ) );
	$editArray['summary']					= strip_tags(stripslashes( $post['summary'] ) );
	$editArray['symptom']					= strip_tags(stripslashes( $post['symptom'] ) );
	$editArray['terms']						= strip_tags(stripslashes( $post['terms'] ) );
	$editArray['reason']					= strip_tags(stripslashes( $post['reason'] ) );
	$editArray['solution']					= strip_tags(stripslashes( $post['solution'] ) );

	$editArray['last_modified_user_id']		= $current_user->ID;
	$editArray['last_modified_user_email']	= $current_user->user_email;
	$editArray['last_modified_date']		= $current_datetime->format('Y-m-d');
	$editArray['last_modified_time']		= $current_datetime->format('H:i:s');
	//self::write_log ( $post );
	//self::write_log ( $editArray );
	$result = $wpdb->update ( $this->tbl_name, $editArray, $whereArray );
	if( $result === false ){
		$response['error']=true;
		$response['notification']=array(
			'buttons'			=> array(
				'OK'			=> array(
					'text'		=> 'OK',
					'btnClass'	=> 'btn-danger',
				),
			),
			'icon'				=> 'fa fa-exclamation-circle fa-sm',
			'closeIcon'			=> true,
			'columnClass'		=> 'large',
			'content'			=> 'Hubo un error al editar el ' . $this->name_single . '; intenta nuevamente. :)',
			'title'				=> 'Bien!',
			'type'				=> 'red',
			'autoClose'			=> 'OK|3000',
		);
	}elseif ( $result == 0){
		$response['error']=true;
		$response['notification']=array(
			'buttons'			=> array(
				'OK'			=> array(
					'text'		=> 'OK',
					'btnClass'	=> 'btn-warning',
				),
			),
			'icon'				=> 'fa fa-exclamation-triangle fa-sm',
			'closeIcon'			=> true,
			'columnClass'		=> 'large',
			'content'			=> 'Los valores son iguales. ' . $this->name_single . ' no modificado',
			'title'				=> 'Bien!',
			'type'				=> 'orange',
			'autoClose'			=> 'OK|3000',
		);
	}else{
		$response['postSubmitAction']	='changeHash';
		$response['newId']				= '#!showissue?i=' . $post['issue_id'];
		$response['notification']=array(
			'buttons'			=> array(
				'OK'			=> array(
					'text'		=> 'OK',
					'btnClass'	=> 'btn-success',
				),
			),
			'icon'				=> 'fa fa-exclamation-triangle fa-sm',
			'closeIcon'			=> true,
			'columnClass'		=> 'large',
			'content'			=> $this->name_single . ' editado exitosamente.',
			'title'				=> 'Bien!',
			'type'				=> 'green',
			'autoClose'			=> 'OK|3000',
		);
	}
	echo json_encode($response);
	wp_die();
}// csi_edit_project_entrance
protected function nov_id ( $value ) {
	return 'NOV' . (string) str_pad ( $value, 5, '0', STR_PAD_LEFT);
}
//END OF CLASS

}
global $NOVIS_CSI_ISSUE;
$NOVIS_CSI_ISSUE =new NOVIS_CSI_ISSUE_CLASS();
?>
