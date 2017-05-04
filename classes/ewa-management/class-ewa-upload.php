<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_EWA_UPLOAD_CLASS extends NOVIS_CSI_CLASS{
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
	$this->class_name	= 'ewa_upload';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Carga de EWA';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Carga de EWA';
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
			id smallint(10) unsigned not null auto_increment COMMENT 'Unique ID for each entry',
			error_flag tinyint(1) not null DEFAULT '0' COMMENT 'Indicates if the load had problemas',
			ewas_no bigint(10) null COMMENT 'Number of uploaded ewas',
			alerts_no bigint(20) null COMMENT 'Nmber of uploaded alerts',
			text text null COMMENT 'Text details of te uploaded file',
			filename tinytext null COMMENT 'Filename',
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
	add_action( 'wp_ajax_csi_ewa_build_page_ewa_loads',	array( $this , 'csi_ewa_build_page_ewa_loads'	));
	add_action( 'wp_ajax_csi_ewa_popup_ewa_upload_log',	array( $this , 'csi_ewa_popup_ewa_upload_log'	));

}
public function new_upload(){
	//Global Variables
	global $wpdb;
	//Local Variables
	$current_user = get_userdata ( get_current_user_id() );
	//Execution

	$insert = $wpdb->insert(
		$this->tbl_name,
		array(
			'error_flag'			=> 1,
			'creation_user_id'		=> intval(get_current_user_id()),
			'creation_user_email'	=> $current_user->user_email,
			'creation_datetime'		=> date("Y-m-d H:i:s"),
		)
	);
	if ( $insert != FALSE){
		return intval ( $wpdb->insert_id );
	}
	return FALSE;
}
public function csi_ewa_popup_ewa_upload_log(){
	$post = isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$load_id = $post['ewaUpload'];
	$load = $this->get_single ( $load_id );
	$date = new DateTime ( $load['last_modified_datetime'] );

	$response['content']='<div class="clearfix">' . $load['text'] . '</div>';
	$response['title']='<span class="text-muted">Registro de carga de archivo <i>CSV-EWA</i> <samp>[id: ' . $load['id'] . ']</samp></span>';
	echo json_encode($response);
	wp_die();
}
public function csi_ewa_build_page_ewa_loads(){
	//Global Variables
	global $wpdb;
	//Local Variables
	$o						= '';
	$response				= array();
	$post = isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//Execution
	//--------------------------------------------------------------------------
	$o='
	<div class="container">
		<div class="page-header row">
			<h2 class="h3">Registro de Cargas de EWAs</h2>
			<p class="text-muted text-justify">La siguiente tabla muestra el detalle de las cargas de información realizadas sobre el sistema.</p>
		</div>
		<div class="panel panel-default row">
			<div class="panel-heading">
				<i class="fa fa-fw fa-pie-chart"></i>Cargas
			</div>
			<table class="table table-hover">
				<thead>
					<tr>
						<th class="text-center"><i class="fa fa-fw fa-hashtag"></i></th>
						<th class="text-center"><i class="fa fa-fw fa-flag"></i></th>
						<th>Fecha</th>
						<th>Usuario</th>
						<th class="hidden-xs">Archivo</th>
						<th>Ewas</th>
						<th>Alertas</th>
						<th>Ver Log</th>
					</tr>
				</thead>
				<tbody>
	';
	$loads = $this->get_all();
	foreach ( $loads as $load){
		$creation_datetime = new DateTime ( $load['creation_datetime'] );
		$creation_datetime->setTimezone ( new DateTimeZone( get_option ( 'timezone_string' ) ) );
		$o.='
					<tr class="small">
						<td class="text-center"><samp>' . $load['id'] . '</samp></td>
						<td class="text-center"><i class="fa fa-fw fa-sm fa-' . ( $load['error_flag'] ? 'exclamation' : '' ) . '"></i></td>
						<td>' . $creation_datetime->format ( 'd/m/Y H:i') . ' </td>
						<td>' .get_userdata( $load['creation_user_id'] )->display_name . '</td>
						<td class="hidden-xs">' . $load['filename'] . '</td>
						<td>' . $load['ewas_no'] . '</td>
						<td>' . $load['alerts_no'] . '</td>
						<td>
							<a href="#" class="btn btn-default csi-popup-page" data-action="csi_ewa_popup_ewa_upload_log" data-ewa-upload="' . $load['id'] . '" data-column-class="xlarge" data-background-dismiss="true" data-type="blue" data-icon="fa fa-info" data-container-fluid="true">
								ver logs
							</a>
						</td>
					</tr>
		';
	}
	$o.='
				</tbody>
			</table>
		</div>
		<div class="well well-sm small row">
			<p>
				Las fechas y horas se muestran en la zona horaria <samp>' . get_option ( 'timezone_string' ) . '</samp> a menos que se especifique lo contrario.
			</p>
		</div>
	</div>
	';
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}

//END OF CLASS

}
global $NOVIS_CSI_EWA_UPLOAD;
$NOVIS_CSI_EWA_UPLOAD =new NOVIS_CSI_EWA_UPLOAD_CLASS();
?>
