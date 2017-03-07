<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_USER_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'user';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Usuario';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Usuarios';
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
			id bigint(20) unsigned not null COMMENT 'Wordpress User ID',
			active_flag tinyint(1) null COMMENT 'Indicates if user is valid in the context of this plugin',
			team_id tinyint(2) unsigned not null COMMENT 'Id of user team',
			team_manager_flag tinyint(1) null COMMENT 'Indicates if user is manager of the team it belongs',
			phone_no varchar(20) null COMMENT 'Phone number of user',
			timezone_id tinyint(2) unsigned not null COMMENT 'Id of users timezone',
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
	add_action( 'wp_ajax_csi_cmp_popup_user_info',				array( $this , 'csi_cmp_popup_user_info'	));
	add_action( 'show_user_profile',							array( $this, 'user_profile_fields'			));
	add_action( 'edit_user_profile',							array( $this, 'user_profile_fields' 		));
	add_action( 'profile_update',								array( $this, 'save_profile_update' 		));
	add_action( 'delete_user',									array( $this, 'disable_profile' 			));
	add_filter('manage_users_columns', 							array( $this, 'add_user_team_column' 		));
	add_action('manage_users_custom_column',  					array( $this, 'show_user_team_column_content'), 10, 3);
}
public function add_user_team_column ( $columns ) {
	$columns = array_slice($columns, 0, 2, true) + array("user_team" => "Equipo") + array_slice($columns, 3, count($columns)-2, true);
    return $columns;
	
}

//
function show_user_team_column_content($value, $column_name, $user_id) {
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_USER_TEAM;
	if ( $column_name = 'user_team' ){
		$sql = 'SELECT
					T01.short_name as team_name
				FROM
					' . $this->tbl_name . ' as T00
					LEFT JOIN ' . $NOVIS_CSI_USER_TEAM->tbl_name . ' as T01
						ON T00.team_id = T01.id
				WHERE
					T00.id = "' . $user_id . '"';
		$team = $wpdb->get_var ( $sql );
		return $team;
	}else{
		return $value;
	}
}

public function csi_cmp_popup_user_info(){
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
/**
 *  Add filed for selecting user role in user section
 *
 * @param $user WP_User
 */
public function user_profile_fields( $user ) {
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_USER_TEAM;
	global $NOVIS_CSI_COUNTRY;
	//Local Variables
	$o						= '';
	$user_teams_opts		= '';

	//if ( ! is_super_admin() && ! current_user_can( 'backwpup_admin' ) ) {
	if ( ! is_super_admin() ) {
		return;
	}

	//user is admin and has BackWPup rights
	//if ( $user->has_cap( 'administrator' ) && $user->has_cap( 'backwpup_settings' ) ) {
	if ( $user->has_cap( 'administrator' ) ) {
		return;
	}
	$sql = 'SELECT * FROM ' . $this->tbl_name . ' WHERE id = "' . $user->ID . '"';
	$csi_user = $wpdb->get_row ( $sql );

	$sql = 'SELECT * FROM ' . $NOVIS_CSI_COUNTRY->tbl_name . ' ORDER BY short_name ';
	$countries = $this->get_sql ( $sql );
	$selected = '';
	foreach ( $countries as $country ){
		$sql = 'SELECT * FROM ' . $NOVIS_CSI_USER_TEAM->tbl_name . ' WHERE country_id="' . $country['id'] . '" ORDER BY short_name ';
		$user_teams = $this->get_sql ( $sql );
		$user_teams_opts.='<optgroup label="' . $country['short_name'] . '">';
		foreach ( $user_teams as $user_team ){
			$selected = ( $csi_user->team_id == $user_team['id'] ) ? 'selected' : '';
			$user_teams_opts.='<option value="' . $user_team['id'] . '" ' . $selected . '>' . $user_team['short_name'] . '</option>';
		}
		$user_teams_opts.='</optgroup>';
	}
	//only if user has other than backwpup role
	$o='
		<h3>CSI </h3>
		<table class="form-table">
			<tr>
				<th>
					<label>Usuario activo</label>
				</th>
				<td>
					<input type="checkbox" name="' . $this->plugin_post . '[active_flag]" id="' . $this->plugin_post . '[active_flag]" style="display:inline-block; float:none;" ' . ($csi_user->active_flag ? 'checked' : '' ) . '/>
					<label for="' . $this->plugin_post . '[active_flag]"> Usuario activo</label>
					<p class="description">Indica si el usuario está activo para el módulo de CSI</p>
				</td>
			</tr>
			<tr>
				<th>
					<label for="' . $this->plugin_post . '[team_id]">Equipo</label>
				</th>
				<td>
					<select name="' . $this->plugin_post . '[team_id]" id="' . $this->plugin_post . '[team_id]" style="display:inline-block; float:none;">
						<option value="0">Ninguno</option>
						' . $user_teams_opts . '
					</select>
					<p class="description">Indica a que equipo pertenece el usuario.</p>
				</td>
			</tr>
			<tr>
				<th>
					<label>Manager</label>
				</th>
				<td>
					<input type="checkbox" name="' . $this->plugin_post . '[team_manager_flag]" id="' . $this->plugin_post . '[team_manager_flag]" style="display:inline-block; float:none;" ' . ($csi_user->team_manager_flag ? 'checked' : '' ) . '/>
					<label for="' . $this->plugin_post . '[team_manager_flag]"> Usuario Lider</label>
					<p class="description">Indica si el usuario es líder del equipo al que pertenece.</p>
				</td>
			</tr>
			<tr>
				<th>
					<label>N&uacute;mero de Tel&eacute;fono</label>
				</th>
				<td>
					<input type="text" name="' . $this->plugin_post . '[phone_no]" id="' . $this->plugin_post . '[phone_no]" style="display:inline-block; float:none;" value="' . $csi_user->phone_no . '"/>
					<p class="description">Registra el n&uacute;mero telef&oacute;nico del usuario.</p>
				</td>
			</tr>
			<tr>
				<th>
					<label for="' . $this->plugin_post . '[timezone_id]">Zona Horaria</label>
				</th>
				<td>
					<select name="' . $this->plugin_post . '[timezone_id]" id="' . $this->plugin_post . '[timezone_id]" style="display:inline-block; float:none;" readonly="true">
						<option value="1">Por ahora es opción por defecto</option>
					</select>
					<p class="description">Indica a que equipo pertenece el usuario.</p>
				</td>
			</tr>
		</table>
	';
	_e ( $o );
}
/**
 * Save for user role adding
 *
 * @param $user_id int
 */
public function save_profile_update( $user_id ) {
	//Global Variables
	global $wpdb;
	//Local Variables
	$editArray				= array();
	$post					= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user		= get_userdata ( get_current_user_id() );
	$current_datetime	= new DateTime();

	$editArray['id']							= intval ( $user_id );
	$editArray['active_flag']					= isset ( $post['active_flag'] ) ? 1 : NULL;
	$editArray['team_id']						= isset ( $post['team_id'] ) ? intval ( $post['team_id'] ) : NULL;
	$editArray['team_manager_flag']				= isset ( $post['team_manager_flag'] ) ? 1 : NULL;
	$editArray['phone_no']						= strip_tags(stripslashes( $post['phone_no'] ));
	$editArray['timezone_id']					= isset ( $post['timezone_id'] ) ? intval ( $post['timezone_id'] ) : NULL;
	$editArray['last_modified_user_id']			= $current_user->ID;
	$editArray['last_modified_user_email']		= $current_user->user_email;
	$editArray['last_modified_date']			= $current_datetime->format('Y-m-d');
	$editArray['last_modified_time']			= $current_datetime->format('H:i:s');
	$result = $wpdb->replace ( $this->tbl_name, $editArray );

	return;
}
public function disable_profile( $user_id ) {
	//Global Variables
	global $wpdb;
	//Local Variables
	$editArray				= array();
	$current_user		= get_userdata ( get_current_user_id() );
	$current_datetime	= new DateTime();

	$editArray['id']							= intval ( $user_id );
	$editArray['active_flag']					= NULL;
	$editArray['last_modified_user_id']			= $current_user->ID;
	$editArray['last_modified_user_email']		= $current_user->user_email;
	$editArray['last_modified_date']			= $current_datetime->format('Y-m-d');
	$editArray['last_modified_time']			= $current_datetime->format('H:i:s');
	$result = $wpdb->replace ( $this->tbl_name, $editArray );

	return;
}
//END OF CLASS
}

global $NOVIS_CSI_USER;
$NOVIS_CSI_USER =new NOVIS_CSI_USER_CLASS();
?>
