<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_CMP_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'cmp';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Plan';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Planes';
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
	$this->db_version	= '0.1.1';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="
		(
			id mediumint unsigned not null auto_increment COMMENT 'Unique ID for each entry',
			customer_id int unsigned not null COMMENT 'Customer ID',
			title varchar(60) not null COMMENT 'Title text',
			description varchar(255) null COMMENT 'Description text',
			manager_user_id bigint(20) unsigned not null COMMENT 'Id of user responsible of this plan',
			manager_user_email varchar(100) not null COMMENT 'Email of user. Used to track user if user id is deleted',
			source_tags varchar(255) null COMMENT 'Tags to add sources of the plan',
			shared_plan_flag tinyint(1) null COMMENT 'Indicates if plan can be shared with other users',
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
		'id' => array(
			'type'						=>'id',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxlength'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'customer_id' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxlength'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'title' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxlength'	=>false,
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
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxlength'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'source_tags' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxlength'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'manager_user_id' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxlength'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'manager_user_email' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>true,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxlength'	=>100,
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
			'data_validation_maxlength'	=>false,
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
			'data_validation_maxlength'	=>false,
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
			'data_validation_maxlength'	=>false,
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
			'data_validation_maxlength'	=>false,
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
			'data_validation_maxlength'	=>false,
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
			'data_validation_maxlength'	=>false,
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
			'data_validation_maxlength'	=>false,
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
			'data_validation_maxlength'	=>false,
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

	add_action( 'wp_ajax_csi_cmp_build_page_intro',				array( $this , 'csi_cmp_build_page_intro'			));
	add_action( 'wp_ajax_csi_cmp_build_page_list_plans',		array( $this , 'csi_cmp_build_page_list_plans'		));
	add_action( 'wp_ajax_csi_cmp_build_page_new_plan_form',		array( $this , 'csi_cmp_build_page_new_plan_form'	));
	add_action( 'wp_ajax_csi_cmp_create_plan',					array( $this , 'csi_cmp_create_plan'				));
	add_action( 'wp_ajax_csi_cmp_fetch_filtered_plan_table',	array( $this , 'csi_cmp_fetch_filtered_plan_table'	));
	add_action( 'wp_ajax_csi_cmp_build_page_show_plan',			array( $this , 'csi_cmp_build_page_show_plan'		));
	add_action( 'wp_ajax_csi_cmp_fetch_plan_info',				array( $this , 'csi_cmp_fetch_plan_info'			));
	add_action( 'wp_ajax_csi_cmp_fetch_plan_docs',				array( $this , 'csi_cmp_fetch_plan_docs'			));
	add_action( 'wp_ajax_csi_cmp_popup_cmp_info',				array( $this , 'csi_cmp_popup_cmp_info'				));
	add_action( 'wp_ajax_csi_cmp_build_cmp_gantt',				array( $this , 'csi_cmp_build_cmp_gantt'			));

}
public function csi_cmp_fetch_filtered_plan_table(){
	//Global Variables
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_CUSTOMER;
	global $wpdb;
	//Local Variables
	$response			= array();
	$tbody				= '';
	$sql = 'SELECT
				*,
				T00.id as plan_id,
				T00.manager_user_id as manager_id,
				T01.short_name as customer_name,
				T01.code as customer_code,
				T02.user_login as user_name,
				T03.code as country_code,
				T03.short_name as country_short_name

			FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T01
				ON T01.id = T00.customer_id
			LEFT JOIN ' . $wpdb->base_prefix . 'users as T02
				ON T00.manager_user_id = T02.id
			LEFT JOIN ' . $NOVIS_CSI_COUNTRY->tbl_name . ' as T03
				ON T01.country_id = T03.id

	';
	$plans = $this->get_sql($sql);
	foreach ( $plans as $plan ){
		$tbody .= '
			<tr>
				<td class="hidden-xs">' . $plan['plan_id'] . '</td>
				<td>
					<span class="hidden-xs">' . $plan['country_short_name'] . '</span>
					<span class="visible-xs">' . strtoupper ( $plan['country_code'] ) . '</span>
				</td>
				<td><span class="hidden-xs">' . $plan['customer_name'] . '</span> <small>(' . strtoupper ( $plan['customer_code'] ) .')</small></td>
				<td><a href="#!showplan?plan_id=' . $plan['plan_id'] . '&otra=wea"><small>' . $plan['title'] . '<small></a></td>
				<td><a href="#" class="user-data" data-user-id="' . $plan['manager_id'] . '" title="M&aacute;s informaci&oacute;n"><small><i class="fa fa-id-card-o"></i> ' . $plan['user_name'] . '</a></td>
				<td>' . self::csi_cmp_calculate_cmp_percentage($plan['plan_id'])['progress_bar'] . '</td>
			</tr>
		';
	}
	$response['tbody'] = $tbody;
	echo json_encode($response);
	wp_die();
}
public function csi_cmp_build_page_show_plan(){
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_PROJECT_STATUS;
	global $wpdb;
	//Local Variables
	$response				= array();
	$post					= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	# Validate user capability ??
	$plan_id 				= intval($post['plan_id']);
	$current_user			= get_userdata ( get_current_user_id() );
	$current_datetime		= new DateTime();
	if ( 0 < $plan_id ){
		$sql = 'SELECT
					*,
					T00.id as plan_id,
					T00.title as plan_title,
					T00.description as plan_description,
					T00.last_modified_user_id as plan_last_modified_user_id,
					T00.last_modified_date as plan_last_modified_date,
					T00.last_modified_time as plan_last_modified_time,
					T00.creation_user_id as plan_creation_user_id,
					T00.creation_date as plan_creation_date,
					T00.creation_time as plan_creation_time,
					T00.manager_user_id as manager_id,
					T01.short_name as customer_name,
					T01.code as customer_code

				FROM
				' . $this->tbl_name . ' as T00
				LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T01
					ON T01.id = T00.customer_id
				WHERE
					T00.id = "' . $plan_id . '"

		';
		$plan = $wpdb->get_row($sql);
		if ( NULL == $plan->plan_last_modified_user_id){
			$last_modified_user	= NULL;
			$creation_user = get_userdata ( $plan->plan_creation_user_id );
		}else{
			$last_modified_user = get_userdata ( $plan->plan_last_modified_user_id );
			$creation_user = NULL;
		}
	}else{

	}

	if ( NULL == $last_modified_user ){
		$modif_text = $creation_user->display_name . ' cre&oacute; el plan';
		$modif_datetime = new DateTime($plan->plan_creation_date . ' ' . $plan->plan_creation_time );
	}else{
		$modif_text = $last_modified_user->user_nicename . ' modific&oacute; las propiedades del plan';
		$modif_datetime = new DateTime($plan->plan_last_modified_date . ' ' . $plan->plan_last_modified_time );
	}
	$current_datetime = new DateTime();
	//last_action_time
	$lat = date_diff($modif_datetime, $current_datetime);
	if ( 0 != $lat->y ){
		if ( 0 != $lat->m ){
			$last_action_time_text = 'm&aacute;s de ' . $lat->y . ' a&ntilde;os';
		}else{
			$last_action_time_text = $lat->y . ' a&ntilde;os';
		}
	}else{
		if ( 0 != $lat->m ){
			$last_action_time_text = $lat->m . ' meses';
		}else{
			if ( 0 != $lat->d ){
				$last_action_time_text = $lat->d . ' d&iacute;as';
			}else{
				$last_action_time_text = ' ' . $lat->h . ' horas';
			}
		}
	}


	$o='
	<div id="csi-template-cmp-control-center-show-plan" class="container">
		<div class="page-header row">
			<h2 class="clearfix">
				<span class="col-sm-10">' . $plan->plan_title . ' <small>' . $plan->customer_code . '</small></span>
				<p class="col-sm-2 text-right">
					<button class="btn btn-default">
						<i class="fa fa-pencil"></i> Editar
					</button>
				</p>
			</h2>
			<div style="margin-top:-5px;height:5px;overflow:hidden;" class="">
				<div style="margin-top: -5px;">
					' . self::csi_cmp_calculate_cmp_percentage($plan_id)['progress_bar'] . '
				</div>
			</div>
			<p class="text-muted hidden-print"><i class="fa fa-clock-o"></i> ' . $modif_text . ' hace ' . $last_action_time_text . '.</p>
			<div>
				<p class="lead"

				data-field="description"
				data-action="csi_cmp_update_field"
				data-element-key="' . $plan_id . '"
			>' . $plan->plan_description . '</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-fw fa-info"></i> Información del Plan
						<div class="pull-right">
							<a href="#csi-cmp-fetch-plan-info" class="refresh-button"><i class="fa fa-fw fa-refresh"></i></a>
							|
							<a data-toggle="collapse" href="#plan-info" role="button"><i class="fa fa-fw fa-caret-down"></i></a>
						</div>
					</div>
					<div id="plan-info" class="collapse">
						<table class="table table-condensed refreshable auto-refreshable" data-auto-refresh-timelapse="60000" style="position:relative;" id="csi-cmp-fetch-plan-info" data-action="csi_cmp_fetch_plan_info" data-plan-id="' . $plan_id . '">
							<tbody style="position:relative;">
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-fw fa-folder-o"></i> Documentos asociados
						<div class="pull-right">
							<a href="#csi-cmp-fetch-plan-docs" class="refresh-button"><i class="fa fa-fw fa-refresh"></i></a>
							|
							<a data-toggle="collapse" href="#csi-cmp-fetch-plan-docs" role="button">
								<i class="fa fa-fw fa-caret-down"></i>
							</a>
						</div>
					</div>
					<div class="list-group collapse refreshable" style="position:relative;" id="csi-cmp-fetch-plan-docs" data-action="csi_cmp_fetch_plan_docs" data-plan-id="' . $plan_id . '">
						<div class="list-group-item">No hay naa</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-fw fa-book"></i> Notas internas
					<div class="pull-right">
						<a href="#"><i class="fa fa-fw fa-plus"></i></a>
						|
						<a href="#"><i class="fa fa-fw fa-refresh"></i></a>
						|
						<a data-toggle="collapse" href="#plan-3-log" role="button">
							<i class="fa fa-fw fa-caret-down"></i>
						</a>
					</div>
				</div>
				<div id="plan-3-log" class="collapse">
					<table class="table table-condensed table-striped" style="margin:0;">
						<tbody>
							<tr>
								<th class="small">23/09/2016 13:56hrs</th>
								<td class="small">Cristian Marin</td>
								<td class="small">El cliente ha solicitado suspender la actividad <a href="#">#46764</a></td>
							</tr>
							<tr>
								<th class="small">28/09/2016 13:56hrs</th>
								<td class="small">Cristian Marin</td>
								<td class="small">El cliente ha solicitado suspender la actividad <a href="#">#46764</a> por Falta de autorización del equipo funcional y del área de Negocios.</td>
							</tr>
							<tr>
								<th class="small">30/09/2016 13:56hrs</th>
								<td class="small">Cristian Marin</td>
								<td class="small">El cliente ha solicitado suspender la actividad <a href="#">#46764</a></td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="999" class="text-center small">
									<nav aria-label="Page navigation">
										<ul class="pagination" style="margin:0;">
											<li>
												<a href="#" aria-label="Previous">
													<span aria-hidden="true">&laquo;</span>
												</a>
											</li>
											<li><a href="#">1</a></li>
											<li><a href="#">2</a></li>
											<li><a href="#">3</a></li>
											<li><a href="#">4</a></li>
											<li><a href="#">5</a></li>
											<li>
												<a href="#" aria-label="Next">
													<span aria-hidden="true">&raquo;</span>
												</a>
											</li>
										</ul>
									</nav>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-fw fa-tasks"></i> Gantt
					<div class="pull-right">
						<a href="#csi-cmp-fetch-cmp-gantt" class="refresh-button"><i class="fa fa-fw fa-refresh"></i></a>
						|
						<a data-toggle="collapse" href="#csi-cmp-fetch-cmp-gantt" role="button">
							<i class="fa fa-fw fa-caret-down"></i>
						</a>
					</div>
				</div>
				<div id="csi-cmp-fetch-cmp-gantt" class="collapse refreshable" style="position:relative; min-height: 250px;" data-action="csi_cmp_build_cmp_gantt" data-plan-id="' . $plan_id . '">
				</div>
			</div>
		</div><!-- CMP Gantt -->
		<div class="panel panel-default row">
			<div class="panel-heading">
			<i class="fa fa-fw fa-list"></i> Tareas
			<div class="pull-right">
				<!--
				<a title="Descargar como hoja de c&aacute;lculo" href="#csi-cmp-fetch-tasks-table" data-action="csi_cmp_fetch_editable_tasks_table"><i class="fa fa-fw fa-file-excel-o"></i></a>
				|
				<a href="#csi-cmp-fetch-tasks-table" class="edit-table-button" data-action="csi_cmp_fetch_editable_tasks_table" data-old-action="csi_cmp_fetch_tasks_table"><i class="fa fa-fw fa-pencil"></i></a>
				|
				-->
				<a href="#csi-cmp-fetch-tasks-table" class="refresh-button"><i class="fa fa-fw fa-refresh"></i></a>
			</div>
			</div>
			<table class="table refreshable" data-action="csi_cmp_fetch_tasks_table" data-plan-id="' . $plan_id . '" style="position:relative;" id="csi-cmp-fetch-tasks-table">
				<thead>
					<tr>
						<th class="text-center hidden-xs"><i class="fa fa-hashtag"></i></th>
						<th class="text-center"><i class="fa fa-exclamation"></i></th>
						<th class="text-center">SID</th>
						<th class="hidden-xs">Ticket</th>
						<th class="text-center hidden">Cambio</th>
						<th>Status</th>
						<th>Inicio</th>
						<th class="text-center hidden-xs">Offline</th>
						<th>Ventana</th>
						<th class="text-center"><i class="fa fa-window-maximize"></i></th>
					</tr>
				</thead>
				<tbody>
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
public function csi_cmp_fetch_plan_docs(){
	//Global Variables
	global $NOVIS_CSI_CMP_TASK_DOC;
	global $wpdb;
	//Local Variables
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$response			= array();
	$plan_id 			= intval ( $post['planId'] );
	$o					= '';
	$sql='SELECT
			*
		FROM
			' . $NOVIS_CSI_CMP_TASK_DOC->tbl_name . '

		WHERE
			cmp_id = "' . $plan_id . '"
	';
	$docs = $this->get_sql ( $sql ) ;
	if ( 0 == count ($docs) ){
		$o='
			<div class="list-group-item">
				No hay documentos asociados <i class="fa fa-thumbs-o-down fa-lg"></i>
			</div>
		';
	}else{
		foreach ( $docs as $doc ){
			$o='
				<a class="list-group-item" target="_blank" href="' . $doc['doc_url'] . '">
					' . $doc['doc_description'] . '
					<div class="pull-right">
						<span class="fa fa-fw text-info fa-cloud-download"></span>
					</div>
				</a>
			';
		}
	}
	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
public function csi_cmp_fetch_problem_tasks_by_plan_id ( $plan_id = 0){
	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
public function csi_cmp_build_cmp_gantt(){
	//Global Variables
	global $NOVIS_CSI_CMP_TASK;
	global $NOVIS_CSI_CMP_TASK_STATUS;
	global $NOVIS_CSI_CUSTOMER_SYSTEM;
	//Local Variables
	$response			= array();
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$dataProvider		= array();
	$plan_id 			= intval ( $post['planId'] );

	$sql='SELECT
			T02.sid as sid,
			T00.start_datetime as start_datetime,
			T00.end_datetime as end_datetime,
			T01.hex_color as status_color
		FROM
			' . $NOVIS_CSI_CMP_TASK->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_CMP_TASK_STATUS->tbl_name . ' as T01
				ON T01.id = T00.status_id
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER_SYSTEM->tbl_name . ' as T02
				ON T02.id = T00.customer_system_id
		WHERE
			T00.cmp_id = "' . $plan_id . '"
		ORDER BY
			T00.start_datetime ASC
	';
	$tasks = $this->get_sql ( $sql );
	foreach ( $tasks as $task ) {
		$index = array_search( $task['sid'], array_column( $dataProvider, 'category' ) );
		if (FALSE === $index ){
			array_push ( $dataProvider, array(
				'category'					=> $task['sid'],
				'segments'					=> array(
					array(
						'start'				=> $task['start_datetime'],
						'end'				=> $task['end_datetime'],
						'color'				=> '#' . $task['status_color'],
					),
				),
			) );
		}else{
			array_push ( $dataProvider[$index]['segments'], array(
					'start'					=> $task['start_datetime'],
					'end'					=> $task['end_datetime'],
					'color'					=> '#' . $task['status_color'],
			) );
		}
	}
	$response['dataProvider']			= $dataProvider;
	$response['graphs']					= null;
	$response['chart']	= array(
		'type'							=> 'gantt',
		'period'						=> 'ss',
		'dataDateFormat'				=> 'YYYY-MM-DD JJ:NN:SS',
		'columnWidth'					=> 0.5,
		'valueAxis'						=> array(
			'type'						=> 'date'
		),
		'brightnessStep'				=> 7,
		'graph'							=> array(
			'lineAlpha'					=> 1,
			'lineColor'					=> '#FFFFFF',
			'fillAlphas'				=> 0.85,
			'balloonText'				=> '[[category]]<br />[[start]] - [[end]]',
		),
		'rotate'						=> true,
		'categoryField'					=> 'category',
		'segmentsField'					=> 'segments',
		'colorField'					=> 'color',
		'startDateField'				=> 'start',
		'endDateField'					=> 'end',
		'dataProvider'					=> $dataProvider,
/*		'valueScrollbar'				=> array(
			'autoGridCount'				=> true,
		),
*/
/*
		'chartCursor'					=> array(
			'cursorColor'				=> '#55bb76',
			'valueBalloonsEnabled'		=> false,
			'cursorAlpha'				=> 0,
			'valueLineAlpha'			=> 0.5,
			'valueLineBalloonEnabled'	=> true,
			'valueLineEnabled'			=> true,
			'zoomable'					=> false,
			'valueZoomable'				=> true,
		),
*/	);
	echo json_encode($response);
	wp_die();
}
public function csi_cmp_fetch_plan_info(){
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_CMP_TASK;
	global $wpdb;
	//Local Variables
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$response			= array();
	$plan_id 			= intval ( $post['planId'] );
	//------------------------------------------------------
	$sql='SELECT
			*,
			T00.manager_user_id as plan_manager_user_id,
			T01.short_name as customer_name,
			T01.code as customer_code,
			T00.source_tags as plan_source_tags,
			T00.title as plan_title,
			T00.description as plan_description,
			T00.shared_plan_flag as plan_shared_flag

		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T01
				ON T00.customer_id = T01.id
		WHERE
			T00.id = "' . $plan_id . '"
	';
	$plan = $wpdb->get_row($sql);
	$manager_user = get_userdata ( $plan->plan_manager_user_id );
	//------------------------------------------------------
	$sql = '
		SELECT
		(SELECT start_datetime FROM ' . $NOVIS_CSI_CMP_TASK->tbl_name . ' WHERE cmp_id = "' . $plan_id . '" ORDER BY start_datetime ASC LIMIT 1) as start,
		(SELECT end_datetime FROM ' . $NOVIS_CSI_CMP_TASK->tbl_name . ' WHERE cmp_id = "' . $plan_id . '" ORDER BY end_datetime DESC LIMIT 1) as end
	';
	$dates = $wpdb->get_row ( $sql );
	setlocale(LC_ALL, 'es_MX');
	$first_date = new DateTime ( $dates->start );
	$last_date = new DateTime ( $dates->end );
	$time_date = date_diff($first_date, $last_date);
	//--------------------------------------------------------------------------
	$sql = 'SELECT
				SUM(TIMESTAMPDIFF(HOUR, start_datetime, end_datetime) ) as hh
					FROM  ' . $NOVIS_CSI_CMP_TASK->tbl_name . '
					WHERE cmp_id = "' . $plan_id . '"
				GROUP BY
					offline_task_flag
	';
	$hh = $wpdb->get_col($sql);
	//--------------------------------------------------------------------------
	$progress = self::csi_cmp_calculate_cmp_percentage($plan_id);
	//--------------------------------------------------------------------------
	if ( $plan->plan_shared_flag ){
		$shared = '<span class="text-danger"><i class="fa fa-unlock"></i> Compartido</span>';
	}else{
		$shared = '<span class="text-success"><i class="fa fa-lock"></i> No compartido</span>';
	}
	//--------------------------------------------------------------------------
	$o='
	<tr>
		<th class="small">Cliente</th>
		<td>' . $plan->customer_name . '</td>
	</tr>
	<tr>
		<th class="small">
			T&iacute;tulo
			<p class="text-center">
				<small>
					<a href="#" class="text-muted in-table-form-button hidden-print" data-action="csi_cmp_popup_edit_cmp_form" data-cmp-id="' . $plan_id . '" data-cmp-field="title">
						<i class="fa fa-lg fa-pencil-square-o"></i> Editar
					</a>
				</small>
			</p>
		</th>
		<td>
			' . $plan->plan_title . '
		</td>
	</tr>
	<tr>
		<th class="small">
			Descripci&oacute;n
			<p class="text-center"><small><a href="#" class="text-muted"><i class="fa fa-lg fa-pencil-square-o"></i> Editar</a></small></p>
		</th>
		<td>
			<p class="text-justify"<i>' . $plan->plan_description . '</i></p>
		</td>
	</tr>
	<tr>
		<th class="small">
			Responsable
			<p class="text-center"><small><a href="#" class="text-muted"><i class="fa fa-lg fa-pencil-square-o"></i> Editar</a></small></p>
			</th>
		<td><a href="#" class="user-data" data-user-id="' . $plan->plan_manager_user_id . '" title="M&aacute;s informaci&oacute;n"><i class="fa fa-id-card-o"></i> ' .  $manager_user->user_nicename . '</a></td>
	</tr>
	<tr>
		<th class="small">
			Compartido
		</th>
		<td>' . $shared . ' <a href="#"><i class="fa fa-question-circle text-info"></i></a></td>
	</tr>
	<tr>
		<th class="small">Cronolog&iacute;a</th>
		<td>
			<ul class="list-unstyled fa-ul">
				<li><i class="fa fa-fw fa-li fa-flag-o"></i> ' . strftime('%d/%b/%g',$first_date->getTimestamp()) . '</li>
				<li><i class="fa fa-fw fa-li fa-flag-checkered"></i> ' . strftime('%d/%b/%g',$last_date->getTimestamp()) . '</li>
				<li><i class="fa fa-fw fa-li fa-calendar"></i> ' . $time_date->days . ' dias</li>
			</ul>
		</td>
	</tr>
	<tr>
		<th class="small">
			<i class="fa fa-tags text-muted"></i> Origen
			<p class="text-center"><small><a href="#" class="text-muted"><i class="fa fa-lg fa-pencil-square-o"></i> Editar</a></small></p>
		</th>
		<td class="">
			<small><kbd>' . str_replace ( ',', '</kbd>&nbsp;<kbd>', $plan->source_tags ) . '</kbd></small>

		</td>
	</tr>
	<tr>
		<th class="small">Ventanas</th>
		<td class="">
				<strong>' . ( isset ( $hh[0] ) ? $hh[0] : 0 ) . '</strong> Horas - Online<br/>
				<strong>' . ( isset ( $hh[1] ) ? $hh[1] : 0 ) . '</strong> Horas - Offline<br/>
				<strong>' . intval ( ( isset ( $hh[0] ) ? $hh[0] : 0 ) + ( isset ( $hh[1] ) ? $hh[1] : 0 ) ) . '</strong> Horas - Total<br/>
				<small class="muted-text">
				Solo se contabilizan las ventanas de <i>ejecución</i>
				<a href="#" class="csi-popup" data-action="csi_cmp_popup_task_type_info">
					<i class="fa fa-question-circle"></i>
				</a>
				</small>
		</td>
	</tr>
	<tr>
		<th class="small">Avance</th>
		<td>
			' . $progress['progress_bar'] . '
			<dl class="">
				<dt>Avance Planificado</dt>
				<dd>' . intval ( $progress['success'] + $progress['warning'] + $progress['error']  ) . '%</dd>
				<dt>Avance Real</dt>
				<dd>' . intval ( $progress['success'] ) . '%</dd>
			</dl>
		</td>
	</tr>

	';
	$response['tbody'] = $o;
	echo json_encode($response);
	wp_die();

}
public function csi_cmp_build_page_intro(){
	//Global Variables
	//Local Variables
	$response			= array();
	$o = '
		<div class="jumbotron">
			<div class="container">
				<h2>Plan de Correcci&oacute;n o Mantenimiento</h2>
				<p>M&oacute;dulo de registro y control de actividades técnicas para la gesti&oacute;n del Equipo de Operaciones de NOVIS.</p>
				<p><a class="btn btn-primary btn-lg" href="#!listplans" role="button">Aprender m&aacute;s</a></p>
			</div>
		</div>
		<nav class="container">
			<div class="row">
				<div class="list-group col-sm-6 col-md-4">
					<a href="#!listplans" class="list-group-item active">
						<h3><i class="fa fa-tasks"></i> PCM</h3>
						<p class="text-justify">Detalle de los Planes de Correcci&oacute;n o Mantenimiento registrados.</p>
					</a>
				</div>
				<div class="list-group col-sm-6 col-md-4">
					<a href="#" class="list-group-item list-group-item-success">
						<h3><i class="fa fa-dashboard"></i> Dashboards</h3>
						<p class="text-justify">Vsitas pre-fabricadas para la gestión de los Planes de Corrección o Mantenimiento.</p>
					</a>
				</div>
				<div class="list-group col-sm-6 col-md-4">
					<a href="#" class="list-group-item list-group-item-danger">
						<h3><i class="fa fa-calendar"></i> Calendario</h3>
						<p class="text-justify">Vista rápida de las próximas actividades por ejecutar acorde a los PCM de clientes.</p>
					</a>
				</div>
				<div class="list-group col-sm-6 col-md-4">
					<a href="#" class="list-group-item list-group-item-info">
						<h3><i class="fa fa-area-chart"></i> Capacity</h3>
						<p class="text-justify">Reportes de la capacidad del personal relacionado a las tareas.</p>
					</a>
				</div>
				<div class="list-group col-sm-6 col-md-4">
					<a href="#" class="list-group-item">
						<h3><i class="fa fa-user-o"></i> Mis Planes</h3>
						<p class="text-justify">Accede a los planes que has creado y los planes en los que has participado.</p>
					</a>
				</div>
				<div class="list-group col-sm-6 col-md-4">
					<a href="#" class="list-group-item list-group-item-warning">
						<h3><i class="fa fa-television"></i> Presentación</h3>
						<p class="text-justify">Reportes orientados a dar soporte a seguimiento periódico con clientes.</p>
					</a>
				</div>
			</div>
		</nav>
	';
	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}


public function csi_cmp_build_page_list_plans(){
	//Global Variables
	//Local Variables
	$response			= array();
	$o = '
	<div id="csi-template-cmp-control-center-list-plans" class="container">
		<div class="page-header row">
			<h3 class="col-sm-10">Planes de Corrección o Mantenimiento</h3>
			<h3 class="col-sm-2">
				<a href="#!addplan" class="btn btn-success" id="csi-template-cmp-add-new-plan">
					<i class="fa fa-plus"></i> Nuevo PCM
				</a>
			</h3>
		</div>
		<div>
			<h4><i class="fa fa-pie-chart"></i> Infogr&aacute;ficos</h4>
		</div>
		<div class="row panel panel-default">
			<div class="panel-body">
				<a href="#list-plans-saved-filter" data-toggle="collapse" >
					<strong class="panel-title">
						<i class="fa fa-filter"></i>
						Filtros
					</strong>
				</a>
				<div class="pull-right">
					<a href="#list-plans-new-filter" data-toggle="collapse" >
						<i class="fa fa-fw fa-plus"></i>
					</a>
				</div>
			</div>
			<div class="panel-body collapse" id="list-plans-saved-filter">
				<div class="panel panel-default">
					<div class="panel-heading">
						<a href="#list-plans-company-filter" data-toggle="collapse" >
							<strong class="">
								<i class="fa fa-building-o"></i>
								Filtros Est&aacute;ndar
							</strong>
						</a>
						<div class="pull-right">
							<a href="#">
								<i class="fa fa-fw fa-refresh"></i>
							</a>
							|
							<a href="#list-plans-company-filter" data-toggle="collapse" >
								<i class="fa fa-fw fa-caret-down"></i>
							</a>
						</div>
					</div>
					<ul class="list-group collapse" id="list-plans-company-filter">
						<li class="list-group-item">
							<a href="#">
								<i class="fa fa-filter"></i>
								Planes en curso
							</a>
							<div class="pull-right">
								<a href="#">
									<i class="fa fa-fw fa-minus-circle text-danger"></i>
								</a>
							</div>
						</li>
					</ul>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a href="#list-plans-own-filter" data-toggle="collapse" >
							<strong class="">
								<i class="fa fa-user-o"></i>
								Filtros <i>Cristian Marin</i>
							</strong>
						</a>
						<div class="pull-right">
							<a href="#">
								<i class="fa fa-fw fa-refresh"></i>
							</a>
							|
							<a href="#list-plans-own-filter" data-toggle="collapse" >
								<i class="fa fa-fw fa-caret-down"></i>
							</a>
						</div>
					</div>
					<ul class="list-group collapse" id="list-plans-own-filter">
						<li class="list-group-item">
							<a href="#">
								<i class="fa fa-filter"></i>
								Gentera - Esta semana
							</a>
							<div class="pull-right">
								<a href="#">
									<i class="fa fa-fw fa-minus-circle text-danger"></i>
								</a>
							</div>
						</li>
						<li class="list-group-item text-center">
							<a class="btn btn-sm btn-success" href="#list-plans-new-filter" data-toggle="collapse">
								<i class="fa fa-fw fa-plus"></i>
								Crear Filtro
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="panel-body collapse" id="list-plans-new-filter">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong class="">
							<i class="fa fa-filter"></i>
							Nuevo Filtro
						</strong>
						<div class="pull-right">
							<a href="#list-plans-new-filter" data-toggle="collapse" >
								<i class="fa fa-fw fa-times"></i>
							</a>
						</div>
					</div>
					<form class=" list-group">
						<div class="form-group list-group-item">
							<label class="sr-only">Id de Pa&iacute;s</label>
							<div class="input-group">
								<select class="form-control input-sm">
									<option>Id de Pa&iacute;s</option>
								</select>
								<div class="input-group-addon"><i class="fa fa-angle-right"></i></div>
								<select class="form-control input-sm">
									<option>es</option>
									<option>no es</option>
								</select>
								<div class="input-group-addon"><i class="fa fa-angle-right"></i></div>
								<select class="form-control input-sm">
									<option>Gentera</option>
								</select>
							</div>
						</div>
						<div class="list-group-item text-center">
							<button class="btn btn-default btn-sm">
								<i class="fa fa-plus"></i>
								Agregar campo
							</button>
						</div>
						<div class="list-group-item panel-footer text-right">
							<button class="btn btn-default btn-xs">
								<i class="fa fa-fw fa-save"></i>
								Guardar
							</button>
								<button class="btn btn-primary btn-xs">
									<i class="fa fa-fw fa-filter"></i>
									Filtrar
								</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="panel panel-default row">
			<div class="panel-heading">
				<strong class="">
					<i class="fa fa-tasks"></i>
					Planes de Correcci&oacute;n o Mantenimiento
				</strong>
				<div class="pull-right">
					<a class="refresh-button" data-refresh-table="" href="#csi-template-cmp-filtered-plan-table">
						<i class="fa fa-fw fa-refresh"></i>
					</a>
				</div>
			</div>
			<div class="collapse in">
			</div>
			<table id="csi-template-cmp-filtered-plan-table" class="table refreshable" data-action="csi_cmp_fetch_filtered_plan_table" style="position:relative;">
				<thead>
					<tr>
						<th class="hidden-xs"><small><i class="fa fa-hashtag"></i></small></th>
						<th><i class="fa fa-globe"></i> <span class="hidden-xs">Pais</span></th>
						<th><i class="fa fa-building-o"></i> <span class="hidden-xs">Cliente</span></th>
						<th>T&iacute;tulo</th>
						<th><span class="hidden-xs">Responsable</span><span class="visible-xs">R</span></th>
						<th>Tareas</th>
					</tr>
				</thead>
				<tbody style="position:relative;">
				</tbody>
				<tfoot>
					<tr>
						<th class="hidden-xs"><small><i class="fa fa-hashtag"></i></small></th>
						<th><i class="fa fa-globe"></i> <span class="hidden-xs">Pais</span></th>
						<th><i class="fa fa-building-o"></i> <span class="hidden-xs">Cliente</span></th>
						<th>T&iacute;tulo</th>
						<th><span class="hidden-xs">Responsable</span><span class="visible-xs">R</span></th>
						<th>Tareas</th>
					</tr>
				</tfoot>
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
public function csi_cmp_create_plan(){
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_PROJECT_STATUS;
	global $NOVIS_CSI_CMP_TASK_DOC;
	global $wpdb;
	//Local Variables
	$insertArray			= array();
	$response				= array();
	$post					= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	# Validate user capability ??
	$current_user			= get_userdata ( get_current_user_id() );
	$manager_user			= get_userdata ( $post['manager_user_id'] );
	$current_datetime		= new DateTime();

	$insertArray['customer_id']				= strip_tags(stripslashes( $post['customer_id'] ));
	$insertArray['title']					= strip_tags(stripslashes( $post['title'] ));
	$insertArray['description']				= strip_tags(stripslashes( $post['description'] ));
	$insertArray['manager_user_id']			= strip_tags(stripslashes( $post['manager_user_id'] ));
	$insertArray['manager_user_email']		= $manager_user->user_email;
	$insertArray['source_tags']				= strip_tags(stripslashes( $post['source_tags'] ));
	$insertArray['shared_plan_flag']		= ('1' == $post['shared_plan_flag'] ) ? 1 : NULL ;
	$insertArray['creation_user_id']		= $current_user->ID;
	$insertArray['creation_user_email']		= $current_user->user_email;
	$insertArray['creation_date']			= $current_datetime->format('Y-m-d');
	$insertArray['creation_time']			= $current_datetime->format('H:i:s');

	if ( $wpdb->insert( $this->tbl_name, $insertArray ) ){
		$response['id']=$wpdb->insert_id;
//		$response['notifMessage']="El nuevo ".$this->name_single." ha sido guardado.";
		$plan_id = $wpdb->insert_id;
		if ( 0 < count ( $post['plan_doc_desc'] ) ){
			if ( false == $NOVIS_CSI_CMP_TASK_DOC->csi_cmp_task_doc_insert ( $plan_id, $post['plan_doc_desc'], $post['plan_doc_url'] ) ){
				$docs_msg='
					<p class="text-warning">
						<i class="fa fa-exclamation-triangle"></i> Sin embargo ha ocurrido un error al agregar los documentos indicados.
						Visualiza el Plan para agregar documentos.
					</p>
				';
			}else{
				$docs_msg='';
			}
		}else{
			$docs_msg='';
		}
		//crear registro de documentos
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
			'content'			=> 'Has agregado un nuevo ' . $this->name_single . ' exitosamente. (ID: <code>#' . $plan_id . '</code>)' . $docs_msg,
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
public function csi_cmp_build_page_new_plan_form(){
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_USER_TEAM;
	global $NOVIS_CSI_USER;
	global $wpdb;
	//Local Variables
	$manager_user_opts		= '';
	$customer_opts			= '';
	$response				= array();
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
		$manager_user_opts .= '<optgroup label="' . $user_team['short_name'] . '">';
		foreach ( $users as $user ){
			$selected = ( $user['user_id'] == get_current_user_id() ) ? ' selected ' : '';
			$manager_user_opts .= '<option value="' . $user['user_id'] . '" ' . $selected . '>' . $user['display_name'] . '</option>';
		}
		$manager_user_opts .= '</optgroup>';
	}
/*
	$sql = 'SELECT ID, display_name FROM ' . $wpdb->base_prefix . 'users ORDER BY display_name ASC';
	$users = $this->get_sql ( $sql );
	foreach ( $users as $user ){
		$selected = ( $user['ID'] == get_current_user_id() ) ? ' selected ' : '';
		$manager_user_opts .= '<option value="' . $user['ID'] . '" ' . $selected . '>' . $user['display_name'] . '</option>';
	}
*/
	//--------------------------------------------------------------------------
	$o	='
	<div class="container">
		<div class="panel panel-default row">
			<div class="panel-heading">
				<h1 class="panel-title">Crea un nuevo Plan de Corrección o Mantenimiento</h1>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" data-function="csi_cmp_create_plan" data-next-page="listplans" style="position:relative;">
					<div class="form-group">
						<label for="customer_id" class="col-sm-2 control-label">Cliente</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-fw fa-users"></i></span>
								<select class="form-control select2" id="customer_id" name="customer_id" required="true" data-placeholder="Selecciona el cliente">
									<option></option>
									' . $customer_opts . '
								</select>
							</div>
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Todo <i>Plan de Correcci&oacute;n o Mantenimiento</i> debe ir asociado con un cliente.<br/>
								En el caso que quieras generar un plan interno debes indicar que el cliente es <strong>Novis</strong>.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">T&iacute;tulo</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="title" name="title" placeholder="T&iacute;tulo" required="true" maxlength="60"/>
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Titulo / nombre del Plan.<br/>
								Frecuentemente se utiliza una descripción sencilla como <small><code>Actualización de Kernel Q3 ' . date( 'Y' ) . '</code></small>.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 60 caracteres.</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Plan compartido</label>
						<div class="col-sm-10">
							<input type="checkbox" class="form-control csi-cool-checkbox" id="shared_plan_flag" name="shared_plan_flag" value="1"/>
							<label for="shared_plan_flag">Plan Compartido</label>
							<span class="help-block">
								Si un plan es marcado como <i>compartido</i> cualquier usuario del sistema puede realizar modificaciones al plan, tales como <i>agregar tareas visibles para el cliente</i>. Este tipo de plan deben usarse solo en situaciones de planes complejos. Para la reasignación de un plan, es recomendable reasignar el <i>responsable del plan</i>.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">Descripci&oacute;n</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="description" name="description" placeholder="Descripci&oacute;n" maxlength="255"></textarea>
							<span class="help-block">
								Descripci&oacute;n breve del Plan de Correcci&oacute;n o Mantenimiento.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 255 caracteres.</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="manager_user_id" class="col-sm-2 control-label">Responsable</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-fw fa-user-o"></i></span>
								<select class="form-control select2" id="manager_user_id" name="manager_user_id" required="true" data-placeholder="Selecciona el responsable">
									<option></option>
									' . $manager_user_opts . '
								</select>
							</div>
							<span class="help-block">
								Responsable del Plan de Correcci&oacute;n o Mantenimiento.<br/>
								<small class="text-danger"><i class="fa fa-exclamation-triangle"></i> Solo el responsable del plan puede realizar modificaciones posteriores.</Small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="source_tags" class="col-sm-2 control-label">Etiquetas de Origen</label>
						<div class="col-sm-10">
							<select class="form-control select2" data-tags="true" multiple id="source_tags" name="source_tags"  data-placeholder="ewa incidente">
								<option value="ewa">ewa</option>
								<option value="incidente">incidente</option>
							</select>
							<span class="help-block">
								Las etiquetas de Origen, permiten indicar las causas que originaron la creación de este plan.<br/>
								<i class="fa fa-info"></i> Las etiquetas deben estar separadas por espacios.<br/>
								Opciones comunes son: <small><kbd>ewa</kbd> <kbd>incidente</kbd> <kbd>recomendaciones_sap</kbd></small>.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 100 caracteres.</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="doc-plus" class="col-sm-2 control-label">Documentos relacionados</label>
						<div class="col-sm-10">
							<div class="input-dynamic" data-dynamic-input="plan-doc">
							</div>
							<div class="text-center">
							</div>
							<span class="help-block">
								Los documentos relacionados permiten adjuntar enlaces a los documentos en los cuales se reflejan diferentes componentes del plan. Los siguientes documentos son recomendados:
								<ul>
									<li>Documento de Objetivos <i class="fa fa-question-circle text-info"></i></li>
									<li>Documento de Seguimiento <i class="fa fa-question-circle text-info"></i></li>
								</ul>
							</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<p class="text-muted text-justify">
								La creación de un Plan de Corrección o Mantenimiento aparecerá de modo inmediato en los planes del cliente seleccionado.
							</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10 text-right">
							<button type="reset" class="btn btn-danger">Cancelar</button>
							<button type="submit" class="btn btn-primary">Entiendo, Crear Plan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	';
	$dynamic_fields=array(
		'plan-doc'			=> array(
			'maxFields'		=> 5,
			'addButton'		=> '<button class="btn btn-sm btn-success" id="doc-plus"><i class="fa fa-plus"></i> Agregar documento</button>',
			'fieldBox'		=> '<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
									<input type="text" class="form-control" placeholder="Descripci&oacute;n del Documento" name="plan_doc_desc[]" required="true"/>
									<span class="input-group-addon"><i class="fa fa-link"></i></span>
									<input type="text" class="form-control" placeholder="Doc. URL" name="plan_doc_url[]"  required="true"/>
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
public function csi_cmp_popup_cmp_info(){
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	global $wpdb;
	//Local Variables
	$response			= array();
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;

	$response			= array();
	$plan_id 			= intval ( $post['planId'] );
	$sql='SELECT
			*,
			T00.title as plan_title,
			T00.description as plan_description,
			T00.manager_user_id as plan_manager_user_id,
			T01.short_name as customer_name,
			T01.code as customer_code
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T01
				ON T00.customer_id = T01.id
		WHERE
			T00.id = "' . $plan_id . '"
	';
	$plan = $wpdb->get_row($sql);
	$manager_user = get_userdata ( $plan->plan_manager_user_id);
	$o='<table class="table table-condensed">
	<tr>
		<th class="small">Cliente</th>
		<td>' . $plan->customer_name . '</td>
	</tr>
	<tr>
		<th class="small">Titulo</th>
		<td><strong>' . $plan->plan_title . '</strong> <a class="btn btn-success btn-xs pull-right" href="#!showplan?plan_id=' . $plan_id . '"><i class="fa fa-folder-open-o"></i> Ver el Plan</a></td>
	</tr>
	<tr>
		<th class="small">Descripci&oacute;n</th>
		<td><i>' . $plan->plan_description . '</i></td>
	</tr>
	<tr>
		<th class="small">Responsable</th>
		<td><a href="#" class="user-data" data-user-id="' . $plan->plan_manager_user_id . '" title="M&aacute;s informaci&oacute;n"><i class="fa fa-id-card-o"></i> ' .  $manager_user->user_nicename . '</a></td>
	</tr>
	<tr>
		<th class="small">Actividad</th>
		<td>
			<ul class="list-unstyled">
				<li><i class="fa fa-fw fa-flag-o"></i> 24 / Febrero / 2017</li>
				<li><i class="fa fa-fw fa-flag-checkered"></i> 24 / Marzo / 2017</li>
			</ul>
		</td>
	</tr>
	<tr>
		<th class="small">Esfuerzo</th>
		<td class="">
			<ul class="list-unstyled">
				<li><strong>32</strong> HH - Invertidas</li>
				<li><strong>58</strong> HH - Planificadas</li>
				<li><strong>90</strong> HH - Total</li>
			</ul>
		</td>
	</tr>
	<tr>
		<th class="small">Avance</th>
		<td>
			' . self::csi_cmp_calculate_cmp_percentage($plan_id)['progress_bar'] . '
		</td>
	</tr>
	</table>
	';
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
public function csi_cmp_calculate_cmp_percentage ( $plan_id = 0 ) {
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_CMP_TASK_STATUS;
	global $NOVIS_CSI_CMP_TASK;
	//Local Variables
	$sql = 'SELECT
				SUM(T01.cmp_total_flag) as total,
				SUM(IF(T01.cmp_finished_start_flag!=0,IF(T00.start_datetime<NOW(),1,0),0)) as start_delay,
				SUM(IF(T01.cmp_finished_end_flag!=0,IF(T00.end_datetime<NOW(),1,0),0)) as end_delay,
				SUM(T01.cmp_finished_flag) as finished,
				SUM(T01.cmp_error_flag) as error

			FROM
				' . $NOVIS_CSI_CMP_TASK->tbl_name . ' as T00
				LEFT JOIN ' . $NOVIS_CSI_CMP_TASK_STATUS->tbl_name . ' as T01
					ON T00.status_id = T01.id
			WHERE
				T00.cmp_id = ' . $plan_id . '
	';
	$data = $wpdb->get_row ( $sql );
	if ( 0 != $data->total){
		$success = intval ( $data->finished / $data->total * 100 );
		$warning = intval ( ( $data->start_delay + $data->end_delay ) / $data->total * 100 );
		$error = intval ( $data->error / $data->total * 100 );
	}else{
		$success = $warning = $error = 0;
	}
	$progress_bar = '
		<div class="progress" style="margin-bottom:0;">
			<div class="progress-bar progress-bar-striped progress-bar-success" style="width: ' . $success . '%" data-toggle="tooltip" data-placement="top" title="' . $data->finished . ' / ' . $data->total . ' Tareas"></div>
			<div class="progress-bar progress-bar-striped progress-bar-warning" style="width: ' . $warning . '%" data-toggle="tooltip" data-placement="top" title="' . ( $data->start_delay + $data->end_delay ) . ' / ' . $data->total . ' Tareas"></div>
			<div class="progress-bar progress-bar-striped progress-bar-danger" style="width: ' . $error . '%" data-toggle="tooltip" data-placement="top" title="' . $data->error . ' / ' . $data->total . ' Tareas"></div>
		</div>
	';

	return array(
		'total'			=> $data->total,
		'success'		=> $success,
		'warning'		=> $warning,
		'error'			=> $error,
		'progress_bar'	=> $progress_bar,
	);

}
//END OF CLASS
}

global $NOVIS_CSI_CMP;
$NOVIS_CSI_CMP =new NOVIS_CSI_CMP_CLASS();
?>
