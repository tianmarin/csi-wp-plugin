<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_SERVICE_STEP_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'service_step';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Paso de Servicio';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Pasos de Servicio';
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
			id tinyint(2) unsigned not null auto_increment COMMENT 'Unique ID for each entry',
			service_id int(10) unsigned not null COMMENT 'ID of task',
			cmp_task_step_type_id tinyint(1) unsigned not null COMMENT 'ID of task step type',
			short_name varchar(80) not null COMMENT 'Short name of step',
			planned_start_datetime datetime not null COMMENT 'Planned start datetime',
			planned_end_datetime datetime not null COMMENT 'Planned end datetime',
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
		'code' => array(
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
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'short_name' => array(
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
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'value' => array(
			'type'						=>'number',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>-10,
			'data_validation_max'		=>10,
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
		'icon' => array(
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
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
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
		'hex_color' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>true,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>6,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'description' => array(
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
	register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install'						));
	//in a new blog creation, create the db for new blog
	//Applies only for non-network classes
	if( true != $this->network_class ){
		add_action( 'wpmu_new_blog',							array( $this , 'db_install'						));
	}
	if ( !is_multisite() ) {
		add_action( 'admin_menu',		 						array( $this , "register_submenu_page"			));
	}else{
		add_action( 'network_admin_menu', 						array( $this , "register_submenu_page"			));
	}

	add_action( 'wp_ajax_csi_fetch_service_step_list_info',		array( $this , 'csi_fetch_service_step_list_info'));
	add_action( 'wp_ajax_csi_create_service_step',				array( $this , 'csi_create_service_step'		));
	add_action( 'wp_ajax_csi_create_service_step_form',			array( $this , 'csi_create_service_step_form'	));
	add_action( 'wp_ajax_csi_edit_service_step',				array( $this , 'csi_edit_service_step'			));
	add_action( 'wp_ajax_csi_edit_service_step_form',			array( $this , 'csi_edit_service_step_form'		));


}
public function csi_fetch_service_step_list_info(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_CMP_TASK_STEP_TYPE;
	global $NOVIS_CSI_USER;
	global $NOVIS_CSI_SERVICE;
	//Local Variables
	$response			= array();
	$o					= '';
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//--------------------------------------------------------------------------
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_CMP_TASK_STEP_TYPE->tbl_name . ' WHERE id="' . $post['stepTypeId'] . '"';
	$step_type = $wpdb->get_row ( $sql );
	//--------------------------------------------------------------------------
	$sql = 'SELECT
				T00.*,
				T01.start_datetime as service_start_datetime
			FROM
				' . $this->tbl_name . ' as T00
				LEFT JOIN ' . $NOVIS_CSI_SERVICE->tbl_name . ' as T01
					ON T01.id = T00.service_id
			WHERE
				T00.service_id="' . $post['serviceId'] . '"
				AND T00.cmp_task_step_type_id="' . $post['stepTypeId'] . '"
			ORDER BY
				T00.planned_start_datetime
	';
	$service_steps = $this->get_sql ( $sql );
	//--------------------------------------------------------------------------
	foreach ( $service_steps as $service_step ){
		$service_start_datetime = new DateTime($service_step['service_start_datetime']);
		$planned_start_datetime = new DateTime($service_step['planned_start_datetime']);
		$planned_end_datetime = new DateTime($service_step['planned_end_datetime']);
		$duration = date_diff ( $planned_end_datetime, $planned_start_datetime );
		$deviation = date_diff ( $service_start_datetime, $planned_start_datetime );
		if ( 1 == $deviation->invert ){
			$invert = '<small>(antes de la ventana)</small>';
		}else{
			$invert = '';
		}
		//----------------------------------------------------------------------
		$edit_link = '<a href="#" class="in-table-form-button hidden-print" data-action="csi_edit_service_step_form"
						data-step-id="' . $service_step['id'] . '"><i class="fa fa-fw fa-edit"></i></a>&nbsp;';
		//----------------------------------------------------------------------
		$o.='
			<tr class="small">
				<td>' . $edit_link . '<samp>' . $service_step['short_name'] . '</samp></td>
				<td>
					<i class="fa fa-fw hidden-xs"></i>
					<span class="text-nowrap">' . $planned_start_datetime->format('d/m H:i') . '</span>
					<span class="hidden-xs"><i class="fa fa-fw fa-caret-right"></i></span>
					<span class="text-nowrap">' . $planned_end_datetime->format('d/m H:i') . '</span>
				</td>
				<td><i class="fa fa-fw hidden-xs"></i>' . $duration->h . ':' . sprintf ( "%02s", $duration->i ) . 'hrs</td>
				<td><i class="fa fa-fw hidden-xs"></i>' . sprintf ( "%02s", 24*$deviation->d + $deviation->h) . ':' . sprintf ( "%02s", $deviation->i ) . 'hrs ' . $invert . '</td>
			</tr>
		';
	}
	$o.='
	<tr style="position:relative;">
		<td colspan="999">
			<a
				href="#"
				class="in-table-form-button btn btn-default btn-sm"
				data-action="csi_create_service_step_form"
				data-service-id="' . $post['serviceId'] . '"
				data-step-type-id="' . $post['stepTypeId'] . '"
				>
				<i class="fa fa-plus"></i> Agregar paso de ' . $step_type->short_name . '
			</a>
		</td>
	</tr>

	';
	$response['tbody']		= $o;

	echo json_encode($response);
	wp_die();
}

public function csi_create_service_step(){
	//Globa Variables
	global $wpdb;
	//Local Variables
	$insertArray			= array();
	$response			= array();
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user		= get_userdata ( get_current_user_id() );
	$current_datetime	= new DateTime();
	$step_datetime		= explode ( ' - ', strip_tags ( stripslashes ( $post['step_datetime'] ) ) );
	$start_datetime		= new DateTime ( $step_datetime[0] . ':00' );
	$end_datetime		= new DateTime ( $step_datetime[1] . ':00' );

	$insertArray['service_id']				= strip_tags(stripslashes( $post['service_id'] ));
	$insertArray['cmp_task_step_type_id']	= strip_tags(stripslashes( $post['cmp_task_step_type_id'] ));
	$insertArray['short_name']				= strip_tags(stripslashes( $post['short_name'] ));
	$insertArray['planned_start_datetime']	= $start_datetime->format ( 'Y-m-d H:i:s' );
	$insertArray['planned_end_datetime']	= $end_datetime->format ( 'Y-m-d H:i:s' );
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
}// csi_create_service_step

public function csi_create_service_step_form(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_USER_TEAM;
	global $NOVIS_CSI_USER;
	//Local Variables
	$executor_user_opts		= '';
	$date_time_input_opts	= '';
	$response				= array();
	$post					= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$sql = 'SELECT
				planned_end_datetime
			FROM
				' . $this->tbl_name . '
			WHERE
				service_id = "' . $post['serviceId'] . '"
				AND cmp_task_step_type_id = "' . $post['stepTypeId'] . '"
			ORDER BY
				planned_end_datetime DESC
			LIMIT
				1';
	$last_step = $wpdb->get_var ( $sql );
	//if a previous step exists
	if ( count ( $last_step ) ){
		$date_time_input_opts	.= ' data-start-date="' . substr ( $last_step, 0, 16) . '"';
		$date_time_input_opts	.= ' data-end-date="' . substr ( $last_step, 0, 16) . '"';
	}else{
		$date_time_input_opts	.= ' data-start-date="2030-05-15 15:00"';
		$date_time_input_opts	.= ' data-end-date="2030-05-15 15:10"';
	}
	$date_time_input_opts		.= ' data-min-date="2030-05-01"';
	$date_time_input_opts		.= ' data-max-date="2030-05-31"';
	$date_time_input_opts		.= ' data-time-picker-increment="5"';
	//--------------------------------------------------------------------------
	$o='<div class="clearfix">
		<form class="in-table-form" data-function="csi_create_service_step">
			<input type="hidden" name="service_id" value="' . $post['serviceId'] . '"/>
			<input type="hidden" name="cmp_task_step_type_id" value="' . $post['stepTypeId'] . '"/>
			<p><strong><i class=" fa fa-plus"></i> Agregar nuevo paso de ejecuci&oacute;n</strong></p>
			<hr/>
			<div class="form-group">
				<label class="col-sm-2">Descripci&oacute;n</label>
				<div class="col-sm-10">
					<input type="text" name="short_name" class="form-control input-sm" required="true"/>
					<p class="help-block">Descripción breve de la actividad<br/>Tama&ntilde;o m&aacute;ximo: 30 caracteres</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Horario de Ejecuci&oacute;n</label>
				<div class="col-sm-10">
					<div class="input-group">
						<input type="text" name="step_datetime" class="form-control input-sm csi-datetime-range-input" required="true" ' . $date_time_input_opts . '/>
						<span class="input-group-addon">&nbsp;</span>
					</div>
					<p class="help-block">Indica el horario de ejecuci&oacute;n de el paso a ejecutar</p>
					<p class="help-block">Recuerda que la Ventana de MAntenimiento comienza el 25/05 a las 15:00hrs. Los tiempos que pongas serán calculados y modificados al momento de realizar la <i>importaci&oacute;n</i> del plan de trbajo.</p>
				</div>
			</div>
			<p></p>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="button" class="btn btn-default in-table-form-cancel"><i class="fa fa-history"></i> Cancelar</button>
					<button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Agregar</button>
				</div>
			</div>
		</form>
		</div>
	';
	$response['message']	= $o;
	echo json_encode($response);
	wp_die();
}// csi_create_service_step_form

public function csi_edit_service_step(){
	//Globa Variables
	global $wpdb;
	//Local Variables
	$editArray			= array();
	$whereArray			= array();
	$response			= array();
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user		= get_userdata ( get_current_user_id() );
	$current_datetime	= new DateTime();
	$step_datetime		= explode ( ' - ', strip_tags ( stripslashes ( $post['step_datetime'] ) ) );
	/*
	if ( 16 <= strlen ( $step_datetime[0]) ){
		$step_datetime[0] = substr ( $step_datetime[0], 0, 16);
	}
	if ( 16 <= strlen ( $step_datetime[1]) ){
		$step_datetime[1] = substr ( $step_datetime[1], 0, 16);
	}
	*/
	$start_datetime		= new DateTime ( $step_datetime[0] . ':00' );
	$end_datetime		= new DateTime ( $step_datetime[1] . ':00' );

	$whereArray['id']						= intval ( $post['service_step_id'] );

	$editArray['short_name']				= strip_tags(stripslashes( $post['short_name'] ));
	$editArray['planned_start_datetime']	= $start_datetime->format ( 'Y-m-d H:i:s' );
	$editArray['planned_end_datetime']		= $end_datetime->format ( 'Y-m-d H:i:s' );
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
		$response['postSubmitAction']	='refreshParent';
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
}// csi_edit_service_step

public function csi_edit_service_step_form(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_USER;
	global $NOVIS_CSI_USER_TEAM;
	//Local Variables
	$executor_user_opts		= '';
	$date_time_input_opts	='';
	$response				= array();
	$post					= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//--------------------------------------------------------------------------
	$sql ='SELECT * FROM ' . $this->tbl_name . ' WHERE id="' . $post['stepId'] . '"';
	$step = $wpdb->get_row ( $sql );
	//--------------------------------------------------------------------------
	$start_datetime = new DateTime ( $step->planned_start_datetime );
	$end_datetime = new DateTime ( $step->planned_end_datetime );
	$duration = date_diff ( $end_datetime, $start_datetime );
	//--------------------------------------------------------------------------
	$date_time_input_opts	.= ' data-start-date="' . substr ( $step->planned_start_datetime, 0, 16) . '"';
	$date_time_input_opts	.= ' data-end-date="' . substr ( $step->planned_end_datetime, 0, 16) . '"';
	$date_time_input_opts	.= ' data-min-date="2030-05-01"';
	$date_time_input_opts	.= ' data-max-date="2030-05-31"';
	$date_time_input_opts	.= ' data-time-picker-increment="5"';
	$datetime_value				= substr ( $step->planned_start_datetime, 0, 16) . ' - ' . substr ( $step->planned_start_datetime, 0, 16);
	//--------------------------------------------------------------------------
	$o='<div class="clearfix">
		<form class="in-table-form" data-function="csi_edit_service_step">
			<input type="hidden" name="service_step_id" value="' . $step->id . '"/>
			<p><strong><i class=" fa fa-plus"></i> Editar paso de ejecuci&oacute;n</strong></p>
			<hr/>
			<div class="form-group">
				<label class="col-sm-2">Descripci&oacute;n</label>
				<div class="col-sm-10">
					<input type="text" name="short_name" class="form-control input-sm" required="true" value="' . $step->short_name . '"/>
					<p class="help-block">Descripción breve de la actividad<br/>Tama&ntilde;o m&aacute;ximo: 30 caracteres</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Horario de Ejecuci&oacute;n</label>
				<div class="col-sm-10">
					<div class="input-group">
						<input type="text" name="step_datetime" class="form-control input-sm csi-datetime-range-input" required="true" value="' . $datetime_value . '" ' . $date_time_input_opts . '/>
						<span class="input-group-addon">' . $duration->h . ':' . sprintf ( "%02s", $duration->i ) . ' hrs</span>
					</div>
					<p class="help-block">Indica el horario de ejecuci&oacute;n de el paso a ejecutar</p>
				</div>
			</div>
			<p></p>
			<div class="form-group">
				<div class="col-sm-2">
					<button type="button" class="btn btn-sm btn-danger in-table-form-delete"><i class="fa fa-fw fa-trash"></i> Eliminar</button>
				</div>
				<div class="col-sm-10 text-right">
					<button type="button" class="btn btn-sm btn-default in-table-form-cancel"><i class="fa fa-fw fa-history"></i> Cancelar</button>
					<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-fw fa-pencil"></i> Editar</button>
				</div>
			</div>
		</form>
		</div>
	';
	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}// csi_edit_service_step_form


//END OF CLASS
}

global $NOVIS_CSI_SERVICE_STEP;
$NOVIS_CSI_SERVICE_STEP =new NOVIS_CSI_SERVICE_STEP_CLASS();
?>
