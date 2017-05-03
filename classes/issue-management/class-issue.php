<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_ISSUE_CLASS extends NOVIS_CSI_CLASS{
public $default_status_code			= 'draft';
public $more_info_link				= 'http://intranetmx.noviscorp.com/novis/kb/issues-mgmt/more-info/';
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
	$this->class_name	= 'issue';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Issue';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Issues';
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
	$this->db_version	= '0.0.5';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="
		(
			id bigint(20) unsigned not null auto_increment COMMENT 'Unique ID for each entry',
			issue_id bigint(20) unsigned not null COMMENT 'Unique ID for each issue',
			revision_id tinyint(1) unsigned not null DEFAULT 1 COMMENT 'Revision id',
			status_id tinyint(1) unsigned not null COMMENT 'ID of Issue status',
			rejected_comments tinytext null COMMENT 'Text if revision has been rejected',
			author_id bigint(20) unsigned not null COMMENT 'Id of author user',
			author_email varchar(100) not null COMMENT 'Email of author user',
			title tinytext not null COMMENT 'Title of Issue',
			summary text not null COMMENT 'Summary text of Issue',
			symptom text not null COMMENT 'Symptom text of Issue',
			terms text not null COMMENT 'Other terms text of Issue',
			reason text not null COMMENT 'Reason and prerequisites text of Issue',
			solution text not null COMMENT 'Solution text of Issue',
			documentation text not null COMMENT 'Documentation text of Issue',
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
			'user_input'				=>false,
		),
		'issue_id' => array(
			'form_help_text'			=>'El <i>Nú&uacute;mero de Nota</i> es el identificador asignado por el sistema a la <strong>Nota NOVIS</strong>.',
		),
		'revision_id' => array(
			'form_help_text'			=>'La <i>Revisi&oacute;n</i> es el identificador asignado por el sistema a la versi&oacute;n de la <strong>Nota NOVIS</strong>.',
		),
		'title' => array(
			'form_help_text'			=>'<small class="text-warning pull-right">(requerido)</small>El T&iacute;tulo de una <strong>Nota NOVIS</strong>, regularmente describe en breve el mensaje de error corto reflejado en el sistema.<br/>Tama&ntilde;o m&aacute;ximo: 255 caracteres.',
		),

		'last_modified_user_id' => array(
			'type'						=>'current_user_id',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Identificador de usuario solicitante.",
			'form_input_size'			=>false,
			'form_label'				=>"Identificador de usuario solicitante.",
			'form_options'				=>false,
			'form_placeholder'			=>"Identificador de usuario solicitante.",
			'form_special_form'			=>true,
			'form_show_field'			=>false,
			'user_input'				=>false,
		),
		'last_modified_date' => array(
			'type'						=>'date',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Fecha de Solicitud.",
			'form_input_size'			=>false,
			'form_label'				=>"Fecha de Solicitud.",
			'form_options'				=>false,
			'form_placeholder'			=>"Fecha de Solicitud.",
			'form_special_form'			=>false,
			'form_show_field'			=>false,
			'user_input'				=>false,
		),
		'last_modified_time' => array(
			'type'						=>'timestamp',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Hora de Solicitud.",
			'form_input_size'			=>false,
			'form_label'				=>"Hora de Solicitud.",
			'form_options'				=>false,
			'form_placeholder'			=>"Hora de Solicitud.",
			'form_special_form'			=>false,
			'form_show_field'			=>true,
			'user_input'				=>false,
		),
		'doc_link' => array(
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
			'form_help_text'			=>"Enlace a la documentaci&oacute;n.",
			'form_input_size'			=>false,
			'form_label'				=>"Enlace a la documentaci&oacute;n.",
			'form_options'				=>false,
			'form_placeholder'			=>"Enlace a la documentaci&oacute;n.",
			'form_special_form'			=>false,
			'form_show_field'			=>true,
			'user_input'				=>true,
		),
		'task_link' => array(
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
			'form_help_text'			=>"Enlace al detalle de las tareas del Proyecto.",
			'form_input_size'			=>false,
			'form_label'				=>"Enlace al detalle de las tareas del Proyecto.",
			'form_options'				=>false,
			'form_placeholder'			=>"Enlace al detalle de las tareas del Proyecto.",
			'form_special_form'			=>false,
			'form_show_field'			=>true,
			'user_input'				=>true,
		),
	);
	//register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install'							));
	add_action( 'plugins_loaded',								array( $this , 'db_install' )						);
	add_action( 'plugins_loaded',								array( $this , 'csi_define_capabilities' )			);
	//Add Ajax actions
	add_action( 'wp_ajax_csi_issue_build_page_intro', 			array( $this , 'csi_issue_build_page_intro'			));
	add_action( 'wp_ajax_csi_issue_create_issue', 				array( $this , 'csi_issue_create_issue'				));
	add_action( 'wp_ajax_csi_issue_create_issue_form', 			array( $this , 'csi_issue_create_issue_form'		));
	add_action( 'wp_ajax_csi_issue_edit_issue_form',			array( $this , 'csi_issue_edit_issue_form'			));
	add_action( 'wp_ajax_csi_issue_edit_issue', 				array( $this , 'csi_issue_edit_issue'				));
	add_action( 'wp_ajax_csi_issue_build_page_preview_issue_rev',array( $this , 'csi_issue_build_page_preview_issue_rev'));
	add_action( 'wp_ajax_csi_issue_build_page_search_issue', 	array( $this , 'csi_issue_build_page_search_issue'	));
	add_action( 'wp_ajax_csi_issue_filtered_issues',	 		array( $this , 'csi_issue_filtered_issues'			));
	add_action( 'wp_ajax_csi_issue_filtered_issues_pagination', array( $this , 'csi_issue_filtered_issues_pagination'));
	add_action( 'wp_ajax_csi_issue_build_page_show_issue', 		array( $this , 'csi_issue_build_page_show_issue'	));
	add_action( 'wp_ajax_csi_issue_new_issue_form_md_preview', 	array( $this , 'csi_issue_new_issue_form_md_preview'));
	add_action( 'wp_ajax_csi_issue_popup_markdown_info',	 	array( $this , 'csi_issue_popup_markdown_info'		));
	add_action( 'wp_ajax_csi_issue_my_issues',				 	array( $this , 'csi_issue_my_issues'				));
	add_action( 'wp_ajax_csi_issue_iab_list',				 	array( $this , 'csi_issue_iab_list'				));
	add_action( 'wp_ajax_csi_issue_reject_revision',			array( $this , 'csi_issue_reject_revision'		));
	add_action( 'wp_ajax_csi_issue_approve_revision',			array( $this , 'csi_issue_approve_revision'		));
	add_action( 'wp_ajax_csi_issue_create_revision',			array( $this , 'csi_issue_create_revision'		));
	add_action( 'wp_ajax_csi_issue_request_approval',			array( $this , 'csi_issue_request_approval'		));

}
public function csi_define_capabilities(){
	global $csi_capabilities;
	$class_cap = array(
		'name'	=> 'Issue MAnagement Capabilities',
		'caps'	=> array(
			'csi_issue_approve_revision',
		),
	);
	array_push ( $csi_capabilities, $class_cap);
}

public function csi_issue_popup_markdown_info(){
	//Global Variables
	global $NOVIS_CSI_CUSTOMER;
	//Local Variables
	$response			= array();
	$o = '';

	$sql = 'SELECT * FROM ' . $this->tbl_name . ' ';
	$task_types = $this->get_sql($sql);
	$o.='
	<p><a target="_blank" href="http://daringfireball.net/projects/markdown/">Markdown <i class="fa fa-external-link"></i></a> es un m&eacute;todo (sencillo y seguro) de poner estilos en la web.</p>

	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Estilo</th>
				<th>Sintaxis</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><strong>negrita</strong></td>
				<td>
					<pre>__negrita__</pre>
				</td>
			</tr>
			<tr>
				<td><i>it&aacute;lica</i></td>
				<td>
					<pre>_it&aacute;lica_</pre>
				</td>
			</tr>
			<tr>
				<td><code>c&oacute;digo</code></td>
				<td>
					<pre>`c&oacute;digo`</pre>
				</td>
			</tr>
			<tr>
				<td>Enlace</td>
				<td>[Google](http://www.google.com)</td>
			</tr>
			<tr>
				<td>
					Lista
					<ul>
						<li>Item 1</li>
						<li>Item 2
							<ul>
								<li>Item 2a</li>
								<li>Item 2b</li>
							</ul>
						</li>
					</ul>
				</td>
				<td>
<pre>* Item 1
* Item 2
  * Item 2a
  * Item 2b</pre>
				</td>
			</tr>
			<tr>
				<td>
					Tabla
					<table class="table">
						<thead>
							<tr><th>Header 1</th><th>Header 2</th></tr>
						</thead>
						<tbody>
							<tr><td>Cell 1</td><td>Cell 2</td></tr>
							<tr><td>Cell 3</td><td>Cell 4</td></tr>
						</tbody>
					</table>
				<td>
<pre>Header 1 | Header 2
------------ | -------------
Cell 1 | Cell 2
Cell 3 | Cell 4</pre>
				</td>
			</tr>
		</tbody>
	</table>';
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
		'title'				=> 'Markdown',
		'type'				=> 'blue',
	);

	echo json_encode($response);
	wp_die();
}
public function csi_issue_new_issue_form_md_preview(){
	//Global Variables
	//Loval Variables
	$pd = new Parsedown();
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//Execution
	$response['message']='
		<div class="panel panel-default">
			<div class="panel-body" style="min-height:100px;">
				<samp>
					' . $pd->text( $post['dataInput'] ) . '
				</samp>
			</div>
		</div>
		';
	$response['message'] = str_replace ( '<table>', '<table class="table">', $response['message']);
	echo json_encode($response);
	wp_die();
}
protected function csi_issue_new_issue_form_textarea ( $var = array() ){
	$ta='
	<div class="form-group ">
		<label for="' . $var['id'] . '" class="col-sm-2 control-label">' . $var['title'] . '</label>
		<div class="col-sm-10">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs">
				<li role="presentation" class="active">
					<a href="#csi-issue-input-' . $var['id'] . '" data-toggle="tab" data-function="editor">
						Escribir
					</a>
				</li>
				<li role="presentation">
					<a href="#csi-issue-preview-' . $var['id'] . '" data-toggle="tab" data-function="mdPreview" data-text-field="#' . $var['id'] . '" data-action="csi_issue_new_issue_form_md_preview">
						Previsualizar
					</a>
				</li>
			</ul><!-- .nav-tabs -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="csi-issue-input-' . $var['id'] . '">
					<div class="list-group" style="margin-bottom:0px;">
						<a href="#" class="list-group-item list-group-item-success small csi-popup" data-action="csi_issue_popup_markdown_info">
							Modo de edici&oacute;n: Markdown habilitado <i class="fa fa-question-circle"></i>
						</a>
					</div>
					<textarea class="form-control" id="' . $var['id'] . '" name="' . $var['id'] . '" placeholder="' . $var['placeholder'] . '" required="true" maxlength="' . $var['maxlength'] . '" rows="' . $var['rows'] . '">' . $var['value'] . '</textarea>
					<p class="help-block collapse in">
						<small class="text-warning pull-right">(requerido)</small>
						' . $var['help'] . '<br>Tamaño máximo: ' . $var['maxlength'] . ' caracteres
					</p>
				</div>
				<div role="tabpanel" class="tab-pane" id="csi-issue-preview-' . $var['id'] . '" style="position:relative;min-height:100px;" ></div>
			</div><!-- .tab-content -->
		</div><!-- .col-sm-10 -->
	</div><!-- .form-group -->
	';
	return $ta;
}
public function csi_issue_create_issue_form(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_USER_TEAM;
	global $NOVIS_CSI_ISSUE_STATUS;
	//Local Variables
	$o				= '';
	//--------------------------------------------------------------------------

	$o.='
	<div class="container">
		<div class="panel panel-default row">
			<div class="panel-heading">
				<h2 class="">Crear Nota NOVIS</h2>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="">
						<p class="text-justify">Para la publicar una <strong>Nota NOVIS</strong> debes seguir el <strong>flujo de aprobación de Notas NOVIS</strong>. Aqu&iacute; puedes comenzar a escribir una nueva nota y una vez que est&eacute; lista para publicar debes solicitar la aprobaci&oacute;n del Comit&eacute; de Notas NOVIS, desde la p&aacute;gina <a href="#!ownissues"><samp>Mis notas</samp></a>.</p>
						<p>Si tienes dudas o quieres aprender m&aacute;s puedes revisar la <a href="' . $this->more_info_link . '" target="_blank">documentaci&oacute;n de la Gesti&oacute;n de Base de Conocimiento - Notas NOVIS<i class="fa fa-fw fa-external-link"></i></a> en nuestra intranet.</p>
					</div>
				</div>
				<hr/>
				<form class="form-horizontal" data-function="csi_issue_create_issue" data-next-page="showissue" style="position:relative;">
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">T&iacute;tulo</label>
						<div class="col-sm-10">
							<input type="text" name="title" id="title" class="form-control" required="true" placeholder="T&iacute;tulo"/>
							<p class="help-block collapse in">
								' . $this->db_fields['title']['form_help_text'] . '
							</p>
						</div>
					</div>
	';
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'summary',
		'title'			=> 'Resumen',
		'placeholder'	=> 'Resumen',
		'maxlength'		=> 1000,
		'rows'			=> 6,
		'required'		=> true,
		'help'			=> 'El Resumen de una <strong>Nota NOVIS</strong> describe brevemente la situaci&oacute;n del error.',
		'value'			=> null,
	)) ;
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'symptom',
		'title'			=> 'S&iacute;ntomas',
		'placeholder'	=> 'S&iacute;ntomas',
		'maxlength'		=> 1000,
		'rows'			=> 6,
		'required'		=> true,
		'help'			=> 'El S&iacute;ntoma de una <strong>Nota NOVIS</strong> describe las diferentes situaciones que generan el error identificado.',
		'value'			=> null,
	)) ;
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'terms',
		'title'			=> 'Otros t&eacute;rminos',
		'placeholder'	=> 'Otros t&eacute;rminos',
		'maxlength'		=> 500,
		'rows'			=> 4,
		'required'		=> true,
		'help'			=> 'Otros T&eacute;rminos de una <strong>Nota NOVIS</strong> permite complementar la
		umentación utilizando palabras clave alternativas para el contenido. (e.g. Solution Manager; Solman; ).',
		'value'			=> null,
	)) ;
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'reason',
		'title'			=> 'Causa y Pre-Requisitos',
		'placeholder'	=> 'Causa y Pre-Requisitos',
		'maxlength'		=> 1000,
		'rows'			=> 6,
		'required'		=> true,
		'help'			=> 'Las Causas y Pre-Requisitos de una <strong>Nota NOVIS</strong> es la descripción detallada del entorno relacionado al error.',
		'value'			=> null,
	)) ;
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'solution',
		'title'			=> 'Soluci&oacute;n',
		'placeholder'	=> 'Soluci&oacute;n',
		'maxlength'		=> 1000,
		'rows'			=> 6,
		'required'		=> true,
		'help'			=> 'La Soluci&oacute;n de una <strong>Nota NOVIS</strong> describe las acciones requeridas para solventar el error. Es v&aacute;lido que las acciones no resuelvan la causa raíz del error y pueden proporcionar un mecanismo de <i>workaround</i>.',
		'value'			=> null,
	)) ;
	$o.=self::csi_issue_new_issue_form_textarea ( array(
		'id'			=> 'documentation',
		'title'			=> 'Documentaci&oacute;n',
		'placeholder'	=> 'Documentaci&oacute;n',
		'maxlength'		=> 1000,
		'rows'			=> 6,
		'required'		=> true,
		'help'			=> '<kbd>¿que ponemos aqui?</kbd>?',
		'value'			=> null,
	)) ;

	$o.='
					<!--
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Documentos Relacionados</label>
						<div class="col-sm-10">
							<div class="input-dynamic" data-dynamic-input="related-docs"></div>
							<div class="text-center"></div>
							<p class="help-block collapse in">
								Los Documentos Relacionados, son enlaces a diferentes documentos, notas SAP, u otros que sirvan como referencia a una <strong>Nota NOVIS</strong>. En caso de utilizar un documento creado para esta nota importante seguir la <a href="#" target="_blank">gu&iacute;a de Documentos Relacionados de una <strong>Nota NOVIS</strong><i class="fa fa-fw fa-external-link"></i></a>.
							</p>
						</div>
					</div>
					-->
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10 text-right">
							<button type="reset" class="btn btn-default ">
								<i class="fa fa-history"></i> Cancelar
							</button>
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-save"></i> Guardar
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div><!-- .container -->';
	/*
	$dynamic_fields=array(
		'related-docs'			=> array(
			'maxFields'		=> 5,
			'addButton'		=> '<button type="button" class="btn btn-sm btn-success" id="doc-plus"><i class="fa fa-plus"></i> Agregar Documento Relacionado</button>',
			'fieldBox'		=> '
				<p>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
						<input type="text" class="form-control" placeholder="T&iacute;tulo del documento" name="related-doc-title[]" required="true"/>
						<input type="text" class="form-control" placeholder="Descripci&oacute;n breve del documento" name="related-doc-description[]" required="true"/>
						<input type="text" class="form-control" placeholder="URL del Documento" name="related-doc-url[]" required="true"/>
						<button type="button" href="#" class="btn btn-danger btn-block btn-sm csi-delete-dynamic-field-button">
							<i class="fa fa-fw fa-times"></i>Eliminar Documento Relacionado
						</button>
					</div>
				</p>',
		),
	);
	$response['dynamicFields'] = $dynamic_fields;
	*/
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_issue_create_issue(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_ISSUE_STATUS;
	//Local Variables
	$insertArray			= array();
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user			= get_userdata ( get_current_user_id() );
	$current_datetime		= new DateTime();
	//Execution
	/*
	$doc_title				= isset ( $post['related-doc-title'] ) ? $post['related-doc-title'] : NULL ;
	$doc_description		= isset ( $post['related-doc-description'] ) ? $post['related-doc-description'] : NULL ;
	$doc_url				= isset ( $post['related-doc-url'] ) ? $post['related-doc-url'] : NULL ;
	*/
	$status_id = $wpdb->get_var ( 'SELECT id FROM ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' WHERE code ="' . $NOVIS_CSI_ISSUE_STATUS->default_status_code . '"');
	$last_issue_id = $wpdb->get_var ('SELECT issue_id FROM ' . $this->tbl_name . ' ORDER BY issue_id DESC LIMIT 1 ');

	$insertArray['issue_id']					= intval( $last_issue_id + 1 ) ;
	$insertArray['revision_id']					= 1;
	$insertArray['status_id']					= intval ( $status_id );
	$insertArray['author_id']					=  $current_user->ID;
	$insertArray['author_email']				=  $current_user->user_email;
	$insertArray['title']						= htmlentities ( $post['title']		);
	$insertArray['summary']						= htmlentities( $post['summary']	);
	$insertArray['symptom']						= htmlentities ( $post['symptom']	);
	$insertArray['terms']						= htmlentities ( $post['terms']		);
	$insertArray['reason']						= htmlentities ( $post['reason']	);
	$insertArray['solution']					= htmlentities ( $post['solution']	);
	$insertArray['documentation']				= htmlentities ( $post['documentation']	);

	$insertArray['creation_user_id']			= $current_user->ID;
	$insertArray['creation_user_email']			= $current_user->user_email;
	$insertArray['creation_date']				= $current_datetime->format('Y-m-d');
	$insertArray['creation_time']				= $current_datetime->format('H:i:s');
	//self::write_log ( $post );
	//self::write_log ( $insertArray );

	if ( $wpdb->insert( $this->tbl_name, $insertArray ) ){
		/*
		$response['id']=$wpdb->insert_id;
		$issue_id = $wpdb->insert_id;
		foreach ( $doc_title as $key => $doc ) {
			self::write_log ( $doc_title[$key] . ' - ' .$doc_description[$key] . ' - ' .$doc_url[$key] );
		}
		*/
		$response['postSubmitAction']	='changeHash';
		$response['newId']				= '#!ownissues';
		$response['notification']=array(
			'buttons'			=> array(
				'OK'			=> array(
					'text'		=> 'Entendido',
					'btnClass'	=> 'btn-success',
				),
			),
			'icon'				=> 'fa fa-check fa-sm',
			'closeIcon'			=> true,
			'columnClass'		=> 'large',
			'content'			=> 'Has agregado un nuevo ' . $this->name_single . ' exitosamente. (ID: <code>' . $this->nov_id ( $insertArray['issue_id'] ) . '</code>).<br/>No olvides agregar el <strong>Evento</strong> que causó la escritura de esta Nota Novis. En la sección inferior de la nota debes crear una nueva entrada con la información requerida.',
			'title'				=> 'Bien!',
			'type'				=> 'green',
			//'autoClose'			=> 'OK|3000',
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
public function csi_issue_build_page_search_issue(){
	//Global Variables
	global $NOVIS_CSI_ISSUE_STATUS;
	global $NOVIS_CSI_COUNTRY;
	//Local Variables
	$status_checkboxes		= '';
	//Execution
	//--------------------------------------------------------------------------
	$o='
	<div class="container">
		<div class="page-header row">
			<h2 class="">Notas Novis</h2>
			<p class="text-muted text-justify">Blablabla</p>
		</div>
		<div class="">
			<form class="form-horizontal" id="csi-issue-filtered-issues-form" data-target="#csi-issue-filtered-issues,#csi-issue-filtered-issues-pagination">
				<div class="form-group">
					<div class="input-group">
						<input type="text" required="true" class="form-control input-lg" id="issue_text" name="issue_text" placeholder="Introduce los t&eacute;rminos de b&uacute;squeda" />
						<div class="input-group-btn">
							<button type="submit" class="refresh-button btn btn-primary btn-lg btn-block" data-refresh-elements="#csi-issue-filtered-issues,#csi-issue-filtered-issues-pagination">
								<i class="fa fa-search"></i> Buscar
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="row">
			<div id="csi-issue-filtered-issues" class="table " data-action="csi_issue_filtered_issues" data-filter-form="#csi-issue-filtered-issues-form" style="position:relative;"></div>
			<div style="position:relative;">
				<div id="csi-issue-filtered-issues-pagination" class=" text-center" data-action="csi_issue_filtered_issues_pagination" data-filter-form="#csi-issue-filtered-issues-form"></div>
			</div>

		</div>
	</div>
	';
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_issue_filtered_issues(){
	//Global Variables
	global $NOVIS_CSI_ISSUE_EVENT;
	global $NOVIS_CSI_ISSUE_STATUS;
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_CUSTOMER;
	//Local Variables
	$o				= '';
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//self::write_log ( $post );
	//--------------------------------------------------------------------------
	$pd = new Parsedown();
	//--------------------------------------------------------------------------
	if ( isset ( $post['issue_text'] ) AND 0 != strlen ($post['issue_text'] ) ) {
		//----------------------------------------------------------------------
		$regex = '~"[^"]*"(*SKIP)(*F)|[ /]+~';
		$terms = preg_split ( $regex, $post['issue_text'] );
		$conditions = array();
		$results = self::csi_issue_filtered_issues_sql($post);
		//$results = $this->get_sql ( $sql );
		if ( 0 < $results['total_rows'] ){
			$o.='
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>Resultados</th>
					</tr>
				</thead>
				<tbody>';
			foreach ( $results['rows'] as $result ){
				//------------------------------------------------------------------
				switch ( $result['status_code'] ){
					case 'draft':
						$class = $result['status_class'];
						break;
					case 'obsolete':
						$class = $result['status_class'];
						break;
					default:
						$class = '';
				}
				//------------------------------------------------------------------
				$creation_date = new DateTime ( $result['creation_date'] );
				$modification_date = new DateTime ( $result['last_modified_date'] );
				//------------------------------------------------------------------
				$o.='
					<tr>
						<td class="' . $class . '">
							<h4>
								<a href="#!showissue?i=' . $this->nov_id ( $result['issue_id'] ) . '&issue_text=' . urlencode ( $post['issue_text'] ). '" target="_blank">
									' . $this->nov_id ( $result['issue_id'] ) . ' - ' . $result['title'] . '
								</a>
							</h4>
							<dl class="dl-horizontal">
								<dt>Resumen</dt>
								<dd><small>' . $pd->text( $result['summary'] ) . '</small></dd>
								<dt>Autor</dt>
								<dd>' . $result['display_name'] . '</dd>
								<dt>Creaci&oacute;n</dt>
								<dd>' . $creation_date->format('d-m-Y') . '</dd>
								<dt>Modificaci&oacute;n</dt>
								<dd>' . $modification_date->format('d-m-Y') . '</dd>
								<dt>Estado</dt>
								<dd><span class="text-' . $result['status_class'] . '"><i class="fa fa-' . $result['status_icon'] . '"></i> ' . $result['status_name'] . '</span></dd>
							</dl>
						</td>
					</tr>
				';
			}
			$o.='
				</tbody>
			</table>
			';
		}else{
			$o.='<div class="well">No hemos encontrado notas que coincidan con tu b&uacute;squeda.</div>';
		}
	}else{
		$o.='<div class="well">¿No has ingresado texto?</div>';
	}

	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
protected function csi_issue_filtered_issues_sql ( $post, $calculate_rows = TRUE ) {
	//Global Variables
	global $NOVIS_CSI_ISSUE_EVENT;
	global $NOVIS_CSI_ISSUE_STATUS;
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_USER;
	global $wpdb;
	//Local Variables
	$page_size			= 20;
	$page_no			= isset ( $post['pageNo'] ) ? intval ( $post['pageNo'] ) : 1 ;
	$results			= array();
	$conditions = array();
	$regex = '~"[^"]*"(*SKIP)(*F)|[ /]+~';
	//Execution
	$terms = preg_split ( $regex, $post['issue_text'] );

	$sql = '
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_ISSUE_EVENT->tbl_name . ' as T01
				ON T01.issue_id = T00.id
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T02
				ON T01.customer_id = T02.id
			LEFT JOIN ' . $NOVIS_CSI_USER->tbl_name . ' as T03
				ON T00.author_id = T03.id
			LEFT JOIN ' . $wpdb->base_prefix . 'users as T04
				ON T03.id = T04.ID
			LEFT JOIN ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' as T05
				ON T00.status_id = T05.id
		WHERE
			T05.released_flag AND
		';
	foreach ( $terms as $term ){
		$term = str_replace ( '\"', '', $term );
		$text='
			(
			UPPER(T00.title) LIKE UPPER("%' . $term . '%")
			OR UPPER(T00.summary) LIKE UPPER("%' . $term . '%")
			OR UPPER(T00.symptom) LIKE UPPER("%' . $term . '%")
			OR UPPER(T00.terms) LIKE UPPER("%' . $term . '%")
			OR UPPER(T00.reason) LIKE UPPER("%' . $term . '%")
			OR UPPER(T00.solution) LIKE UPPER("%' . $term . '%")
			OR UPPER(T00.documentation) LIKE UPPER("%' . $term . '%")
			OR UPPER(T02.short_name) LIKE UPPER("%' . $term . '%")
			OR UPPER(T02.code) LIKE UPPER("%' . $term . '%")
			)
		';
		array_push ( $conditions, $text );
	}
	$sql.=implode (' AND ', $conditions );
	$group_by=' GROUP BY T00.issue_id';
	//self::write_log ( $sql );
	$results['total_rows']	= $wpdb->get_var ( 'SELECT COUNT(T00.issue_id) as total ' . $sql );
	if ( $results['total_rows'] <= $page_size ){
		$page_no = 1;
	}
	if ( $calculate_rows ){
		$rows = 'SELECT T00.issue_id, T00.title, T00.creation_date, T00.last_modified_date, T00.summary , T04.display_name as display_name, T05.short_name as status_name, T05.code as status_code, T05.icon as status_icon, T05.css_class as status_class';
		$limit = ' LIMIT ' . ( $page_no - 1 ) * $page_size . ',' . $page_size ;
		$order = ' ORDER BY T00.creation_date DESC ';
		$results['rows']		= $this->get_sql (  $rows . $sql . $group_by . $order . $limit );
	}
	$results['pages']		= ceil ( $results['total_rows'] / $page_size );
	$results['page_no']		= $page_no;

	return $results;
}
public function csi_issue_filtered_issues_pagination(){
	//Global Variables

	//Local Variables
	$response		= array();
	$pagination		= '';
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;

	if ( isset ( $post['issue_text'] ) AND 0 != strlen ($post['issue_text'] ) ) {
		$results = self::csi_issue_filtered_issues_sql ( $post, FALSE ) ;
		//self::write_log( $post );
		$page_no = $results['page_no'];
		$page_count = $results['pages'];
		if ( $page_count > 1){
			$pagination.= '
			<nav aria-label="Page navigation">
				<ul class="pagination">
					<li class="' . ( ( $page_no <= 0 ) ? 'disabled' : '' ). '">
						<button data-refresh-elements="#csi-issue-filtered-issues,#csi-issue-filtered-issues-pagination" aria-label="Previous" data-page-no="' . strval ( ( $page_no <= 0 ) ? 0 :  $page_no ) . '" class="refresh-button btn btn-default btn-sm">
							<span aria-hidden="true">&laquo;</span>
						</button>
					</li>
			';
			for ( $i = 1 ; $i < $page_count ; $i++ ){
				$pagination.= '
					<li class="">
						<button data-refresh-elements="#csi-issue-filtered-issues,#csi-issue-filtered-issues-pagination" data-page-no="' . $i . '" class="refresh-button btn btn-' . ( $i == $page_no ? 'primary' : 'default' ). ' btn-sm">
							' .$i . '
						</button>
					</li>';
			}
			$pagination.='
					<li class="' . ( ( $page_no + 1 >= $page_count) ? 'disabled' : '' ) . '">
						<button data-refresh-elements="#csi-issue-filtered-issues,#csi-issue-filtered-issues-pagination" aria-label="Next" data-page-no="' . ( strval ( $page_no + 1 >= $page_count ) ? $page_count-1 : intval ( $page_no + 1 ) ). '" class="refresh-button btn btn-default btn-sm">
							<span aria-hidden="true">&raquo;</span>
						</button>
					</li>
				</ul>
			</nav>';
		}else{
			if ( 0 < $results['total_rows'] ){
				$pagination = '';
			}else{
				$pagination = '<i class="fa fa-2x fa-frown-o"></i>';
			}
		}

		$response['message'] = $pagination;
	}else{
		$response['message'] ='<i class="fa fa-2x fa-meh-o"></i>';
	}
	echo json_encode($response);
	wp_die();
}
public function csi_issue_build_page_preview_issue_rev(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_ISSUE_STATUS;
	//Local Variables
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$o					= '';
	$issue_id = preg_replace ( '/[^0-9]/', '', $post['i'] );
	//--------------------------------------------------------------------------
	$sql = '
		SELECT
			T00.*,
			T01.prevent_edition_flag,
			T01.css_class as status_class,
			T01.short_name as status_name,
			T01.icon as status_icon,
			T00.rejected_comments
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' as T01
				ON T00.status_id = T01.id
		WHERE
			T00.issue_id ="' . $issue_id . '"
		ORDER BY
			T00.revision_id DESC
		LIMIT 2
	';
	$issues = $this->get_sql ( $sql, 'OBJECT' );
	if ( 1 < sizeof ( $issues ) ){
		$issue = $issues[0];
		$old_issue = $issues[1];
		$have_old = TRUE;
	}else{
		$issue = $issues[0];
		$have_old = FALSE;
	}
	//--------------------------------------------------------------------------
	$pd = new Parsedown();
	//--------------------------------------------------------------------------
	$edit_link = '';

	//--------------------------------------------------------------------------
	foreach ( $issue as $key => $value ){
		switch ( $key ){
			case 'id':
			case 'revision_id':
			case 'author_id':
			case 'issue_id':
			case 'prevent_edition_flag':
			case 'status_id':
			case 'status_name':
			case 'status_class':
			case 'status_icon':
				break;
			default:
				if ( $have_old ){
					$old_text = $old_issue->$key ;
					$new_text = $issue->$key;
					$opcodes = FineDiff::getDiffOpcodes($old_text, $new_text,   FineDiff::$wordGranularity );
					$old_issue->$key = FineDiff::renderDiffToHTMLFromOpcodes($old_text, $opcodes);
					$old_issue->$key = $pd->text( $old_issue->$key );
					$old_issue->$key = str_replace ( '<table>', '<table class="table">', $old_issue->$key);

				}
				$issue->$key = $pd->text( $issue->$key );
				$issue->$key = str_replace ( '<table>', '<table class="table">', $issue->$key);
		}
	}
	//--------------------------------------------------------------------------
	$o = '
	<div class="container csi_issue_revision_comparison">
		<div class="row">
			<div class="alert alert-' . $issue->status_class . '">
				<p>La revisión se encuentra en estado: <i class="fa fa-fw fa-' . $issue->status_icon . '"></i>' . $issue->status_name . '</p>';
	if ( '' != $issue->rejected_comments){
		$o.='<p><strong>Comentarios de comeité</strong></p>';
		$o.='<p>' . $issue->rejected_comments . '</p>';
	}
	$o.='
			</div>
		</div>';
	if ( $have_old ){
		$o.='
		<!-- Nav tabs -->
		<ul class="nav nav-tabs nav-justified">
			<li role="presentation" class="active">
				<a href="#csi-issue-revision" data-toggle="tab">Previsualizaci&oacute;n</a>
			</li>
			<li role="presentation">
				<a href="#csi-issue-comparison" data-toggle="tab">Comparaci&oacute;n de Revisiones</a>
			</li>
		</ul><!-- .nav-tabs -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="csi-issue-revision">
		';
	}
	$o.='
				<div class="page-header row">
					<h3 class="">
						<samp class="col-sm-10">
							<p class="text-muted small">' . $this->nov_id( $issue->issue_id ) . '</p>
							' . $issue->title . '
						</samp>
					</h3>
				</div><!-- .page-header -->
				<div class="row csi-issue-display-note">
					<div id="csi-issue-summary">
						<div class="page-header">
							<h3 class=""><strong><samp>Resumen</samp></strong></h3>
						</div>
						<div class="text-justify"><samp>' . $issue->summary . '</samp></div>
					</div><!-- #csi-issue-summary -->
					<div id="csi-issue-symptom">
						<div class="page-header">
							<h3 class=""><strong><samp>Sintoma</samp></strong></h3>
						</div>
						<div class="text-justify"><samp>' . $issue->symptom . '</samp></div>
					</div><!-- #csi-issue-symptom -->
					<div id="csi-issue-terms">
						<div class="page-header">
							<h3 class=""><strong><samp>Otros Términos</samp></strong></h3>
						</div>
						<div class="text-justify"><samp>' . $issue->terms . '</samp></div>
					</div><!-- #csi-issue-terms -->
					<div id="csi-issue-reason">
						<div class="page-header">
							<h3 class=""><strong><samp>Causa y Pre-Requisitos</samp></strong></h3>
						</div>
						<div class="text-justify"><samp>' .  $issue->reason . '</samp></div>
					</div><!-- #csi-issue-reason -->
					<div id="csi-issue-solution">
						<div class="page-header">
							<h3 class=""><strong><samp>Solución</samp></strong></h3>
						</div>
						<div class="text-justify"><samp>' . $issue->solution . '</samp></div>
					</div><!-- #csi-issue-solution -->
					<div id="csi-issue-documentation">
						<div class="page-header">
							<h3 class=""><strong><samp>Documentaci&oacute;n</samp></strong></h3>
						</div>
						<div class="text-justify"><samp>' . $issue->documentation . '</samp></div>
					</div><!-- #csi-issue-documentation -->
				</div>
	';
	if ( $have_old ){
		$o.='
			</div>
			<div role="tabpanel" class="tab-pane" id="csi-issue-comparison">
				<div class="page-header row">
					<h3 class="">
						<samp class="col-sm-10">
							<p class="text-muted small">' . $this->nov_id( $issue->issue_id )  . '</p>
							' . $old_issue->title . '
						</samp>
					</h3>
				</div><!-- .page-header -->
				<div class="row csi-issue-display-note">
					<div id="csi-issue-summary">
						<div class="page-header">
							<h3 class=""><strong><samp>Resumen</samp></strong></h3>
						</div>
						<div class="text-justify"><samp>' . $old_issue->summary . '</samp></div>
					</div><!-- #csi-issue-summary -->
					<div id="csi-issue-symptom">
						<div class="page-header">
							<h3 class=""><strong><samp>Sintoma</samp></strong></h3>
						</div>
						<div class="text-justify"><samp>' . $old_issue->symptom . '</samp></div>
					</div><!-- #csi-issue-symptom -->
					<div id="csi-issue-terms">
						<div class="page-header">
							<h3 class=""><strong><samp>Otros Términos</samp></strong></h3>
						</div>
						<div class="text-justify"><samp>' . $old_issue->terms . '</samp></div>
					</div><!-- #csi-issue-terms -->
					<div id="csi-issue-reason">
						<div class="page-header">
							<h3 class=""><strong><samp>Causa y Pre-Requisitos</samp></strong></h3>
						</div>
						<div class="text-justify"><samp>' .  $old_issue->reason . '</samp></div>
					</div><!-- #csi-issue-reason -->
					<div id="csi-issue-solution">
						<div class="page-header">
							<h3 class=""><strong><samp>Solución</samp></strong></h3>
						</div>
						<div class="text-justify"><samp>' . $old_issue->solution . '</samp></div>
					</div><!-- #csi-issue-solution -->
					<div id="csi-issue-documentation">
						<div class="page-header">
							<h3 class=""><strong><samp>documentation</samp></strong></h3>
						</div>
						<div class="text-justify"><samp>' . $old_issue->documentation . '</samp></div>
					</div><!-- #csi-issue-documentation -->
				</div>
			</div>
		</div><!-- .tab-content -->
		<div id="csi-issue-event">
			<div class="page-header">
				<h3 class=""><strong><samp>Eventos</samp></strong></h3>
				<p class="help-block collapse in">Los <strong>eventos</strong> permiten registrar en que contexto se utilizó la Nota Novis, para futuras búsquedas de errores relacionados con clientes.</p>
				<p>Los eventos presentados a continuación son los eventos actuales de la <strong>Nota NOVIS</strong>, no se guardan eventos por revisi&oacute;n.</p>
			</div>
			<table class="refreshable table table-condensed" data-action="csi_fetch_issue_event_list_info" data-issue-id="' . $issue_id . '" id="csi-fetch-issue-event-list-info">
				<thead>
					<tr>
						<th class="col-xs-3">Cliente</th>
						<th class="col-xs-3">Sistema</th>
						<th class="col-xs-3">Ticket</th>
						<th class="col-xs-3">Fecha</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div><!-- #csi-issue-event -->
';
	}
	if ( $issue->author_id == get_current_user_id() && !$issue->prevent_edition_flag ){
		$o.='
		<div class="row" style="min-height:300px;">
			<form data-function="csi_issue_request_approval" data-next-page="ownissues" style="position:relative;">
				<input type="hidden" name="id" id="id" value="' . $issue->id . '"/>
				<input type="hidden" name="issue_id" id="issue_id" value="' . $issue->issue_id . '"/>
				<input type="hidden" name="revision_id" id="revision_id" value="' . $issue->revision_id . '"/>
				<p class="text-right">
					<button type="submit" class="btn btn-success">Solicitar aprobación</button>
				</p>
			</form>
		</div>
		';
	}
	if ( current_user_can_for_blog ( 1, 'csi_issue_approve_revision' ) && $issue->prevent_edition_flag) {
		//----------------------------------------------------------------------
		$sql = 'SELECT id FROM ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' WHERE code = "pending" ';
		$pending_id = $wpdb->get_var ( $sql );
		if ( $issue->status_id == $pending_id ){
			//------------------------------------------------------------------
			$sql = 'SELECT id FROM ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' WHERE code = "released" ';
			$approved_id = $wpdb->get_var ( $sql );
			//------------------------------------------------------------------
			$sql = 'SELECT id FROM ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' WHERE code = "rejected" ';
			$rejected_id = $wpdb->get_var ( $sql );
			$o.='
				<div class="row" style="min-height:300px;">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs nav-justified">
						<li role="presentation">
							<a href="#csi-issue-approve-form" data-toggle="tab">
								<p class="btn btn-success btn-block">Aprobar</p>
							</a>
						</li>
						<li role="presentation">
							<a href="#csi-issue-reject-form" data-toggle="tab">
								<p class="btn btn-danger btn-block">Rechazar</p>
							</a>
						</li>
					</ul><!-- .nav-tabs -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane alert alert-success" id="csi-issue-approve-form">
							<form class="form-horizontal" data-function="csi_issue_approve_revision" data-next-page="issueiab" style="position:relative;">
								<h4>Aprobar Nota Novis</h4>
								<input type="hidden" name="status_id" id="status_id" value="' . $approved_id . '"/>
								<input type="hidden" name="id" id="id" value="' . $issue->id . '"/>
								<input type="hidden" name="issue_id" id="issue_id" value="' . $issue->issue_id . '"/>
								<input type="hidden" name="revision_id" id="revision_id" value="' . $issue->revision_id . '"/>
								<p>El Comit&eacute; de Notas Novis ha decidido que esta nota cumple con las Reglas de aprobación de Notas Novis.</p>
								<p class="text-center">
									<button type="submit" class="btn btn-success">
										<i class="fa fa-fw fa-check"></i>Aprobado
									</button>
								</p>
							</form>
						</div>
						<div role="tabpanel" class="tab-pane alert alert-danger" id="csi-issue-reject-form">
							<form class="form-horizontal" data-function="csi_issue_reject_revision" data-next-page="issueiab" style="position:relative;">
								<h4>Rechazar Nota Novis</h4>
								<input type="hidden" name="status_id" id="status_id" value="' . $rejected_id . '"/>
								<input type="hidden" name="id" id="id" value="' . $issue->id . '"/>
								<input type="hidden" name="issue_id" id="issue_id" value="' . $issue->issue_id . '"/>
								<input type="hidden" name="revision_id" id="revision_id" value="' . $issue->revision_id . '"/>
								<p>El Comit&eacute; de Notas Novis ha decidido que esta nota <samp><strong>no</strong></samp> cumple con las Reglas de aprobación de Notas Novis.</p>
								<div class="form-group">
									<label for="" class="col-sm-2 control-label">Observaciones</label>
									<div class="col-sm-10">
										<textarea class="form-control" rows="4" placeholder="Motivos del rechazo" required="true" name="rejected_comments" id="rejected_comments"></textarea>
									</div>
								</div>
								<p class="text-center">
									<button type="submit" class="btn btn-danger">
										<i class="fa fa-fw fa-times"></i>Rechazado
									</button>
								</p>
							</form>
						</div>
					</div>
				</div>
			';
		}
	}
	$o.='
	</div><!-- .container -->
	';
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_issue_build_page_show_issue(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_ISSUE_STATUS;
	//Local Variables
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$o					= '';
	$issue_id = preg_replace ( '/[^0-9]/', '', $post['i'] );
	//--------------------------------------------------------------------------
	$sql = '
		SELECT
			T00.*
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' as T01
				ON T00.status_id = T01.id
		WHERE
			T00.issue_id ="' . $issue_id . '"
			AND T01.released_flag
		ORDER BY
			T00.revision_id DESC
		LIMIT
			1
	';
	$issue = $wpdb->get_row ( $sql );
	//--------------------------------------------------------------------------
	$pd = new Parsedown();
	//--------------------------------------------------------------------------
	$edit_link = '';

	//--------------------------------------------------------------------------
	foreach ( $issue as $key => $value ){
		switch ( $key ){
			case 'id':
			case 'revision_id':
			case 'author_id':
			case 'last_modified_date':
				break;
			case 'issue_id':
				$issue->$key = $this->nov_id ( $value );
				break;
			default:
				$issue->$key = $pd->text( $issue->$key );
				$issue->$key = str_replace ( '<table>', '<table class="table">', $issue->$key);
				if ( isset ( $post['issue_text'] ) AND 0 != strlen ($post['issue_text'] ) ) {
					$regex = '~"[^"]*"(*SKIP)(*F)|[ /]+~';
					$terms = preg_split ( $regex, urldecode ( $post['issue_text'] ) ) ;
					foreach ( $terms as $term ){
						//self::write_log (  urldecode ( $post['issue_text'] ));
						$conditions = array();
						$pattern = preg_quote($term);
						$issue->$key  = preg_replace("/($pattern)/i", '<mark>$1</mark>', $issue->$key);
					}
				}
		}
	}
	//--------------------------------------------------------------------------
	$o = '
	<div class="container">

		<div class="page-header row">
			<!--
			<a href="#!searchissues" class="hidden-print"><i class="fa fa-angle-left fa-fw"></i> Buscador de Notas Novis</a>
			-->
			<h3 class="">
				<samp class="col-sm-10">
					<p class="text-muted small">' . $issue->issue_id . '</p>
					' . $issue->title . '
				</samp>
	';
	if ( preg_replace ( '/[^0-9]/', '', $issue->author_id ) == get_current_user_id() ){
		$sql = '
			SELECT
				COUNT(T00.id) as rev,
				NOT(T01.prevent_edition_flag) as editable
			FROM
				' . $this->tbl_name . ' as T00
				LEFT JOIN ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' as T01
					ON T00.status_id = T01.id
			WHERE
				T00.issue_id = "' . preg_replace ( '/[^0-9]/', '', $issue->issue_id ) . '"
				AND T00.revision_id > "' . preg_replace ( '/[^0-9]/', '', $issue->revision_id ) . '"
			ORDER BY
				T00.revision_id DESC
			LIMIT
				1
		';
		$revision = $wpdb->get_row ( $sql );
		if ( $revision->rev ){
			if ( $revision->editable ){
				$o.='
				<p class="col-sm-2 text-right hidden-print">
				<a href="#!editissue?i=' . $this->nov_id( $issue_id ) . '" class="btn btn-default">
						<i class="fa fa-fw fa-pencil-square-o"></i>Rrevisi&oacute;n
					</a>
				</p>
				';
			}else{
				$o.='
				<p class="col-sm-2 text-right hidden-print">
					<a href="#!issuerevprev?i=' . $this->nov_id( $issue_id ) . '" class="btn btn-default">
						<i class="fa fa-fw fa-bolt"></i>Ver status de aprobaci&oacute;n
					</a>
				</p>
				';
			}
		}else{
			$o.='
				<form data-function="csi_issue_create_revision" style="position:relative;" class="col-sm-2 text-right hidden-print">
					<input type="hidden" name="i" id="i" value="' . $this->nov_id( $issue_id ) . '"/>
					<button type="submit" class="btn btn-default">
						<i class="fa fa-clone"></i> Crear revisi&oacute;n
					</button>
				</form>
			';
		}
	}
	$o.='
			</h3>
		</div><!-- .page-header -->
		<div class="row csi-issue-display-note">
			<div id="csi-issue-data">
				<table class="table">
					<thead>
						<tr>
							<th><i class="fa fa-fw fa-user"></i>Autor</th>
							<th><i class="fa fa-fw fa-clone"></i>Revisión</th>
							<th><i class="fa fa-fw fa-calendar"></i>Liberación</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><i class="fa fa-fw fa-angle-right"></i>Cristian Marin</td>
							<td><i class="fa fa-fw fa-angle-right"></i>' . $issue->revision_id . '</td>
							<td><i class="fa fa-fw fa-angle-right"></i>' . $issue->last_modified_date . '</td>
						</tr>
					</tbody>
				</table>
			</div><!-- #csi-issue-data -->
			<div id="csi-issue-summary">
				<div class="page-header">
					<h3 class=""><strong><samp>Resumen</samp></strong></h3>
				</div>
				<div class="text-justify"><samp>' . $issue->summary . '</samp></div>
			</div><!-- #csi-issue-summary -->
			<div id="csi-issue-symptom">
				<div class="page-header">
					<h3 class=""><strong><samp>Sintoma</samp></strong></h3>
				</div>
				<div class="text-justify"><samp>' . $issue->symptom . '</samp></div>
			</div><!-- #csi-issue-symptom -->
			<div id="csi-issue-terms">
				<div class="page-header">
					<h3 class=""><strong><samp>Otros Términos</samp></strong></h3>
				</div>
				<div class="text-justify"><samp>' . $issue->terms . '</samp></div>
			</div><!-- #csi-issue-terms -->
			<div id="csi-issue-reason">
				<div class="page-header">
					<h3 class=""><strong><samp>Causa y Pre-Requisitos</samp></strong></h3>
				</div>
				<div class="text-justify"><samp>' .  $issue->reason . '</samp></div>
			</div><!-- #csi-issue-reason -->
			<div id="csi-issue-solution">
				<div class="page-header">
					<h3 class=""><strong><samp>Solución</samp></strong></h3>
				</div>
				<div class="text-justify"><samp>' . $issue->solution . '</samp></div>
			</div><!-- #csi-issue-solution -->
			<div id="csi-issue-documentation">
				<div class="page-header">
					<h3 class=""><strong><samp>documentation</samp></strong></h3>
				</div>
				<div class="text-justify"><samp>' . $issue->documentation . '</samp></div>
			</div><!-- #csi-issue-documentation -->
			<div id="csi-issue-event">
				<div class="page-header">
					<h3 class=""><strong><samp>Eventos</samp></strong></h3>
					<p class="help-block collapse in">Los <strong>eventos</strong> permiten registrar en que contexto se utilizó la Nota Novis, para futuras búsquedas de errores relacionados con clientes.</p>
				</div>
				<table class="refreshable table table-condensed" data-action="csi_fetch_issue_event_list_info" data-issue-id="' . $issue_id . '" id="csi-fetch-issue-event-list-info">
					<thead>
						<tr>
							<th class="col-xs-3">Cliente</th>
							<th class="col-xs-3">Sistema</th>
							<th class="col-xs-3">Ticket</th>
							<th class="col-xs-3">Fecha</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div><!-- #csi-issue-event -->
		</div>
	</div><!-- .container -->

	';
	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_issue_build_page_intro(){
	//Global Variables
	//Local Variables
	$o					= '';
	//--------------------------------------------------------------------------
	$o.='
	<div class="jumbotron">
		<div class="container">
			<h2>Gestión de Notas Novis</h2>
			<p>:)</p>
			<p><a target="_blank" href="' . $this->more_info_link . '" class="btn btn-primary btn-lg" role="button">Aprender m&aacute;s</a></p>
		</div>
	</div><!-- .jumbotron -->
	<nav class="container">
		<div class="row">
			<div class="list-group col-sm-6 col-md-4">
				<a href="#!searchissues" class="list-group-item list-group-item-info">
					<h3><i class="fa fa-search"></i> Buscador de Notas</h3>
					<p class="text-justify">Notas Novis</p>
				</a>
			</div>
			<div class="list-group col-sm-6 col-md-4">
				<a href="#!addissue" class="list-group-item active">
					<h3><i class="fa fa-plus"></i> Crear nueva Nota</h3>
					<p class="text-justify">Nuevo</p>
				</a>
			</div>
			<!--
			<div class="list-group col-sm-6 col-md-4">
				<a href="#!pm_dashboard" class="list-group-item list-group-item-success">
					<h3><i class="fa fa-dashboard"></i> Dashboards</h3>
					<p class="text-justify">Vsitas pre-fabricadas para la gestión de Proyectos.</p>
				</a>
			</div>
			-->
			<div class="list-group col-sm-6 col-md-4">
				<a href="#!ownissues" class="list-group-item list-group-item-warning">
					<h3><i class="fa fa-plus"></i> Mis notas</h3>
					<p class="text-justify">visualiza las notas que has escrito</p>
				</a>
			</div>
	';
	if ( current_user_can_for_blog( 1, 'csi_issue_approve_revision') ){
		$o.='
			<div class="list-group col-sm-6 col-md-4">
				<a href="#!issueiab" class="list-group-item list-group-item-danger">
					<h3><i class="fa fa-users"></i> Comité de Aprobadores</h3>
					<p class="text-justify">Acciones para el Issue Advisory Board</p>
				</a>
			</div>
		';
	}
	$o.='
		</div>
	</nav><!-- .container -->
	';
	$response['message']=$o;
	echo json_encode($response);
	wp_die();

}
public function csi_issue_edit_issue_form(){
	//Global Variables
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_USER_TEAM;
	global $NOVIS_CSI_ISSUE_STATUS;
	global $wpdb;
	//Local Variables
	$o				= '';
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//--------------------------------------------------------------------------
	$issue_id = preg_replace ( '/[^0-9]/', '', $post['i'] );
	$sql = '
		SELECT
			T00.*
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' as T01
				ON T00.status_id = T01.id
		WHERE
			T00.issue_id ="' . $issue_id . '"
			AND NOT(T01.prevent_edition_flag)
		ORDER BY
			T00.revision_id ASC
		LIMIT
			1';
	$issue = $wpdb->get_row ( $sql );
	//--------------------------------------------------------------------------
	if ( $issue->author_id == get_current_user_id() ){
		$o.='
		<div class="container">
			<div class="panel panel-default row">
				<div class="panel-heading">
					<h2 class="">Editar Nota Novis</h2>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="">
							<p class="text-justify">Para la publicar una <strong>Nota NOVIS</strong> debes seguir el <strong>flujo de aprobación de Notas NOVIS</strong>. Aqu&iacute; puedes comenzar a escribir una nueva nota y una vez que est&eacute; lista para publicar debes solicitar la aprobaci&oacute;n del Comit&eacute; de Notas NOVIS, desde la p&aacute;gina <a href="#!ownissues"><samp>Mis notas</samp></a>.</p>
							<p>Si tienes dudas o quieres aprender m&aacute;s puedes revisar la <a href="' . $this->more_info_link . '" target="_blank">documentaci&oacute;n de la Gesti&oacute;n de Base de Conocimiento - Notas NOVIS<i class="fa fa-fw fa-external-link"></i></a> en nuestra intranet.</p>
							<button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target=".help-block" aria-expanded="false" aria-controls="collapseExample">
								Desactivar ayuda
							</button>
						</div>
					</div>
					<hr/>
					<form class="form-horizontal" data-function="csi_issue_edit_issue" style="position:relative;">
						<input type="hidden" name="id" id="id" value="' . $issue->id . '"/>
						<div class="form-group">
							<label class="col-sm-2 control-label">N&uacute;mero de nota</label>
							<div class="col-sm-10">
								<input type="text" class="form-control disabled" name="issue_id" id="issue_id" value="' . $this->nov_id ( $issue_id ) . '" style="text-align: right;" disabled/>
								<span class="help-block collapse in">' . $this->db_fields['issue_id']['form_help_text'] . '</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Revisi&oacute;n</label>
							<div class="col-sm-10">
								<input type="number" class="form-control disabled" name="revision_id" id="revision_id" value="' . $issue->revision_id . '" style="text-align: right;" disabled/>
								<span class="help-block collapse in">' . $this->db_fields['revision_id']['form_help_text'] . '</span>
							</div>
						</div>
						<div class="form-group">
							<label for="title" class="col-sm-2 control-label">T&iacute;tulo</label>
							<div class="col-sm-10">
								<input type="text" name="title" id="title" class="form-control" required="true" placeholder="T&iacute;tulo" value="' . $issue->title . '"/>
								<p class="help-block collapse in">' . $this->db_fields['title']['form_help_text'] . '</p>
							</div>
						</div>
		';
		$o.=self::csi_issue_new_issue_form_textarea ( array(
			'id'			=> 'summary',
			'title'			=> 'Resumen',
			'placeholder'	=> 'Resumen',
			'maxlength'		=> 1000,
			'rows'			=> 6,
			'required'		=> true,
			'help'			=> 'El Resumen de una <strong>Nota NOVIS</strong> describe brevemente la situaci&oacute;n del error.',
			'value'			=> $issue->summary,
		)) ;
		$o.=self::csi_issue_new_issue_form_textarea ( array(
			'id'			=> 'symptom',
			'title'			=> 'S&iacute;ntomas',
			'placeholder'	=> 'S&iacute;ntomas',
			'maxlength'		=> 1000,
			'rows'			=> 6,
			'required'		=> true,
			'help'			=> 'hola',
			'value'			=> $issue->symptom,
		)) ;
		$o.=self::csi_issue_new_issue_form_textarea ( array(
			'id'			=> 'terms',
			'title'			=> 'Otros t&eacute;rminos',
			'placeholder'	=> 'Otros t&eacute;rminos',
			'maxlength'		=> 500,
			'rows'			=> 4,
			'required'		=> true,
			'help'			=> 'hola',
			'value'			=> $issue->terms,
		)) ;
		$o.=self::csi_issue_new_issue_form_textarea ( array(
			'id'			=> 'reason',
			'title'			=> 'Causa y Pre-Requisitos',
			'placeholder'	=> 'Soluci&oacute;n',
			'maxlength'		=> 1000,
			'rows'			=> 6,
			'required'		=> true,
			'help'			=> 'hola',
			'value'			=> $issue->reason,
		)) ;
		$o.=self::csi_issue_new_issue_form_textarea ( array(
			'id'			=> 'solution',
			'title'			=> 'Soluci&oacute;n',
			'placeholder'	=> 'Soluci&oacute;n',
			'maxlength'		=> 1000,
			'rows'			=> 6,
			'required'		=> true,
			'help'			=> 'La Soluci&oacute;n de una <strong>Nota NOVIS</strong> describe las acciones requeridas para solventar el error. Es v&aacute;lido que las acciones no resuelvan la causa raíz del error y pueden proporcionar un mecanismo de <i>workaround</i>.',
			'value'			=> $issue->solution,
		)) ;
		$o.=self::csi_issue_new_issue_form_textarea ( array(
			'id'			=> 'documentation',
			'title'			=> 'documentation',
			'placeholder'	=> 'documentation',
			'maxlength'		=> 1000,
			'rows'			=> 6,
			'required'		=> true,
			'help'			=> '<kbd>fds</kbd>',
			'value'			=> $issue->documentation,
		)) ;
		$o.='
						<!--
						<div class="form-group">
							<label for="title" class="col-sm-2 control-label">Documentos Relacionados</label>
							<div class="col-sm-10">
								<div class="input-dynamic" data-dynamic-input="related-docs"></div>
								<div class="text-center"></div>
								<p class="help-block collapse in">
									Los Documentos Relacionados, son enlaces a diferentes documentos, notas SAP, u otros que sirvan como referencia a una <strong>Nota NOVIS</strong>. En caso de utilizar un documento creado para esta nota importante seguir la <a href="#" target="_blank">gu&iacute;a de Documentos Relacionados de una <strong>Nota NOVIS</strong><i class="fa fa-fw fa-external-link"></i></a>.
								</p>
							</div>
						</div>
						-->
						<div id="csi-issue-event">
							<div class="page-header">
								<h3 class=""><strong><samp>Eventos</samp></strong></h3>
								<p class="help-block collapse in">Los <strong>eventos</strong> permiten registrar en que contexto se utilizó la Nota Novis, para futuras búsquedas de errores relacionados con clientes.</p>
								<p>Los eventos presentados a continuación son los eventos actuales de la <strong>Nota NOVIS</strong>, no se guardan eventos por revisi&oacute;n.</p>
							</div>
							<table class="refreshable table table-condensed" data-action="csi_fetch_issue_event_list_info" data-issue-id="' . $issue_id . '" id="csi-fetch-issue-event-list-info">
								<thead>
									<tr>
										<th class="col-xs-3">Cliente</th>
										<th class="col-xs-3">Sistema</th>
										<th class="col-xs-3">Ticket</th>
										<th class="col-xs-3">Fecha</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div><!-- #csi-issue-event -->
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10 text-right">
								<button type="reset" class="btn btn-default"><i class="fa fa-fw fa-history"></i>Cancelar</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i>Guardar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div><!-- .container -->';
		/*
		$dynamic_fields=array(
			'related-docs'			=> array(
				'maxFields'		=> 5,
				'addButton'		=> '<button type="button" class="btn btn-sm btn-success" id="doc-plus"><i class="fa fa-plus"></i> Agregar Documento Relacionado</button>',
				'fieldBox'		=> '
					<p>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
							<input type="text" class="form-control" placeholder="T&iacute;tulo del documento" name="related-doc-title[]" required="true"/>
							<input type="text" class="form-control" placeholder="Descripci&oacute;n breve del documento" name="related-doc-description[]" required="true"/>
							<input type="text" class="form-control" placeholder="URL del Documento" name="related-doc-url[]" required="true"/>
							<button type="button" href="#" class="btn btn-danger btn-block btn-sm csi-delete-dynamic-field-button">
								<i class="fa fa-fw fa-times"></i>Eliminar Documento Relacionado
							</button>
						</div>
					</p>',
			),
		);
		$response['dynamicFields'] = $dynamic_fields;
		*/
	}else{
		$o.= self::no_permissions_msg();
	}

	$response['message']=$o;
	echo json_encode($response);
	wp_die();
}
public function csi_issue_request_approval(){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_ISSUE_STATUS;
	//Local Variables
	$editArray			= array();
	$whereArray			= array();
	$response			= array();
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$revision_id		= intval ( preg_replace ( '/[^0-9]/', '',	$post['revision_id'] ) );
	$issue_id			= intval ( preg_replace ( '/[^0-9]/', '',	$post['issue_id'] ) );
	$id					= intval ( preg_replace ( '/[^0-9]/', '',	$post['id'] ) );

	$sql = '
		SELECT
			T00.id,
			T00.author_id,
			T01.prevent_edition_flag
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' as T01
				ON T00.status_id = T01.id
		WHERE
			T00.id			="' . $id . '" AND
			T00.issue_id	="' . $issue_id . '" AND
			T00.revision_id	="' . $revision_id . '"
	';
	$revision = $wpdb->get_row ( $sql );
	//self::write_log ( $post );
	//self::write_log ( $revision );

	if ( $revision->author_id == get_current_user_id() && !$revision->prevent_edition_flag ){

		$current_user		= get_userdata ( get_current_user_id() );
		$current_datetime	= new DateTime();
		$status_id = $wpdb->get_var ( 'SELECT id FROM ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' WHERE code ="' . $NOVIS_CSI_ISSUE_STATUS->default_approval_code . '"');

		$whereArray['id']						= $id;
		$whereArray['issue_id']					= $issue_id;
		$whereArray['revision_id']				= $revision_id;

		$editArray['status_id']					= intval ( $status_id );

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
			$response['postSubmitAction']	='changeHash';
			//$response['newId']				= '#!showissue?i=' . $post['issue_id'];
			$response['newId']				= '#!ownissues';
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
				'content'			=> 'Has solicitado la aprobaci&oacute;n de la nueva revisi&oacute;n.',
				'title'				=> 'Bien!',
				'type'				=> 'green',
				'autoClose'			=> 'OK|3000',
			);
		}
	}else{
		$response['error']=true;
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
}
public function csi_issue_edit_issue(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_ISSUE_STATUS;
	//Local Variables
	$editArray			= array();
	$whereArray			= array();
	$response			= array();
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$sql = '
		SELECT
			T00.id,
			T00.author_id,
			T01.prevent_edition_flag
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' as T01
				ON T00.status_id = T01.id
		WHERE
			T00.id ="' . intval ( $post['id'] ) . '"
	';
	$revision = $wpdb->get_row ( $sql );
	if ( $revision->author_id == get_current_user_id() && !$revision->prevent_edition_flag ){

		$current_user		= get_userdata ( get_current_user_id() );
		$current_datetime	= new DateTime();

		$whereArray['id']						= intval ( $post['id'] );
		$whereArray['issue_id']					= intval ( preg_replace ( '/[^0-9]/', '', $post['issue_id'] ) );
		$whereArray['revision_id']				= intval ( $post['revision_id'] );

		$editArray['title']						= htmlentities ( $post['title'] ) ;
		$editArray['summary']					= htmlentities ( $post['summary'] );
		$editArray['symptom']					= htmlentities ( $post['symptom'] );
		$editArray['terms']						= htmlentities ( $post['terms'] );
		$editArray['reason']					= htmlentities ( $post['reason'] );
		$editArray['solution']					= htmlentities ( $post['solution'] );
		$editArray['documentation']				= htmlentities ( $post['documentation'] );

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
			$response['postSubmitAction']	='changeHash';
			//$response['newId']				= '#!showissue?i=' . $post['issue_id'];
			$response['newId']				= '#!ownissues';
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
	}else{
		$response['error']=true;
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
}// csi_edit_project_entrance
protected function csi_issue_check_manager_user ( ) {
	//Global Variables
	global $NOVIS_CSI_USER;
	//Local Variables
	$current_user			= get_userdata ( get_current_user_id() );
	//Execution
	$sql = '
		SELECT
			*
		FROM
			' . $NOVIS_CSI_USER->tbl_name . ' as T00
			LEFT JOIN ' . $wpdb->base_prefix . 'users as T04
				ON T03.id = T04.ID
			LEFT JOIN ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' as T05
				ON T00.status_id = T05.id
		WHERE
			T00.id = ' . get_current_user_id() . '
			AND T00.team_manager_flag = "1"
			AND T00.active_flag = "1"
	';
}
public function csi_issue_my_issues(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_ISSUE_STATUS;
	//Local Variables
	$response			= array();
	$o					= '';
	//Execution
	$o.='
	<div class="container">
		<div class="page-header row">
			<h2 class="">Mis Notas <small>Revisiones</small></h2>
		</div>
		<div class="row">
			<p class="text-justify">La siguinete tabla muestra las <strong>Notas NOVIS</strong> que has escrito.</p>
			<div class="alert alert-info">
				Recuerda que una nota suele tener revisiones (correcciones o mejoras) que deben ser aprobadas por el <i>Comit&eacute; de Notas NOVIS</i>.<br/>
				Los colores de cada fila representan los status<a href="#" class="csi-popup alert-link" data-action="csi_issue_popup_issue_status_info"><i class="fa fa-fw fa-question-circle"></i></a> de las revisiones m&aacute;s nuevas.
			</div>
		</div>
		<div class="row">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Nota Novis</th>
						<th class="hidden-xs">Liberada</th>
						<th class="hidden-xs">Revisiones</th>
						<th class="hidden-xs">Status de &uacute;ltima revisi&oacute;n</th>
						<th class="text-right">Acciones</th>
					</tr>
				</thead>
				<tbody>';
	$sql = '
		SELECT
			T00.issue_id,
		    T00.title,
		    COUNT(DISTINCT T00.revision_id) as revisions,
			SUM(IF(T01.released_flag = 1,1,0)) as released,
			SUM(IF(NOT(T01.prevent_edition_flag) = 1,1,0)) as editable,
			SUM(IF(T01.revision_requested_flag = 1,1,0)) as pending,
		    last_rev.css_class as status_class,
			last_rev.short_name as status_name,
			last_rev.icon as status_icon
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' as T01
				ON T00.status_id = T01.id
			LEFT JOIN (
				SELECT
					T00.issue_id,
					T01.css_class,
					T01.short_name,
					T01.icon
				FROM
					' . $this->tbl_name . ' as T00
					LEFT JOIN ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' as T01
						ON T00.status_id = T01.id
					ORDER BY
						revision_id DESC
				) as last_rev
				ON last_rev.issue_id = T00.issue_id
		WHERE
			author_id = "' . get_current_user_id() . '"
		GROUP BY
			T00.issue_id
		ORDER BY
			T00.last_modified_date DESC,
			T00.last_modified_time DESC,
			T00.creation_date DESC,
			T00.creation_time DESC
	';

	//self::write_log ( $sql );
	$issues = $this->get_sql ( $sql );
	foreach ( $issues as $issue ){
		$o.='
					<tr>
						<td class="">
							' . $this->nov_id ( $issue['issue_id'] ) . '<br/>
							' . $issue['title'] . '
						</td>
						<td>
							<i class="fa fa-fw fa-' . ( $issue['released'] ? 'check-square-o' : 'square-o' ) .'"></i>
						</td>
						<td class="hidden-xs">' . $issue['revisions'] . '</td>
						<td class="' . $issue['status_class'] . '">
							<i class="fa fa-fw fa-' . $issue['status_icon'] . '"></i>' . $issue['status_name'] . '
						</td>
						<td class="text-right">
							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" id="own_issues_' . $issue['issue_id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									Acciones<i class="fa fa-fw fa-caret-down"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="own_issues_' . $issue['issue_id'] . '">
		';
		if ( $issue['released'] ){
			$o.='<li>
					<a href="#!showissue?i=' . $this->nov_id ( $issue['issue_id'] ) . '" >
						<i class="fa fa-fw fa-file-text-o"></i>Ver revisi&oacute;n liberada
					</a>
				</li>';
		}
		if ( $issue['editable'] ){
			$o.='<li>
					<a href="#!editissue?i=' . $this->nov_id ( $issue['issue_id'] ) . '">
						<i class="fa fa-fw fa-pencil-square-o"></i>Editar revisi&oacute;n en curso
					</a>
				</li>';
		}
		if ( !$issue['editable'] && $issue['released'] && !$issue['pending'] ){
			$o.='<li>
					<form data-function="csi_issue_create_revision" style="position:relative;" class="col-sm-2 text-right hidden-print">
						<input type="hidden" name="i" id="i" value="' . $this->nov_id( $issue['issue_id'] ) . '"/>
						<button type="submit" class="btn btn-default">
							<i class="fa fa-clone"></i> Crear revisi&oacute;n
						</button>
					</form>
				</li>';
		}
		if ( $issue['pending'] ){
			$o.='<li>
					<a href="#!issuerevprev?i=' . $this->nov_id ( $issue['issue_id'] ) . '">
						<i class="fa fa-fw fa-bolt"></i>Consultar estado de aprobaci&oacute;n
					</a>
				</li>';
		}
		if ( $issue['editable'] ){
			$o.='<li role="separator" class="divider"></li>
				<li>
					<a href="#!issuerevprev?i=' . $this->nov_id ( $issue['issue_id'] ) . '">
						<i class="fa fa-fw fa-bolt"></i>Solicitar aprobaci&oacute;n de revisi&oacute;n
					</a>
				</li>';
		}
		$o.='

								</ul>
							</div>
						</td>
					</tr>
		';
	}
	$o.='
				</tbody>
			</table>
		</div>
	</div>
	';
	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
public function csi_issue_iab_list(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_ISSUE_STATUS;
	global $NOVIS_CSI_USER;
	//Local Variables
	$response			= array();
	$o					= '';
	//Execution
	if ( current_user_can_for_blog ( 1, 'csi_issue_approve_revision' ) ) {
		$sql = '
			SELECT
				T00.issue_id,
				T00.author_id,
				T00.title,
				T00.last_modified_date,
				T00.last_modified_time,
				COUNT(T00.revision_id) as revisions,
				SUM(IF(T01.code="pending", 1, 0)) as pending,
				SUM(IF(T01.released_flag = 1,1,0)) as released,
				SUM(IF(NOT(T01.prevent_edition_flag) = 1,1,0)) as editable,
				T03.display_name as author_name
			FROM
				' . $this->tbl_name . ' as T00
				LEFT JOIN ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' as T01
					ON T00.status_id = T01.id
				LEFT JOIN ' . $NOVIS_CSI_USER->tbl_name . ' as T02
					ON T00.author_id = T02.id
				LEFT JOIN ' . $wpdb->base_prefix . 'users as T03
					ON T02.id = T03.ID
			GROUP BY
				T00.issue_id
			ORDER BY
				T00.last_modified_date ASC,
				T00.last_modified_time ASC
		';
		$requests = $this->get_sql ( $sql );
		$o.='
		<div class="container">
			<div class="page-header row">
				<h2 class="">Lista de revisiones en espera de aprobaci&oacute;n</h2>
				<p class="text-muted text-justify">El siguiente listado permite que el <i>Comit&eacute; de Notas NOVIS</i> eval&uacute;e y autorice/rechace solicitudes de aprobaci&oacute;n.</p>
			</div>
			<div class="row">
				<table class="table">
					<thead>
						<tr>
							<th>Nota Novis</th>
							<th>Autor</th>
							<th>Liberada</th>
							<th class="hidden-xs">Revisiones</th>
							<th>Fecha de Solicitud</th>
						</tr>
					</thead>
					<tbody>';
		foreach ( $requests as $request ){
			if ( $request['pending'] ){
				$last_modified = new DateTime ( $request['last_modified_date'] . ' ' . $request['last_modified_time']);
				$last_modified->setTimezone ( new DateTimeZone('America/Mexico_City') );
				$o.='
							<tr>
								<td>
									<a href="#!issuerevprev?i=' . $this->nov_id ( $request['issue_id'] ) . '">
										' . $this->nov_id ( $request['issue_id'] ) . '<br/>
										' . $request['title'] . '
									</a>
								</td>
								<td>' . $request['author_name'] . '</td>
								<td><i class="fa fa-fw fa-' . ( $request['released'] ? 'check-square-o' : 'square-o' ) .'"></i></td>
								<td class="hidden-xs">' . $request['revisions'] . '</td>
								<td class="small">' . $last_modified->format('d/m/Y H:i:s') . '</td>
							</tr>
				';
			}
		}
		$o.='
					</tbody>
				</table>
			</div>
		</div>';
	}else{
		$o.=self::no_permissions_msg();
	}

	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
public function csi_issue_approve_revision(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_ISSUE_STATUS;
	//Local Variables
	$editArray			= array();
	$whereArray			= array();
	$response			= array();
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//self::write_log ( $post );
	if ( current_user_can_for_blog ( 1, 'csi_issue_approve_revision' ) ) {

		$current_user		= get_userdata ( get_current_user_id() );
		$current_datetime	= new DateTime();

		$whereArray['id']						= intval ( $post['id'] );
		$whereArray['issue_id']					= intval ( preg_replace ( '/[^0-9]/', '', $post['issue_id'] ) );
		$whereArray['revision_id']				= intval ( $post['revision_id'] );

		$editArray['status_id']					= intval ( $post['status_id'] );
		if ( isset ( $post['rejected_comments'] ) ){
			$editArray['rejected_comments']		= htmlentities ( $post['rejected_comments'] );
		}

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
		}else{
			$response['postSubmitAction']	='changeHash';
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
	}else{
		$response['error']=true;
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
}
public function csi_issue_reject_revision(){
	self::csi_issue_approve_revision();
}
public function csi_issue_create_revision(){
	//Globa Variables
	global $wpdb;
	global $NOVIS_CSI_ISSUE_STATUS;
	//Local Variables
	$insertArray			= array();
	$post= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	$current_user			= get_userdata ( get_current_user_id() );
	$current_datetime		= new DateTime();
	//Execution
	$issue_id = preg_replace ( '/[^0-9]/', '', $post['i'] );
	$sql = '
		SELECT
			T00.*,
			T01.released_flag as released
		FROM
			' . $this->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' as T01
				ON T00.status_id = T01.id
		WHERE issue_id = "' . $issue_id . '" ORDER BY revision_id DESC LIMIT 1';
	$issue = $wpdb->get_row ( $sql );
	self::write_log ( $issue );
	if ( $issue->released && $issue->author_id == get_current_user_id() ){
		$status_id = $wpdb->get_var ( 'SELECT id FROM ' . $NOVIS_CSI_ISSUE_STATUS->tbl_name . ' WHERE code ="' . $NOVIS_CSI_ISSUE_STATUS->default_status_code . '"');

		$insertArray['issue_id']					= intval( $issue_id ) ;
		$insertArray['revision_id']					= intval ( $issue->revision_id + 1 );
		$insertArray['status_id']					= intval ( $status_id );
		$insertArray['author_id']					=  $current_user->ID;
		$insertArray['author_email']				=  $current_user->user_email;
		$insertArray['title']						= htmlentities ( $issue->title		);
		$insertArray['summary']						= htmlentities ( $issue->summary	);
		$insertArray['symptom']						= htmlentities ( $issue->symptom	);
		$insertArray['terms']						= htmlentities ( $issue->terms		);
		$insertArray['reason']						= htmlentities ( $issue->reason		);
		$insertArray['solution']					= htmlentities ( $issue->solution	);
		$insertArray['documentation']				= htmlentities ( $issue->documentation	);

		$insertArray['creation_user_id']			= $current_user->ID;
		$insertArray['creation_user_email']			= $current_user->user_email;
		$insertArray['creation_date']				= $current_datetime->format('Y-m-d');
		$insertArray['creation_time']				= $current_datetime->format('H:i:s');
		if ( $wpdb->insert( $this->tbl_name, $insertArray ) ){
			$response['postSubmitAction']	='changeHash';
			$response['newId']				= '#!editissue?i=' . $this->nov_id ( $issue_id );
			$response['notification']=array(
				'buttons'			=> array(
					'OK'			=> array(
						'text'		=> 'Entendido',
						'btnClass'	=> 'btn-success',
					),
				),
				'icon'				=> 'fa fa-check fa-sm',
				'closeIcon'			=> true,
				'columnClass'		=> 'large',
				'content'			=> 'Has creado una nueva revisi&oacute;n (ID: <code>' . $insertArray['revision_id'] . '</code>).',
				'title'				=> 'Bien!',
				'type'				=> 'green',
				//'autoClose'			=> 'OK|3000',
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
			'content'			=> 'No existe una revisi&oacute;n liberada de la nota ' . $this->nov_id ($issue_id) . '.<br/>Para crear una nueva revisi&oacute;n, la Nota NOVIS debe estar liberada.',
			'title'				=> 'Error!',
			'type'				=> 'red',
		);
	}
	echo json_encode($response);
	wp_die();
}

protected function nov_id ( $value ) {
	return 'NOV' . (string) str_pad ( $value, 5, '0', STR_PAD_LEFT);
}
//END OF CLASS

}
global $NOVIS_CSI_ISSUE;
$NOVIS_CSI_ISSUE =new NOVIS_CSI_ISSUE_CLASS();
?>
