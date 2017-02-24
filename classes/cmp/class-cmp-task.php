<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_CMP_TASK_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'cmp_task';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Tarea';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Tareas';
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
	$this->db_version	= '0.0.4';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="
		(
			id int(10) unsigned not null auto_increment COMMENT 'Unique ID for each entry',
			cmp_id mediumint(8) unsigned not null COMMENT 'Plan ID',
			customer_system_id int(10) unsigned not null COMMENT 'Customer System ID',
			task_type_id tinyint(2) unsigned not null COMMENT 'Task Type ID',
			service_id mediumint(8) unsigned null COMMENT 'Service ID',
			procedure_url varchar(255) null COMMENT 'URL of execution procedure',
			offline_task_flag boolean null COMMENT 'Indicate if task implies offline downtime window',
			customer_visible_flag boolean null COMMENT 'Indicates if task is shown in customer calendar',
			comments varchar(255) null COMMENT 'Additional comments',
			status_id tinyint(2) unsigned not null COMMENT 'Status ID',
			ticket_no varchar(20) null COMMENT 'Ticket Number',
			start_datetime datetime not null COMMENT 'Start datetime of task',
			end_datetime datetime not null COMMENT 'End datetime of task',
			creation_user_id bigint(20) unsigned null COMMENT 'Id of user responsible of the creation of this record',
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
		'id' => array(
			'type'						=>'id',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'cmp_id' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'customer_system_id' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'task_type_id' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'service_id' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'procedure_url' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>true,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>255,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'offline_task_flag' => array(
			'type'						=>'bool',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'customer_visible_flag' => array(
			'type'						=>'bool',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'comments' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>255,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'status_id' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'ticket_no' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>true,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>20,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'start_datetime' => array(
			'type'						=>'datetime',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'end_datetime' => array(
			'type'						=>'datetime',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'creation_user_id' => array(
			'type'						=>'create_user_id',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'creation_user_email' => array(
			'type'						=>'create_user_email',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'creation_date' => array(
			'type'						=>'create_date',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'creation_time' => array(
			'type'						=>'create_time',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'last_modified_user_id' => array(
			'type'						=>'edit_user_id',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'last_modified_user_email' => array(
			'type'						=>'edit_user_email',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'last_modified_date' => array(
			'type'						=>'edit_date',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'last_modified_time' => array(
			'type'						=>'edit_time',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
	);
	register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install'					));
	//in a new blog creation, create the db for new blog
	//Applies only for non-network classes
	if( true != $this->network_class ){
		add_action( 'wpmu_new_blog',							array( $this , 'db_install'					));
	}
	if ( !is_multisite() ) {
		add_action( 'admin_menu',		 						array( $this , "register_submenu_page"		));
	}else{
		add_action( 'network_admin_menu', 						array( $this , "register_submenu_page"		));
	}
	add_action( 'wp_ajax_csi_cmp_build_page_new_task_form',		array( $this , 'csi_cmp_build_page_new_task_form'	));
	add_action( 'wp_ajax_csi_cmp_create_cmp_task',				array( $this , 'csi_cmp_create_cmp_task'			));
	add_action( 'wp_ajax_csi_cmp_fetch_tasks_table',			array( $this , 'csi_cmp_fetch_tasks_table'			));


}
public function csi_cmp_popup_task_info(){
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	//Local Variables
	$response			= array();
	$o = '';

	$sql = 'SELECT * FROM ' . $this->tbl_name . ' ';
	$task_types = $this->get_sql($sql);
	$o.='<table class="table table-condensed">';
	$o.='
	<tr>
		<th class="col-xs-3">' . $this->name_plural . '</th>
		<th>Descripci&oacute;n</th>
	</tr>
	';
	foreach ( $task_types as $task_type ){
		$o.='
		<tr>
			<td class="col-xs-3"><code><i class="fa fa-' . $task_type['icon'] . ' hidden-xs"></i> ' . $task_type['short_name'] . '</code></td>
			<td><p class="text-justify">' . $task_type['description'] . '</p></td>
		</tr>
		';
	}
	$o.='</table>';
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
		'title'				=> $this->name_plural,
		'type'				=> 'blue',
	);

	echo json_encode($response);
	wp_die();
}
public function csi_cmp_build_page_new_task_form(){
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_CUSTOMER_SYSTEM;
	global $NOVIS_CSI_SAPCUSTNO;
	global $NOVIS_CSI_CMP;
	global $NOVIS_CSI_CMP_TASK_TYPE;
	global $NOVIS_CSI_CMP_TASK_STATUS;
	global $wpdb;
	//Local Variables
	$response			= array();
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$plan_id			= intval ( $post['plan_id'] );
	$executor_opts		= '';

	$sql = 'SELECT
				*,
				T00.id as plan_id,
				T00.title as plan_title,
				T00.manager_user_id as manager_id,
				T01.short_name as customer_name,
				T01.code as customer_code,
				T01.id as customer_id

			FROM
			' . $NOVIS_CSI_CMP->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T01
				ON T01.id = T00.customer_id
			WHERE
				T00.id = "' . $plan_id . '"
	';
	$plan = $wpdb->get_row($sql);
	$sql = 'SELECT
				T00.id as id,
				T00.sid as sid
			FROM
				' . $NOVIS_CSI_CUSTOMER_SYSTEM->tbl_name . ' as T00
				LEFT JOIN ' . $NOVIS_CSI_SAPCUSTNO->tbl_name . ' as T01
					ON T00.sapcustno = T01.sapcustno
				LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T02
					ON T01.customer_id = T02.id
			WHERE
				T02.id = "' . $plan->customer_id . '"
	';
	$systems = $this->get_sql ( $sql );
	$systems_opt = '';
	foreach ( $systems as $system ){
		$systems_opt .='<option value="' . $system['id'] . '">' . $system['sid'] . '</option>';
	}
	$sql ='SELECT
				*
			FROM
				' . $NOVIS_CSI_CMP_TASK_TYPE->tbl_name . '
	';
	$task_types = $this->get_sql ( $sql );
	$task_types_opt = '';
	foreach ( $task_types as $task_type ){
		$task_types_opt .='<option value="' . $task_type['id'] . '">' . $task_type['short_name'] . '</option>';
	}
	$sql ='SELECT
				*
			FROM
				' . $NOVIS_CSI_CMP_TASK_STATUS->tbl_name . '
	';
	$task_status = $this->get_sql ( $sql );
	$task_status_opt = '';
	foreach ( $task_status as $status ){
		$task_status_opt .='<option value="' . $status['id'] . '">' . $status['short_name'] . '</option>';
	}
	$o='
	<!-- #AddTask -->
	<div id="csi-template-cmp-control-center-add-plan" class="container ">
		<div class="panel panel-default row">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-plus"></i> Agregar tarea</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" data-function="csi_cmp_create_cmp_task" data-next-page="showplan?plan_id=' . $plan_id . '">
					<div class="form-group">
						<label class="col-sm-2 control-label">
							Cliente
						</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon">
									<span class="text-danger">
										<i class="fa fa-exclamation-circle"></i>
									</span>
								</span>
								<p class="form-control disabled">' . $plan->customer_name . '</p>
							</div>
							<span class="help-block">
							</span>
						</div>
					</div>
					<div class="form-group">
					<label class="col-sm-2 control-label">
						Plan
					</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon">
									<span class="text-warning">
										<i class="fa fa-exclamation-triangle"></i>
									</span>
								</span>
								<input type="hidden" id="cmp_id" name="cmp_id" value="' . $plan_id . '"/>
								<p class="form-control">
									' . $plan->plan_title . '
									<small>
										(<a href="#" class="csi-popup" data-action="csi_cmp_popup_cmp_info" data-plan-id="' . $plan_id . '">
											#PCM_' . $plan_id . '
										</a>)
									</small>
								</p>
							</div>
							<span class="help-block">
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="customer_system_id" class="col-sm-2 control-label">Sistema</label>
						<div class="col-sm-10">
							<input type="hidden" id="system-id" />
							<select class="form-control select2" name="customer_system_id" id="customer_system_id" data-placeholder="Selecciona el sistema" required="true"">
								<option></option>
								' . $systems_opt . '
							</select>
							<span class="help-block">
								El sistema involucrado indica el sistema del cliente afectado en la actividad.<br/>
								En el caso que esta tarea afecte dos sistemas existen diferentes.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="task_type_id" class="col-sm-2 control-label">Tipo de Tarea</label>
						<div class="col-sm-10">
							<select class="form-control select2" name="task_type_id" id="task_type_id" required="true" data-placeholder="Selecciona el tipo de Tarea">
								<option></option>
								' . $task_types_opt . '
							</select>
							<span class="help-block">
								El tipo de tarea define el comportamiento de esta tarea en el proceso de evaluación de horas, y calendario
								<a href="#" class="csi-popup" data-action="csi_cmp_popup_task_type_info">
									<i class="fa fa-question-circle"></i>
								</a>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="service_id" class="col-sm-2 control-label">Servicio relacionado</label>
						<div class="col-sm-10">
							<select  class="form-control select2" name="service_id" id="service_id" data-placeholder="Selecciona el Servicio relacionado">
								<option></option>
							</select>
							<span class="help-block">
								Si el servicio no aparece en la lista, selecciona <strong>Otros</strong>.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="procedure_url" class="col-sm-2 control-label">Procedimiento</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-link"></i></span>
								<input type="text" name="procedure_url" id="procedure_url" class="form-control" placeholder="http://intranet.noviscorp.com/"/>
							</div>
							<span class="help-block">

							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="offline_task_flag" class="col-sm-2 control-label">¿Ventana Offline?</label>
						<div class="col-sm-10">
							<input type="checkbox" class="form-control" name="offline_task_flag" id="offline_task_flag" value="1"/>
							<span class="help-block">
								Indica si la actividad impacta la disponibilidad del sistema relacionado.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="customer_visible_flag" class="col-sm-2 control-label">Visible para Cliente</label>
						<div class="col-sm-10">
							<input type="checkbox" class="form-control" name="customer_visible_flag" id="customer_visible_flag" value="1"/>
							<span class="help-block">
								Si el campo est&aacute; seleccionado (dependiendo del <i>Tipo de Tarea</i>
								<a href="#" class="csi-popup" data-action="csi_cmp_popup_task_type_info"><i class="fa fa-question-circle"></i></a>)
								esta actividad es visible para el calendario del cliente.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="comments" class="col-sm-2 control-label">Observaciones</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="comments" id="comments" placeholder="Observaciones adicionales"></textarea>
							<span class="help-block">
								Si el tipo de actividad es sincronizado con el calentadio, este texto aparecerá como contenido adicional en el evento.<br/>
								Tama&ntilde;o m&aacute;ximo: 255 caracteres.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="status_id" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10">
						<select class="form-control select2" name="status_id" id="status_id" required="true" data-placeholder="Selecciona el status">
							<option></option>
							' . $task_status_opt . '
						</select>
							<span class="help-block">
							El status de la tarea indica el punto de resolución de la actividad
							<a href="#" class="csi-popup" data-action="csi_cmp_popup_task_status_info"><i class="fa fa-question-circle"></i></a>.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="ticket_no" class="col-sm-2 control-label">Ticket</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="ticket_no" id="ticket_no" placeholder="5000012345" />
							<span class="help-block">
								El status de la tarea define el comportamiento de esta esta tarea en el proceso de evaluación de horas, y calendario <a href="#"><i class="fa fa-question-circle"></i></a>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="task_datetime" class="col-sm-2 control-label">Fecha y hora</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon" title="Zona horaria Cliente">
									<a href="#">
										<i class="fa fa-calendar-check-o fa-fw"></i><i class="fa fa-building fa-fw"></i>
									</a>
								</span>
								<input type="text" class="csi-datetime-range-input form-control" name="task_datetime" id="task_datetime" readonly="true"/>
								<span class="input-group-addon duration ">X horas</span>
							</div>
							<div class="input-group">
							<span class="input-group-addon" title="Zona horaria Usuario">
								<a href="#">
									<i class="fa fa-calendar-check-o fa-fw"></i><i class="fa fa-user-o fa-fw"></i>
								</a>
							</span>
								<input type="text" class="form-control"  readonly="true"/>
							</div>
							<span class="help-block">
								El campo de fecha y hora identifica el lapso de tiempo en el cual se desarrolla la tarea.
								<div class="animated fadeIn alert alert-warning alert-dismissible text-jutify" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<i class="fa fa-exclamation-triangle text-warning fa-fw"></i>
									El horario y fecha debe ser expresado en la zona horaria del cliente.<br/>
									El cliente <strong>' . $plan->customer_name . '</strong> tiene la zona horaria [ZONA_HORARIA]. La fecha y hora actual es este cliente es: [FECHA_HORA_CLIENTE].
								</div>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="task-add-executor" class="col-sm-2 control-label">Ejecutores</label>
						<div class="col-sm-10">
							<div class="input-dynamic" data-dynamic-input="task-executioner">
							</div>
							<div class="text-center">
							</div>
							<span class="help-block">
								Los ejecutores de una actividad permiten la notificación previa en el calendario personal.<br/>
								Si el campo de tiempo de actividad en cada responsable se deja en blanco, el sistema asigna la duración total de la tarea. (<a href="#">Aprender m&aacute;s</a>).
							</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<p class="text-muted text-justify">
								La creaci&oacute;n de un Plan de Correcci&oacute;n o Mantenimiento aparecer&aacute; de modo inmediato en los planes del cliente seleccionado.
							</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10 text-right">
							<button type="reset" class="btn btn-danger">Cancelar</button>
							<button type="submit" class="btn btn-primary">Entiendo, Crear tarea</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	';
	$sql = 'SELECT ID, display_name FROM ' . $wpdb->base_prefix . 'users ORDER BY display_name ASC';
	$users = $this->get_sql ( $sql );
	foreach ( $users as $user ){
		$executor_opts .= '<option value="' . $user['ID'] . '">' . $user['display_name'] . '</option>';
	}
	$dynamic_fields=array(
		'task-executioner'			=> array(
			'maxFields'		=> 5,
			'addButton'		=> '<button class="btn btn-sm btn-success" id="doc-plus"><i class="fa fa-plus"></i> Agregar ejecutor</button>',
			'fieldBox'		=> '<div class="input-group select2-bootstrap-append select2-bootstrap-prepend">
									<span class="input-group-addon"><i class="fa fa-user-o"></i></span>
									<select
										type="text"
										class="form-control select2"
										data-placeholder="Ejecutor"
										name="task_executor_user_id[]"
										required="true"
									>
										<option></option>
										' . $executor_opts . '
									</select>
									<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									<input type="number" class="form-control col-xs-2" placeholder="3" name="task_executor_time[]"
									style="min-width:60px;"
									/>
									<span class="input-group-addon">horas</span>
									<span class="input-group-btn">
										<a href="#" class="btn btn-danger csi-cmp-delete-dynamic-field-button">
											<i class="fa fa-times"></i>
										</a>
									</span>
								</div>',
		),
	);
	$response['dynamicFields'] = $dynamic_fields;

	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
public function csi_cmp_create_cmp_task(){
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_PROJECT_STATUS;
	global $wpdb;
	//Local Variables
	$insertArray			= array();
	$response				= array();
	$post					= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	# Validate user capability ??
	$current_user			= get_userdata ( get_current_user_id() );
	$current_datetime		= new DateTime();
	$task_datetime			= explode ( ' - ', strip_tags ( stripslashes ( $post['task_datetime'] ) ) );
	$start_datetime			= new DateTime ( $task_datetime[0] . ':00' );
	$end_datetime			= new DateTime ( $task_datetime[1] . ':00' );

	$insertArray['cmp_id']					= strip_tags(stripslashes( $post['cmp_id'] ));
	$insertArray['customer_system_id']		= strip_tags(stripslashes( $post['customer_system_id'] ));
	$insertArray['task_type_id']			= strip_tags(stripslashes( $post['task_type_id'] ));
	$insertArray['service_id']				= strip_tags(stripslashes( $post['service_id'] ));
	$insertArray['procedure_url']			= strip_tags(stripslashes( $post['procedure_url'] ));
	$insertArray['offline_task_flag']		= ('1' == $post['offline_task_flag'] ) ? 1 : 0 ;
	$insertArray['customer_visible_flag']	= ('1' == $post['customer_visible_flag'] ) ? 1 : 0 ;
	$insertArray['comments']				= strip_tags(stripslashes( $post['comments'] ));
	$insertArray['status_id']				= strip_tags(stripslashes( $post['status_id'] ));
	$insertArray['ticket_no']				= strip_tags(stripslashes( $post['ticket_no'] ));
	$insertArray['start_datetime']			= $start_datetime->format ( 'Y-m-d H:i:s' );
	$insertArray['end_datetime']			= $end_datetime->format ( 'Y-m-d H:i:s' );
	$insertArray['creation_user_id']		= $current_user->ID;
	$insertArray['creation_user_email']		= $current_user->user_email;
	$insertArray['creation_date']			= $current_datetime->format('Y-m-d');
	$insertArray['creation_time']			= $current_datetime->format('H:i:s');

	if ( $wpdb->insert( $this->tbl_name, $insertArray ) ){
		$response['id']=$wpdb->insert_id;
		$plan_id = $wpdb->insert_id;
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
			'content'			=> 'Has agregado un nuevo ' . $this->name_single . ' exitosamente. (ID: <code>#' . $plan_id . '</code>)',
			'title'				=> 'Bien!',
			'type'				=> 'green',
			'autoClose'			=> 'OK|3000',
		);
	}else{
		$response['error']=true;
		$response['notifStopNextPage'] = true;
		$response['postSubmitAction']	='changeHash';
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
public function csi_cmp_fetch_tasks_table(){
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_CUSTOMER_SYSTEM;
	global $NOVIS_CSI_CMP_TASK_STATUS;
	global $wpdb;
	//Local Variables
	$insertArray			= array();
	$response				= array();
	$o						= '';
	$post					= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$plan_id				= $post['planId'];

	$sql='SELECT
			*,
			T00.id as task_id,
			T00.start_datetime as task_start,
			T00.end_datetime as task_end,
			UPPER(T01.sid) as sid,
			T02.short_name as status_name,
			T02.icon as status_icon,
			T02.hex_color as status_color,
			T02.code as status_code

		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER_SYSTEM->tbl_name . ' as T01
				ON T00.customer_system_id = T01.id
			LEFT JOIN ' . $NOVIS_CSI_CMP_TASK_STATUS->tbl_name . ' as T02
				ON T00.status_id = T02.id
		WHERE
			T00.cmp_id = "' . $plan_id . '"
		ORDER BY T00.start_datetime ASC

	';
	$tasks = $this->get_sql ( $sql );
	foreach ( $tasks as $task ){
		$start_datetime = new DateTime ( $task['task_start'] );
		$end_datetime = new DateTime ( $task['task_end'] );
		$duration = date_diff ( $end_datetime, $start_datetime );
		$color_r = hexdec ( substr ( $task['status_color'], 0, 2 ) );
		$color_g = hexdec ( substr ( $task['status_color'], 2, 2 ) );
		$color_b = hexdec ( substr ( $task['status_color'], 4, 2 ) );
		$current_datetime = new DateTime();
		$calculate_delay_status_code = array( 'proposed', 'customer', 'programmed', );
		$task_class='';
		if ( FALSE != in_array ( $task['code'], $calculate_delay_status_code) ){
			if ( $current_datetime > $start_datetime ){
				$task_class="danger";
			}
		}
		$o.='
			<tr
				class="' . $task_class . '"
				style="border-left: 5px solid rgba(' . $color_r . ',' . $color_g . ',' . $color_b . ',1);"
			>
				<td class="hidden-xs">
					<small>' . $task['task_id'] . '</small>
				</td>
				<td>' . $task['sid'] . '</td>
				<td class="hidden-xs">' . ( ('' != $task['ticket_no'] && NULL != $task['ticket_no'] ) ? '<samp><small>' . $task['ticket_no'] . '</small></samp>' : '--' ) . '</td>
				<td
					style="background-color: rgba(' . $color_r . ',' . $color_g . ',' . $color_b . ',0.1);color: rgba(' . $color_r . ',' . $color_g . ',' . $color_b . ',1);"
				>
					<i class="fa fa-' . $task['status_icon'] . ' hidden-xs"></i>
					' . $task['status_name'] . '
				</td>
				<td><small>' . $start_datetime->format ('d/m/y H:i') . '</small></td>
				<td>' . $duration->h . ' horas</td>
				<td><a href="#" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a></td>
			</tr>
		';
	}
	$o.='
	<tr>
		<td colspan="999" class="text-center">
			<a href="#!addtask?plan_id=' . $plan_id . '" class="btn btn-success">
				<i class="fa fa-plus"></i> Agregar Tarea
			</a>
		</td>
	</tr>
	';

	$response['tbody']		= $o;

	echo json_encode($response);
	wp_die();

}

//END OF CLASS
}

global $NOVIS_CSI_CMP_TASK;
$NOVIS_CSI_CMP_TASK =new NOVIS_CSI_CMP_TASK_CLASS();
?>
