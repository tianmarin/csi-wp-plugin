<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_PROJECT_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'project';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Proyecto';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Proyecto';
	//Identificador de menú padre
	$this->parent_slug	= $novis_csi_vars['network_menu_slug'];
	//Identificador de submenú de la clase
	$this->menu_slug	= $novis_csi_vars[$this->class_name.'_menu_slug'];
	//Utilizadp para validaciones
	$this->plugin_post	= $novis_csi_vars['plugin_post'];
	//Permisos de usuario a nivel de backend WordPRess
	$this->capability	= $novis_csi_vars[$this->class_name.'_menu_cap'];
	//Tabla de la clase
	$this->tbl_name		= $novis_csi_vars[$this->class_name.'_tbl_name'];
	//Versión de DB (para registro y actualización automática)
	$this->db_version	= '0.2';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql	=	"CREATE TABLE ".$this->tbl_name." (
								id bigint(20) unsigned not null auto_increment,
								customer_id bigint unsigned not null,
								customer_name varchar(50) not null,
								short_name varchar(100) not null,
								description text not null,
								requested_user_id bigint(20) unsigned not null,
								requested_date date not null,
								requested_time time not null,
								requested_start_date date null,
								requested_end_date date null,
								requested_urgency_id tinyint(2) unsigned not null,
								status_id tinyint(2) unsigned not null,
								planned_start_date date null,
								planned_end_date date null,
								percentage tinyint(2) unsigned not null DEFAULT '0',
								last_modified_user_id bigint(20) unsigned null,
								last_modified_date date null,
								last_modified_time time null,
								doc_link varchar(255) null,
								task_link varchar(255) null,
								UNIQUE KEY id (id)
							) $charset_collate;";
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
		),
		'customer_id' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>true,
			'backend_wp_table_lead'		=>true,
			'data_required'				=>false,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>'disabled',
			'form_help_text'			=>"El ID de Cliente debe ser desplegado de la lista actual. Por ahora está deshabilitado",
			'form_input_size'			=>false,
			'form_label'				=>'Cliente',
			'form_options'				=>false,
			'form_placeholder'			=>'Cliente',
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'customer_name' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>true,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>50,
			'form_disabled'				=>false,
			'form_help_text'			=>'En el caso que el cliente no esté registrado, indicar el nombre del cliente para el cual se solicita el Proyecto.<br/>Tama&ntilde;o m&aacute;ximo: 50 caracteres.',
			'form_input_size'			=>false,
			'form_label'				=>'Nombre de Cliente',
			'form_options'				=>false,
			'form_placeholder'			=>'Nombre de Cliente',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'short_name' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>true,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>100,
			'form_disabled'				=>false,
			'form_help_text'			=>"Indicar el nombre descriptivo del Proyecto.<br/>Tama&ntilde;o m&aacute;ximo: 100 caracteres",
			'form_input_size'			=>false,
			'form_label'				=>'Nombre del Proyecto',
			'form_options'				=>false,
			'form_placeholder'			=>'Nombre del Proyecto',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'description' => array(
			'type'						=>'textarea',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Indicar el detalle del Proyecto solicitado.",
			'form_input_size'			=>false,
			'form_label'				=>'Descripci&oacute;n del Proyecto',
			'form_options'				=>false,
			'form_placeholder'			=>'Descripci&oacute;n del Proyecto',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'requested_user_id' => array(
			'type'						=>'nat_number',
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
			'form_label'				=>"Solicitante.",
			'form_options'				=>false,
			'form_placeholder'			=>"Solicitante.",
			'form_special_form'			=>true,
			'form_show_field'			=>true,
		),
		'requested_date' => array(
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
		),
		'requested_time' => array(
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
			'form_show_field'			=>false,
		),
		'requested_start_date' => array(
			'type'						=>'date',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Fecha estimada de inicio del Proyecto.",
			'form_input_size'			=>false,
			'form_label'				=>"Fecha estimada de inicio del Proyecto.",
			'form_options'				=>false,
			'form_placeholder'			=>"Fecha estimada de inicio del Proyecto.",
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'requested_end_date' => array(
			'type'						=>'date',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Fecha estimada de finalizaci&oacute;n o cierre del Proyecto.",
			'form_input_size'			=>false,
			'form_label'				=>"Fecha estimada de fin del Proyecto.",
			'form_options'				=>false,
			'form_placeholder'			=>"Fecha estimada de fin del Proyecto.",
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'requested_urgency_id' => array(
			'type'						=>'select',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Urgencia del Proyecto",
			'form_input_size'			=>false,
			'form_label'				=>"Urgencia del Proyecto",
			'form_options'				=>array(),
			'form_placeholder'			=>"Urgencia del Proyecto",
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'status_id' => array(
			'type'						=>'select',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Status del Proyecto",
			'form_input_size'			=>false,
			'form_label'				=>"Status del Proyecto",
			'form_options'				=>array(),
			'form_placeholder'			=>"Status del Proyecto",
			'form_special_form'			=>true,
			'form_show_field'			=>true,
		),
		'planned_start_date' => array(
			'type'						=>'date',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Fecha real de inicio del Proyecto.",
			'form_input_size'			=>false,
			'form_label'				=>"Fecha real de inicio del Proyecto.",
			'form_options'				=>false,
			'form_placeholder'			=>"Fecha real de inicio del Proyecto.",
			'form_special_form'			=>true,
			'form_show_field'			=>true,
		),
		'planned_end_date' => array(
			'type'						=>'date',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Fecha real de fin del Proyecto.",
			'form_input_size'			=>false,
			'form_label'				=>"Fecha real de fin del Proyecto.",
			'form_options'				=>false,
			'form_placeholder'			=>"Fecha real de fin del Proyecto.",
			'form_special_form'			=>true,
			'form_show_field'			=>true,
		),
		'percentage' => array(
			'type'						=>'percentage',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>true,
			'data_validation_min'		=>0,
			'data_validation_max'		=>100,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>"Porcentaje de Avance del Proyecto.",
			'form_input_size'			=>false,
			'form_label'				=>"Porcentaje de Avance del Proyecto.",
			'form_options'				=>false,
			'form_placeholder'			=>"Porcentaje de Avance del Proyecto.",
			'form_special_form'			=>true,
			'form_show_field'			=>true,
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
		),
		'trak_link' => array(
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
		),
	);
	register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install'					));
	if ( !is_multisite() ) {
		add_action( 'admin_menu',		 						array( $this , "register_submenu_page"		));
	}else{
		add_action( 'network_admin_menu', 						array( $this , "register_submenu_page"		));
	}
	add_shortcode( 'csi_project_list_panel',			 		array( $this , 'shortcode_project_panel'	));
}
protected function backend_wp_sp_table_code($code){
	return '<code>'.$code.'</code>';
}
protected function backend_wp_sp_table_short_name($text,$element){
	return $text;
}
public function shortcode_project_panel($atts){
	global $wpdb;
	global $novis_csi_vars;
	$output		='';
	$customer	= isset($atts['customer']) && is_numeric($atts['customer']) ? $atts['customer'] : 'all';
	$weeks		= isset($atts['weeks']) && is_numeric($atts['weeks']) ? $atts['weeks'] : 8;
	$graph		= isset($atts['weeks']) && true == $atts['weeks'] ? true : false;
	
	$sql = "SELECT * FROM ".$this->tbl_name;
	$projects = self::get_sql($sql);
	wp_register_script(
		'bootstrap',
		CSI_PLUGIN_URL.'/external/bootstrap/dist/js/bootstrap.min.js' ,
		array('jquery'),
		'3.3.7'
	);
	wp_enqueue_script('bootstrap');
	$MONTH = 100/6;
	$output.='
		<div class="row">
			<div class="hidden-xs col-md-2">&nbsp;</div>
			<div class="col-xs-12 col-md-10">
				<div>
					<div class="month text-center" style="float:left;width:'.$MONTH.'%;outline-left:solid thin black;">Enero</div>
					<div class="month text-center" style="float:left;width:'.$MONTH.'%;outline-left:solid thin black;">Febrero</div>
					<div class="month text-center" style="float:left;width:'.$MONTH.'%;outline-left:solid thin black;">Marzo</div>
					<div class="month text-center" style="float:left;width:'.$MONTH.'%;outline-left:solid thin black;">Abril</div>
					<div class="month text-center" style="float:left;width:'.$MONTH.'%;outline-left:solid thin black;">Mayo</div>
					<div class="month text-center" style="float:left;width:'.$MONTH.'%;outline-left:solid thin black;">Junio</div>
				</div>
			</div>
		</div>';
	foreach ( $projects as $project){
		$UNO = (15)/30*$MONTH;
		$TRES= (30-23)/30*$MONTH+$MONTH;
		$DOS = 100-($UNO + $TRES);
		$output.='
		<div class="row">
			<div class="col-xs-12 col-md-2 text-center">
				<div class="btn-group btn-group-sm">
					<a type="button" class="text-muted dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="fa fa-cog fa-fw"></span>'.$project['short_name'].'
					</a>
					<ul class="dropdown-menu">
						<li><a href="#" title="Ver los documentos del proyecto '.$project['short_name'].'"><i class="fa fa-tasks fa-fw" aria-hidden="true"></i> Tareas</a></li>
						<li><a href="#" title="Ver las tareas del proyecto '.$project['short_name'].'"><i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> Documentos</a></li>
					</ul>
				</div>
				
			</div>
			<div class="col-xs-12 col-md-10">
				<div>
					<div class="month text-center" style="float:left;width:'.$UNO.'%;">&nbsp;</div>
					<div class="month text-center" style="float:left;width:'.$DOS.'%;">
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="'.$project['percentage'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$project['percentage'].'%;">
								<span>'.$project['percentage'].'%</span>
							</div>
						</div>
					</div>
					<div class="month text-center" style="float:left;width:'.$TRES.'%;">&nbsp;</div>
				</div>
			</div>
		</div>';
	}
	return $output;	
}
//END OF CLASS	
}

global $NOVIS_CSI_PROJECT;
$NOVIS_CSI_PROJECT =new NOVIS_CSI_PROJECT_CLASS();
?>