<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_PROJECT_INVOICE_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'project_invoice';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Factura de Proyecto';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Facturas de Proyecto';
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
	$this->db_version	= '0.0.3';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="
		(
			id tinyint(2) unsigned not null auto_increment COMMENT 'Unique ID for each entry',
			project_id bigint(20) unsigned not null COMMENT 'ID of project',
			reg_date date not null COMMENT 'Date of reference',
			text tinytext not null COMMENT 'Invoice text',
			flag_resolved tinyint(1) null COMMENT 'Indicates if invoice has been resolved',
			bill varchar(20) null COMMENT 'Billing info',
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
	add_action( 'plugins_loaded',								array( $this , 'db_install' )						);
	add_action( 'plugins_loaded',								array( $this , 'csi_define_capabilities' )			);

	add_action( 'wp_ajax_csi_fetch_project_invoice_list_info',		array( $this , 'csi_fetch_project_invoice_list_info'));
	add_action( 'wp_ajax_csi_create_project_invoice',				array( $this , 'csi_create_project_invoice'		));
	add_action( 'wp_ajax_csi_create_project_invoice_form',			array( $this , 'csi_create_project_invoice_form'	));
	add_action( 'wp_ajax_csi_edit_project_invoice',				array( $this , 'csi_edit_project_invoice'			));
	add_action( 'wp_ajax_csi_edit_project_invoice_form',			array( $this , 'csi_edit_project_invoice_form'		));
	add_action( 'wp_ajax_csi_delete_project_invoice',				array( $this , 'csi_delete_project_invoice'		));


}
public function csi_define_capabilities(){
	global $csi_capabilities;
	$class_cap = array(
		'name'	=> 'Project Invoice Capabilities',
		'caps'	=> array(
			'csi_pm_manage_project_invoices',
		),
	);
	array_push ( $csi_capabilities, $class_cap);

}
public function csi_fetch_project_invoice_list_info(){
	//Globa Variables
	global $wpdb;
	//Local Variables
	$response			= array();
	$o					= '';
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$project_id = $post['projectId'];
	$page_no			= NULL;
	$page_count			= NULL;
	$page_size			= 5;
	$page_no	= isset ( $post['pageNo'] ) ? intval ( $post['pageNo'] ) : 0 ;
	$count_sql	= 'SELECT COUNT(DISTINCT id) as total FROM ' . $this->tbl_name . ' WHERE project_id="' . $project_id .'" ';
	$total_invoices= $wpdb->get_var ( $count_sql );
	$page_count	= ceil ( $total_invoices / $page_size );
	if ( $page_no >= $page_count ){
		$page_no			= 0;
	}
	//--------------------------------------------------------------------------
	$sql = 'SELECT
				T00.*
			FROM
				' . $this->tbl_name . ' as T00
			WHERE
				T00.project_id="' . $project_id . '"
			ORDER BY
				T00.reg_date DESC
			LIMIT ' . $page_no * $page_size . ',' . $page_size . '
	';
	$project_invoices = $this->get_sql ( $sql );
	//--------------------------------------------------------------------------
	if ( current_user_can_for_blog( 1, 'csi_pm_manage_project_invoices') ){
		$o.='
		<tr class="hidden-print">
			<td colspan="999" class="">
				<a href="#" class="in-table-form-button btn btn-success btn-xs" data-action="csi_create_project_invoice_form" data-project-id="' . $project_id . '">
					<i class="fa fa-plus"></i> Agregar hito de facturaci&oacute;n
				</a>
			</td>
		</tr>
		';
	}
	//--------------------------------------------------------------------------
	foreach ( $project_invoices as $project_invoice ){
		//----------------------------------------------------------------------
		$reg_date = new DateTime ( $project_invoice['reg_date'] );
		//----------------------------------------------------------------------
		$o.='
			<tr>
				<td class="col-xs-1">';
		if ( current_user_can_for_blog( 1, 'csi_pm_manage_project_invoices') ){
			$o.='
					<a href="#" class="in-table-form-button hidden-print" data-action="csi_edit_project_invoice_form" data-invoice-id="' . $project_invoice['id'] . '">
						<i class="fa fa-fw fa-edit"></i>
					</a>';
		}else{
			$o.='	&nbsp;';
		}
		$o.='	</td>
				<td class="small col-xs-2">' . $reg_date->format('d-m-Y') . '</td>
				<td class="small col-xs-2">' . $project_invoice['bill'] . '</td>
				<td class="col-xs-1"><i class="fa fa-fw fa-' . ( $project_invoice['flag_resolved'] ? 'check-square-o' : 'square-o' ) . '"></i></td>
				<td class="small col-xs-6">' .  nl2br ( $project_invoice['text'] ) . '</td>
			</tr>
		';
	}
	//Pagination
	if ( 1 < $page_count  ){
		$o.='
				<tr>
					<td colspan="999" class="text-center">
						<nav aria-label="Page navigation">
							<ul class="pagination" style="margin:auto;">
								<li class="' . ( ( $page_no <= 0 ) ? 'disabled' : '' ). '">
									<a href="#" aria-label="Previous" data-page-no="' . strval ( ( $page_no <= 0 ) ? 0 : intval ( $page_no - 1 ) ) . '">
										<span aria-hidden="true">&laquo;</span>
									</a>
								</li>
					';
		for ( $i = 0 ; $i < $page_count ; $i++ ){
			$o.= '			<li class="' . ( $i == $page_no ? 'active' : '' ). '">
									<a href="#" data-page-no="' . $i . '">' . strval ( intval ($i + 1 ) ) . '</a>
								</li>
			';
		}
		$o.='
								<li class="' . ( ( $page_no + 1 >= $page_count) ? 'disabled' : '' ) . '">
									<a href="#" aria-label="Next" data-page-no="' . ( strval ( $page_no + 1 >= $page_count ) ? $page_count-1 : intval ( $page_no + 1 ) ). '">
										<span aria-hidden="true">&raquo;</span>
									</a>
								</li>
							</ul>
						</nav>
					</td>
				</tr>
		';
	}
	$response['tbody']		= $o;

	echo json_encode($response);
	wp_die();
}

public function csi_create_project_invoice(){
	//Globa Variables
	global $wpdb;
	//Local Variables
	$insertArray			= array();
	$response			= array();
	$post				= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user		= get_userdata ( get_current_user_id() );
	$current_datetime	= new DateTime();
	$reg_date			= new DateTime ( $post['reg_date'] );

	if ( current_user_can_for_blog( 1, 'csi_pm_manage_project_invoices') ){
		$insertArray['project_id']				= htmlentities( $post['project_id'] );
		$insertArray['bill']					= htmlentities ( $post['bill'] );
		$insertArray['text']					= htmlentities ( $post['text'] );
		$insertArray['reg_date']				= $reg_date->format ( 'Y-m-d' );
		$insertArray['flag_resolved']			= isset ( $post['flag_resolved'] ) && 1 == $post['flag_resolved'] ? 1 : 0 ;

		$insertArray['creation_user_id']		= $current_user->ID;
		$insertArray['creation_user_email']		= $current_user->user_email;
		$insertArray['creation_datetime']		= $current_datetime->format('Y-m-d H:i:s');
		//	self::write_log ( $post );
		//	self::write_log ( $insertArray );
		if ( $wpdb->insert( $this->tbl_name, $insertArray ) ){
			$response['id']=$wpdb->insert_id;
			$plan_id = $wpdb->insert_id;
			//crear registro de Ejecutores
			$response['postSubmitAction']	='refreshParent';
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
			);
		}
	}else{
				$response['postSubmitAction']	='changeURL';
		$response['newUrl'] = 'https://www.fbi.gov/investigate/cyber';
		$response['notification']=array(
			'buttons'			=> array(
				'OK'			=> array(
					'text'		=> ':( Lo siento',
					'btnClass'	=> 'btn-danger',
				),
			),
			'icon'				=> 'fa fa-exclamation-circle fa-sm',
			'closeIcon'			=> true,
			'columnClass'		=> 'large',
			'content'			=> 'Estás tratando de hacer trampa. Que verg&uuml;enza',
			'title'				=> 'Cuidado!',
			'type'				=> 'red',
		);
	}
	echo json_encode($response);
	wp_die();
}// csi_create_project_invoice

public function csi_create_project_invoice_form(){
	//Globa Variables
	global $wpdb;
	//Local Variables
	$o						= '';
	$date_time_input_opts	= '';
	$response				= array();
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_datetime 		= new DateTime();
	if ( current_user_can_for_blog( 1, 'csi_pm_manage_project_invoices') ){
		//----------------------------------------------------------------------
		$o='<div class="row">
			<form class="in-table-form" data-function="csi_create_project_invoice">
				<input type="hidden" name="project_id" value="' . $post['projectId'] . '"/>
				<div class="col-sm-1">&nbsp;</div>
				<div class="col-sm-2">
					<div class="row">
						<label for="reg_date" class="col-xs-12 visible-xs">Fecha</label>
						<div class="col-xs-12">
							<input type="text" name="reg_date" id="reg_date" class="form-control input-sm csi-date-range-input" required="true" value="' . $current_datetime->format('Y-m-d') . '" data-single-date-picker="true" data-drops="up"/>
							<p class="help-block"></p>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="row">
						<label for="bill" class="col-xs-12 visible-xs">Monto de Facturaci&oacute;n</label>
						<div class="col-xs-12">
							<input type="text" name="bill" class="form-control" required="true" />
							<p class="help-block"></p>
						</div>
					</div>
				</div>
				<div class="col-sm-1">
					<div class="row">
						<label class="col-xs-12 visible-xs">Finalizado</label>
						<div class="col-xs-12">
							<input type="checkbox" class="form-control csi-cool-checkbox" id="flag_resolved" name="flag_resolved" value="1"/>
							<label for="flag_resolved">&nbsp;</label>
							<p class="help-block"></p>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="row">
						<label for="text" class="col-xs-12 visible-xs">Texto</label>
						<div class="col-xs-12">
							<input type="text" name="text" id="text" class="form-control input-sm" required="true" maxlength="20" />
							<p class="help-block small">Tama&ntilde;o m&aacute;ximo: 20 caracteres</p>
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="text-right">
						<button type="button" class="btn btn-default in-table-form-cancel"><i class="fa fa-history"></i> Cancelar</button>
						<button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Agregar hito de facturaci&oacute;n</button>
					</div>
				</div>
			</form>
			</div>
		';
	}else{
		$o.=self::no_permissions_msg();
	}

	$response['message']	= $o;
	echo json_encode($response);
	wp_die();
}// csi_create_project_invoice_form

public function csi_edit_project_invoice(){
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
	if ( current_user_can_for_blog( 1, 'csi_pm_manage_project_invoices') ){
		$whereArray['id']						= intval ( $post['project_invoice_id'] );

		$editArray['reg_date']					= $reg_date->format('Y-m-d');
		$editArray['bill']						= htmlentities( $post['bill'] );
		$editArray['text']						= htmlentities( $post['text'] );

		$editArray['flag_resolved']				= isset ( $post['flag_resolved'] )  ? 1 : 0 ;
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
			$response['postSubmitAction']	='refreshParent';
		}
	}else{
				$response['postSubmitAction']	='changeURL';
		$response['newUrl'] = 'https://www.fbi.gov/investigate/cyber';
		$response['notification']=array(
			'buttons'			=> array(
				'OK'			=> array(
					'text'		=> ':( Lo siento',
					'btnClass'	=> 'btn-danger',
				),
			),
			'icon'				=> 'fa fa-exclamation-circle fa-sm',
			'closeIcon'			=> true,
			'columnClass'		=> 'large',
			'content'			=> 'Estás tratando de hacer trampa. Que verg&uuml;enza',
			'title'				=> 'Cuidado!',
			'type'				=> 'red',
		);
	}
	echo json_encode($response);
	wp_die();
}// csi_edit_project_invoice

public function csi_edit_project_invoice_form(){
	//Globa Variables
	global $wpdb;
	//Local Variables
	$date_time_input_opts	='';
	$response				= array();
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	if ( current_user_can_for_blog( 1, 'csi_pm_manage_project_invoices') ){
		//----------------------------------------------------------------------
		$sql ='SELECT * FROM ' . $this->tbl_name . ' WHERE id="' . $post['invoiceId'] . '"';
		$invoice = $wpdb->get_row ( $sql );
		//--------------------------------------------------------------------------
		$o='<div class="row">
			<form class="in-table-form" data-function="csi_edit_project_invoice">
				<input type="hidden" name="project_invoice_id" value="' . $invoice->id . '"/>
				<div class="col-sm-1">&nbsp;</div>
				<div class="col-sm-2">
					<div class="row">
						<label for="reg_date" class="col-xs-12 visible-xs">Fecha</label>
						<div class="col-xs-12">
							<input type="text" name="reg_date" id="reg_date" class="form-control input-sm csi-date-range-input" required="true" value="' . $invoice->reg_date . '" data-single-date-picker="true" data-drops="up"/>
							<p class="help-block"></p>
						</div>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="row">
						<label for="bill" class="col-xs-12 visible-xs">Monto de Facturaci&oacute;n</label>
						<div class="col-xs-12">
							<input type="text" name="bill" class="form-control" required="true" />
							<p class="help-block"></p>
						</div>
					</div>
				</div>
				<div class="col-sm-1">
					<div class="row">
						<label class="col-xs-12 visible-xs">Resoluci&oacute;n</label>
						<div class="col-xs-12">
							<input type="checkbox" class="form-control csi-cool-checkbox" id="flag_resolved" name="flag_resolved" value="1" ' . ( $invoice->flag_resolved ? 'checked' : '' ) . '/>
							<label for="flag_resolved">&nbsp;</label>
							<p class="help-block"></p>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="row">
						<label for="text" class="col-xs-12 visible-xs">Texto</label>
						<div class="col-xs-12">
							<input type="ext" name="text" id="text" class="form-control input-sm" required="true" maxlength="20" value="' . $invoice->text . '" />
							<p class="help-block small">Tama&ntilde;o m&aacute;ximo: 20 caracteres</p>
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="text-right">
						<div class="pull-left">
							<button type="button" class="btn btn-danger in-table-form-delete" data-action="csi_delete_project_invoice" data-content="¿Est&aacute;s seguro que quieres eliminar este hito de facturaci&oacute;n del proyecto? <pre>' . $invoice->text . '</pre>" data-type="red" data-column-class="xlarge">
								<i class="fa fa-trash"></i> Eliminar
							</button>
						</div>
						<button type="button" class="btn btn-default in-table-form-cancel">
							<i class="fa fa-history"></i> Cancelar
						</button>
						<button type="submit" class="btn btn-warning">
							<i class="fa fa-pencil"></i> Editar hito de facturaci&oacute;n
						</button>
					</div>
				</div>
			</form>
			</div>
		';
	}else{
		$o.=self::no_permissions_msg();
	}

	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}// csi_edit_project_invoice_form

public function csi_delete_project_invoice(){
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
	$whereArray['id']						= intval ( $post['project_invoice_id'] );
	if ( current_user_can_for_blog( 1, 'csi_pm_manage_project_invoices') ){
		$result = $wpdb->delete ( $this->tbl_name, $whereArray );
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
				'content'			=> 'Hubo un error al eliminar el ' . $this->name_single . '; intenta nuevamente. :)',
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
				'content'			=> 'No hay ' . $this->name_single . ' que eliminar',
				'title'				=> 'Bien!',
				'type'				=> 'orange',
				'autoClose'			=> 'OK|3000',
			);
		}else{
			$response['postSubmitAction']	='refreshParent';
		}
	}else{
				$response['postSubmitAction']	='changeURL';
		$response['newUrl'] = 'https://www.fbi.gov/investigate/cyber';
		$response['notification']=array(
			'buttons'			=> array(
				'OK'			=> array(
					'text'		=> ':( Lo siento',
					'btnClass'	=> 'btn-danger',
				),
			),
			'icon'				=> 'fa fa-exclamation-circle fa-sm',
			'closeIcon'			=> true,
			'columnClass'		=> 'large',
			'content'			=> 'Estás tratando de hacer trampa. Que verg&uuml;enza',
			'title'				=> 'Cuidado!',
			'type'				=> 'red',
		);
	}
	echo json_encode($response);
	wp_die();
}// csi_edit_project_invoice

//END OF CLASS
}

global $NOVIS_CSI_PROJECT_INVOICE;
$NOVIS_CSI_PROJECT_INVOICE =new NOVIS_CSI_PROJECT_INVOICE_CLASS();
?>
