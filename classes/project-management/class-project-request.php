<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_PROJECT_REQUEST_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'project_request';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Solicitud de Proyecto';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Solicitudes de Proyecto';
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
	$this->db_version	= '0.0.4';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="
		(
			id bigint(20) unsigned not null auto_increment,
			registered_customer_flag tinyint(1) unsigned null COMMENT 'Indicates if customer is already registered',
			registered_customer_id bigint(20) unsigned not null COMMENT 'Customer Id',
			non_registered_customer_name varchar(50) not null COMMENT 'Name of unregistered customer',
			short_name varchar(100) not null,
			description tinytext not null,
			requested_user_id bigint(20) unsigned not null COMMENT 'Id of requester',
			requested_user_email bigint(20) unsigned not null COMMENT 'Email of requester. Used to track user if user id is deleted',
			requested_datetime datetime not null COMMENT 'Date and time of request of this record',
			status_id tinyint(2) unsigned not null COMMENT 'Status id for this record',
			pmo_comments tinytext null COMMENT 'PMO comments',
			project_id bigint(20) unsigned null COMMENT 'ID of Project if approved',
			planned_start_date date null,
			planned_end_date date null,
			creation_user_id bigint(20) unsigned null COMMENT 'Id of user responsible of the creation of each record',
			creation_user_email varchar(100) null COMMENT 'Email of user. Used to track user if user id is deleted',
			creation_datetime datetime null COMMENT 'Date and time of creation of this record',
			last_modified_user_id bigint(20) unsigned null COMMENT 'Id of user responsible of the last modification of this record',
			last_modified_user_email varchar(100) null COMMENT 'Email of user. Used to track user if user id is deleted',
			last_modified_datetime datetime null COMMENT 'Date and time of last modification of this record',

			UNIQUE KEY id (id)
		) $charset_collate;";
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql	=	"CREATE TABLE ".$this->tbl_name." ".$this->crt_tbl_sql_wt;
	$this->db_fields	= array(
	);
	add_action( 'plugins_loaded',	array( $this , 'db_install' ) );
	add_action( 'plugins_loaded',	array( $this , 'csi_define_capabilities' ) );
	//Add Ajax actions
	add_action( 'wp_ajax_csi_pm_project_request_build_page_intro', array( $this , 'csi_pm_project_request_build_page_intro' ) );
	add_action( 'wp_ajax_csi_pm_new_pr_form', array( $this, 'csi_pm_new_pr_form' ) );
	add_action( 'wp_ajax_csi_pm_new_pr', array( $this, 'csi_pm_new_pr' ) );
	add_action( 'wp_ajax_csi_pm_build_page_own_project_request', array( $this, 'csi_pm_build_page_own_project_request' ) );
	add_action( 'wp_ajax_csi_pm_build_page_show_project_request', array( $this, 'csi_pm_build_page_show_project_request' ) );
	add_action( 'wp_ajax_csi_pm_build_page_edit_project_request_form', array( $this, 'csi_pm_build_page_edit_project_request_form' ) );
	add_action( 'wp_ajax_csi_pm_build_page_edit_project_request', array( $this, 'csi_pm_build_page_edit_project_request' ) );
	add_action( 'wp_ajax_csi_pm_build_page_list_project_requests', array( $this, 'csi_pm_build_page_list_project_requests' ) );

}
public function csi_define_capabilities(){
	global $csi_capabilities;
	$class_cap = array(
		'name'	=> 'Project Request Capabilities',
		'caps'	=> array(
			'csi_edit_others_project_request',
			'csi_edit_project_request_restricted_fields',
		),
	);
	array_push ( $csi_capabilities, $class_cap);
}
public function csi_pm_project_request_build_page_intro(){
	//Global Variables
	//Local Variables
	$o					= '';
	//--------------------------------------------------------------------------
	$o.='
	<div class="jumbotron">
		<div class="container">
			<h2>Solicitudes de Proyecto</h2>
			<p>M&oacute;dulo de registro y control de solicitudes de proyectos.</p>
			<p><a class="btn btn-primary btn-lg" href="#" role="button">Aprender m&aacute;s</a></p>
		</div>
	</div><!-- .jumbotron -->
	<nav class="container">
		<div class="row">
			<div class="list-group col-sm-6 col-md-6">
				<a href="#!newprojectrequest" class="list-group-item active">
					<h3><i class="fa fa-plus"></i> Solicitud de Proyecto</h3>
					<p class="text-justify">Solicita un nuevo Proyecto.</p>
				</a>
			</div>
			<div class="list-group col-sm-6 col-md-6">
				<a href="#!ownprojectrequest" class="list-group-item list-group-item-success">
					<h3><i class="fa fa-user"></i> Mis solicitudes</h3>
					<p class="text-justify">Ve el status de tus solicitudes.</p>
				</a>
			</div>
		</div>
	</nav><!-- .container -->
	';
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_pm_build_page_edit_project_request_form(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_PROJECT_REQUEST_STATUS;
	//Local Variables
	$o				= '';
	$customer_opts	= '';
	$status_opts	= '';
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$pr_id = intval ( $post['r'] );
	$sql = 'SELECT * FROM ' . $this->tbl_name . ' WHERE id = "' . $pr_id . '" ';
	$pr = $wpdb->get_row ( $sql );
	//--------------------------------------------------------------------------
	$planned_start_date = new DateTime ( $pr->planned_start_date );
	$planned_end_date = new DateTime ( $pr->planned_end_date );
	//--------------------------------------------------------------------------
	$sql = 'SELECT id, short_name FROM ' . $NOVIS_CSI_COUNTRY->tbl_name . ' ORDER BY short_name';
	foreach ( $this->get_sql ( $sql ) as $country ){
		$customer_opts.='<optgroup label="' . $country['short_name'] . '">';
		$sql = 'SELECT id, short_name, code FROM ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' WHERE country_id="' . $country['id'] . '" ORDER BY short_name';
		foreach ( $this->get_sql ( $sql ) as $customer ){
			$selected = ( $pr->registered_customer_id == $customer['id'] ) ? 'selected' : '';
			$customer_opts.='<option value="' . $customer['id'] . '" ' . $selected . '>' . $customer['short_name'] . ' (' . strtoupper ( $customer['code'] ) . ')</option>';
		}
		$customer_opts.='</optgroup>';
	}
	//--------------------------------------------------------------------------
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_PROJECT_REQUEST_STATUS->tbl_name . '';
	$status = $this->get_sql ( $sql );
	foreach ( $status as $status_det ){
		$selected = ( $status_det['id'] == $pr->status_id ) ? 'selected' : '';
		$status_opts .= '<option value="' . $status_det['id'] . '" ' . $selected . '>' . $status_det['short_name'] . '</option>';
	}
	//--------------------------------------------------------------------------
	if ( $pr->requested_user_id == get_current_user_id() || current_user_can_for_blog ( 1, 'csi_edit_others_project_request' ) ){

		$o.='
		<div class="container">
			<div class="panel panel-default row">
				<div class="panel-heading">
					<h1 class="panel-title">Editar Solicitud de Proyecto</h1>
				</div>
				<div class="panel-body">
					<h4>Información de la Solicitud</h4>
					<form class="form-horizontal" data-function="csi_pm_build_page_edit_project_request" data-next-page="showprojectrequest?r=' . $pr->id . '" style="position:relative;">
						<input type="hidden" name="id" id="id" value="' . $pr->id . '"/>
						<div class="form-group">
							<label for="customer_id" class="col-sm-2 control-label">Cliente</label>
							<div class="col-sm-10">
								<div class="input-group select2-bootstrap-append select2-bootstrap-prepend">
									<span class="input-group-addon small"><samp>&nbsp;&nbsp;&nbsp;Registrado</samp></span>
									<span class="input-group-addon">
										<input type="radio" name="registered_customer_flag" class="csi-switchable-radio-button" value="1" ' . ( $pr->registered_customer_flag ? 'checked' : '' ) . '>
									</span>
									<select name="registered_customer_id" class="form-control select2 ' . ( $pr->registered_customer_flag ? '' : 'disabled' ) . '" ' . ( $pr->registered_customer_flag ? '' : 'disabled' ) . ' required="true" data-placeholder="Selecciona el cliente registrado" tabindex="-1" aria-hidden="true">
										<option></option>
										' . $customer_opts . '
									</select>
								</div><!-- .input-group -->
								<div class="input-group">
									<span class="input-group-addon small"><samp>No registrado</samp></span>
									<span class="input-group-addon">
										<input type="radio" class="csi-switchable-radio-button" name="registered_customer_flag" value="0" ' . ( $pr->registered_customer_flag ? '' : 'checked' ) . '>
									</span>
									<input type="text" name="non_registered_customer_name" required="true" class="form-control ' . ( $pr->registered_customer_flag ? 'disabled' : '' ) . '" ' . ( $pr->registered_customer_flag ? 'disabled' : '' ) . ' placeholder="[Nombre de Cliente]" value="' . $pr->non_registered_customer_name . '">
								</div><!-- .input-group -->
								<p class="help-block">
									<small class="text-warning pull-right">(requerido)</small>
									Si el cliente no existe en nuestra Base de Datos (campo <strong>Cliente registrado</strong> puedes agregar la referencia con un texto que identifique al cliente.<br/>
									Por ejemplo: <i>Soluciones Industriales</i></p>
							</div>
						</div>
						<div class="form-group ">
							<label for="short_name" class="col-sm-2 control-label">Nombre del Proyecto</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="short_name" name="short_name" placeholder="Nombre del Proyecto" required="true" value="' . $pr->short_name . '">
								<p class="help-block">
									<small class="text-warning pull-right">(requerido)</small>
									Indicar el nombre descriptivo del Proyecto.<br>Tamaño máximo: 100 caracteres
								</p>
							</div>
						</div>
						<div class="form-group">
							<label for="description" class="col-sm-2 control-label">Descripción</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="description" name="description" placeholder="Descripción" required="true">' . $pr->description . '</textarea>
								<span class="help-block">
									<small class="text-warning pull-right">(requerido)</small>
									Descripción breve del Plan de Corrección o Mantenimiento.<br>
									<small>Tamaño máximo: 255 caracteres.</small>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label for="planned_start_date" class="col-sm-2 control-label">Fecha de Inicio</label>
							<div class="col-sm-10">
								<input type="text" class="form-control csi-date-range-input" id="planned_start_date" name="planned_start_date" data-single-date-picker="true" required="true" value="' . $planned_start_date->format('Y-m-d') . '"/>
								<span class="help-block">
									<small class="text-warning pull-right">(requerido)</small>
									Indica la fecha estimada de inicio del proyecto.
								</span>
							</div>
						</div>
						<div class="form-group">
							<label for="planned_end_date" class="col-sm-2 control-label">Fecha de Fin</label>
							<div class="col-sm-10">
								<input type="text" class="form-control csi-date-range-input" id="planned_end_date" name="planned_end_date" data-single-date-picker="true" required="true" value="' . $planned_end_date->format('Y-m-d') . '"/>
								<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
									Indica la fecha estimada de fin del proyecto.<br/>
								</span>
							</div>
						</div>';
		if ( current_user_can_for_blog ( 1, 'csi_edit_project_request_restricted_fields') ){
			$o.='
						<h4>PMO</h4>
						<div class="form-group">
							<label for="status_id" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10">
								<select id="status_id" name="status_id" class="form-control select2" data-placeholder="Selecciona el Status" required="true">
									<option></option>
									' . $status_opts . '
								</select>
								<span class="help-block">
									<small class="text-warning pull-right">(requerido)</small>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label for="pmo_comments" class="col-sm-2 control-label">Comentarios PMO</label>
							<div class="col-sm-10">
								<textarea id="pmo_comments" name="pmo_comments" class="form-control" placeholder="Comentarios de PMO">' . $pr->pmo_comments . '</textarea>
								<span class="help-block">
								</span>
							</div>
						</div>';
		}
		$o.='
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10 text-right">
								<button type="reset" class="btn btn-default"><i class="fa fa-fw fa-history"></i>Cancelar</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i>Guardar cambios</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div><!-- .container -->';
	}else{
		$o.=self::no_permissions_msg();
	}
	//--------------------------------------------------------------------------

	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_pm_build_page_edit_project_request(){
	//Globa Variables
	global $wpdb;
	//Local Variables
	$editArray			= array();
	$whereArray			= array();
	$response			= array();
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//self::write_log ( $post );
	$current_user		= get_userdata ( get_current_user_id() );
	$current_datetime	= new DateTime();
	if ( isset ( $post['planned_start_date'] ) ){
		$start_date = new DateTime ( $post['planned_start_date'] );
		$planned_start_date = $start_date->format('Y-m-d');
	}else{
		$planned_start_date = NULL;
	}
	if ( isset ( $post['planned_end_date'] ) ){
		$end_date = new DateTime ( $post['planned_end_date'] );
		$planned_end_date = $end_date->format('Y-m-d');
	}else{
		$planned_end_date = NULL;
	}

	$whereArray['id']							= intval ( $post['id'] );

	$editArray['registered_customer_flag']		= isset ( $post['registered_customer_flag'] ) && 1 == $post['registered_customer_flag'] ? 1 : NULL ;
	$editArray['registered_customer_id']		= isset ( $post['registered_customer_id'] ) ? intval ( $post['registered_customer_id'] ) : NULL;
	$editArray['non_registered_customer_name']	= isset ( $post['non_registered_customer_name'] ) ? strip_tags(stripslashes( $post['non_registered_customer_name'] ) ) : NULL;
	$editArray['short_name']					= strip_tags(stripslashes( $post['short_name'] ) );
	$editArray['description']					= strip_tags(stripslashes( $post['description'] ) );
	$editArray['planned_start_date']			= $planned_start_date;
	$editArray['planned_end_date']				= $planned_end_date;

	if ( current_user_can_for_blog ( 1, 'csi_edit_project_request_restricted_fields') ){
		$editArray['status_id']					= intval ( $post['status_id'] );
		$editArray['pmo_comments']				= strip_tags(stripslashes( $post['pmo_comments'] ) );
	}

	$editArray['last_modified_user_id']		= $current_user->ID;
	$editArray['last_modified_user_email']	= $current_user->user_email;
	$editArray['last_modified_datetime']	= $current_datetime->format('Y-m-d H:i:s');
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
		//$response['newId']				= '#!showissue?i=' . $post['issue_id'];
		//$response['newId']				= '#!ownissues';
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
public function csi_pm_new_pr_form(){
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_COUNTRY;
	//Local Variables
	$o				= '';
	$customer_opts	= '';
	//--------------------------------------------------------------------------
	$sql = 'SELECT id, short_name FROM ' . $NOVIS_CSI_COUNTRY->tbl_name . ' ORDER BY short_name';
	foreach ( $this->get_sql ( $sql ) as $country ){
		$customer_opts.='<optgroup label="' . $country['short_name'] . '">';
		$sql = 'SELECT id, short_name, code FROM ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' WHERE country_id="' . $country['id'] . '" ORDER BY short_name';
		foreach ( $this->get_sql ( $sql ) as $customer ){
			$customer_opts.='<option value="' . $customer['id'] . '">' . $customer['short_name'] . ' (' . strtoupper ( $customer['code'] ) . ')</option>';
		}
		$customer_opts.='</optgroup>';
	}
	//--------------------------------------------------------------------------
	$o.='
	<div class="container">
		<div class="panel panel-default row">
			<div class="panel-heading">
				<h1 class="panel-title">Crear Solicitud de Proyecto</h1>
			</div>
			<div class="panel-body">
				<div class="well well-sm">
					<p><kbd>Escribir algo interesante</kbd></p>
				</div>
				<form class="form-horizontal" data-function="csi_pm_new_pr" data-next-page="ownprojectrequest" style="position:relative;">
					<div class="form-group">
						<label for="customer_id" class="col-sm-2 control-label">Cliente</label>
						<div class="col-sm-10">
							<div class="input-group select2-bootstrap-append select2-bootstrap-prepend">
								<span class="input-group-addon"><samp>&nbsp;&nbsp;&nbsp;Registrado</samp></span>
								<span class="input-group-addon">
									<input type="radio" name="registered_customer_flag" class="csi-switchable-radio-button" value="1" checked>
								</span>
								<select name="registered_customer_id" class="form-control select2 " required="true" data-placeholder="Selecciona el cliente registrado" tabindex="-1" aria-hidden="true">
									<option></option>
									' . $customer_opts . '
								</select>
							</div><!-- .input-group -->
							<div class="input-group">
								<span class="input-group-addon"><samp>No registrado</samp></span>
								<span class="input-group-addon">
									<input type="radio" class="csi-switchable-radio-button" name="registered_customer_flag" value="0">
								</span>
								<input type="text" name="non_registered_customer_name" required="true" class="form-control disabled" disabled="" placeholder="[Nombre de Cliente]" value="">
							</div><!-- .input-group -->
							<p class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Si el cliente no existe en nuestra Base de Datos (campo <strong>Cliente registrado</strong> puedes agregar la referencia con un texto que identifique al cliente.<br/>
								Por ejemplo: <i>Soluciones Industriales</i></p>
						</div>
					</div>
					<div class="form-group ">
						<label for="short_name" class="col-sm-2 control-label">Nombre del Proyecto</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="short_name" name="short_name" placeholder="Nombre del Proyecto" required="true">
							<p class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Indicar el nombre descriptivo del Proyecto.<br>Tamaño máximo: 100 caracteres
							</p>
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">Descripción</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="description" name="description" placeholder="Descripción" required="true"></textarea>
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Descripción breve del Plan de Corrección o Mantenimiento.<br>
								<small>Tamaño máximo: 255 caracteres.</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="planned_start_date" class="col-sm-2 control-label">Fecha de Inicio</label>
						<div class="col-sm-10">
							<input type="text" class="form-control csi-date-range-input" id="planned_start_date" name="planned_start_date" data-single-date-picker="true" required="true"/>
							<span class="help-block">
								<small class="text-warning pull-right">(requerido)</small>
								Indica la fecha estimada de inicio del proyecto.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="planned_end_date" class="col-sm-2 control-label">Fecha de Fin</label>
						<div class="col-sm-10">
							<input type="text" class="form-control csi-date-range-input" id="planned_end_date" name="planned_end_date" data-single-date-picker="true" required="true"/>
							<span class="help-block">
							<small class="text-warning pull-right">(requerido)</small>
								Indica la fecha estimada de fin del proyecto.<br/>
							</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10 text-right">
							<button type="reset" class="btn btn-danger">Cancelar</button>
							<button type="submit" class="btn btn-primary">Crear Solicitud de Proyecto</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div><!-- .container -->';

	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_pm_build_page_own_project_request(){
	//Global Variables
	global $NOVIS_CSI_PROJECT_REQUEST_STATUS;
	global $NOVIS_CSI_CUSTOMER;
	//Local Variables
	$o				= '';
	$customer_opts	= '';
	//--------------------------------------------------------------------------
	$sql = '
		SELECT
			T00.id as id,
			T00.short_name as short_name,
			T00.requested_datetime as requested_date,
			T00.project_id as project_id,
			T01.short_name as status_name,
			T01.icon as status_icon,
			T01.css_class as status_class,
			IF ( T00.registered_customer_flag , T02.short_name, T00.non_registered_customer_name ) as customer_short_name
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_PROJECT_REQUEST_STATUS->tbl_name . ' as T01
				ON T00.status_id = T01.id
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T02
				ON T00.registered_customer_id = T02.id
		WHERE
			T00.requested_user_id = "' . get_current_user_id() . '"
		ORDER BY
			T00.requested_datetime ASC
		';
	$preqs = $this->get_sql ( $sql );
	//--------------------------------------------------------------------------
	$current_user			= get_userdata ( get_current_user_id() );
	$o.='
	<div class="container">
		<div class="page-header row">
			<h3 class="col-sm-10">Mis Solicitudes de Proyecto</h3>
			<h3 class="col-sm-2">
				<a href="#!newprojectrequest" class="btn btn-success">
					<i class="fa fa-plus"></i> Nueva Solicitud
				</a>
			</h3>
		</div>
		<div class="row">
			<table class="table">
				<thead>
					<tr>
						<th>Status <a href="#" class="csi-popup" data-action="csi_pm_popup_project_request_status_info"><i class="fa fa-fw fa-question-circle"></i></a></th>
						<th><span class="hidden-xs">Fecha de </span>Solicitud</th>
						<th>Cliente</th>
						<th>Nombre<span class="hidden-xs"> del Proyecto</span></th>
					</tr>
				</thead>
				<tbody>';
	foreach ( $preqs as $preq ){
		$request_date = new DateTime ( $preq['requested_date'] );
		$o.='
					<tr class="' . $preq['status_class'] . '">
						<td><i class="fa fa-fw fa-' . $preq['status_icon'] . '"></i><span class="hidden-xs">' . $preq['status_name'] . '</span></td>
						<td>' . $request_date->format('d/m/Y') . '</td>
						<td>' . $preq['customer_short_name'] . '</td>
						<td>
							<a href="#!showprojectrequest?r=' . $preq['id'] . '">
								<i class="fa fa-fw fa-arrows-alt"></i>' . $preq['short_name'] . '
							</a>
						</td>
					</tr>
		';
	}
	$o.='
				</tbody>
			</table>
		</div>
	</div><!-- .container -->';
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_pm_build_page_show_project_request(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_PROJECT_REQUEST_STATUS;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_USER;
	//Local Variables
	$response				= array();
	$o						= '';
	$current_user			= get_userdata ( get_current_user_id() );
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//--------------------------------------------------------------------------
	$pr_id = intval ( $post['r'] );
	$sql = '
	SELECT
		T00.id,
		T00.short_name as short_name,
		T00.description as description,
		T00.requested_datetime as requested_datetime,
		T00.requested_user_id,
		T00.last_modified_datetime as last_modified_datetime,
		T00.planned_start_date as planned_start_date,
		T00.planned_end_date as planned_end_date,
		T00.pmo_comments as pmo_comments,
		T01.short_name as status_name,
		T01.icon as status_icon,
		T01.css_class as status_class,
		IF ( T00.registered_customer_flag , T02.short_name, T00.non_registered_customer_name ) as customer_short_name,
		T04.display_name as requester_name,
		T06.display_name as modifier_name
	FROM
		' . $this->tbl_name . ' as T00
		LEFT JOIN ' . $NOVIS_CSI_PROJECT_REQUEST_STATUS->tbl_name . ' as T01
			ON T00.status_id = T01.id
		LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T02
			ON T00.registered_customer_id = T02.id
		LEFT JOIN ' . $NOVIS_CSI_USER->tbl_name . ' as T03
			ON T00.requested_user_id = T03.id
		LEFT JOIN ' . $wpdb->base_prefix . 'users as T04
			ON T03.id = T04.ID
		LEFT JOIN ' . $NOVIS_CSI_USER->tbl_name . ' as T05
			ON T00.last_modified_user_id = T05.id
		LEFT JOIN ' . $wpdb->base_prefix . 'users as T06
			ON T05.id = T06.ID
	WHERE
		T00.id = "' . $pr_id . '" ';
	$pr = $wpdb->get_row ( $sql );
	$request_datetime = new DateTime ( $pr->requested_datetime );
	$last_modif_datetime = new DateTime ( $pr->last_modified_datetime );
	$last_modif_datetime->setTimezone ( new DateTimeZone('America/Mexico_City') );
	$planned_start_date = new DateTime ( $pr->planned_start_date );
	$planned_end_date = new DateTime ( $pr->planned_end_date );
	//--------------------------------------------------------------------------
	//--------------------------------------------------------------------------
	//Execution
	$o.='
	<div class="container">
		<div class="page-header row">';
	if ( current_user_can_for_blog ( 1, 'csi_edit_project_request_restricted_fields') ){
		$o.='<a href="#!listprojectrequests" class="clearfix"><i class="fa fa-fw fa-angle-left"></i>Solicitudes de Proyecto</a>';
	}else{
		$o.='<a href="#!ownprojectrequest" class="clearfix"><i class="fa fa-fw fa-angle-left"></i>Mis Solicitudes de Proyecto</a>';
	}
	$o.='
			<h3 class="col-sm-10">Solicitud de Proyecto</h3>';
	if ( $pr->requested_user_id == get_current_user_id() || current_user_can_for_blog ( 1, 'csi_edit_others_project_request' ) ){
		$o.='
			<h3 class="col-sm-2">
				<a href="#!editprojectrequest?r=' . $pr->id . '" class="btn btn-default">
					<i class="fa fa-fw fa-pencil-square-o"></i> Editar Solicitud
				</a>
			</h3>';
	}
	$o.='
		</div>
		<h4>Informaci&oacute;n de la Solicitud de Proyecto</h4>
		<ul class="list-group row">
			<li class="list-group-item col-xs-12">
				<span class="col-sm-2 text-muted small"><strong>Solicitante</strong></span>
				<div class="col-sm-10">Solicitado por ' . $pr->requester_name . ' el ' . $request_datetime->format('d/m/Y') . '</div>
			</li>
			<li class="list-group-item col-xs-12">
				<span class="col-sm-2 text-muted small"><strong>Cliente</strong></span>
				<div class="col-sm-10">' . $pr->customer_short_name . '</div>
			</li>
			<li class="list-group-item col-xs-12">
				<span class="col-sm-2 text-muted small"><strong>Nombre del Proyecto</strong></span>
				<div class="col-sm-10">' . $pr->short_name . '</div>
			</li>
			<li class="list-group-item col-xs-12">
				<span class="col-sm-2 text-muted small"><strong>Descripci&oacute;n</strong></span>
				<div class="col-sm-10">' . nl2br ( $pr->description ) . '</div>
			</li>
			<li class="list-group-item col-xs-12">
				<span class="col-sm-2 text-muted small"><strong>Fechas de Proyecto</strong></span>
				<div class="col-sm-10">' . $planned_start_date->format('d/m/Y') . ' - ' . $planned_end_date->format('d/m/Y') . '</div>
			</li>
		</ul>
		<h4>Informaci&oacute;n de PMO</h4>
		<ul class="list-group row">
			<li class="list-group-item col-xs-12 list-group-item-' . $pr->status_class . '">
				<span class="col-sm-2 text-muted small">
					<strong>Status</strong>
					<a href="#" class="csi-popup" data-action="csi_pm_popup_project_request_status_info"><i class="fa fa-fw fa-question-circle"></i></a>
				</span>
				<div class="col-sm-10">
					<i class="fa fa-fw fa-' . $pr->status_icon . '"></i>' . $pr->status_name . '

				</div>
			</li>
			<li class="list-group-item col-xs-12">
				<span class="col-sm-2 text-muted small"><strong>&Uacute;ltima modificaci&oacute;n</strong></span>
				<div class="col-sm-10">' . $pr->modifier_name . ' ' . $last_modif_datetime->format('d/m/Y') . '</div>
			</li>
			<li class="list-group-item col-xs-12">
				<span class="col-sm-2 text-muted small"><strong>Comentarios PMO</strong></span>
				<div class="col-sm-10">' . $pr->pmo_comments . '</div>
			</li>
		</ul>
	</div>
	';
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_pm_new_pr(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_PROJECT_REQUEST_STATUS;
	//Local Variables
	$insertArray			= array();
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user			= get_userdata ( get_current_user_id() );
	$current_datetime		= new DateTime();
	//Execution
	if ( isset ( $post['planned_start_date'] ) ){
		$start_date = new DateTime ( $post['planned_start_date'] );
		$planned_start_date = $start_date->format('Y-m-d');
	}else{
		$planned_start_date = NULL;
	}
	if ( isset ( $post['planned_end_date'] ) ){
		$end_date = new DateTime ( $post['planned_end_date'] );
		$planned_end_date = $end_date->format('Y-m-d');
	}else{
		$planned_end_date = NULL;
	}
	$status_id = $wpdb->get_var ( 'SELECT id FROM ' . $NOVIS_CSI_PROJECT_REQUEST_STATUS->tbl_name . ' WHERE code ="' . $NOVIS_CSI_PROJECT_REQUEST_STATUS->default_status_code . '"');


	$insertArray['registered_customer_flag']	= isset ( $post['registered_customer_flag'] ) && 1 == $post['registered_customer_flag'] ? 1 : NULL ;
	$insertArray['registered_customer_id']		= isset ( $post['registered_customer_id'] ) ? intval ( $post['registered_customer_id'] ) : NULL;
	$insertArray['non_registered_customer_name']= isset ( $post['non_registered_customer_name'] ) ? strip_tags(stripslashes( $post['non_registered_customer_name'] ) ) : NULL;
	$insertArray['short_name']					= strip_tags(stripslashes( $post['short_name'] ) );
	$insertArray['description']					= strip_tags(stripslashes( $post['description'] ) );
	$insertArray['status_id']					= intval ( $status_id );
	$insertArray['planned_start_date']			= $planned_start_date;
	$insertArray['planned_end_date']			= $planned_end_date;
	$insertArray['requested_user_id']			= $current_user->ID;
	$insertArray['requested_user_email']		= $current_user->user_email;
	$insertArray['requested_datetime']			= $current_datetime->format('Y-m-d H:i:s');
	$insertArray['creation_user_id']			= $current_user->ID;
	$insertArray['creation_user_email']			= $current_user->user_email;
	$insertArray['creation_datetime']			= $current_datetime->format('Y-m-d H:i:s');
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
public function csi_pm_build_page_list_project_requests(){
	//Global Variables
	global $NOVIS_CSI_PROJECT_REQUEST_STATUS;
	global $NOVIS_CSI_CUSTOMER;
	//Local Variables
	$o				= '';
	$response		= array();
	//Execution
	$sql = '
		SELECT
			T00.id as id,
			T00.short_name as short_name,
			T00.requested_datetime as requested_date,
			T00.project_id as project_id,
			T01.short_name as status_name,
			T01.icon as status_icon,
			T01.css_class as status_class,
			IF ( T00.registered_customer_flag , T02.short_name, T00.non_registered_customer_name ) as customer_short_name
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_PROJECT_REQUEST_STATUS->tbl_name . ' as T01
				ON T00.status_id = T01.id
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T02
				ON T00.registered_customer_id = T02.id
		ORDER BY
			T00.requested_datetime DESC
		';
	$preqs = $this->get_sql ( $sql );
	//--------------------------------------------------------------------------
	$o.='
	<div class="container">
		<div class="page-header row">
			<h3>Solicitudes de Proyecto</h3>
		</div>
		<div class="row">
			<table class="table">
				<thead>
					<tr>
						<th>Status <a href="#" class="csi-popup" data-action="csi_pm_popup_project_request_status_info"><i class="fa fa-fw fa-question-circle"></i></a></th>
						<th>Solicitante</th>
						<th><span class="hidden-xs">Fecha de </span>Solicitud</th>
						<th>Cliente</th>
						<th>Nombre<span class="hidden-xs"> del Proyecto</span></th>
					</tr>
				</thead>
				<tbody>
	';
	foreach ( $preqs as $preq ){
		$request_date = new DateTime ( $preq['requested_date'] );
		$o.='
					<tr class="' . $preq['status_class'] . '">
						<td><i class="fa fa-fw fa-' . $preq['status_icon'] . '"></i><span class="hidden-xs">' . $preq['status_name'] . '</span></td>
						<td>' . $request_date->format('d/m/Y') . '</td>
						<td>Solicitante</td>
						<td>' . $preq['customer_short_name'] . '</td>
						<td>
							<a href="#!showprojectrequest?r=' . $preq['id'] . '">
								<i class="fa fa-fw fa-arrows-alt"></i>' . $preq['short_name'] . '
							</a>
						</td>
					</tr>
		';
	}

	$o.='
				</tbody>
			</table>
		</div>
	</div><!-- .container -->';
	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}

//END OF CLASS
}
global $NOVIS_CSI_PROJECT_REQUEST;
$NOVIS_CSI_PROJECT_REQUEST =new NOVIS_CSI_PROJECT_REQUEST_CLASS();
?>
