<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_PROJECT_ENTRANCE_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'project_entrance';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Entrada de Proyecto';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Entradas de Proyecto';
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
								id tinyint(2) unsigned not null auto_increment COMMENT 'Unique ID for each entry',
								project_id bigint(20) unsigned not null COMMENT 'ID of project',
								author bigint(20) unsigned not null COMMENT 'Id of user responsible of the entrance',
								reg_date date not null COMMENT 'Date of reference',
								entrance tinytext not null COMMENT 'Entrance text',
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
		),
		'short_name' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>true,
			'backend_wp_table_lead'		=>true,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>50,
			'form_disabled'				=>false,
			'form_help_text'			=>'Nombre Corto.<br/>Tama&ntilde;o m&aacute;ximo: 50 caracteres.',
			'form_input_size'			=>false,
			'form_label'				=>'Nombre Corto',
			'form_options'				=>false,
			'form_placeholder'			=>'Nombre Corto',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'code' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>true,		//Show as <code></code>
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>30,
			'form_disabled'				=>false,
			'form_help_text'			=>'C&oacute;digo.<br/>Tama&ntilde;o m&aacute;ximo: 20 caracteres.',
			'form_input_size'			=>false,
			'form_label'				=>'C&oacute;digo',
			'form_options'				=>false,
			'form_placeholder'			=>'C&oacute;digo',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
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
			'data_validation_maxchar'	=>100,
			'form_disabled'				=>false,
			'form_help_text'			=>'Estilo de Prioridad (<code>danger</code>, <code>warning</code>).<br/>Tama&ntilde;o m&aacute;ximo: 30 caracteres.',
			'form_input_size'			=>false,
			'form_label'				=>'Icono',
			'form_options'				=>false,
			'form_placeholder'			=>'Estilo CSS',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'hex_color' => array(
			'type'						=>'hex',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>6,
			'form_disabled'				=>false,
			'form_help_text'			=>'Color Hexadecimal.<br/>Tama&ntilde;o m&aacute;ximo: 6 caracteres.',
			'form_input_size'			=>false,
			'form_label'				=>'Color Hexadecimal',
			'form_options'				=>false,
			'form_placeholder'			=>'Color Hexadecimal',
			'form_special_form'			=>true,
			'form_show_field'			=>true,
		),
	);
	register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install'					));
	self::db_install();
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
	add_action( 'wp_ajax_csi_fetch_project_entrance_list_info',		array( $this , 'csi_fetch_project_entrance_list_info'));
	add_action( 'wp_ajax_csi_create_project_entrance',				array( $this , 'csi_create_project_entrance'		));
	add_action( 'wp_ajax_csi_create_project_entrance_form',			array( $this , 'csi_create_project_entrance_form'	));
	add_action( 'wp_ajax_csi_edit_project_entrance',				array( $this , 'csi_edit_project_entrance'			));
	add_action( 'wp_ajax_csi_edit_project_entrance_form',			array( $this , 'csi_edit_project_entrance_form'		));


}
public function csi_fetch_project_entrance_list_info(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_USER;
	global $NOVIS_CSI_PROJECT;
	//Local Variables
	$response			= array();
	$o					= '';
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$project_id = $post['projectId'];
	//--------------------------------------------------------------------------
	$sql = 'SELECT
				T00.*
			FROM
				' . $this->tbl_name . ' as T00
			WHERE
				T00.project_id="' . $project_id . '"
			ORDER BY
				T00.reg_date DESC
	';
	$project_entrances = $this->get_sql ( $sql );
	//--------------------------------------------------------------------------
	$o.='
	<tr class="hidden-print">
		<td colspan="999" class="">
			<a href="#" class="in-table-form-button btn btn-success btn-xs" data-action="csi_create_project_entrance_form" data-project-id="' . $project_id . '">
				<i class="fa fa-plus"></i> Agregar hito
			</a>
		</td>
	</tr>
	';
	//--------------------------------------------------------------------------
	foreach ( $project_entrances as $project_entrance ){
		//----------------------------------------------------------------------
		$sql = 'SELECT
					T00.id as user_id,
					T01.display_name as display_name,
					T01.user_email as user_email
				FROM
					' . $NOVIS_CSI_USER->tbl_name . ' as T00
					LEFT JOIN ' . $wpdb->base_prefix . 'users as T01
						ON T00.id = T01.ID
				WHERE
					T00.id = "' . $project_entrance['author'] . '"
		';
		$author_data = $wpdb->get_row ( $sql);
		$author = '
			<a href="#" class="user-data" data-user-id="' . $author_data->user_id . '" title="Más información">
				<i class="fa fa-id-card-o"></i> ' . $author_data->display_name . '
			</a>';
		//----------------------------------------------------------------------
		$reg_date = new DateTime ( $project_entrance['reg_date'] );
		//----------------------------------------------------------------------
		$o.='
			<tr>
				<td class="hidden-print">
					<a href="#" class="in-table-form-button hidden-print" data-action="csi_edit_project_entrance_form" data-entrance-id="' . $project_entrance['id'] . '">
						<i class="fa fa-fw fa-edit"></i>
					</a>
				</td>
				<td class="small">' . $reg_date->format('d-m-Y') . '</td>
				<td class="small">' . $author . '</td>
				<td class="small">' . $project_entrance['entrance'] . '</td>
			</tr>
		';
	}
	$response['tbody']		= $o;

	echo json_encode($response);
	wp_die();
}

public function csi_create_project_entrance(){
	//Globa Variables
	global $wpdb;
	//Local Variables
	$insertArray			= array();
	$response			= array();
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user		= get_userdata ( get_current_user_id() );
	$current_datetime	= new DateTime();
	$reg_date			= new DateTime ( $post['reg_date'] );

	$insertArray['project_id']				= strip_tags(stripslashes( $post['project_id'] ));
	$insertArray['author']					= intval ( $post['author'] );
	$insertArray['entrance']				= strip_tags(stripslashes( $post['entrance'] ));
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
}// csi_create_project_entrance

public function csi_create_project_entrance_form(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_USER_TEAM;
	global $NOVIS_CSI_USER;
	//Local Variables
	$author_user_opts		= '';
	$date_time_input_opts	= '';
	$response				= array();
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_datetime 		= new DateTime();
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
		$author_user_opts .= '<optgroup label="' . $user_team['short_name'] . '">';
		foreach ( $users as $user ){
			$selected = ( $user['user_id'] == get_current_user_id() ) ? ' selected ' : '';
			$author_user_opts .= '<option value="' . $user['user_id'] . '" ' . $selected . '>' . $user['display_name'] . '</option>';
		}
		$author_user_opts .= '</optgroup>';
	}
	//--------------------------------------------------------------------------
	$o='<div class="clearfix">
		<form class="in-table-form" data-function="csi_create_project_entrance">
			<input type="hidden" name="project_id" value="' . $post['projectId'] . '"/>
			<p><strong><i class=" fa fa-plus"></i> Agregar hito</strong></p>
			<hr/>
			<div class="form-group">
				<label for="reg_date" class="col-sm-2">Fecha</label>
				<div class="col-sm-10">
					<input type="text" name="reg_date" id="reg_date" class="form-control input-sm csi-date-range-input" required="true" value="' . $current_datetime->format('Y-m-d') . '" data-single-date-picker="true"/>
					<p class="help-block"> : p </p>
				</div>
			</div>
			<div class="form-group">
				<label for="author" class="col-sm-2">Autor</label>
				<div class="col-sm-10">
					<select name="author" class="form-control select2" required="true" data-placeholder="Selecciona el autor">
						<option></option>
						' . $author_user_opts . '
					</select>
					<p class="help-block"></p>
				</div>
			</div>
			<div for="entrance" class="form-group">
				<label class="col-sm-2">Texto</label>
				<div class="col-sm-10">
					<textarea name="entrance" id="entrance" class="form-control input-sm" required="true"></textarea>
					<p class="help-block">Descripción<br/>Tama&ntilde;o m&aacute;ximo: 255 caracteres</p>
				</div>
			</div>
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
}// csi_create_project_entrance_form

public function csi_edit_project_entrance(){
	//Globa Variables
	global $wpdb;
	//Local Variables
	$editArray			= array();
	$whereArray			= array();
	$response			= array();
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user		= get_userdata ( get_current_user_id() );
	$current_datetime	= new DateTime();
	$reg_date			= new DateTime ( $post['reg_date']);

	$whereArray['id']						= intval ( $post['project_entrance_id'] );

	$editArray['reg_date']					= $reg_date->format('Y-m-d');
	$editArray['author']					= intval ( $post['author'] );
	$editArray['entrance']					= strip_tags(stripslashes( $post['entrance'] ));

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
}// csi_edit_project_entrance

public function csi_edit_project_entrance_form(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_USER;
	global $NOVIS_CSI_USER_TEAM;
	//Local Variables
	$author_user_opts		= '';
	$date_time_input_opts	='';
	$response				= array();
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//--------------------------------------------------------------------------
	$sql ='SELECT * FROM ' . $this->tbl_name . ' WHERE id="' . $post['entranceId'] . '"';
	$entrance = $wpdb->get_row ( $sql );
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
		$author_user_opts .= '<optgroup label="' . $user_team['short_name'] . '">';
		foreach ( $users as $user ){
			$selected = ( $user['user_id'] == $entrance->author ) ? ' selected ' : '';
			$author_user_opts .= '<option value="' . $user['user_id'] . '" ' . $selected . '>' . $user['display_name'] . '</option>';
		}
		$author_user_opts .= '</optgroup>';
	}
	//--------------------------------------------------------------------------
	$o='<div class="clearfix">
		<form class="in-table-form" data-function="csi_edit_project_entrance">
			<input type="hidden" name="project_entrance_id" value="' . $entrance->id . '"/>
			<p><strong><i class=" fa fa-plus"></i> Editar hito</strong></p>
			<hr/>
			<div class="form-group">
				<label for="reg_date" class="col-sm-2">Fecha</label>
				<div class="col-sm-10">
					<input type="text" name="reg_date" id="reg_date" class="form-control input-sm csi-date-range-input" required="true" data-single-date-picker="true" value="' . $entrance->reg_date . '"/>
					<p class="help-block"> : p </p>
				</div>
			</div>
			<div class="form-group">
				<label for="author" class="col-sm-2">Autor</label>
				<div class="col-sm-10">
					<select name="author" class="form-control select2" required="true" data-placeholder="Selecciona el autor">
						<option></option>
						' . $author_user_opts . '
					</select>
					<p class="help-block"></p>
				</div>
			</div>
			<div for="entrance" class="form-group">
				<label class="col-sm-2">Texto</label>
				<div class="col-sm-10">
					<textarea name="entrance" id="entrance" class="form-control input-sm" required="true">' . $entrance->entrance . '</textarea>
					<p class="help-block">Descripción<br/>Tama&ntilde;o m&aacute;ximo: 255 caracteres</p>
				</div>
			</div>
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
}// csi_edit_project_entrance_form



//END OF CLASS
}

global $NOVIS_CSI_PROJECT_ENTRANCE;
$NOVIS_CSI_PROJECT_ENTRANCE =new NOVIS_CSI_PROJECT_ENTRANCE_CLASS();
?>
