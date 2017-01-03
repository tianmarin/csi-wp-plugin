<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_ALERT_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'alert';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Alertas';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Alertas';
	//Identificador de menú padre
	$this->parent_slug	= $novis_csi_vars['main_menu_slug'];
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
								id int(4) unsigned not null auto_increment,
								system_id int(4) unsigned not null,
								alert_priority_id tinyint(2) unsigned not null,
								issued_date date not null,
								last_modified_user_id bigint(20) unsigned null,
								last_modified_date date null,
								alert_message tinytext not null,
								action_party_id tinyint(2) unsigned null,
								action_id varchar(50) null,
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
		'system_id' => array(
			'type'						=>'select',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'ID del sistema en el cual se gener&oacute; la alerta',
			'form_input_size'			=>false,
			'form_label'				=>'Identificador de Sistema',
			'form_options'				=>false,
			'form_placeholder'			=>'Identificador de Sistema',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'alert_priority_id' => array(
			'type'						=>'select',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'ID de la prioridad de la alerta',
			'form_input_size'			=>false,
			'form_label'				=>'Identificador de Prioridad de Alerta',
			'form_options'				=>false,
			'form_placeholder'			=>'Identificador de Prioridad de Alerta',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'issued_date' => array(
			'type'						=>'date',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'Fecha en la cual se gener&oacute; la alerta',
			'form_input_size'			=>false,
			'form_label'				=>'Fecha de generaci&oacute;n',
			'form_options'				=>false,
			'form_placeholder'			=>'Fecha de generaci&oacute;n',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'last_modified_user_id' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'ID del usuario modificador',
			'form_input_size'			=>false,
			'form_label'				=>'ID de usuario modificador',
			'form_options'				=>false,
			'form_placeholder'			=>'ID de usuario modificador',
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'last_modified_date' => array(
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
			'form_help_text'			=>'Fecha de &uacute;ltima modificaci&oacute;n',
			'form_input_size'			=>false,
			'form_label'				=>'Fecha de &uacute;ltima modificaci&oacute;',
			'form_options'				=>false,
			'form_placeholder'			=>'Fecha de &uacute;ltima modificaci&oacute;',
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'alert_message' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>'Mensaje de Error',
			'form_input_size'			=>false,
			'form_label'				=>'Mensaje de Error',
			'form_options'				=>false,
			'form_placeholder'			=>'Mensaje de Error',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'action_party_id' => array(
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
			'form_help_text'			=>'Identificador del Sistema de Ticket',
			'form_input_size'			=>false,
			'form_label'				=>'ID del Sistema de Ticket',
			'form_options'				=>false,
			'form_placeholder'			=>'ID del Sistema de Ticket',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
		'action_id' => array(
			'type'						=>'text',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>50,
			'form_disabled'				=>false,
			'form_help_text'			=>'Identificador del Ticket',
			'form_input_size'			=>false,
			'form_label'				=>'ID del Ticket',
			'form_options'				=>false,
			'form_placeholder'			=>'ID del Ticket',
			'form_special_form'			=>false,
			'form_show_field'			=>true,
		),
	);
	
	register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install'					));
	add_shortcode( 'csi_ewa_system_panel',				 		array( $this , 'shortcode_system_panel'		));
}
public function shortcode_system_panel($atts){
	global $wpdb;
	global $novis_csi_vars;
	$output		='';
	$system		= isset($atts['system']) && is_numeric($atts['system']) ? $atts['system'] : null;
	$weeks		= isset($atts['weeks']) && is_numeric($atts['weeks']) ? $atts['weeks'] : 8;
	$graph		= isset($atts['weeks']) && true == $atts['weeks'] ? true : false;
	
	if ( $system > 0 ){
		//Obtener información del Sistema
		global $NOVIS_CSI_ALERT_PRIORITY;
		global $NOVIS_CSI_ACTION_PARTY;
		$output.='<div class="col-xs-12 col-sm-12 col-md-6">';
		$output.='<header>';
			$output.='<h3>CRP <small>CRM Productivo</small></h3>';
		
		$output.='</header>';

		$sql="SELECT
				id as id,
				issued_date as date,
				COUNT( IF( alert_priority_id = 1, 1, NULL ) ) as critical,
				COUNT( IF( alert_priority_id = 2, 1, NULL ) ) as warning
			FROM $this->tbl_name
			WHERE system_id=$system
			GROUP BY issued_date
			LIMIT $weeks
			";		
		if ( $graph ) {
			$dates = self::get_sql($sql);
			$dataProvider = array();
			foreach ( $dates as $date ){
				$date_data = array(
					'date'		=>$date['date'],
					'warning'	=>$date['warning'],
					'critical'	=>$date['critical'],
				);
				array_push($dataProvider, $date_data);
			}
			wp_register_script(
				'amcharts',
				CSI_PLUGIN_URL.'/external/amcharts/amcharts/amcharts.js' ,
				array('jquery'),
				'3.2'
			);
		//	wp_enqueue_script('amcharts');
			//-----------------------------------------------------
			wp_register_script(
				'amcharts-serial',
				CSI_PLUGIN_URL.'/external/amcharts/amcharts/serial.js' ,
				array('amcharts'),
				'3.2'
			);
		//	wp_enqueue_script('amcharts-serial');
			//-----------------------------------------------------
			wp_register_script(
				'amcharts-responsive',
				CSI_PLUGIN_URL.'/external/amcharts/amcharts/plugins/responsive/responsive.min.js' ,
				array('amcharts'),
				'3.2'
			);
			wp_register_script(
				'csi_WPCLIENT',
				CSI_PLUGIN_URL.'/js/client-min.js' ,
				array('jquery','amcharts','amcharts-serial','amcharts-responsive'),
				'1.0'
			);
			wp_enqueue_script('csi_WPCLIENT');
			wp_localize_script(
				'csi_WPCLIENT',
				'csiWPCLIENT_'.'ewa_system_graph_'.$system,
				array(
					'ppost'							=> $this->plugin_post,
					'ajaxurl'						=> admin_url( 'admin-ajax.php' ),
					'ewa_system_graph_'.$system	=> json_encode($dataProvider),
				)
			);
			$output.='<section>';
				$output.='<div id="ewa_system_graph_'.$system.'" class="csi_ewa_system_panel" style="height:300px;"></div>';
			$output.='</section>';
		}
		$output.='<section>';
		$dates = self::get_sql($sql);
		foreach ( $dates as $date ){
			$beauty_date=date_create($date['date']);
			$beauty_date = date_format($beauty_date,"M d");
			$output.='<div class="panel panel-default container-fluid">
						<div class="panel-heading row">
							<div class="col-xs-3 text-center"><i class="fa fa-calendar"></i> '.$beauty_date.'</div>
							<div class="col-xs-3 text-center text-danger"><i class="fa fa-exclamation-circle"></i> '.$date['critical'].'</div>
							<div class="col-xs-3 text-center text-warning"><i class="fa fa-exclamation-triangle"></i> '.$date['warning'].'</div>
							<div class="col-xs-3 text-center">
								<a class="btn btn-default btn-sm" role="button" data-toggle="collapse" href="#ewa_system_graph_'.$system.'_'.$date['date'].'" aria-expanded="false" aria-controls="collapseExample">
									<i class="fa fa-plus"></i> Ver más
								</a>
							</div>
						</div><!-- panel-heading -->';
//			$output.=$date;
			$output.='<ul class="list-group row collapse" id="ewa_system_graph_'.$system.'_'.$date['date'].'">';
			$sql="SELECT
					a.id as alert_id,
					a.alert_message as message,
					b.css_class as class,
					b.icon as priority_icon,
					c.short_name as party_name,
					c.url as party_url,
					c.icon as party_icon,
					a.action_id as action
					FROM
						(($this->tbl_name as a
						LEFT JOIN $NOVIS_CSI_ALERT_PRIORITY->tbl_name as b ON a.alert_priority_id = b.id)
						LEFT JOIN $NOVIS_CSI_ACTION_PARTY->tbl_name as c ON a.action_party_id = c.id)
					WHERE
						a.system_id=$system
						AND a.issued_date='".$date['date']."'
				";
			$alerts = self::get_sql($sql);
			foreach ( $alerts as $alert){
				$output.='<li class="list-group-item list-group-item-'.$alert['class'].'">
							<h5 class="list-group-item-heading"><i class="fa fa-'.$alert['priority_icon'].'"></i> '.$alert['message'].'</h5>
							<div class="row">';
				if ( '' != $alert['action'] ){
					$output.='<p class="text-muted text-justify col-xs-8">El análisis y resolución de este mensaje de error, están siendo tratados en <em>'.$alert['party_name'].'</em></p>';
					$url = str_replace ( '[TICKET]', $alert['action'], $alert['party_url'] );
					$output.='<div class="col-xs-4 text-center">';
					$output.='<div class="btn-group" role="group" aria-label="...">';
					$output.='<a href="'.$url.'" class="btn btn-'.$alert['class'].' btn-sm"><i class="fa fa-'.$alert['party_icon'].' fa-fw"></i> '.$alert['action'].'</a>';
					$output.='<a href="#" class="btn btn-default btn-sm"><i class="fa fa-edit fa-fw"></i></a>';
					$output.='</div>';
					$output.='</div>';
				}else{
					$output.='<p class="text-muted text-justify col-xs-8">El análisis y resolución de este mensaje de error <strong>NO</strong> están siendo tratados.</p>';
					$output.='<div class="col-xs-4 text-center">';
					$output.='<div class="btn-group" role="group" aria-label="...">';
					$output.='<a href="#" class="btn btn-default btn-sm"><i class="fa fa-edit fa-fw"></i></a>';
					$output.='</div>';
					$output.='</div>';
				}
				$output.='</div></li>';
			}
			$output.='</ul>';
			$output.='</div>';
		}
		$output.="</section>";
		$output.="</div>";
	}else{
		$output.='<div class="well">';
				$output.='<p class="h3"><i class="fa fa-exclamation-circle fa-sm text-danger"></i> Error</p>';
				$output.='<p>Ha ocurrido un error, o probablemente no est&aacute;s usando de modo correcto el <code>shortcode</code>.</p>';
				$output.='<p><code>[csi_ewa_system_panel system=<kbd>id-del-sistema</kbd> weeks=<kbd>numero-de-semanas-previas</kbd> graph=<kbd>true|false</kbd></code></p>';
				$output.='<a href="'.get_site_option('ics_shortcode_help_url','#').'" class="btn btn-sm btn-primary">Aprender m&aacute;s</a>';
		$output.='</div>';
	}
	return $output;
}
//END OF CLASS	
}

global $NOVIS_CSI_ALERT;
$NOVIS_CSI_ALERT =new NOVIS_CSI_ALERT_CLASS();
?>