<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_CMP_TASK_STEP_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'cmp_task_step';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Status de Tarea';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Status de Tarea';
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
	$this->db_version	= '0.0.6';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="
		(
			id tinyint(2) unsigned not null auto_increment COMMENT 'Unique ID for each entry',
			cmp_task_id int(10) unsigned not null COMMENT 'ID of task',
			cmp_task_step_type_id tinyint(1) unsigned not null COMMENT 'ID of task step type',
			short_name varchar(80) not null COMMENT 'Short name of step',
			internal_executor_flag tinyint(1) null COMMENT 'Indicates if executor is registered user',
			external_executor varchar(30) null COMMENT 'External executor name',
			internal_user_id bigint(20) unsigned null COMMENT 'ID of registered user',
			internal_user_team tinyint(2) unsigned null COMMENT 'Internal user team',
			planned_start_datetime datetime not null COMMENT 'Planned start datetime',
			planned_end_datetime datetime not null COMMENT 'Planned end datetime',
			execution_status_flag tinyint(1) null COMMENT 'Indicates if step has been executed',
			real_start_datetime datetime null COMMENT 'Real start datetime',
			real_end_datetime datetime null COMMENT 'Real end datetime',
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
	add_action( 'wp_ajax_csi_cmp_popup_new_step_form',			array( $this , 'csi_cmp_popup_new_step_form'	));
	add_action( 'wp_ajax_csi_cmp_create_cmp_task_step',			array( $this , 'csi_cmp_create_cmp_task_step'	));
	add_action( 'wp_ajax_csi_cmp_popup_edit_step_form',			array( $this , 'csi_cmp_popup_edit_step_form'	));
	add_action( 'wp_ajax_csi_cmp_edit_cmp_task_step',			array( $this , 'csi_cmp_edit_cmp_task_step'		));
	add_action( 'wp_ajax_csi_cmp_build_page_task_steps_import',	array( $this , 'csi_cmp_build_page_task_steps_import'));
	add_action( 'wp_ajax_csi_cmp_build_page_task_steps_import_from_service',	array( $this , 'csi_cmp_build_page_task_steps_import_from_service'));

}

public function csi_cmp_create_cmp_task_step(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_USER;
	//Local Variables
	$insertArray			= array();
	$response			= array();
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user		= get_userdata ( get_current_user_id() );
	$current_datetime	= new DateTime();
	$step_datetime		= explode ( ' - ', strip_tags ( stripslashes ( $post['step_datetime'] ) ) );
	$start_datetime		= new DateTime ( $step_datetime[0] . ':00' );
	$end_datetime		= new DateTime ( $step_datetime[1] . ':00' );
	if ( isset ( $post['internal_user_id'] ) ){
		$sql = 'SELECT team_id FROM ' . $NOVIS_CSI_USER->tbl_name . ' WHERE id = "' . $post['internal_user_id'] . '"';
		$team_id = intval ( $wpdb->get_var ( $sql ) );
	}

	$insertArray['cmp_task_id']				= strip_tags(stripslashes( $post['cmp_task_id'] ));
	$insertArray['cmp_task_step_type_id']	= strip_tags(stripslashes( $post['cmp_task_step_type_id'] ));
	$insertArray['short_name']				= strip_tags(stripslashes( $post['short_name'] ));
	$insertArray['internal_executor_flag']	= isset ( $post['internal_executor_flag'] ) ? 1 : NULL ;
	$insertArray['external_executor']		= isset ( $post['external_executor'] ) ? strip_tags(stripslashes( $post['external_executor'] )) : null;
	$insertArray['internal_user_id']		= isset ( $post['internal_user_id'] ) ? intval ( $post['internal_user_id'] ) : null;
	$insertArray['internal_user_team']		= isset ( $team_id ) ? $team_id : null;
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
}// csi_cmp_create_cmp_task_step

public function csi_cmp_popup_new_step_form(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_USER_TEAM;
	global $NOVIS_CSI_USER;
	//Local Variables
	$executor_user_opts	= '';
	$response			= array();
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;

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
		$executor_user_opts .= '<optgroup label="' . $user_team['short_name'] . '">';
		foreach ( $users as $user ){
			$selected = ( $user['user_id'] == get_current_user_id() ) ? ' selected ' : '';
			$executor_user_opts .= '<option value="' . $user['user_id'] . '" ' . $selected . '>' . $user['display_name'] . '</option>';
		}
		$executor_user_opts .= '</optgroup>';
	}
	//--------------------------------------------------------------------------
	$o='<div class="clearfix">
		<form class="in-table-form" data-function="csi_cmp_create_cmp_task_step">
			<input type="hidden" name="cmp_task_id" value="' . $post['taskId'] . '"/>
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
				<label class="col-sm-2">Ejecutor</label>
				<div class="col-sm-10">
					<div class="input-group select2-bootstrap-append select2-bootstrap-prepend">
						<span class="input-group-addon"><samp>Ejecutor Interno</samp></span>
						<span class="input-group-addon">
							<input type="radio" name="internal_executor_flag" class="csi-switchable-radio-button"  value="1" checked>
						</span>
						<select name="internal_user_id" class="form-control select2" required="true" data-placeholder="Selecciona el ejecutor interno">
							<option></option>
							' . $executor_user_opts . '
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><samp>Ejecutor Externo</samp></span>
						<span class="input-group-addon">
							<input type="radio" class="csi-switchable-radio-button" name="internal_executor_flag" value="0"">
						</span>
						<input type="text" name="external_executor" required="true"  class="form-control disabled" disabled placeholder="[Compa&ntilde;ia] - [Nombre Apellido]">
					</div>
					<p class="help-block">Si el ejecutor es externo puedes agregar el paso como referencia con un texto que identifique a la persona y su empresa. Por ejemplo: <i>IBM - Javier Mart&iacute;nez</i></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Horario de Ejecuci&oacute;n</label>
				<div class="col-sm-10">
					<div class="input-group">
						<input type="text" name="step_datetime" class="form-control input-sm csi-datetime-range-input" required="true"/>
						<span class="input-group-addon">&nbsp;</span>
					</div>
					<p class="help-block">Indica el horario de ejecuci&oacute;n de el paso a ejecutar</p>
				</div>
			</div>
			<p>Recuerda que la asignación de los recursos debe ser coordinada y acordada con el l&iacute;der de cada área, acorde a las <a href="#" target="_blank"> Reglas de Solcitud de Cambio <i class="fa fa-external-link"></i></a>.</p>
			<p></p>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="button" class="btn btn-default in-table-form-cancel">Cancelar</button>
					<button type="submit" class="btn btn-success">Agregar</button>
				</div>
			</div>
		</form>
		</div>
	';
	$response['message']	= $o;
	echo json_encode($response);
	wp_die();
}// csi_cmp_popup_new_step_form

public function csi_cmp_popup_edit_step_form(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_USER;
	global $NOVIS_CSI_USER_TEAM;
	//Local Variables
	$executor_user_opts	= '';
	$response			= array();
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$sql ='SELECT * FROM ' . $this->tbl_name . ' WHERE id="' . $post['stepId'] . '"';
	$step = $wpdb->get_row ( $sql );
	//--------------------------------------------------------------------------
	$start_datetime = new DateTime ( $step->planned_start_datetime );
	$end_datetime = new DateTime ( $step->planned_end_datetime );
	$duration = date_diff ( $end_datetime, $start_datetime );
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
		$executor_user_opts .= '<optgroup label="' . $user_team['short_name'] . '">';
		foreach ( $users as $user ){
			$selected = ( 1 == $step->internal_executor_flag && $step->internal_user_id == $user['user_id'] ) ? ' selected ' : '';
			$executor_user_opts .= '<option value="' . $user['user_id'] . '" ' . $selected . '>' . $user['display_name'] . '</option>';
		}
		$executor_user_opts .= '</optgroup>';
	}
	//--------------------------------------------------------------------------
	$o='<div class="clearfix">
		<form class="in-table-form" data-function="csi_cmp_edit_cmp_task_step">
			<input type="hidden" name="cmp_task_step_id" value="' . $step->id . '"/>
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
				<label class="col-sm-2">Ejecutor</label>
				<div class="col-sm-10">
					<div class="input-group select2-bootstrap-append select2-bootstrap-prepend">
						<span class="input-group-addon"><samp>Ejecutor Interno</samp></span>
						<span class="input-group-addon">
							<input type="radio" name="internal_executor_flag" class="csi-switchable-radio-button"  value="1" ' . ( $step->internal_executor_flag ? 'checked' : '' ). '>
						</span>
						<select name="internal_user_id" class="form-control select2 ' . ( !$step->internal_executor_flag ? 'disabled' : '' ). '" ' . ( !$step->internal_executor_flag ? 'disabled' : '' ). ' required="true" data-placeholder="Selecciona el ejecutor interno">
							<option></option>
							' . $executor_user_opts . '
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><samp>Ejecutor Externo</samp></span>
						<span class="input-group-addon">
							<input type="radio" class="csi-switchable-radio-button" name="internal_executor_flag" value="0"" ' . ( !$step->internal_executor_flag ? 'checked="true"' : '' ). '>
						</span>
						<input type="text" name="external_executor" required="true"  class="form-control ' . ( $step->internal_executor_flag ? 'disabled' : '' ). '" ' . ( $step->internal_executor_flag ? 'disabled' : '' ). ' placeholder="[Compa&ntilde;ia] - [Nombre Apellido]" value="' . $step->external_executor . '">
					</div>
					<p class="help-block">Si el ejecutor es externo puedes agregar el paso como referencia con un texto que identifique a la persona y su empresa. Por ejemplo: <i>IBM - Javier Mart&iacute;nez</i></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Horario de Ejecuci&oacute;n</label>
				<div class="col-sm-10">
					<div class="input-group">
						<input type="text" name="step_datetime" class="form-control input-sm csi-datetime-range-input" required="true" value="' . $step->planned_start_datetime . ' - ' . $step->planned_end_datetime . '"/>
						<span class="input-group-addon">' . $duration->h . ':' . sprintf ( "%02s", $duration->m ) . ' hrs</span>
					</div>
					<p class="help-block">Indica el horario de ejecuci&oacute;n de el paso a ejecutar</p>
				</div>
			</div>
			<p>Recuerda que la asignación de los recursos debe ser coordinada y acordada con el l&iacute;der de cada área, acorde a las <a href="#" target="_blank"> Reglas de Solcitud de Cambio <i class="fa fa-external-link"></i></a>.</p>
			<p></p>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="button" class="btn btn-default in-table-form-cancel">Cancelar</button>
					<button type="submit" class="btn btn-success">Editar</button>
				</div>
			</div>
		</form>
		</div>
	';



	$response['message'] = $o;

	echo json_encode($response);
	wp_die();
}// csi_cmp_popup_edit_step_form
public function csi_cmp_edit_cmp_task_step(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_USER;
	//Local Variables
	$editArray			= array();
	$whereArray			= array();
	$response			= array();
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//--------------------------------------------------------------------------
	$current_user		= get_userdata ( get_current_user_id() );
	$current_datetime	= new DateTime();
	//--------------------------------------------------------------------------
	$step_datetime		= explode ( ' - ', strip_tags ( stripslashes ( $post['step_datetime'] ) ) );
	if ( 15 <= strlen ( $step_datetime[0]) ){
		$step_datetime[0] = substr ( $step_datetime[0], 0, 15);
	}
	if ( 15 <= strlen ( $step_datetime[1]) ){
		$step_datetime[1] = substr ( $step_datetime[1], 0, 15);
	}
	$start_datetime		= new DateTime ( $step_datetime[0] . ':00' );
	$end_datetime		= new DateTime ( $step_datetime[1] . ':00' );
	//--------------------------------------------------------------------------
	if ( isset ( $post['internal_user_id'] ) ){
		$sql = 'SELECT team_id FROM ' . $NOVIS_CSI_USER->tbl_name . ' WHERE id = "' . $post['internal_user_id'] . '"';
		$team_id = intval ( $wpdb->get_var ( $sql ) );
	}
	//--------------------------------------------------------------------------

	$whereArray['id']						= intval ( $post['cmp_task_step_id'] );

	$editArray['short_name']				= strip_tags(stripslashes( $post['short_name'] ));
	$editArray['internal_executor_flag']	= isset ( $post['internal_executor_flag'] ) ? 1 : 0 ;
	$editArray['external_executor']			= isset ( $post['external_executor'] ) ? strip_tags(stripslashes( $post['external_executor'] )) : null;
	$editArray['internal_user_id']			= isset ( $post['internal_user_id'] ) ? intval ( $post['internal_user_id'] ) : null;
	$editArray['internal_user_team']		= isset ( $team_id ) ? $team_id : null;
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
}// csi_cmp_edit_cmp_task_step

public function csi_cmp_build_page_task_steps_import_from_service(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_USER;
	global $NOVIS_CSI_USER_TEAM;
	global $NOVIS_CSI_CMP_TASK_STEP_TYPE;
	global $NOVIS_CSI_CMP_TASK;
	global $NOVIS_CSI_SERVICE;
	global $NOVIS_CSI_SERVICE_STEP;
	//Local Variables
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$task_id			= $post['task_id'];
	$current_user		= get_userdata ( get_current_user_id() );
	$current_datetime	= new DateTime();
	$sql='
		SELECT
			T00.*,
			T01.start_datetime as service_start_datetime,
			T01.name as service_name,
			T01.id as service_id

		FROM
			' . $NOVIS_CSI_CMP_TASK->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_SERVICE->tbl_name . ' as T01
				ON T00.service_id = T01.id
		WHERE
			T00.id = "' . $task_id . '"
	';
	$task= $wpdb->get_row ( $sql );
	$service_datetime = new DateTime ( $task->service_start_datetime );
	$task_datetime = new DateTime ( $task->start_datetime );
	//--------------------------------------------------------------------------
	$service_window_start_datetime	= new DateTime ( $task->service_start_datetime );
	$task_window_start_datetime		= new DateTime ( $task->start_datetime );
	//--------------------------------------------------------------------------
	// Delete steps related to this task
	$where['cmp_task_id'] = $task_id;
	$wpdb->delete ( $this->tbl_name, $where, null );
	// Insert each step with owner executor
	$sql = '
		SELECT
			*
		FROM
			' . $NOVIS_CSI_SERVICE_STEP->tbl_name . '
		WHERE
			service_id = "' . $task->service_id . '"
		ORDER BY
			planned_start_datetime ASC
		';
	$service_steps = $this->get_sql ( $sql );
	foreach ( $service_steps as $service_step ){
		//step start datetime
		$diff = date_diff ( $service_window_start_datetime, new DateTime ( $service_step['planned_start_datetime']));
		$task_window_start_datetime = new DateTime ( $task->start_datetime ) ;
		$task_window_start_datetime->add( $diff );
		//duration
		$duration = date_diff ( new DateTime ( $service_step['planned_start_datetime']), new DateTime ( $service_step['planned_end_datetime']) );

		$insertArray = array();
		$insertArray['cmp_task_id']				= strip_tags ( stripslashes( $task_id ) );
		$insertArray['cmp_task_step_type_id']	= intval ( $service_step['cmp_task_step_type_id'] );
		$insertArray['short_name']				= strip_tags ( stripslashes ( $service_step['short_name'] ) );
		$insertArray['internal_executor_flag']	= 1;
		$insertArray['internal_user_id']		= $current_user->ID;
		$insertArray['planned_start_datetime']	= $task_window_start_datetime->format('Y/m/d H:i:s');
		$insertArray['planned_end_datetime']	= $task_window_start_datetime->format('Y/m/d H:i:s');
		$insertArray['creation_user_id']		= $current_user->ID;
		$insertArray['creation_user_email']		= $current_user->user_email;
		$insertArray['creation_date']			= $current_datetime->format('Y-m-d');
		$insertArray['creation_time']			= $current_datetime->format('H:i:s');
		$wpdb->insert( $this->tbl_name, $insertArray );
	}
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
		'content'			=> 'Has ajustdo el plan de trabajo exitosamente.',
		'title'				=> 'Bien!',
		'type'				=> 'green',
		//'autoClose'			=> 'OK|3000',
	);
	echo json_encode($response);
	wp_die();
}// csi_cmp_build_page_task_steps_import_from_service

public function csi_cmp_build_page_task_steps_import(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_USER;
	global $NOVIS_CSI_USER_TEAM;
	global $NOVIS_CSI_CMP_TASK_STEP_TYPE;
	global $NOVIS_CSI_CMP_TASK;
	global $NOVIS_CSI_SERVICE;
	global $NOVIS_CSI_SERVICE_STEP;
	//Local Variables
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$response			= array();
	$o					= '';
	$task_id			= $post['task_id'];
	$import_source		= $post['import_source'];
	//--------------------------------------------------------------------------
	$sql='
		SELECT
			T00.*,
			T01.start_datetime as service_start_datetime,
			T01.name as service_name,
			T01.id as service_id

		FROM
			' . $NOVIS_CSI_CMP_TASK->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_SERVICE->tbl_name . ' as T01
				ON T00.service_id = T01.id
		WHERE
			T00.id = "' . $task_id . '"
	';
	$task = $wpdb->get_row ( $sql );
	$service_datetime = new DateTime ( $task->service_start_datetime );
	$task_datetime = new DateTime ( $task->start_datetime );
	//--------------------------------------------------------------------------
	$service_window_start_datetime	= new DateTime ( $task->service_start_datetime );
	$task_window_start_datetime		= new DateTime ( $task->start_datetime );
	//--------------------------------------------------------------------------
	$o.='<div class="container">';
	$o.='
		<p>
			El servicio <strong>' . $task->service_name . '</strong> tiene definido el siguiente Plan de Actividades.<br/>
			El horario de cada actividad ha sido ajustado al inicio de la Ventana de Mantenimiento definida en la tarea (
			' . $task_datetime->format('d/m H:i') . ').
		</p>
	';
	//--------------------------------------------------------------------------
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_CMP_TASK_STEP_TYPE->tbl_name . ' ORDER BY step_type_order ASC';
	$step_types = $this->get_sql ( $sql );
	foreach ( $step_types as $step_type ){
		$o.='
		<div class="panel panel-' . $step_type['css_class'] . ' ">
			<div class="panel-heading">
				 Pasos de ' . $step_type['short_name'] . '
			</div>
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>
							<span class="hidden-xs"><i class="fa fa-fw fa-align-left"></i> Descripci&oacute;n</span>
							<span class="visible-xs"><small>Descripci&oacute;n</small></span>
						</th>
						<th>
							<span class="hidden-xs"><i class="fa fa-fw fa-calendar-o"></i> Tiempo</span>
							<span class="visible-xs"><small>Tiempo</small></span>
						</th>
						<th>
							<span class="hidden-xs"><i class="fa fa-fw fa-clock-o"></i> Duraci&oacute;n</span>
							<span class="visible-xs"><small>Duraci&oacute;n</small></span>
						</th>
						<th>
							<span class="hidden-xs"><i class="fa fa-fw fa-code-fork"></i> Tiempo desde Inicio de Ventana</span>
							<span class="visible-xs"><small>Desviaci&oacute;n</small></span>
						</th>
					</tr>
				</thead>
				<tbody>';
		$sql = '
			SELECT
				*
			FROM
				' . $NOVIS_CSI_SERVICE_STEP->tbl_name . '
			WHERE
				service_id = "' . $task->service_id . '"
				AND cmp_task_step_type_id = "' . $step_type['id'] . '"
			ORDER BY
				planned_start_datetime ASC
			';
		$service_steps = $this->get_sql ( $sql );
		foreach ( $service_steps as $service_step ){
			//step start datetime
			$diff = date_diff ( $service_window_start_datetime, new DateTime ( $service_step['planned_start_datetime']));
			$task_window_start_datetime = new DateTime ( $task->start_datetime ) ;
			$task_window_start_datetime->add( $diff );
			//duration
			$duration = date_diff ( new DateTime ( $service_step['planned_start_datetime']), new DateTime ( $service_step['planned_end_datetime']) );
			$duration_text = sprintf ( "%02s", 24*$duration->d + $duration->h) . ':' . sprintf ( "%02s", $duration->i ) . 'hrs ';

			$o.='
				<tr>
					<td>' . $service_step['short_name'] . '</td>
					<td>' . $task_window_start_datetime->format('d/m H:i') . 'hrs</td>
					<td>' . $duration_text . '</td>
					<td>hrs</td>
				</tr>
			';
		}
		$o.='
				</tbody>
			</table>
		</div>
		';
	}
	$o.='
		<form data-function="csi_cmp_build_page_task_steps_import_from_service" data-next-page="showtask?task_id=' . $task->id . '">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10 text-right">
					<input type="hidden" name="task_id" id="task_id" value="' . $task->id . '"/>
					<input type="hidden" name="service_id" id="service_id" value="' . $task->service_id . '"/>
					<button type="reset" class="btn btn-danger">Cancelar</button>
					<button type="submit" class="btn btn-primary">Aceptar</button>
				</div>
			</div>
		</form>
	</div>';
	//--------------------------------------------------------------------------

	$response['message'] = $o;

	echo json_encode($response);
	wp_die();
}



//END OF CLASS
}

global $NOVIS_CSI_CMP_TASK_STEP;
$NOVIS_CSI_CMP_TASK_STEP =new NOVIS_CSI_CMP_TASK_STEP_CLASS();
?>
