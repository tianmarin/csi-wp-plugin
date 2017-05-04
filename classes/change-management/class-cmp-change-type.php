<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_CMP_CHANGE_TYPE_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'cmp_change_type';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Tipo de Cambio';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Tipos de Cambio';
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
			short_name varchar(20) not null COMMENT 'Status name',
			description text null COMMENT 'Description of status',
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
	register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install_data'			));
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
	add_action( 'wp_ajax_csi_cmp_popup_change_type_info',		array( $this , 'csi_cmp_popup_change_type_info'	));


}
public function db_install_data(){
	global $wpdb;
	$count =intval($wpdb->get_var( "SELECT COUNT(*) FROM ".$this->tbl_name));
	if($count == 0){
		$current_user = wp_get_current_user();
		$wpdb->insert(
			$this->tbl_name,
			array(
				'short_name'				=> 'No hay cambio',
				'creation_user_id'			=> intval(get_current_user_id()),
				'creation_user_email'		=> $current_user->user_email,
				'creation_date'				=> date("Y-m-d"),
				'creation_time'				=> date("H:i:s"),
			)
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'short_name'				=> 'Cambio pre-aprobado',
				'creation_user_id'			=> intval(get_current_user_id()),
				'creation_user_email'		=> $current_user->user_email,
				'creation_date'				=> date("Y-m-d"),
				'creation_time'				=> date("H:i:s"),
			)
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'short_name'				=> 'Cambio normal',
				'creation_user_id'			=> intval(get_current_user_id()),
				'creation_user_email'		=> $current_user->user_email,
				'creation_date'				=> date("Y-m-d"),
				'creation_time'				=> date("H:i:s"),
			)
		);
	}
}
public function csi_cmp_popup_change_type_info(){
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	//Local Variables
	$response			= array();
	$o = '';

	$sql = 'SELECT * FROM ' . $this->tbl_name . ' ';
	$change_types = $this->get_sql($sql);
	$o.='<table class="table table-condensed">';
	$o.='
	<tr>
		<th class="col-xs-3">' . $this->name_plural . '</th>
		<th>Descripci&oacute;n</th>
	</tr>
	';
	foreach ( $change_types as $change_type ){
		$o.='
		<tr>
			<td class="col-xs-3"><code>' . $change_type['short_name'] . '</code></td>
			<td><p class="text-justify">' . $change_type['description'] . '</p></td>
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
//END OF CLASS
}

global $NOVIS_CSI_CMP_CHANGE_TYPE;
$NOVIS_CSI_CMP_CHANGE_TYPE =new NOVIS_CSI_CMP_CHANGE_TYPE_CLASS();
?>
