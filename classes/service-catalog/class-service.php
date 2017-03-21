<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_SERVICE_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'service';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Servicio';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Servicios';
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
	$this->db_version	= '0.0.2';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="
		(
			id tinyint(2) unsigned not null auto_increment COMMENT 'Unique ID for each entry',
			name varchar(150) not null COMMENT 'Service name',
			short_name varchar(150) not null COMMENT 'Service short name',
			lead_time varchar(20) not null COMMENT 'Lead time of service',
			execution_window_time varchar(20) not null COMMENT 'Execution window time of service',
			start_datetime datetime not null COMMENT 'Service start datetime reference',
			offline_service_flag tinyint(1) null COMMENT 'Indicates if execution is meant to be offline',
			short_description tinytext null COMMENT 'Short description of service',
			description text null COMMENT 'Description of service',
			user_team_id tinyint(2) not null COMMENT 'Responsible team of service',
			change_type_id tinyint(1) unsigned not null COMMENT 'Change type id',
			service_url varchar(100) null COMMENT 'Service URL',
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
	register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install'					));
	//register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install_data'			));

	//in a new blog creation, create the db for new blog
	//Applies only for non-network classes
	if( true != $this->network_class ){
		add_action( 'wpmu_new_blog',							array( $this , 'db_install'					));
		add_action( 'wpmu_new_blog',							array( $this , 'db_install_data'			));
	}
	if ( !is_multisite() ) {
		add_action( 'admin_menu',		 						array( $this , "register_submenu_page"		));
	}else{
		add_action( 'network_admin_menu', 						array( $this , "register_submenu_page"		));
	}
	add_action( 'wp_ajax_csi_cmp_build_page_list_services',		array( $this , 'csi_cmp_build_page_list_services'		));
	add_action( 'wp_ajax_csi_cmp_fetch_filtered_service_table',	array( $this , 'csi_cmp_fetch_filtered_service_table'	));
	add_action( 'wp_ajax_csi_cmp_build_page_show_service',		array( $this , 'csi_cmp_build_page_show_service'		));
	add_action( 'wp_ajax_csi_cmp_fetch_service_step_list_info',	array( $this , 'csi_cmp_fetch_service_step_list_info'	));
	add_action( 'wp_ajax_csi_cmp_build_page_edit_service_form',	array( $this , 'csi_cmp_build_page_edit_service_form'	));
	add_action( 'wp_ajax_csi_edit_service',						array( $this , 'csi_edit_service'	));
	add_action( 'wp_ajax_csi_cmp_build_page_new_service_form',	array( $this , 'csi_cmp_build_page_new_service_form'	));
	add_action( 'wp_ajax_csi_add_service',						array( $this , 'csi_add_service'	));

}
public function csi_add_service(){
	//Global Variables
	global $wpdb;
	//Local Variables
	$insertArray			= array();
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user			= get_userdata ( get_current_user_id() );
	$current_datetime		= new DateTime();
	self::write_log ( $post );



	$insertArray['name']						= strip_tags(stripslashes( $post['name'] ));
	$insertArray['short_name']					= strip_tags(stripslashes( $post['short_name'] ));
	$insertArray['lead_time']					= strip_tags(stripslashes( $post['lead_time'] ) );
	$insertArray['execution_window_time']		= strip_tags(stripslashes( $post['execution_window_time'] ) );
	$insertArray['offline_service_flag']		= isset ( $post['offline_service_flag'] )? 1 : NULL ;
	$insertArray['short_description']			= strip_tags(stripslashes( $post['short_description'] ));
	$insertArray['description']					= strip_tags(stripslashes( $post['description'] ));
	$insertArray['user_team_id']				= intval ( $post['user_team_id'] );
	$insertArray['change_type_id']				= intval ( $post['change_type_id'] );
	$insertArray['service_url']					= strip_tags(stripslashes( $post['service_url'] ));
	$insertArray['creation_user_id']			= $current_user->ID;
	$insertArray['creation_user_email']			= $current_user->user_email;
	$insertArray['creation_date']				= $current_datetime->format('Y-m-d');
	$insertArray['creation_time']				= $current_datetime->format('H:i:s');
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
public function csi_edit_service(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_CMP_CHANGE_TYPE;
	//Local Variables
	$post					= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user			= get_userdata ( get_current_user_id() );
	$current_datetime		= new DateTime();

	$whereArray['id']							= intval ( $post['service_id'] );


	$editArray['name']							= strip_tags(stripslashes( $post['name'] ));
	$editArray['short_name']					= strip_tags(stripslashes( $post['short_name'] ));
	$editArray['lead_time']						= strip_tags(stripslashes( $post['lead_time'] ) );
	$editArray['execution_window_time']			= strip_tags(stripslashes( $post['execution_window_time'] ) );
	$editArray['offline_service_flag']			= isset ( $post['offline_service_flag'] )? 1 : NULL ;
	$editArray['short_description']				= strip_tags(stripslashes( $post['short_description'] ));
	$editArray['description']					= strip_tags(stripslashes( $post['description'] ));
	$editArray['user_team_id']					= intval ( $post['user_team_id'] );
	$editArray['change_type_id']				= intval ( $post['change_type_id'] );
	$editArray['service_url']					= strip_tags(stripslashes( $post['service_url'] ));
	$editArray['last_modified_user_id']			= $current_user->ID;
	$editArray['last_modified_user_email']		= $current_user->user_email;
	$editArray['last_modified_date']			= $current_datetime->format('Y-m-d');
	$editArray['last_modified_time']			= $current_datetime->format('H:i:s');
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

}
public function csi_cmp_build_page_edit_service_form(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_CMP_CHANGE_TYPE;
	global $NOVIS_CSI_USER_TEAM;
	//Local Variables
	$response			= array();
	$o					= '';
	$change_type_opts	= '';
	$user_team_opts	= '';
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$service_id			= intval ( $post['service_id'] );
	$sql = 'SELECT * FROM ' . $this->tbl_name . ' WHERE id = "' . $service_id . '"';
	$service = $wpdb->get_row ( $sql );
	//--------------------------------------------------------------------------
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_CMP_CHANGE_TYPE->tbl_name . ' ';
	$change_types = $this->get_sql ( $sql );
	foreach ( $change_types as $change_type ){
		$checked = ( $change_type['id'] == $service->change_type_id ) ? 'checked' : '';
		$change_type_opts.='
			<div class="">
				<input type="radio" name="change_type_id" id="change_type_' . $change_type['id'] . '" value="' . $change_type['id'] . '" ' . $checked . ' class="csi-cool-radio">
				<label for="change_type_' . $change_type['id'] . '">' . $change_type['short_name'] . '</label>
			</div>
		';
	}
	//--------------------------------------------------------------------------
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_USER_TEAM->tbl_name . ' ';
	$user_teams = $this->get_sql ( $sql );
	foreach ( $user_teams as $user_team ){
		$selected = ( $user_team['id'] == $service->user_team_id ) ? 'selected' : '';
		$user_team_opts.='<option value="' . $user_team['id'] . '" ' . $selected . '>' . $user_team['short_name'] . '</option>';
	}
	//--------------------------------------------------------------------------
	$o='
	<!-- #EditService -->
	<div id="csi-template-cmp-control-center-edit-service" class="container ">
		<div class="panel panel-default row">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> Editar Servicio</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" data-function="csi_edit_service" data-next-page="showservice?service_id=' . $service->id . '">
					<input type="hidden" name="service_id" value="' . $service->id . '"/>
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Nombre del Servicio</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name" id="name" required="true" maxlength="100" placeholder="Actualización de Nivel de Parche de Kernel SAP NetWeaver ABAP" value="' . $service->name . '"/>
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Nombre &uacute;nico del servicio.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 100 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="short_name" class="col-sm-2 control-label">Nombre Corto</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="short_name" id="short_name" required="true" maxlength="20" placeholder="Act. Kernel" value="' . $service->short_name . '"/>
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								El nombre corto se utiliza para su despliegue en formatos peque&ntilde;os como <i>Eventos de Calendario</i>.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 20 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="lead_time" class="col-sm-2 control-label">Tiempo de Antelaci&oacute;n</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="lead_time" id="lead_time" required="true" value="' . $service->lead_time . '" maxlength="20"/>
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								El <abbr data-toggle="tooltip" data-placement="top" title="Service Lead Time">tiempo de antelaci&oacute;n</abbr> indica con cuantas horas el solicitante de un servicio debe realizar la <i>Solicitud de Servicio</i>, para que el ejector del servicio pueda preparar la tarea.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 20 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="execution_window_time" class="col-sm-2 control-label">Ventana mínima de ejecuci&oacute;n</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="execution_window_time" id="execution_window_time" required="true" value="' . $service->execution_window_time . '" maxlength="20"/>
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								La <i>ventana mínima de ejecuci&oacute;n</i> indica cuantas horas deben ser las mínimas solicitadas para la ejecución de este servicio. Considerando el tiempo que toman los pasos de <i>ejecución</i> y de <i>vuelta atrás</i> es importante considerar que la <i>ventana mínima de ejecuci&oacute;n</i> considere la suma de los peores tiempos.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 20 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Ventana Offline</label>
						<div class="col-sm-10">
							<input type="checkbox" class="form-control csi-cool-checkbox" id="offline_service_flag" name="offline_service_flag" value="1" ' . ( 1 == $service->offline_service_flag ? 'checked' : '' ) . '/>
							<label for="offline_service_flag">Ventana Offline</label>
							<span class="help-block">
								Indica si la actividad impacta la disponibilidad del sistema relacionado.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="short_description" class="col-sm-2 control-label">Descripci&oacute;n breve</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="short_description" id="short_description" maxlength="255" value="' . $service->short_description . '" maxlength="255" />
							<span class="help-block">
								<small>Tama&ntilde;o m&aacute;ximo: 255 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">Descripci&oacute;n</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="description" id="description">' . $service->description . '</textarea>
							<span class="help-block">
								<small>Tama&ntilde;o m&aacute;ximo: 60,000 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="user_team_id" class="col-sm-2 control-label">Equipo responsable</label>
						<div class="col-sm-10">
							<select class="form-control select2" name="user_team_id" id="user_team_id" data-placeholder="Selecciona el equipo responsable">
								<option></option>
								' . $user_team_opts . '
							</select>
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								El <i>equipo responsable</i> define el equipo responsable de la documentaci&oacute;n del servicio. De igual modo, en caso de inconsistencias en los procedimientos asociados, el equipo puede ser informado mediante un correo electr&oacute;nico que notificar&aacute; a todos los miembros del equipo.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Cambio</label>
						<div class="col-sm-10">
							' . $change_type_opts . '
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								El <i>tipo de cambio</i> refleja el mecanismo de aprobación para la ejecuci&oacute;n del servicio. Para más información visita la documentación de <a href="http://intranetmx.noviscorp.com/novis/csi/change-mgmt/" target="_blank" >Gesti&oacute;n de Cambio <i class="fa fa-external-link"></i></a> en Novis.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="service_url" class="col-sm-2 control-label">Documentaci&oacute;n</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="service_url" id="service_url" maxlength="15" value="' . $service->service_url . '" maxlength="100"/>
							<span class="help-block">
								URL de la documentaci&oacute;n del servicio.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 100 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10 text-right">
							<button type="reset" class="btn btn-default">Cancelar</button>
							<button type="submit" class="btn btn-primary">Entiendo, Editar servicio</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div><!-- #csi-template-cmp-control-center-edit-service -->
	';

	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
public function csi_cmp_build_page_new_service_form(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_CMP_CHANGE_TYPE;
	global $NOVIS_CSI_USER_TEAM;
	//Local Variables
	$response			= array();
	$o					= '';
	$change_type_opts	= '';
	$user_team_opts	= '';
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//--------------------------------------------------------------------------
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_CMP_CHANGE_TYPE->tbl_name . ' ';
	$change_types = $this->get_sql ( $sql );
	foreach ( $change_types as $change_type ){
		$change_type_opts.='
			<div class="">
				<input type="radio" name="change_type_id" id="change_type_' . $change_type['id'] . '" value="' . $change_type['id'] . '"  class="csi-cool-radio">
				<label for="change_type_' . $change_type['id'] . '">' . $change_type['short_name'] . '</label>
			</div>
		';
	}
	//--------------------------------------------------------------------------
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_USER_TEAM->tbl_name . ' ';
	$user_teams = $this->get_sql ( $sql );
	foreach ( $user_teams as $user_team ){
		$user_team_opts.='<option value="' . $user_team['id'] . '" >' . $user_team['short_name'] . '</option>';
	}
	//--------------------------------------------------------------------------
	$o='
	<!-- #EditService -->
	<div id="csi-template-cmp-control-center-edit-service" class="container ">
		<div class="panel panel-default row">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-plus"></i> Nuevo Servicio</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" data-function="csi_add_service" data-next-page="listservices">
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Nombre del Servicio</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name" id="name" required="true" maxlength="100" placeholder="Actualización de Nivel de Parche de Kernel SAP NetWeaver ABAP"/>
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Nombre &uacute;nico del servicio.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 100 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="short_name" class="col-sm-2 control-label">Nombre Corto</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="short_name" id="short_name" required="true" maxlength="20" placeholder="Act. Kernel" />
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								El nombre corto se utiliza para su despliegue en formatos peque&ntilde;os como <i>Eventos de Calendario</i>.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 20 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="lead_time" class="col-sm-2 control-label">Tiempo de Antelaci&oacute;n</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="lead_time" id="lead_time" required="true" maxlength="20"/>
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								El <abbr data-toggle="tooltip" data-placement="top" title="Service Lead Time">tiempo de antelaci&oacute;n</abbr> indica con cuantas horas el solicitante de un servicio debe realizar la <i>Solicitud de Servicio</i>, para que el ejector del servicio pueda preparar la tarea.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 20 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="execution_window_time" class="col-sm-2 control-label">Ventana mínima de ejecuci&oacute;n</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="execution_window_time" id="execution_window_time" required="true" maxlength="20"/>
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								La <i>ventana mínima de ejecuci&oacute;n</i> indica cuantas horas deben ser las mínimas solicitadas para la ejecución de este servicio. Considerando el tiempo que toman los pasos de <i>ejecución</i> y de <i>vuelta atrás</i> es importante considerar que la <i>ventana mínima de ejecuci&oacute;n</i> considere la suma de los peores tiempos.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 20 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Ventana Offline</label>
						<div class="col-sm-10">
							<input type="checkbox" class="form-control csi-cool-checkbox" id="offline_service_flag" name="offline_service_flag" value="1" />
							<label for="offline_service_flag">Ventana Offline</label>
							<span class="help-block">
								Indica si la actividad impacta la disponibilidad del sistema relacionado.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="short_description" class="col-sm-2 control-label">Descripci&oacute;n breve</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="short_description" id="short_description" maxlength="255" maxlength="255" />
							<span class="help-block">
								<small>Tama&ntilde;o m&aacute;ximo: 255 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">Descripci&oacute;n</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="description" id="description"></textarea>
							<span class="help-block">
								<small>Tama&ntilde;o m&aacute;ximo: 60,000 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="user_team_id" class="col-sm-2 control-label">Equipo responsable</label>
						<div class="col-sm-10">
							<select class="form-control select2" name="user_team_id" id="user_team_id" data-placeholder="Selecciona el equipo responsable">
								<option></option>
								' . $user_team_opts . '
							</select>
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								El <i>equipo responsable</i> define el equipo responsable de la documentaci&oacute;n del servicio. De igual modo, en caso de inconsistencias en los procedimientos asociados, el equipo puede ser informado mediante un correo electr&oacute;nico que notificar&aacute; a todos los miembros del equipo.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Cambio</label>
						<div class="col-sm-10">
							' . $change_type_opts . '
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								El <i>tipo de cambio</i> refleja el mecanismo de aprobación para la ejecuci&oacute;n del servicio. Para más información visita la documentación de <a href="http://intranetmx.noviscorp.com/novis/csi/change-mgmt/" target="_blank" >Gesti&oacute;n de Cambio <i class="fa fa-external-link"></i></a> en Novis.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="service_url" class="col-sm-2 control-label">Documentaci&oacute;n</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="service_url" id="service_url" maxlength="15" maxlength="100"/>
							<span class="help-block">
								URL de la documentaci&oacute;n del servicio.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 100 caracteres</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10 text-right">
							<button type="reset" class="btn btn-default">Cancelar</button>
							<button type="submit" class="btn btn-primary">Entiendo, Editar servicio</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div><!-- #csi-template-cmp-control-center-edit-service -->
	';

	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
public function csi_cmp_build_page_show_service(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_CMP_TASK_STEP_TYPE;
	global $NOVIS_CSI_USER_TEAM;
	global $NOVIS_CSI_CMP_CHANGE_TYPE;
	//Local Variables
	$response			= array();
	$o					= '';
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$service_id			= intval ( $post['service_id'] );
	$sql = 'SELECT
	 			T00.*,
				T01.short_name as service_team_name,
				T02.short_name as service_change_type_name
			FROM
				' . $this->tbl_name . ' as T00
				LEFT JOIN ' . $NOVIS_CSI_USER_TEAM->tbl_name . ' as T01
					ON T01.id = T00.user_team_id
				LEFT JOIN ' . $NOVIS_CSI_CMP_CHANGE_TYPE->tbl_name . ' as T02
					ON T02.id = T00.change_type_id
			WHERE T00.id = "' . $service_id . '"';
	$service = $wpdb->get_row ( $sql );
	//--------------------------------------------------------------------------
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_CMP_TASK_STEP_TYPE->tbl_name . ' ORDER BY step_type_order ASC';
	$step_types = $this->get_sql ( $sql );
	//--------------------------------------------------------------------------
	$o='
	<!-- #showService -->
	<div id="" class="container ">
		<h2>Informaci&oacute;n del Servicio</h2>
		<p class="lead">' . $service->name . '</p>
		<div class="row">
			<div class="col-sm-9">
				<div class="panel panel-default">
					<div class="panel-heading">
						<span class="pull-right">
							<a href="#!editservice?service_id=' . $service->id . '" class=""><i class="fa fa-pencil"></i> Editar</a>
						</span>
						Ficha T&eacute;cnica
					</div>
					<table class="table">
						<tbody>
							<tr>
								<td class="small text-muted"><p>Nombre del Servicio</p></td>
								<th><p>' . $service->name . '</p></th>
							</tr>
							<tr>
								<td class="small text-muted"><p>Nombre Corto</p></td>
								<th><p>' . $service->short_name . '</p></th>
							</tr>
							<tr>
								<td class="small text-muted"><p>Tiempo de Antelación</p></td>
								<td><time>' . $service->lead_time . '</time></td>
							</tr>
							<tr>
								<td class="small text-muted"><p>Ventana de Mantenimiento</p></td>
								<td><time>' . $service->execution_window_time . '</time></td>
							</tr>
							<tr>
								<td class="small text-muted"><p>Descripción breve</p></td>
								<td><p>' . $service->short_description . '</p></td>
							</tr>
							<tr>
								<td class="small text-muted"><p>Descripción</p></td>
								<td><p>' . $service->description . ' <a href="#">[<i class="fa fa-ellipsis-h"></i></a>]</p></td>
							</tr>
							<tr>
								<td class="small text-muted"><p>Equipo Responsable</p></td>
								<td>' . $service->service_team_name . '</td>
							</tr>
							<tr>
								<td class="small text-muted"></p>Cambio</p></td>
								<td>' . $service->service_change_type_name . '</td>
							</tr>
							<tr>
								<td class="small text-muted"><p>Doc. de Servicio</p></td>
								<td><a href="' . $service->service_url . '" target="_blank">' . $service->service_url . ' <i class="fa fa-external-link"></i></a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<h3>Plan de trabajo</h3>
		<div class="well">
			<p>Para crear el plan de trabajo de
			<p>El <i>plan de trabajo</i> relacionado a este servicio, considera una Ventana de Ejecución de <time>' . $service->execution_window_time . '</time>. Para evaluar la duración y antelación de cada paso el plan está construido, asumiendo que la Ventana de Ejecución está programada en una fecha futura para el <code>15 de Mayo <small>(2030-05-15)</small> a las 15:00hrs</code>.</p>
		</div>';
		foreach ( $step_types as $step_type ){
			$o.='
			<div class="panel panel-' . $step_type['css_class'] . ' row">
				<div class="panel-heading">
					 Pasos de ' . $step_type['short_name'] . '
					<span class="pull-right hidden-print">
						<a href="#csi-fetch-service-step-list-info-' . $step_type['id'] . '" class="refresh-button text-' . $step_type['css_class'] . '"><i class="fa fa-fw fa-refresh"></i></a>
					</span>
				</div>
				<table class="table table-condensed refreshable" id="csi-fetch-service-step-list-info-' . $step_type['id'] . '" data-action="csi_fetch_service_step_list_info" data-step-type-id="' . $step_type['id'] . '" data-service-id="' . $service->id . '" style="position:relative;">
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
					<tbody style="position:relative;">
					</tbody>
				</table>
			</div>
			';
		}
		$o.='
	</div>
	';
	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
public function csi_cmp_build_page_list_services(){
	//Global Variables
	global $wpdb;
	//Local Variables
	$response			= array();
	$o='
	<div id="csi-template-cmp-control-center-list-services" class="container">
		<div class="page-header row">
			<h3 class="col-sm-10">Catálogo de Servicios</h3>
			<h3 class="col-sm-2">
				<a href="#!addservice" class="btn btn-success" id="csi-template-cmp-add-new-plan">
					<i class="fa fa-plus"></i> Nuevo Servicio
				</a>
			</h3>
		</div>
		<div class="panel panel-default row">
			<div class="panel-heading">
				<strong class="">
					<i class="fa fa-tasks"></i>
					Servicios
				</strong>
				<div class="pull-right">
					<a class="refresh-button" data-refresh-table="" href="#csi-template-cmp-filtered-service-table">
						<i class="fa fa-fw fa-refresh"></i>
					</a>
				</div>
			</div>
			<div class="collapse in">
			</div>
			<table id="csi-template-cmp-filtered-service-table" class="table refreshable" data-action="csi_cmp_fetch_filtered_service_table" style="position:relative;">
				<thead>
					<tr>
						<th class="hidden-xs"><small><i class="fa fa-hashtag"></i></small></th>
						<th>Nombre</th>
						<th>Tareas</th>
					</tr>
				</thead>
				<tbody style="position:relative;">
				</tbody>
			</table>
			<div style="position:relative;">
				<div id="csi-template-cmp-control-center-table-pagination" class="text-center"></div>
			</div>
		</div>
	</div>
	';

	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
public function csi_cmp_fetch_filtered_service_table(){
	//Global Variables
	global $wpdb;
	//Local Variables
	$response			= array();
	$o					= '';
	$sql = 'SELECT * FROM ' . $this->tbl_name . ' ORDER BY name ASC';
	$services = $this->get_sql ( $sql );
	foreach ( $services as $service ){
		$o.='
			<tr>
				<td><small>' . $service['id'] . '</small></td>
				<td><a href="#!showservice?service_id=' . $service['id'] . '">' . $service['name'] . '</a></td>
				<td>algo mas </td>
			</tr>
		';

	}
	$response['tbody'] = $o;
	echo json_encode($response);
	wp_die();
}
public function csi_cmp_fetch_service_step_list_info(){
	//Global Variables
	global $wpdb;
	$o='';
	//Local Variables

	$response['tbody'] = $o;
	echo json_encode($response);
	wp_die();
}
//END OF CLASS
}

global $NOVIS_CSI_SERVICE;
$NOVIS_CSI_SERVICE =new NOVIS_CSI_SERVICE_CLASS();
?>
