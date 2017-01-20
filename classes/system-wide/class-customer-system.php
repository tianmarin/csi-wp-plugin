<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_CUSTOMER_SYSTEM_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'customer_system';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Sistema de Cliente';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Sistemas de Cliente';
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
	$this->db_version	= '0.6.1';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="(
								id int unsigned not null auto_increment COMMENT 'Unique ID for each entry',
								sapcustno bigint(13) unsigned not null COMMENT 'SAP Customer Number',
								system_no bigint(18) unsigned not null COMMENT 'SAP System Number',
								inst_no bigint(10) unsigned not null COMMENT 'SAP System Installation Number',
								sid varchar(15) not null COMMENT 'System ID',
								landscape_id int unsigned not null COMMENT 'System Landscape',
								environment_id int unsigned not null COMMENT 'System Environment',
								creation_user_id bigint(20) unsigned null COMMENT 'Id of user responsible of the creation of this record',
								creation_user_email varchar(100) null COMMENT 'Email of user. Used to track user if user id is deleted',
								creation_date date null COMMENT 'Date of the creation of this record',
								creation_time time null COMMENT 'Time of the creation of this record',
								creation_filename varchar(255) null COMMENT 'Name of the file used to create this record',
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
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>'<i class="fa fa-hashtag"></i>',
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'sapcustno' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>true,
			'backend_wp_table_lead'		=>true,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'ID que SAP ha dado al cliente. Este se puede encontrar en SAP Solution Manager',
			'form_input_size'			=>false,
			'form_label'				=>'Customer SAP Number',
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'system_no' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'El n&uacute;mero identificador del sistema.',
			'form_input_size'			=>false,
			'form_label'				=>'System Number',
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'inst_no' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'El n&uacute;mero de instalaci&oacute;n del sistema.',
			'form_input_size'			=>false,
			'form_label'				=>'Intall Number',
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'sid' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>3,
			'form_disabled'				=>false,
			'form_help_text'			=>'El SID del sistema.<br/>Tamaño m&aacute;ximo: 3 caracteres.',
			'form_input_size'			=>false,
			'form_label'				=>'SID',
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'landscape_id' => array(
//			'type'						=>'select',
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>true,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Selecciona el landscape",
			'form_input_size'			=>false,
			'form_label'				=>'Landscape',
			'form_options'				=>array(),
			'form_placeholder'			=>false,
			'form_special_form'			=>true,
			'form_show_field'			=>true,
		),
		'environment_id' => array(
//			'type'						=>'select',
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>true,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Selecciona el ambiente",
			'form_input_size'			=>false,
			'form_label'				=>'Ambiente',
			'form_options'				=>array(),
			'form_placeholder'			=>false,
			'form_special_form'			=>true,
			'form_show_field'			=>true,
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
		'creation_filename' => array(
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

}
protected function backend_wp_sp_table_code($code){
	return strtoupper($code);
}

protected function backend_wp_sp_table_sapcustno($sapcustno){
	global $NOVIS_CSI_SAPCUSTNO;
	global $NOVIS_CSI_CUSTOMER;
	global $wpdb;
	
	$sql = 'SELECT T01.short_name FROM '.$NOVIS_CSI_SAPCUSTNO->tbl_name.' as T00 LEFT JOIN '.$NOVIS_CSI_CUSTOMER->tbl_name.' as T01 ON T00.customer_id=T01.id WHERE T00.sapcustno="'.$sapcustno.'"';
	$short_name = $wpdb->get_row($sql,'ARRAY_A')['short_name'];
	return $short_name.' (<small>'.$sapcustno.'</small>)';
	
}

protected function backend_wp_sp_table_blog_id($blog_id){
	if ( is_multisite() ){
		return '<a href="/wp-admin/network/site-info.php?id='.$blog_id.'">'.$blog_id.'</a>';
	}else{
		return $blog_id;
	}
}
public function get_system_no_col(){
	global $wpdb;
	$sql = "SELECT system_no FROM ".$this->tbl_name;
	return $wpdb->get_col( $sql );
}
public function get_row_by_system_no($system_no){
	global $wpdb;
	$sql = 'SELECT * FROM '.$this->tbl_name.' WHERE system_no = "'.$system_no.'" ';
	return $wpdb->get_row( $sql, 'ARRAY_A');
}


//END OF CLASS	
}

global $NOVIS_CSI_CUSTOMER_SYSTEM;
$NOVIS_CSI_CUSTOMER_SYSTEM =new NOVIS_CSI_CUSTOMER_SYSTEM_CLASS();
?>