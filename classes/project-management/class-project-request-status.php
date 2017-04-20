<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_PROJECT_REQUEST_STATUS_CLASS extends NOVIS_CSI_CLASS{
public			$default_status_code		= 'new';

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
	$this->class_name	= 'project_request_status';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Estado de Solicitud de Proyecto';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Estados de Solicitud de Proyecto';
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
			code varchar(20) not null COMMENT 'Code ID for programming calls',
			short_name varchar(50) not null COMMENT 'Short name of status',
			icon varchar(50) null COMMENT 'Icon of rating',
			css_class varchar(100) null COMMENT 'Bootstrap Class',
			hex_color varchar(6) null COMMENT 'HEX Color of this record',
			description text null COMMENT 'Description of this record',
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
	);
	add_action( 'plugins_loaded',	array( $this , 'db_install' ) );
	add_action( 'plugins_loaded',	array( $this , 'db_install_data' ) );
	add_action( 'wp_ajax_csi_pm_popup_project_request_status_info',	array( $this , 'csi_pm_popup_project_request_status_info' ) );
}
public function db_install_data(){
	global $wpdb;
	$current_db_version = get_option( $this->tbl_name."_db_version");
	if( $current_db_version == false || $current_db_version != $this->db_version ){
		$sql = 'DELETE * FROM ' . $this->tbl_name;
		self::write_log ('Contenido de tabla ' . $this->tbl_name . ' eliminado.');
		self::write_log ( $this->get_sql ( $sql ) );
		$current_user			= get_userdata ( get_current_user_id() );
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> 1,
				'code'					=> 'new',
				'short_name'			=> 'Nuevo',
				'icon'					=> 'plus',
				'css_class'				=> 'info',
				'hex_color'				=> '',
				'description'			=> 'Las solicitudes en Status <i>nuevo</i> no han sido analizadas.',
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_date'			=> date("Y-m-d"),
				'creation_time'			=> date("H:i:s"),
			)
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> 2,
				'code'					=> 'revision',
				'short_name'			=> 'En revisi&oacute;n',
				'icon'					=> 'bookmark',
				'css_class'				=> 'warning',
				'hex_color'				=> '',
				'description'			=> 'Las solicitudes en Status <i>En Revisi&oacute;n</i> están siendo revisadas por la PMO.',
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_date'			=> date("Y-m-d"),
				'creation_time'			=> date("H:i:s"),
			)
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> 3,
				'code'					=> 'rejected',
				'short_name'			=> 'Rechazada',
				'icon'					=> 'times',
				'css_class'				=> 'danger',
				'hex_color'				=> '',
				'description'			=> 'Las solicitudes en Status <i>Rechazada</i> no ser&aacute;n tratadas como proyecto.',
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_date'			=> date("Y-m-d"),
				'creation_time'			=> date("H:i:s"),
			)
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> 4,
				'code'					=> 'approved',
				'short_name'			=> 'Aprobada',
				'icon'					=> 'check',
				'css_class'				=> 'success',
				'hex_color'				=> '',
				'description'			=> 'Las solicitudes en Status <i>aprobada</i> ser&aacute;n tratadas como proyecto.',
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_date'			=> date("Y-m-d"),
				'creation_time'			=> date("H:i:s"),
			)
		);
	}
}
public function csi_pm_popup_project_request_status_info ( $echo = null ) {
	//Global Variables
	//Local Variables
	$response			= array();
	$o = '';
	//Execution
	$sql = 'SELECT * FROM ' . $this->tbl_name . ' ';
	$issues_status = $this->get_sql($sql);
	$o.='<table class="table table-condensed">';
	$o.='
	<tr>
		<th class="col-xs-3">Status</th>
		<th>Descripci&oacute;n</th>
	</tr>
	';
	foreach ( $issues_status as $issue_status ){
		$o.='
		<tr>
			<td class="col-xs-3 ' . $issue_status['css_class'] . '"><span class="text-' . $issue_status['css_class'] . '"><i class="fa fa-' . $issue_status['icon'] . ' hidden-xs"></i> ' . $issue_status['short_name'] . '</span></td>
			<td><p class="text-justify">' . $issue_status['description'] . '</p></td>
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
		'title'				=> 'Status de solicitudes de Proyecto',
		'type'				=> 'blue',
	);

	if ( null == $echo ){
		echo json_encode($response);
		wp_die();
	}else{
		return $response;
	}
}
//END OF CLASS
}

global $NOVIS_CSI_PROJECT_REQUEST_STATUS;
$NOVIS_CSI_PROJECT_REQUEST_STATUS =new NOVIS_CSI_PROJECT_REQUEST_STATUS_CLASS();
?>
