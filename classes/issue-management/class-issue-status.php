<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_ISSUE_STATUS_CLASS extends NOVIS_CSI_CLASS{
public $default_status_code			= 'draft';
public $default_approval_code		= 'pending';
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
	$this->class_name	= 'issue_status';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Status de Issue';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Status de Issue';
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
	$this->data_db_version	= '0.0.6';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="
		(
			id tinyint(1) unsigned not null auto_increment COMMENT 'Unique ID for each entry',
			code varchar(10) not null COMMENT 'Code ID for programming calls',
			short_name varchar(50) not null COMMENT 'Short name of status',
			released_flag tinyint(1) unsigned null COMMENT 'Indicates if status provides visibility to final users',
			prevent_edition_flag tinyint(1) unsigned null COMMENT 'Indicates if status should allow editors to modify revision',
			revision_requested_flag tinyint(1) unsigned null COMMENT 'Indicates if status is approval state',
			icon varchar(50) null COMMENT 'Icon of rating',
			css_class varchar(100) null COMMENT 'Bootstrap Class',
			hex_color varchar(6) null COMMENT 'HEX Color of Rating',
			description text null COMMENT 'Description of this record',
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

	add_action( 'plugins_loaded',								array( $this , 'db_install' )						);
	add_action( 'plugins_loaded',								array( $this , 'db_install_data' )					);

	add_action( 'wp_ajax_csi_issue_popup_issue_status_info',	array( $this , 'csi_issue_popup_issue_status_info'	));
}
public function db_install_data(){
	//Global Variables
	global $wpdb;
	//Local Variables
	$current_data_db_version = get_option( $this->tbl_name."_data_db_version");
	//Execuion
	if( $current_data_db_version == false || $current_data_db_version != $this->data_db_version ){
		$sql = 'DELETE FROM ' . $this->tbl_name;
		self::write_log ('Contenido de tabla ' . $this->tbl_name . ' eliminado.');
		self::write_log ( $this->get_sql ( $sql ) );
		update_option( $this->tbl_name."_data_db_version" , $this->data_db_version );
		$current_user = get_userdata ( get_current_user_id() );
		$i=1;
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> $i++,
				'code'					=> 'draft',
				'short_name'			=> 'Borrador',
				'released_flag'			=> NULL,
				'prevent_edition_flag'	=> NULL,
				'revision_requested_flag'	=> NULL,
				'icon'					=> 'pencil-square-o',
				'css_class'				=> 'default',
				'hex_color'				=> '',
				'description'			=> 'Las notas en estado <i>Borrador</i>, son notas que est&aacute;n en proceso de escritura, correcci&oacute;n o mejora.',
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_datetime'		=> date("Y-m-d H:i:s"),
			)
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> $i++,
				'code'	  				=> 'pending',
				'short_name'			=> 'Solicitud de Aprobaci&oacute;n',
				'released_flag'			=> NULL,
				'revision_requested_flag'	=> 1,
				'prevent_edition_flag'	=> 1,
				'icon'					=> 'clock-o',
				'css_class'				=> 'info',
				'hex_color'				=> '',
				'description'			=> '',
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_datetime'		=> date("Y-m-d H:i:s"),
			)
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> $i++,
				'code'					=> 'released',
				'short_name'			=> 'Liberado',
				'released_flag'			=> 1,
				'prevent_edition_flag'	=> 1,
				'revision_requested_flag'	=> NULL,
				'icon'					=> 'check',
				'css_class'				=> 'success',
				'hex_color'				=> '',
				'description'			=> 'Las notas en estado <i>Liberado</i>, son notas que han sido validadas y autorizadas para su utilizaci&oacute;n por parte de un <i>L&iacute;der</i>.',
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_datetime'		=> date("Y-m-d H:i:s"),
			)
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> $i++,
				'code'	  				=> 'obsolete',
				'short_name'			=> 'Obsoleto',
				'released_flag'			=> 1,
				'prevent_edition_flag'	=> 1,
				'revision_requested_flag'	=> NULL,
				'icon'					=> 'paperclip',
				'css_class'				=> 'active',
				'hex_color'				=> '',
				'description'			=> 'Las notas en estado <i>Obsoleto</i>, son notas que han sido resueltas desde su causa ra&iacute;z y los errores relacionados no deber&iacute;an existir. Una nota en estado <i>Obsoleto</i>, tambi&eacute;n pueden ser reemplazadas por nuevas notas con informaci&oacute;n completa y unificada de varias notas relacionadas.',
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_datetime'		=> date("Y-m-d H:i:s"),
			)
		);
		$wpdb->insert(
			$this->tbl_name,
			array(
				'id'					=> $i++,
				'code'	  				=> 'rejected',
				'short_name'			=> 'Rechazado',
				'released_flag'			=> NULL,
				'prevent_edition_flag'	=> NULL,
				'revision_requested_flag'	=> NULL,
				'icon'					=> 'times',
				'css_class'				=> 'danger',
				'hex_color'				=> '',
				'description'			=> '',
				'creation_user_id'		=> intval(get_current_user_id()),
				'creation_user_email'	=> $current_user->user_email,
				'creation_datetime'		=> date("Y-m-d H:i:s"),
			)
		);
	}
}
public function csi_issue_popup_issue_status_info ( $echo = null ) {
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
		<th class="col-xs-3">Estado de Nota NOVIS</th>
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
		'title'				=> 'Status de las revisiones de <strong>Notas NOVIS</trong>',
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
global $NOVIS_CSI_ISSUE_STATUS;
$NOVIS_CSI_ISSUE_STATUS =new NOVIS_CSI_ISSUE_STATUS_CLASS();
?>
