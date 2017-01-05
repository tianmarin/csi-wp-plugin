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
	$this->db_version	= '0.5.2';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="(
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
			'type'						=>'select',
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
			'form_options'				=>array(),
			'form_placeholder'			=>'Nombre de Cliente',
			'form_special_form'			=>true,
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
			'form_show_field'			=>false,
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
			'form_show_field'			=>false,
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
		),
	);
	register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install'					));
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
	define('DAYS_PER_MONTH', 30);
	define('DURATION', 6);
	$error		= false;
	$err_msg	='';
	//wrap plugins shortcodes
	$output		='<div class="csi-shortcode">';
	if ( isset($atts['customer']) ){
		if( is_numeric($atts['customer']) ){
			$customer =$atts['customer']; 
		}else{
			$customer_list = explode(',', $atts['customer']);
			if( count($customer_list)>1 ){
				if ( is_multisite() ){
					foreach($customer_list as $i => $customer){
						if ( !is_numeric($customer) ){
							unset($customer_list[$i]);
						}
					}
					$customer = $customer_list;
				}else{
					$customer=false;
				}
			}elseif( 'all' == $atts['customer']){
				$customer = false;
			}elseif( 'current' == $atts['customer']){
				if( is_multisite() ){
					$customer = get_current_blog_id();
				}else{
					$customer=false;
				}
			}else{
				$error=true;
			}
		}
	}else{
		if( is_multisite() ){
			$customer = get_current_blog_id();
		}else{
			$customer=false;
		}
	}
	if ( isset ( $atts['silent'] ) && $atts['silent'] == 'yes'){
		$silent=true;
	}else{
		$silent=false;
	}
	//duration validation
	if ( isset ( $atts['duration'] )){
		if ( is_numeric($atts['duration']) && $atts['duration'] > 1 && $atts['duration'] <= 12 ){
			$duration = $atts['duration'];
		}else{
			$err_msg .=" La duraci&oacute;n debe estar definida entre 1 & 12.";
			$error = true;
		}
	}else{
		$duration = DURATION;
	}
	//start_date validation
	if ( isset( $atts['start_date'] ) ){
		if ( self::validate_date( $atts['start_date'] ) ){
			$date = explode('-', $atts['start_date']);
			$date=array($date[0],$date[1],'01');
			$tl_start_date = DateTime::createFromFormat('Y-m-d', implode('-',$date));
		}else{
			$err_msg .=" La fecha de inicio debe ser válida y estar en el formato YYYY-MM-DD.";
			$error = true;
		}
	}else{
		$tl_start_date = new DateTime();
		$tl_start_date->modify('-1 month');
	}
	if ( false == $error ){
		wp_register_script(
			'bootstrap',
			CSI_PLUGIN_URL.'/external/bootstrap/dist/js/bootstrap.min.js' ,
			array('jquery'),
			'3.3.7'
		);
		wp_enqueue_script('bootstrap');
		wp_register_style(
			"csi_client_style",
			CSI_PLUGIN_URL.'/css/client.css' ,
			null,
			"1.0",
			"all"
		);
		wp_enqueue_style("csi_client_style" );
		//register and enqueue bootstrap javascript
		$start_month_name	= $tl_start_date->format('F');
		$year				= $tl_start_date->format('Y');
		$month				= $tl_start_date->format('m');
		$day				= $tl_start_date->format('d');
		$tl_end_date		= DateTime::createFromFormat('Y-m-d', $year.'-'.intval($month+$duration-1).'-28');
		$month_width		= 100 / $duration;
		//Print months header
		$style= $silent ? ' style="color:#FFF" ' : "";
		$output.='<h2 '.$style.'>Proyectos en curso</h2>';
		$output.='
		<div class="csi-project-panel">
		';
		if ( !$silent ){
//			$output.='
//			<div class="hidden-xs col-md-2">&nbsp;</div>';
		}
		$output.='<div class="col-xs-12 timeline-header">';
		for ( $i = 0 ; $i < $duration ; $i++ ){
			$date = DateTime::createFromFormat('Y-m-d', $year.'-'.intval($month+$i).'-01');
			$date_header_long='<span '.$style.'>'.$date->format('F').'<br/><small class="text-muted">'.$date->format('Y').'</small></span>';
			$date_header_short='<span '.$style.'>'.$date->format('M').'<br/><small class="text-muted">'.$date->format('Y').'</small></span>';
			$output.='<div class="month text-center hidden-xs" style="width:'.$month_width.'%;">'.$date_header_long.'</div>';
			$output.='<div class="month text-center visible-xs" style="width:'.$month_width.'%;">'.$date_header_short.'</div>';
		}//end for $i counter
		$output.='</div>';##timeline-header
		if ( false == $customer ){
			$sql = "SELECT * FROM ".$this->tbl_name." ORDER BY customer_id DESC";		
		}else{
			if ( 'array' == gettype($customer) ){
				$sql = "SELECT * FROM ".$this->tbl_name;
				$sql.=" WHERE customer_id=".implode(" OR customer_id=", $customer);
				$sql.=" ORDER BY customer_id";
			}else{
				$sql = "SELECT * FROM ".$this->tbl_name;
				$sql.=" WHERE customer_id=$customer ORDER BY customer_id DESC";
			}
		}
		//PROJECTS Timelines
		$customer_id=null;
		$projects = self::get_sql($sql);
		$MONTH = 100/$duration;
		foreach ( $projects as $project){
			if ( self::validate_date( $project['planned_start_date'] ) && self::validate_date( $project['planned_end_date'] ) ){
				if(!$silent){
					if( is_multisite() ){
						if ( $customer_id != $project['customer_id']){
							$customer_id = $project['customer_id'];
							if (0 == $customer_id){
								$output.='<div class="col-xs-12 customer"><p class="lead text-center" '.$style.'>Clientes fuera de Operaci&oacute;n</p></div>';							
							}else{
								$blog_details = get_blog_details($customer_id);
								$output.='<div class="col-xs-12 customer"><div class="lead text-center">'.$blog_details->blogname.'</div></div>';						
							}
						}
						
					}
					
				}
				$planned_start_date	= DateTime::createFromFormat('Y-m-d', $project['planned_start_date']);
				$planned_end_date	= DateTime::createFromFormat('Y-m-d', $project['planned_end_date']);
				if( $tl_start_date < $planned_start_date){
					$month_diff = new DateTime;
					$month_diff = date_diff ( $planned_start_date,$tl_start_date);
					//add months
					$proj_prev = floatval ( intval( $month_diff->format('%m') ) * $month_width );
//					self::write_log($month_diff);
					//add days
					$proj_prev = $proj_prev + intval( $month_diff->format('%d') ) / DAYS_PER_MONTH * $month_width;
				}else{
					$proj_prev = 0;
				}
				if( $tl_end_date > $planned_end_date){
					$month_diff = new DateTime;
					$month_diff = date_diff ( $planned_end_date,$tl_end_date);
					//add months
					$proj_post = floatval ( intval( $month_diff->format('%m') ) * $month_width );
					//add days
					$proj_post = $proj_post + $month_width / ( DAYS_PER_MONTH / intval( $planned_end_date->format('d') ) );
					//self::write_log( $month_width / ( DAYS_PER_MONTH / intval( $planned_end_date->format('d') ) ) );
				}else{
					$proj_post=0;
				}
				$proj_width = 100 - ($proj_prev + $proj_post);
				//self::write_log($proj_prev.' - '.$proj_width.' - '.$proj_post);
				$output.='
				<div class="row project">';
				if ( !$silent ){
					$output.='
					<div class="col-xs-12 text-left project-options">
						<div class="month text-center" style=";width:'.$proj_prev.'%;">&nbsp;</div>
						<div class="btn-group btn-group-sm" style=";width:'.$proj_width.'%;">
							<a type="button" class="text-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="fa fa-cog fa-fw"></span>'.$project['short_name'].'
							</a>
							<ul class="dropdown-menu">
								<li><a href="#" title="Ver los documentos del proyecto '.$project['short_name'].'"><i class="fa fa-tasks fa-fw" aria-hidden="true"></i> Tareas</a></li>
								<li><a href="#" title="Ver las tareas del proyecto '.$project['short_name'].'"><i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i> Documentos</a></li>
							</ul>
						</div>
						<div class="month" style="width:'.$proj_post.'%;">'.$short_name.'</div>
					</div>';
				}
				$short_name= true==$silent  ? '<small style="color:#FFF;white-space: nowrap;text-overflow: ellipsis;display: block;overflow: hidden;">&nbsp;'.$project['short_name'].'</small>':'&nbsp;';
				$start_class= (0 == $proj_prev) ? ' non_start ' : '';
				$end_class= (0 == $proj_post) ? ' non_end ' : '';
				$output.='
					<div class="col-xs-12 project-timeline">
						<div class="month text-center" style="width:'.$proj_prev.'%;">&nbsp;</div>
						<div class="month text-center" style="width:'.$proj_width.'%;">
							<div class="progress '.$start_class.$end_class.'">
								<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$project['percentage'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$project['percentage'].'%;">
									<span>'.$project['percentage'].'%</span>
								</div>
							</div>
						</div>
						<div class="month" style="width:'.$proj_post.'%;">'.$short_name.'</div>
					</div>
				</div>';
			}else{
				//No se muestra el proyecto, ya que no tiene fechas valida planificadas
			}
		}
		$output.="</div>";
	}else{
		$output.='<div class="well">';
			$output.='<p class="h3"><i class="fa fa-exclamation-circle fa-sm text-danger"></i> Error</p>';
			$output.='<p>Ha ocurrido un error, o probablemente no est&aacute;s usando de modo correcto el <code>shortcode</code>.</p>';
			$output.='<p><code>[csi_project_list_panel duration=<kbd>meses</kbd> start_date=<kbd>yyyy-mm-dd</kbd></code></p>';
			$output.='<p class=""text-muted">'.$err_msg.'</p>';
			$output.='<a href="'.get_site_option('ics_shortcode_help_url','#').'" class="btn btn-sm btn-primary">Aprender m&aacute;s</a>';
		$output.='</div>';

	}
	$output.='</div>';#wrap plugin shortcode csi-shortcode
	return $output;	
}
//END OF CLASS	
}

global $NOVIS_CSI_PROJECT;
$NOVIS_CSI_PROJECT =new NOVIS_CSI_PROJECT_CLASS();
?>