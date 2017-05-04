<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_PROJECT_STATUS_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'project_status';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Estado de Proyecto';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Estados de Proyecto';
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
	$this->db_version		= '0.0.2';
	$this->data_db_version	= '0.0.6';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="
		(
			id tinyint(1) unsigned not null auto_increment COMMENT 'Unique ID for each entry',
			code varchar(20) not null COMMENT 'Code ID for programming calls',
			short_name varchar(50) not null COMMENT 'Short name of status',
			icon varchar(50) null COMMENT 'Icon of rating',
			css_class varchar(100) null COMMENT 'Bootstrap Class',
			hex_color varchar(6) null COMMENT 'HEX Color of this record',
			description text null COMMENT 'Description of this record',
			default_timeline_flag tinyint(1) unsigned null COMMENT 'Indicates if status are shown by default in timeline view',
			creation_user_id bigint(20) unsigned null COMMENT 'Id of user responsible of the creation of each record',
			creation_user_email varchar(100) null COMMENT 'Email of user. Used to track user if user id is deleted',
			creation_datetime datetime null COMMENT 'Date and time of the creation of this record',
			last_modified_user_id bigint(20) unsigned null COMMENT 'Id of user responsible of the last modification of this record',
			last_modified_user_email varchar(100) null COMMENT 'Email of user. Used to track user if user id is deleted',
			last_modified_datetime datetime null COMMENT 'Date and time of the last modification of this record',

			UNIQUE KEY id (id)
		) $charset_collate;";
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql	=	"CREATE TABLE ".$this->tbl_name." ".$this->crt_tbl_sql_wt;
	$this->db_fields	= array();

	add_action( 'plugins_loaded',	array( $this , 'db_install' ) );
	add_action( 'plugins_loaded',	array( $this , 'db_install_data' ) );
}
public function db_install_data(){
	//Global Variables
	global $wpdb;
	//Local Variables
	if ( is_multisite() ){
		$current_data_db_version = get_blog_option ( 1, $this->tbl_name."_data_db_version" );
	}else{
		$current_data_db_version = get_option( $this->tbl_name."_data_db_version");
	}
	//Execuion
	if( $current_data_db_version == false || $current_data_db_version != $this->data_db_version ){
		$sql = 'DELETE FROM ' . $this->tbl_name;
		self::write_log ('Contenido de tabla ' . $this->tbl_name . ' eliminado.');
		self::write_log ( $this->get_sql ( $sql ) );
		if ( is_multisite() ){
			update_blog_option ( 1, $this->tbl_name."_data_db_version" , $this->data_db_version );
		}else{
			update_option( $this->tbl_name."_data_db_version" , $this->data_db_version );
		}
		$current_user = get_userdata ( get_current_user_id() );
		$i=1;
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> $i++,
				'code'					=> 'new',
				'short_name'			=> 'Nuevo',
				'icon'					=> 'plus',
				'css_class'				=> 'info',
				'hex_color'				=> '',
				'description'			=> '',
				'default_timeline_flag'	=> NULL,
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_datetime'		=> date("Y-m-d H:i:s"),
			)
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> $i++,
				'code'					=> 'pipe',
				'short_name'			=> 'Pipeline',
				'icon'					=> 'plus',
				'css_class'				=> 'info',
				'hex_color'				=> '',
				'description'			=> '',
				'default_timeline_flag'	=> NULL,
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_datetime'		=> date("Y-m-d H:i:s"),
			)
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> $i++,
				'code'					=> 'executing',
				'short_name'			=> 'En Curso',
				'icon'					=> 'plus',
				'css_class'				=> 'info',
				'hex_color'				=> '',
				'description'			=> '',
				'default_timeline_flag'	=> 1,
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_datetime'		=> date("Y-m-d H:i:s"),
			)
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> $i++,
				'code'					=> 'canceled',
				'short_name'			=> 'Cancelado',
				'icon'					=> 'plus',
				'css_class'				=> 'info',
				'hex_color'				=> '',
				'description'			=> '',
				'default_timeline_flag'	=> NULL,
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_datetime'		=> date("Y-m-d H:i:s"),
			)
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> $i++,
				'code'					=> 'finished',
				'short_name'			=> 'Terminado',
				'icon'					=> 'plus',
				'css_class'				=> 'info',
				'hex_color'				=> '',
				'description'			=> '',
				'default_timeline_flag'	=> NULL,
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_datetime'		=> date("Y-m-d H:i:s"),
			)
		);

	}
}

//END OF CLASS
}

global $NOVIS_CSI_PROJECT_STATUS;
$NOVIS_CSI_PROJECT_STATUS =new NOVIS_CSI_PROJECT_STATUS_CLASS();
?>
