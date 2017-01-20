<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_EWA_CLASS extends NOVIS_CSI_CLASS{

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
	$this->class_name	= 'ewa';
	//Nombre singular para títulos, mensajes a usuario, etc.
	$this->name_single	= 'Reporte EWA';
	//Nombre plural para títulos, mensajes a usuario, etc.
	$this->name_plural	= 'Reportes EWA';
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
	$this->db_version	= '0.6.0';
	//Reglas actuales de caracteres a nivel de DB.
	//Dado que esto sólo se usa en la cración de la tabla
	//no se guarda como variable de clase.
	$charset_collate	= $wpdb->get_charset_collate();
	//Sentencia SQL de creación (y ajuste) de la tabla de la clase
	$this->crt_tbl_sql_wt	="(
								id bigint unsigned not null auto_increment COMMENT 'Unique ID for each entry',
								system_no bigint(18) unsigned not null COMMENT 'SAP System Number',
								ewa_session_no bigint(13) unsigned not null COMMENT 'EWA session number',
								planned_date date not null COMMENT 'Planned date of EWA',
								ewa_status varchar(1) not null COMMENT 'EWA Status char',
								ewa_rating varchar(1) not null COMMENT 'EWA Rating char',
								creation_user_id bigint(20) unsigned null COMMENT 'Id of user responsible of the creation of this record',
								creation_user_email varchar(100) null COMMENT 'Email of user. Used to track user if user id is deleted',
								creation_date date null COMMENT 'Date of the creation of this record',
								creation_time time null COMMENT 'Time of the creation of this record',
								creation_filename varchar(255) null COMMENT 'Name of the file used to create this record',
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
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'system_no' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'ewa_session_no' => array(
			'type'						=>'nat_number',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>true,
			'data_validation_min'		=>1,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'planned_date' => array(
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
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'ewa_status' => array(
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
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'ewa_rating' => array(
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
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'creation_user_id' => array(
			'type'						=>'create_user_id',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'creation_user_email' => array(
			'type'						=>'create_user_email',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'creation_date' => array(
			'type'						=>'create_date',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'creation_time' => array(
			'type'						=>'create_time',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>true,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'creation_filename' => array(
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
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'last_modified_user_id' => array(
			'type'						=>'edit_user_id',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'last_modified_user_email' => array(
			'type'						=>'edit_user_email',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'last_modified_date' => array(
			'type'						=>'edit_date',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
		'last_modified_time' => array(
			'type'						=>'edit_time',
			'backend_wp_in_table'		=>false,
			'backend_wp_sp_table'		=>false,
			'backend_wp_table_lead'		=>false,
			'data_required'				=>false,
			'data_validation'			=>false,
			'data_validation_min'		=>false,
			'data_validation_max'		=>false,
			'data_validation_maxchar'	=>false,
			'form_disabled'				=>false,
			'form_help_text'			=>false,
			'form_input_size'			=>false,
			'form_label'				=>false,
			'form_options'				=>false,
			'form_placeholder'			=>false,
			'form_special_form'			=>false,
			'form_show_field'			=>false,
		),
	);
	
	register_activation_hook(CSI_PLUGIN_DIR."/index.php",		array( $this , 'db_install'								));
	//in a new blog creation, create the db for new blog
	//Applies only for non-network classes
	if( true != $this->network_class ){
		add_action( 'wpmu_new_blog',							array( $this , 'db_install'								));
	}
	add_action( 'wp_ajax_csi_ajax_upload_ewa_file',				array( $this , 'csi_ajax_upload_ewa_file'				));
	add_shortcode( 'ewa_system_history',			 			array( $this , 'csi_shortcode_ewa_system_history'		));
	add_shortcode( 'csi_ewa_status',					 		array( $this , 'csi_shortcode_ewa_status'				));
	add_shortcode( 'csi_ewa_status_by_customer',		 		array( $this , 'csi_shortcode_ewa_status_by_customer'	));
	add_shortcode( 'csi_ewa_system_dashboard',			 		array( $this , 'csi_shortcode_ewa_ssystem_dashboard'	));
	add_shortcode( 'csi_ewa_customer_block',			 		array( $this , 'csi_shortcode_ewa_customer_block'	));
	

}
public function get_ewa_session_no_col(){
	global $wpdb;
	$sql = "SELECT ewa_session_no FROM ".$this->tbl_name;
	return $wpdb->get_col( $sql );
}

public function csi_ajax_upload_ewa_file(){
	global $wpdb;
	$response 					= array();	
	$curr_system_no				= array();
	$error_flag					= FALSE;
	$EWA_insert_array			= array();
	$EWA_insert_array_temp		= array();
	$ALERT_insert_array			= array();
	$ALERT_insert_array_temp	= array();
	$non_reg_systno				= array();
	$non_reg_output				= '';
	$mime_type_error			= '';
	$db_error					= '';
	$rewind_error				= '';
	$no_new_data				= '';
	$prevent_dup_alert			= 0;
	$skipped_ewa_reports		= 0;
	$line_lenght				= 2000; //longest lenght of line
	$current_user				= wp_get_current_user();

	set_time_limit(600);	
	
	global $NOVIS_CSI_CUSTOMER_SYSTEM;
	$curr_system_no				=$NOVIS_CSI_CUSTOMER_SYSTEM->get_system_no_col();
	$curr_sessno				=$this->get_ewa_session_no_col();
	$allowed_mime_types 		= array('text/csv','text/plain');
	
	if ( FALSE == array_search( mime_content_type($_FILES['file']['tmp_name']) , $allowed_mime_types ) ){
		$error_flag=TRUE;
		$mime_type_error='<div class="alert alert-danger" role="alert">';
		$mime_type_error.='Tipo de archivo incorrecto: <code>'.mime_content_type($_FILES['file']['tmp_name']).'</code>';
		$mime_type_error='</div>';
	}else{
		$csv_filename = $_FILES['file']['name'];
		$csv_file = fopen($_FILES['file']['tmp_name'], 'rb');
		//CSV Structure
		//SAPCUSTNO|SOLID|SOLDESC|DBID|INSTNO|SYSTNO|SESSNO|PLANNED_DATE|EWA_STATUS|EWA_RATING|ALERT_GROUP|ALERT_NUMBER|ALERT_RATING|TEXT		
		//Get CSV Headers
		$line = fgetcsv($csv_file,$line_lenght);
		foreach ( $line as $key => $field){ $line[$key] = htmlspecialchars ( trim ( $field ) ); }
		if ( FALSE === ($csv_h_sapcustno	= array_search("SAPCUSTNO",		$line)) ) { $error_flag = TRUE;}
		if ( FALSE === ($csv_h_solid		= array_search("SOLID"	,		$line)) ) { $error_flag = TRUE;}
		if ( FALSE === ($csv_h_soldesc		= array_search("SOLDESC",		$line)) ) { $error_flag = TRUE;}
		if ( FALSE === ($csv_h_dbid			= array_search("DBID",			$line)) ) { $error_flag = TRUE;}
		if ( FALSE === ($csv_h_instno		= array_search("INSTNO",		$line)) ) { $error_flag = TRUE;}
		if ( FALSE === ($csv_h_systno		= array_search("SYSTNO",		$line)) ) { $error_flag = TRUE;}
		if ( FALSE === ($csv_h_sessno		= array_search("SESSNO",		$line)) ) { $error_flag = TRUE;}
		if ( FALSE === ($csv_h_planned_date	= array_search("PLANNED_DATE",	$line)) ) { $error_flag = TRUE;}
		if ( FALSE === ($csv_h_ewa_status	= array_search("EWA_STATUS",	$line)) ) { $error_flag = TRUE;}
		if ( FALSE === ($csv_h_ewa_rating	= array_search("EWA_RATING",	$line)) ) { $error_flag = TRUE;}
		if ( FALSE === ($csv_h_alert_group	= array_search("ALERT_GROUP",	$line)) ) { $error_flag = TRUE;}
		if ( FALSE === ($csv_h_alert_number	= array_search("ALERT_NUMBER",	$line)) ) { $error_flag = TRUE;}
		if ( FALSE === ($csv_h_alert_rating	= array_search("ALERT_RATING",	$line)) ) { $error_flag = TRUE;}
		if ( FALSE === ($csv_h_alert_text	= array_search("TEXT",			$line)) ) { $error_flag = TRUE;}
		
		while  ( FALSE !== ($line = fgetcsv($csv_file,$line_lenght) ) ){
			foreach ( $line as $key => $field){
					$line[$key] = htmlspecialchars ( trim ( $field ) ) ;
			}
			//Check if system is registered
			if ( FALSE === array_search($line[$csv_h_systno], $curr_system_no)){
				if ( FALSE === array_search( $line[$csv_h_systno], array_column( $non_reg_systno, 'systno' ) ) ) {
					if ( 0 < intval ( $line[$csv_h_systno] ) ) {
						$reg=array(
							'sapcustno'		=> $line[$csv_h_sapcustno],
							'solid'			=> $line[$csv_h_solid],
							'soldesc'		=> $line[$csv_h_soldesc],
							'dbid'			=> $line[$csv_h_dbid],
							'systno'		=> $line[$csv_h_systno],
						);
						array_push($non_reg_systno, $reg);
					}
				}
			}else{
				//Validar si el ewa ya está registrado en el sistema
				//Si el ewa ya fue ingresado al sistema, se guarda como EWAs Omitidos
				//Check if ewa_session_no is registered
				if ( FALSE === array_search( $line[$csv_h_sessno], $curr_sessno ) ) {
					//Check if is not already registered to save
					if ( FALSE === array_search( $line[$csv_h_sessno], array_column( $EWA_insert_array, 'ewa_session_no' ) ) ) {
						$EWA = array(
							'system_no'			=> $line[$csv_h_systno],
							'ewa_session_no'	=> $line[$csv_h_sessno],
							'planned_date'		=> $line[$csv_h_planned_date],
							'ewa_status'		=> $line[$csv_h_ewa_status],
							'ewa_rating'		=> $line[$csv_h_ewa_rating],
							'creation_filename'	=> $csv_filename,
						);
						$count_ewas = array_push( $EWA_insert_array, $EWA );
					}else{
						// silence is golden
					}
				}else{
					$skipped_ewa_reports++;
			// 		Este ewa ya existe en el sistema.... por lo tanto se omite
				}
			}
		}
		//prepare the variables for insert

		if ( FALSE != rewind($csv_file) ){
			$line = fgetcsv($csv_file,$line_lenght);
			while  ( FALSE !== ($line = fgetcsv($csv_file,$line_lenght) ) ){
				foreach ( $line as $key => $field){
					$line[$key] = htmlspecialchars ( trim ( $field ) ) ;
				}
				//Check if ewa_session_no is going to be inserted
				if ( FALSE === array_search( $line[$csv_h_sessno], array_column( $EWA_insert_array, 'ewa_session_no' ) ) ) {
					//silence is golden
				}else{
					//Check for no duplicates (duplicates are not inserted )
					
					if (FALSE !== array_search( $line[$csv_h_sessno], array_column( $EWA_insert_array, 'ewa_session_no' ) )
						&& FALSE !== array_search( $line[$csv_h_systno], array_column( $EWA_insert_array, 'system_no' ) ) 
						) {
							if ( 'NULL' == $line[$csv_h_alert_number] || '' == $line[$csv_h_alert_rating]  ){
								$ALERT = array(
									'system_no'				=> $line[$csv_h_systno],
									'ewa_session_no'		=> $line[$csv_h_sessno],
									'alert_group'			=> 'NOVIS_NO_ALERT',
									'alert_rating'			=> 'Z',
									'alert_no'				=> '1',
									'alert_text'			=> 'No alert has been generated [novis]',
									'creation_filename'		=> $csv_filename,
								);
							}else{
								$ALERT = array(
									'system_no'				=> $line[$csv_h_systno],
									'ewa_session_no'		=> $line[$csv_h_sessno],
									'alert_group'			=> $line[$csv_h_alert_group],
									'alert_rating'			=> $line[$csv_h_alert_rating],
									'alert_no'				=> $line[$csv_h_alert_number],
									'alert_text'			=> $line[$csv_h_alert_text],
									'creation_filename'		=> $csv_filename,
								);
								
							}
							$count_alerts = array_push( $ALERT_insert_array, $ALERT );
//					}else{
//						$prevent_dup_alert++;
					}
				}
			}
			$prevent_dup_alert = count ( $ALERT_insert_array);
			$ALERT_insert_array = array_unique($ALERT_insert_array, SORT_REGULAR);
			$prevent_dup_alert = count ( $ALERT_insert_array) - $prevent_dup_alert;
			if (0 < count ( $EWA_insert_array ) ) {
				$sql = "INSERT INTO ".$this->tbl_name. " (system_no, ewa_session_no, planned_date, ewa_status, ewa_rating, creation_filename, creation_user_id, creation_user_email, creation_date, creation_time)
						VALUES ";
				foreach ( $EWA_insert_array as $key => $row ){
					$EWA_insert_array_temp[$key]=' ("'.$row['system_no'].'","'.$row['ewa_session_no'].'","'.$row['planned_date'].'","'.$row['ewa_status'].'","'.$row['ewa_rating'].'","'.$row['creation_filename'].'","'.intval(get_current_user_id()).'","'.$current_user->user_email.'","'.date("Y-m-d").'","'.date("H:i:s").'") ';
				}
				$sql.=implode(",", $EWA_insert_array_temp);
				$ewa_inserts = $wpdb->query($sql);
				
				if ( FALSE === $ewa_inserts ){
					$error_flag=TRUE;
					$db_error='<p>Ha ocurrido un error al insertar los registros de EWA en la Base de Datos.</p><p><code>'.$sql.'</code></p>';
					$db_error.='<br/>Solicita apoyo al administrador del sistema.';
				}else{
					global $NOVIS_CSI_EWA_ALERT;
					$sql = "INSERT INTO ".$NOVIS_CSI_EWA_ALERT->tbl_name. " (ewa_session_no, alert_group, alert_rating, alert_no, alert_text, creation_filename, creation_user_id, creation_user_email, creation_date, creation_time)
							VALUES ";
					foreach ( $ALERT_insert_array as $key => $row ){
						$ALERT_insert_array_temp[$key] =' ("'.$row['ewa_session_no'].'","'.$row['alert_group'].'","'.$row['alert_rating'].'","'.$row['alert_no'].'","'.$row['alert_text'].'","'.$row['creation_filename'].'","'.intval(get_current_user_id()).'","'.$current_user->user_email.'","'.date("Y-m-d").'","'.date("H:i:s").'") ';
					}
					$sql.=implode(",", $ALERT_insert_array_temp);
					// Normally @@global.max_allowed_packet = 1048576
					$check_max_allowed_packet= $wpdb->get_row('SELECT @@global.max_allowed_packet as max_allowed_packet','ARRAY_A')['max_allowed_packet'];
					$query_size = strlen( $sql ) + 1024 * 4;
					self::write_log( $query_size );
					self::write_log($check_max_allowed_packet);
					if ( $query_size >= $check_max_allowed_packet ){
						self::write_log("WARNING! To prevent DB Error for getting packet bigger than 'max_allowed_packet' bytes, global.max_allowed_packet will be temporarily modified. QUERY_SIZE : ".$query_size." max_allowed_packet : ".$check_max_allowed_packet);
						//In order to this fix to work, you need to grant the database user the "SUPER" privilege
						/*
						REVOKE ALL PRIVILEGES ON *.* FROM 'user'@'localhost';
						REVOKE GRANT OPTION ON *.* FROM 'user'@'localhost';
						GRANT SUPER ON *.* TO 'user'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
						*/
						$query_size = ( $query_size < 33554432 )? 33554432 : 67108864 ;
						self::write_log( $wpdb->query( 'SET @@global.max_allowed_packet = ' . $query_size ) );
						self::write_log ( "WARNING! max_allowed_packet changed to ".$query_size );
						$alert_inserts = $wpdb->query($sql);
						self::write_log( $wpdb->query( 'SET @@global.max_allowed_packet = ' . $check_max_allowed_packet ) );
						self::write_log ( "WARNING! max_allowed_packet changed back to " . $check_max_allowed_packet );
					}else{
						$alert_inserts = $wpdb->query($sql);
					}
					if ( FALSE === $alert_inserts ){
						$error_flag=TRUE;
						$db_error='<p>Ha ocurrido un error al insertr los registros de Alertas de EWA en la Base de Datos.</p><p><code>'.$sql.'</code></p>';
						$db_error.='<br/>Solicita apoyo al administrador del sistema.';
					}
				}
				
			}else{
				$no_new_data ='<div class="alert alert-danger" role="alert">';
				$no_new_data.='Ninguno de los registros en este archivo son v&aacute;lidos.';
				$no_new_data.='<br/>Puede que estés cargando el archivo por segunda vez o los sistemas no est&eacute;n registrados.';
				$no_new_data.='</div>';
				
			}
		}else{
			$error_flag=TRUE;
			
			$rewind_error ='<div class="alert alert-danger" role="alert">';
			$rewind_error.='Ha ocurrido un error al procesar el archivo (<code>Rewind CSV File <small>'.$_FILES['file']['tmp_name'].'</small></code>).';
			$rewind_error.='<br/>Solicita apoyo al administrador del sistema.';
			$rewind_error.='</div>';
		}
		// ----- 
	}
	if ( FALSE === $error_flag ){
		if ( 0 < $prevent_dup_alert ){
			$prevent_dup_output ='<div class="alert alert-info" role="alert">';
			$prevent_dup_output .='Se han omitido <strong>'.$prevent_dup_alert.'<div class="alert alert-info" role="alert">';
		}
		if ( 0 < count( $non_reg_systno ) ) {
			$non_reg_output.='<div class="row">';
			$non_reg_output.='<div class="col-xs-12">';
			$non_reg_output.='<h4>Sistemas no registrados</h4>';
			$non_reg_output.='<p>Existen sistemas que no están registrados. Debes registrar el sistema y posteriormente puedes re-procesar la carga.</p>';
			$non_reg_output.='<p class="text-muted">Esta informaci&oacute;n no es almacenada. Te recomendamos guardar esta p&aacute;gina como PDF.</p>';
			$non_reg_output.='<table class="table table-condensed table-hover">';
			$non_reg_output.='<thead><tr><th>SAP Customer Number</th><th>Solution ID</th><th>Solution Desc</th><th>DBID</th><th>System Number</th></tr></thead>';
			$non_reg_output.='<tbody>';
			foreach ( $non_reg_systno as $sys){
				$non_reg_output.='<tr><td>'.$sys['sapcustno'].'</td><td>'.$sys['solid'].'</td><td>'.$sys['soldesc'].'</td><td>'.$sys['dbid'].'</td><td>'.$sys['systno'].'</td></tr>';
			}
			$non_reg_output.='</tbody></table>';
			$non_reg_output.='</div>';
			$non_reg_output.='</div>';
		}
	}
	$response['status']='ok';
	$response['message']	 ='';
	$response['message']	.=$mime_type_error;
	$response['message']	.=$db_error;
	$response['message']	.=$rewind_error;
	$response['message']	.=$no_new_data;
	$response['message']	.=$non_reg_output;
	echo json_encode($response);
	wp_die();
}

public function csi_shortcode_ewa_system_history(){
	global $wpdb;
	$output = '';
//	$systems = explode(',', $atts['system']);
	//ensure systems array is 'system_no' array
//	foreach ( $systems as $key => $system ){
		$system = '312137533';
		wp_register_script(
			'csiEWASystemHistory',
			CSI_PLUGIN_URL.'/js/shortcodes/min/shortcode-ewa-system-history-min.js' ,
			array('amcharts','amcharts-serial','amcharts-responsive'),
			'0.9.0'
		);
		wp_enqueue_script('csiEWASystemHistory');
		global $NOVIS_CSI_EWA_ALERT;
		global $NOVIS_CSI_EWA_ALERT_RATING;
		$sql = 'SELECT
				T01.alert_group,
				T01.alert_no,
				T02.hex_color,
				T01.alert_text
				FROM
					'.$this->tbl_name.' as T00
					LEFT JOIN '.$NOVIS_CSI_EWA_ALERT->tbl_name.' as T01 ON T00.ewa_session_no = T01.ewa_session_no
					LEFT JOIN '.$NOVIS_CSI_EWA_ALERT_RATING->tbl_name.' as T02 ON T01.alert_rating = T02.alert_rating
				GROUP BY
					T01.alert_group,T01.alert_no
				';
//				WHERE
//					T00.system_no="'.$system.'"
		$id_alerts = $this->get_sql($sql);
		$dataProvider = array();
		$graphs = array();
		foreach ( $id_alerts as $id_alert ){
			$alert_id = $id_alert['alert_group'].'_'.$id_alert['alert_no'];
			$graph = array(
				'balloonText'	=> "<small>[[title]]</small>",
				'fillAlphas'	=> 1,
//				'labelText'		=> "[[title]]",
				'lineAlpha'		=> 0.5,
				'title'			=> $id_alert['alert_text'],
				'type'			=> "column",
				'fillColors'	=> '#'.$id_alert['hex_color'],
				'lineColor'		=> '#FFF',
				'valueField'	=> $alert_id,
				'hidden'		=> true,
			);
			array_push($graphs, $graph);
			$sql = 'SELECT
					T00.planned_date,
					T01.alert_group,
					T01.alert_no,
					COUNT(*) as total
					FROM
						'.$this->tbl_name.' as T00
						LEFT JOIN '.$NOVIS_CSI_EWA_ALERT->tbl_name.' as T01 ON T00.ewa_session_no = T01.ewa_session_no
						LEFT JOIN '.$NOVIS_CSI_EWA_ALERT_RATING->tbl_name.' as T02 ON T01.alert_rating = T02.alert_rating
					WHERE
						T01.alert_group="'.$id_alert['alert_group'].'"
						AND T01.alert_no="'.$id_alert['alert_no'].'"
					GROUP BY 
						T00.planned_date
					ORDER BY 
						T00.planned_date
					';
//T00.system_no="'.$system.'"
//						AND 

			$alerts = $this->get_sql($sql,'ARRAY_A');
			foreach ($alerts as $alert ){
				$reg = array(
					'planned_date'	=> $alert['planned_date'],
					$alert_id		=> $alert['total'],
				);
				$index = array_search( $alert['planned_date'], array_column( $dataProvider, 'planned_date' ) );
				if (FALSE === $index ){
					array_push($dataProvider, $reg);
				}else{
					$dataProvider[$index][$alert_id] = $alert['total'];
				}
			}
		}
//		self::write_log($dataProvider);
//		self::write_log($graphs);
		wp_localize_script(
			'csiEWASystemHistory',
			'csiEWASystemHistory'.'_system_'.$system,
			array(
				'ppost'			=> $this->plugin_post,
				'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
				'dataProvider'	=> $dataProvider,
//				'graphs'		=> json_encode($graphs),
				'graphs'		=> $graphs,
			)
		);
		$output.='<h3>Resumen de Alertas EWA - Sistema BSP <small>312137533</small></h3>';
		$output.='<div id="ewa_system_history_dp_'.$system.'" class="ewa_system_history_graph" data-system-id="'.$system.'" style="min-height: 300px"></div>';
		$output.='<div id="ewa_system_history_dp_'.$system.'_legend" class="ewa_system_history_legend" data-system-id="'.$system.'" ></div>';
	
//	}
	
	return $output;
}

public function csi_shortcode_ewa_status_by_customer($atts){
	//Variable definition
	global $wpdb;
	global $NOVIS_CSI_EWA_RATING;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_CUSTOMER_SYSTEM;
	global $NOVIS_CSI_SAPCUSTNO;
	$output = '';

	//Parameters evaluation
	$environment = array( 1, );
	$customer = $atts [ 'customer' ];
	if ( NULL == $customer ){
		//Current BLOG Customer
		$sql = 'SELECT id FROM '.$NOVIS_CSI_CUSTOMER->tbl_name.' WHERE blog_id = "'.get_current_blog_id().'"';
		$customer = $wpdb->get_col( $sql );
	}elseif ( 'all' == $customer){
		//All Customers
		$sql = 'SELECT id FROM '.$NOVIS_CSI_CUSTOMER->tbl_name;
		$customer = $wpdb->get_col( $sql );
	}else{
		$customer = explode ( ',', $customer );
		foreach ($customer as $key => $val ){
			if (FALSE == intval ( $customer[$key] ) ){
				$sql = 'SELECT id FROM '.$NOVIS_CSI_CUSTOMER->tbl_name.' WHERE code="'.$customer[$key].'"';
				$customer_id = $wpdb->get_var( $sql, 0, 0 );
				$customer[$key] = intval ( $customer_id );
			}
		}
	}

	//get SAPCUSTNO from $customer array
	$sql = 'SELECT sapcustno FROM '.$NOVIS_CSI_SAPCUSTNO->tbl_name.' WHERE customer_id IN ('.implode(', ', $customer ).')';
	$sapcustno = $wpdb->get_col( $sql );

	//get SYSTEMO_NO from $sapcustno array and $environment
	$sql = 'SELECT system_no FROM '.$NOVIS_CSI_CUSTOMER_SYSTEM->tbl_name;
	$sql.=' WHERE sapcustno IN ('.implode(', ', $sapcustno ).') AND environment_id IN ('.implode(',', $environment).') ORDER BY system_no';
	$system_no = $wpdb->get_col( $sql );
	
	$dataProvider = array();
	$graphs = array();

	foreach ( $system_no as $system){
		$sql = 'SELECT
					T00.planned_date,
					T01.hex_color
				FROM
					'.$this->tbl_name.' as T00
					LEFT JOIN '.$NOVIS_CSI_EWA_RATING->tbl_name.' as T01 ON T00.ewa_rating = T01.ewa_rating
				WHERE
					T00.system_no="'.$system.'"
				GROUP BY
					T00.planned_date
				ORDER BY
					T00.planned_date
		';
		$ewas = $this->get_sql( $sql );
		foreach ( $ewas as $key => $ewa){
			$ewa['planned_date'] = self::findMonday($ewa['planned_date']);
			$ewa['planned_date'] = $ewa['planned_date']->format('Y-m-d');
			$reg = array(
				'planned_date'		=> $ewa['planned_date'],
				$system.'_color'	=> '#'.$ewa['hex_color'],
				$system.'_size'		=> 10,
				$system				=> 1,
				'total'				=> 1,
			);
			$index = array_search( $ewa['planned_date'], array_column( $dataProvider, 'planned_date' ) );
			if (FALSE === $index ){
				array_push($dataProvider, $reg);
			}else{
				$dataProvider[$index][$system]			= 1;
				$dataProvider[$index][$system.'_color']	= '#'.$ewa['hex_color'];
				$dataProvider[$index][$system.'_size']	+= 10;
				$dataProvider[$index]['total']			= 1;
			}
		}
		$system_info = $NOVIS_CSI_CUSTOMER_SYSTEM->get_row_by_system_no($system);
		$sql = 'SELECT
					T02.short_name
				FROM
					'.$NOVIS_CSI_CUSTOMER_SYSTEM->tbl_name.' as T00
					LEFT JOIN '.$NOVIS_CSI_SAPCUSTNO->tbl_name.' as T01 ON T00.sapcustno=T01.sapcustno
					LEFT JOIN '.$NOVIS_CSI_CUSTOMER->tbl_name.' as T02 ON T01.customer_id=T02.id
				WHERE
					T00.system_no='.$system;
		$customer_shortname = $wpdb->get_var( $sql, 0, 0 );
		$graph = array(
			'balloonText'				=> "<small>[[title]]</small>",
//			'fillAlphas'				=> 1,
//			'lineThickness'				=> 3,
//			'lineAlpha'					=> 1,
			"fillColorsField"			=> $system.'_color',
			'title'						=> $customer_shortname.' - '.$system_info['sid'],
			'type'						=> "line",
//			'fillColors'				=> '#'.$ewa_rating['hex_color'],
			'lineColor'					=> '#FFF',
			'valueField'				=> $system,
			'id'						=> $system,
			"labelText"					=> $system_info['sid'],
			"lineColor"					=> "#786c56",
			"lineAlpha"					=> 0.25,
			"lineThickness"				=> 1,
			"bullet" 					=> "square",
			"bulletBorderAlpha"			=> 0.25,
			"bulletBorderColor"			=> "#000000",
			"bulletSize"				=> 10,
			"bulletBorderThickness"		=> 2,
			"colorField"				=> $system.'_color',
			"dashLength"				=> 3,
//			"bulletSizeField"			=> $system.'_size'			
//			'visibleInLegend'	=> false,
		);
		array_push($graphs, $graph);
	}
	$graph = array(
		'balloonText'		=> "<small>[[value]]</small>",
//		'fillAlphas'		=> 1,
		'lineAlpha'			=> 0.0,
		'title'				=> 'total',
		'type'				=> "step",
		'lineColor'			=> '#33F',
		'valueField'		=> 'total',
		'id'				=> 'total',
		'visibleInLegend'	=> false,
//		'hidden'			=> true,
	);
	array_push($graphs, $graph);
	
/*
	//get EWA_SESSION_NO from $system_no aarray
	$weeks				= isset ($atts [ 'weeks' ]) ? intval( $atts [ 'weeks' ] ) : 53;
	$days				= intval ($weeks * 7 );
	$current_datetime	= new DateTime();
	$past_datetime		= new DateTime();
	$past_datetime		= $past_datetime->modify('-'. $days . ' days' );
	$current_datetime	=$current_datetime->format('Y-m-d');
	$past_datetime		=$past_datetime->format('Y-m-d');
	$sql				= 'SELECT ewa_session_no FROM '.$this->tbl_name.' WHERE system_no IN ('.implode(',', $system_no).') ';
	$sql				.='AND planned_date BETWEEN "'.$past_datetime.'" AND "'.$current_datetime.'"';
	$ewa_session_no		= $wpdb->get_col( $sql );
//	self::write_log($sql);
	$sql='SELECT
			T00.ewa_rating,
			T01.short_name,
			T01.hex_color
		FROM 
			'.$this->tbl_name.' as T00
			LEFT JOIN '.$NOVIS_CSI_EWA_RATING->tbl_name.' as T01 ON T00.ewa_rating=T01.ewa_rating
		WHERE
			ewa_session_no IN ('.implode(',', $ewa_session_no).') 
		GROUP BY
			T00.ewa_rating
		ORDER BY
			T00.ewa_rating DESC
			';
	$ewa_ratings = $this->get_sql($sql);

	wp_register_script(
		'csiEWASummary',
		CSI_PLUGIN_URL.'/js/shortcodes/min/shortcode-ewa-summary-min.js' ,
		array('amcharts','amcharts-serial','amcharts-responsive'),
		'0.9.0'
	);
	wp_enqueue_script('csiEWASummary');
	$dataProvider = array();
	$graphs = array();
	foreach ( $ewa_ratings as $ewa_rating ){
		$graph = array(
			'balloonText'	=> "<small>[[title]]</small>",
			'fillAlphas'	=> 1,
			'lineAlpha'		=> 1,
			'title'			=> $ewa_rating['short_name'],
			'type'			=> "column",
			'fillColors'	=> '#'.$ewa_rating['hex_color'],
			'lineColor'		=> '#FFF',
			'valueField'	=> $ewa_rating['ewa_rating'],
			'id'			=> $ewa_rating['ewa_rating'],
		);
		array_push($graphs, $graph);
		$sql='SELECT
				T00.planned_date,
				T00.ewa_rating,
				T01.hex_color,
				COUNT(T00.ewa_session_no) as total
				FROM
				'.$this->tbl_name.' as T00 LEFT JOIN '.$NOVIS_CSI_EWA_RATING->tbl_name.' as T01 ON T00.ewa_rating=T01.ewa_rating
				WHERE
					T00.ewa_rating = "'.$ewa_rating['ewa_rating'].'"
					AND ewa_session_no IN ('.implode(',', $ewa_session_no).') 
				GROUP BY
					T00.planned_date
				ORDER BY
					T00.planned_date ASC
				';
		$ewas = $this->get_sql($sql,'ARRAY_A');
		foreach ($ewas as $ewa ){
			if ( $ewa['planned_date'] == '2016-07-14' ){
				self::write_log ( $ewa['planned_date'] );
				self::write_log ( self::findMonday($ewa['planned_date']) );
			}
			$ewa['planned_date'] = self::findMonday($ewa['planned_date']);
			$ewa['planned_date'] = $ewa['planned_date']->format('Y-m-d');
			
			$reg = array(
				'planned_date'				=> $ewa['planned_date'],
				$ewa_rating['ewa_rating']	=> $ewa['total'],
				'total'						=> $ewa['total'],
			);
			$index = array_search( $ewa['planned_date'], array_column( $dataProvider, 'planned_date' ) );
			if (FALSE === $index ){
				array_push($dataProvider, $reg);
			}else{
				if ( isset ( $dataProvider[$index][$ewa_rating['ewa_rating']] )){
					$dataProvider[$index][$ewa_rating['ewa_rating']] += $ewa['total'];
				}else{
					$dataProvider[$index][$ewa_rating['ewa_rating']] = $ewa['total'];					
				}
				$dataProvider[$index]['total'] += $ewa['total'];
			}
		}
//		array_multisort($dataProvider, SORT_ASC, SORT_STRING);
//		array_multisort($graphs, SORT_ASC, SORT_STRING);

	}
	$graph = array(
		'balloonText'		=> "<small>[[title]]</small>",
		'fillAlphas'		=> 1,
		'lineAlpha'			=> 1,
		'title'				=> $ewa_rating['short_name'],
		'type'				=> "column",
		'lineColor'			=> '#000',
		'valueField'		=> 'total',
		'id'				=> 'total',
		'visibleInLegend'	=> false,
		'hidden'			=> true,
	);
	array_push($graphs, $graph);
*/
	wp_register_script(
		'csiEWASummary',
		CSI_PLUGIN_URL.'/js/shortcodes/min/shortcode-ewa-summary-by-customer-min.js' ,
		array('amcharts','amcharts-serial','amcharts-responsive'),
		'0.9.0'
	);
	wp_enqueue_script('csiEWASummary');
	wp_localize_script(
		'csiEWASummary',
		'csiEWASummary',
		array(
			'ppost'			=> $this->plugin_post,
			'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
			'dataProvider'	=> $dataProvider,
			'graphs'		=> $graphs,
		)
	);
	self::write_log( json_encode($dataProvider));
	self::write_log( json_encode($graphs));
	$output.='<div class="row">';
		$output.='<div id="ewa_summary" class="ewa_summary_graph" style="min-height: 500px"></div>';
		$output.='<div id="ewa_summary_legend" class="ewa_summary_legend"  ></div>';
//		$output.='<p class="text-muted text-center"><small>Para generar esta gr&aacute;fica se han analizado '.count($customer).' clientes, '.count($system_no).' systemas ';
//		$output.=' y '.count($ewa_session_no).' reportes EWA considerando los reportes generados entre '.$past_datetime.' y '.$current_datetime.'<small></p>';
	$output.='</div>';
	return $output;
}

public function csi_shortcode_ewa_status($atts){
	//Variable definition
	global $wpdb;
	global $NOVIS_CSI_EWA_RATING;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_CUSTOMER_SYSTEM;
	global $NOVIS_CSI_SAPCUSTNO;
	$output = '';

	//Parameters evaluation
	$environment = array( 1, );
	$customer = $atts [ 'customer' ];
	if ( NULL == $customer ){
		//Current BLOG Customer
		$sql = 'SELECT id FROM '.$NOVIS_CSI_CUSTOMER->tbl_name.' WHERE blog_id = "'.get_current_blog_id().'"';
		$customer = $wpdb->get_col( $sql );
	}elseif ( 'all' == $customer){
		//All Customers
		$sql = 'SELECT id FROM '.$NOVIS_CSI_CUSTOMER->tbl_name;
		$customer = $wpdb->get_col( $sql );
	}else{
		$customer = explode ( ',', $customer );
		foreach ($customer as $key => $val ){
			if (FALSE == intval ( $customer[$key] ) ){
				$sql = 'SELECT id FROM '.$NOVIS_CSI_CUSTOMER->tbl_name.' WHERE code="'.$customer[$key].'"';
				$customer_id = $wpdb->get_var( $sql, 0, 0 );
				$customer[$key] = intval ( $customer_id );
			}
		}
	}

	//get SAPCUSTNO from $customer array
	$sql = 'SELECT sapcustno FROM '.$NOVIS_CSI_SAPCUSTNO->tbl_name.' WHERE customer_id IN ('.implode(', ', $customer ).')';
	$sapcustno = $wpdb->get_col( $sql );

	//get SYSTEMO_NO from $sapcustno array and $environment
	$sql = 'SELECT system_no FROM '.$NOVIS_CSI_CUSTOMER_SYSTEM->tbl_name;
	$sql.=' WHERE sapcustno IN ('.implode(', ', $sapcustno ).') AND environment_id IN ('.implode(',', $environment).') ORDER BY system_no';
	$system_no = $wpdb->get_col( $sql );

	//get EWA_SESSION_NO from $system_no aarray
	$weeks				= isset ($atts [ 'weeks' ]) ? intval( $atts [ 'weeks' ] ) : 53;
	$days				= intval ($weeks * 7 );
	$current_datetime	= new DateTime();
	$past_datetime		= new DateTime();
	$past_datetime		= $past_datetime->modify('-'. $days . ' days' );
	$current_datetime	=$current_datetime->format('Y-m-d');
	$past_datetime		=$past_datetime->format('Y-m-d');
	$sql				= 'SELECT ewa_session_no FROM '.$this->tbl_name.' WHERE system_no IN ('.implode(',', $system_no).') ';
	$sql				.='AND planned_date BETWEEN "'.$past_datetime.'" AND "'.$current_datetime.'"';
	$ewa_session_no		= $wpdb->get_col( $sql );
//	self::write_log($sql);
	$sql='SELECT
			T00.ewa_rating,
			T01.short_name,
			T01.hex_color
		FROM 
			'.$this->tbl_name.' as T00
			LEFT JOIN '.$NOVIS_CSI_EWA_RATING->tbl_name.' as T01 ON T00.ewa_rating=T01.ewa_rating
		WHERE
			ewa_session_no IN ('.implode(',', $ewa_session_no).') 
		GROUP BY
			T00.ewa_rating
		ORDER BY
			T00.ewa_rating DESC
			';
	$ewa_ratings = $this->get_sql($sql);

	wp_register_script(
		'csiEWASummary',
		CSI_PLUGIN_URL.'/js/shortcodes/min/shortcode-ewa-summary-min.js' ,
		array('amcharts','amcharts-serial','amcharts-responsive'),
		'0.9.0'
	);
	wp_enqueue_script('csiEWASummary');
	$dataProvider = array();
	$graphs = array();
	foreach ( $ewa_ratings as $ewa_rating ){
		$graph = array(
			'balloonText'	=> "<small>[[title]]</small>",
			'fillAlphas'	=> 1,
			'lineAlpha'		=> 1,
			'title'			=> $ewa_rating['short_name'],
			'type'			=> "column",
			'fillColors'	=> '#'.$ewa_rating['hex_color'],
			'lineColor'		=> '#FFF',
			'valueField'	=> $ewa_rating['ewa_rating'],
			'id'			=> $ewa_rating['ewa_rating'],
		);
		array_push($graphs, $graph);
		$sql='SELECT
				T00.planned_date,
				T00.ewa_rating,
				T01.hex_color,
				COUNT(T00.ewa_session_no) as total
				FROM
				'.$this->tbl_name.' as T00 LEFT JOIN '.$NOVIS_CSI_EWA_RATING->tbl_name.' as T01 ON T00.ewa_rating=T01.ewa_rating
				WHERE
					T00.ewa_rating = "'.$ewa_rating['ewa_rating'].'"
					AND ewa_session_no IN ('.implode(',', $ewa_session_no).') 
				GROUP BY
					T00.planned_date
				ORDER BY
					T00.planned_date ASC
				';
		$ewas = $this->get_sql($sql,'ARRAY_A');
		foreach ($ewas as $ewa ){
			$ewa['planned_date'] = self::findMonday($ewa['planned_date']);
			$ewa['planned_date'] = $ewa['planned_date']->format('Y-m-d');
			
			$reg = array(
				'planned_date'				=> $ewa['planned_date'],
				$ewa_rating['ewa_rating']	=> intval( $ewa['total'] ),
//				'total'						=> intval( $ewa['total'] ),
			);
			$index = array_search( $ewa['planned_date'], array_column( $dataProvider, 'planned_date' ) );
			if (FALSE === $index ){
				array_push($dataProvider, $reg);
			}else{
				if ( isset ( $dataProvider[$index][$ewa_rating['ewa_rating']] )){
					$dataProvider[$index][$ewa_rating['ewa_rating']] += intval( $ewa['total'] );
				}else{
					$dataProvider[$index][$ewa_rating['ewa_rating']] = intval( $ewa['total'] );
				}
//				$dataProvider[$index]['total'] += intval( $ewa['total'] );
			}
		}
//		array_multisort($dataProvider, SORT_ASC, SORT_STRING);
//		array_multisort($graphs, SORT_ASC, SORT_STRING);

	}
/*
	$graph = array(
		'balloonText'		=> "<small>[[title]]</small>",
		'fillAlphas'		=> 1,
		'lineAlpha'			=> 1,
		'title'				=> $ewa_rating['short_name'],
		'type'				=> "column",
		'lineColor'			=> '#000',
		'valueField'		=> 'total',
		'id'				=> 'total',
		'visibleInLegend'	=> false,
		'hidden'			=> true,
	);
	array_push($graphs, $graph);
*/	
	wp_register_script(
		'csiEWASummary',
		CSI_PLUGIN_URL.'/js/shortcodes/min/shortcode-ewa-summary-min.js' ,
		array('amcharts','amcharts-serial','amcharts-responsive'),
		'0.9.0'
	);
	wp_enqueue_script('csiEWASummary');
	wp_localize_script(
		'csiEWASummary',
		'csiEWASummary',
		array(
			'ppost'			=> $this->plugin_post,
			'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
			'dataProvider'	=> $dataProvider,
			'graphs'		=> $graphs,
		)
	);
//	self::write_log( json_encode($dataProvider));
//	self::write_log( json_encode($graphs));
	$output.='<div class="row">';
		$output.='<div id="ewa_summary" class="ewa_summary_graph" style="min-height: 500px"></div>';
		$output.='<div id="ewa_summary_legend" class="ewa_summary_legend"  ></div>';
		$output.='<p class="text-muted text-center"><small>Para generar esta gr&aacute;fica se han analizado '.count($customer).' clientes, '.count($system_no).' systemas ';
		$output.=' y '.count($ewa_session_no).' reportes EWA considerando los reportes generados entre '.$past_datetime.' y '.$current_datetime.'<small></p>';
	$output.='</div>';
	return $output;
}
public function csi_shortcode_ewa_ssystem_dashboard($atts){
	//global variables
	global $wpdb;
	global $NOVIS_CSI_CUSTOMER_SYSTEM;
	global $NOVIS_CSI_EWA_RATING;
	global $NOVIS_CSI_EWA_ALERT;
	global $NOVIS_CSI_EWA_ALERT_RATING;
	//local variables
	$o			='';
	$weeks		= 10;
	$system		= '312137533';
	$javascript = array (
		'ppost'							=> $this->plugin_post,
		'ajaxurl'						=> admin_url( 'admin-ajax.php' ),
	);

	$o.='<style>
			.csi-system-dashboard-alert-chart{
				height:20px;
			}
			.csi-system-dashboard-ewa-chart{
				height:80px;
			}
			</style>';
	//check if system exists
	//calculate dates
	//get info of system
	//get ewas of system in ewas
	//build ewa status chart info
	//build table
	//build header
	//get alerts  in ewas
	//foreach alert build two rows
		//build row of alert
		//build info of alert chart
		//build alert table
		//get alerts detail
		//fill alerts detail
	//Parameters evaluation
	$system = intval ( $atts [ 'system' ] );
	if ( NULL == $system || 0 === $system){
		//error message
	}else{
		$start_date			= self::findMonday();
		$days				= intval ($weeks * 7 );
		$current_datetime	= new DateTime();
		$past_datetime		= new DateTime();
		$past_datetime		= $past_datetime->modify('-'. $days . ' days' );
		$current_datetime	= $current_datetime->format('Y-m-d');
		$past_datetime		= $past_datetime->format('Y-m-d');
		$sql = 'SELECT ewa_session_no FROM '.$this->tbl_name.' WHERE system_no="'.$system.'" AND planned_date BETWEEN "'.$past_datetime.'" AND "'.$current_datetime.'"';
		$ewas_id = $wpdb->get_col ( $sql);

		//System Table
		$o.='<div>';
		$o.='<table class="table table-condensed">';
		//System Table Head
		$o.='<thead>';
		$o.='<tr>';
		$sql = 'SELECT
					T00.ewa_session_no,
					T00.planned_date,
					T01.short_name,
					T01.icon,
					T01.css_class,
					T01.hex_color
				FROM
					' . $this->tbl_name . ' as T00
					LEFT JOIN ' . $NOVIS_CSI_EWA_RATING->tbl_name . ' as T01
						ON T00.ewa_rating = T01.ewa_rating
				WHERE
					T00.ewa_session_no IN ('.implode(',', $ewas_id).')
				ORDER BY
					T00.planned_date
		';
		$ewas_data_temp	= $this->get_sql ( $sql );
		$graphs_ewa_data = array();
		foreach ( $ewas_data_temp as $graph_ewa_data ){
			$graphs_ewa_data[$graph_ewa_data['planned_date']] = array(1, $graph_ewa_data['ewa_session_no'], $graph_ewa_data['hex_color'] );
		}
		$dataProvider		= array();
		
		$aa1 = new DateTime($past_datetime);
		$aa2 = new DateTime($current_datetime);
		$daterange = new DatePeriod($aa1, new DateInterval('P1D'), $aa2);
		foreach($daterange as $date){
			$i_date					= $date->format('Y-m-d');
			$val					= isset ( $graphs_ewa_data[ $i_date ] ) ? 1 : null ;
			$color			= isset ( $graphs_ewa_data[ $i_date ] ) ? $graphs_ewa_data[ $i_date ][2] : null ;
			$data_point = array(
				'planned_date'		=> $i_date,
				'color'				=>'#'.$color,
				'val'				=> $val,
			);
			array_push($dataProvider, $data_point);
		}
		$javascript [ $system . '_DataProvider' ] = $dataProvider;
		$graphs = array(
			array(
				"balloonText"	=> "<small>[[category]]</small>",
				"colorField"	=> 'color',
				"fillAlphas"	=> 1,
				"lineThickness"	=> 0,
				"lineAlpha"		=> 0.5,
				"title"			=> $system,
				"type"			=> "column",
				"valueField"	=> "val",
				//------
				"type"			=> "line",
				"lineColor"		=> "#786c56",
				"fillAlphas"	=> 0,
				"lineAlpha"		=> 0,
				"bullet" 		=> "circle",
				"lineColorField"	=> 'color',
				"bulletBorderAlpha"=> 0.125,
				"bulletBorderColor"=> "#000000",
				"bulletSize"	=> 20,
				"bulletBorderThickness"=> 2,
			),
		);
		$javascript [ $system . '_Graphs' ] = $graphs;
		$system_row = $NOVIS_CSI_CUSTOMER_SYSTEM->get_row_by_system_no($system);
		$o.='<th>';
		$o.='<h3> Sistema '.$system_row['sid'].' <small>' . $system . '</small></h3>';
		$o.='<p><a href="#ewa-dashboard-alerts-' . $system . '" data-toggle="collapse">mas</a></p>';
		$o.='<div
				class="csi-system-dashboard-ewa-chart"
				id="' . $system . '"
				data-chart-data="' . $system . '"
				data-system-id="'.$system.'"
			></div>';
		$o.='</th>';

		$o.='</tr>';
		$o.='</thead>';
		$o.='</table>';
		
		//System Table Body
		$o.='<table class="table table-condensed collapse" id="ewa-dashboard-alerts-' . $system . '">';
		$o.='<tbody>';

		$sql = 'SELECT
				T00.alert_group,
				T00.alert_rating,
				T00.alert_no,
				T00.alert_text,
				T01.icon,
				T01.css_class,
				T01.hex_color
			FROM
				'.$NOVIS_CSI_EWA_ALERT->tbl_name.' as T00
				LEFT JOIN '.$NOVIS_CSI_EWA_ALERT_RATING->tbl_name.' as T01
					ON T00.alert_rating=T01.alert_rating
			WHERE
				ewa_session_no IN ('.implode(',', $ewas_id).')
			GROUP BY
				alert_group,
				alert_no
		';
		$alerts = $this->get_SQL ( $sql );

		foreach ( $alerts as $alert ){
			$alert_id = $system . '_' . $alert['alert_group'] . '_' . $alert['alert_no'];
			$o.='<tr class="active">';
			$o.='<td>';
			$o.='<div class="clearfix">';
			$o.='<h5 class="pull-left"><i class="fa fa-' . $alert['icon'] . ' text-' . $alert['css_class'] . ' fa-fw"></i> ' . $alert['alert_text'] . ' </h5>';
			$o.='<div class="pull-right">';
			$o.='<button class="btn btn-default" data-target="#' . $alert_id . '_detail" data-toggle="collapse">';
			$o.='Ver mas';
			$o.='</button>';
			$o.='</div>';
			$o.='</div>';
			//Alert Chart
			$sql = 'SELECT
						T01.planned_date,
						T00.alert_rating,
						T00.alert_text,
						T00.last_modified_user_id,
						T00.last_modified_user_email,
						T00.last_modified_date,
						T00.last_modified_time,
						T00.action_party_id,
						T00.action_id,
						T02.icon,
						T02.css_class,
						T02.hex_color
					FROM
						' . $NOVIS_CSI_EWA_ALERT->tbl_name . ' as T00
						LEFT JOIN ' . $this->tbl_name . ' as T01
							ON T00.ewa_session_no = T01.ewa_session_no
						LEFT JOIN '.$NOVIS_CSI_EWA_ALERT_RATING->tbl_name.' as T02
							ON T00.alert_rating=T02.alert_rating
					WHERE
						T00.alert_group		= "' . $alert['alert_group'] . '"
						AND T00.alert_no	= "' . $alert['alert_no'] . '"
						AND T00.ewa_session_no IN ('.implode(',', $ewas_id).')
					ORDER BY
						T01.planned_date
			';


			$alerts_data_temp	= $this->get_sql ( $sql );
			$graphs_alert_data = array();
			foreach ( $alerts_data_temp as $graph_alert_data ){
				$graphs_alert_data[$graph_alert_data['planned_date']] = 1;
			}
			$dataProvider		= array();
			
			$aa1 = new DateTime($past_datetime);
			$aa2 = new DateTime($current_datetime);
			$daterange = new DatePeriod($aa1, new DateInterval('P1D'), $aa2);
			foreach($daterange as $date){
				$i_date = $date->format('Y-m-d');
				$val = isset ( $graphs_alert_data[ $i_date ] ) ? 1 : null ;
				$data_point = array(
					'planned_date'	=> $i_date,
					'val'			=> $val,
				);
				array_push($dataProvider, $data_point);
			}
			$javascript [ $alert_id . '_DataProvider' ] = $dataProvider;
			$graphs = array(
				array(
					"balloonText"	=> "<small>[[category]]</small>",
					"fillColors"	=> array ('#'.$alert['hex_color']),
					"fillAlphas"	=> 1,
					"lineThickness"	=> 0,
					"lineAlpha"		=> 0.5,
					"title"			=> $system,
					"type"			=> "column",
					"valueField"	=> "val",
					//------
//					"type"			=> "line",
//					"lineColor"		=> "#786c56",
//					"fillAlphas"	=> 0,
//					"lineAlpha"		=> 0,
//					"bullet" 		=> "circle",
//					"bulletColor"	=> array ('#'.$alert['hex_color']),
//					"bulletBorderAlpha"=> 0.125,
//					"bulletBorderColor"=> "#000000",
//					"bulletSize"	=> 20,
//					"bulletBorderThickness"=> 2,
				),
			);
			$javascript [ $alert_id . '_Graphs' ] = $graphs;
			$o.='<div
					class="csi-system-dashboard-alert-chart"
					id="' . $alert_id . '"
					data-chart-data="' . $alert_id . '"
					data-system-id="'.$system.'"
				></div>';
				
			$o.='</td>';
			$o.='</tr>';
			$o.='<tr class="collapse" id="' . $alert_id . '_detail">';
			$o.='<td colspan="999" >';

			//Detailed Alert Table
			$o.='<table class="table table-condensed">';

			//Detailed Alert Table Head
			$o.='<thead>';
			$o.='<tr>';
			$o.='<th>Fecha</th>';
			$o.='<th class="text-center">Rating</th>';
			$o.='<th class="text-center">Prioridad</th>';
			$o.='<th class="text-center">&Uacute;ltima modificaci&oacute;n</th>';
			$o.='<th class="text-center">Acci&oacute;n</th>';
			$o.='</tr>';	
			$o.='</thead>';

			//Detailed Alert Table Body
			$o.='<tbody>';
			foreach ( $alerts_data_temp as $alert ){
				$o.='<tr>';
				$o.='<td>' . $alert['planned_date'] . '</td>';
				$o.='<td class="text-center"><i class="fa fa-' . $alert['icon'] . ' text-' . $alert['css_class'] . '"></i></td>';
				$o.='<td class="text-center"><small class="text-danger">
											<i class="fa fa-star fa-sm"></i>
											<i class="fa fa-star fa-sm"></i>
											<i class="fa fa-star-o fa-sm"></i>
											<i class="fa fa-star-o fa-sm"></i>
											<i class="fa fa-star-o fa-sm"></i>
										</small>
					</td>';
				if ( $alert['last_modified_user_id'] > 0 ){
					$user_info = get_userdata($alert['last_modified_user_id']);
					$user_name = $user_info->user_login;
				}else{
					$user_name = '';
				}
				$o.='<td class="text-center">
						<p class=""><a href="mailto:' . $alert['last_modified_user_email'] . '">' . $user_name . '</a></p>
						<p class="text-muted"><small>' . $alert['last_modified_date'] . ' - ' . $alert['last_modified_time'] . '</small></p>
					</td>';
				$o.='<td class="text-center"><a href="#" class="btn btn-primary">Accion</a></td>';
				$o.='</tr>';
				
			}
			
			$o.='</tbody>';
			
			$o.='</table>';
			$o.='</td>';
			$o.='</tr>';			
		}
		$o.='</tbody>';
		$o.='</table>';
		$o.='</div>';
		wp_register_script(
			'csiEWASystemDashboard',
			CSI_PLUGIN_URL.'/js/shortcodes/min/shortcode-ewa-system-dashboard-min.js' ,
			array('jquery','bootstrap','amcharts','amcharts-serial','amcharts-responsive'),
			'0.0.1'
		);
		wp_enqueue_script('csiEWASystemDashboard');
		wp_localize_script(
			'csiEWASystemDashboard',
			'csiEWASystemDashboard'.$system,
			$javascript
		);
	}
	return $o;
}
public function csi_shortcode_ewa_customer_block($atts){
	//global variables
	global $wpdb;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_CUSTOMER_SYSTEM;
	global $NOVIS_CSI_EWA_RATING;
	global $NOVIS_CSI_EWA_ALERT;
	global $NOVIS_CSI_EWA_ALERT_RATING;
	global $NOVIS_CSI_SAPCUSTNO;
	//local variables
	$customers		= array( 20);
	$environment	= array(1);
	$o				='';
	$weeks			= isset ($atts [ 'weeks' ]) ? intval( $atts [ 'weeks' ] ) : 0;
	$days			= intval ($weeks * 7 );
	$javascript = array (
		'ppost'							=> $this->plugin_post,
		'ajaxurl'						=> admin_url( 'admin-ajax.php' ),
	);
	$o.='<style>
			.ewa-customer-block-ewa-chart{
				vertical-align: middle;
				min-height:100px;
			}
			</style>';
	$customer = isset ( $atts [ 'customer' ] ) ? $atts [ 'customer' ] : NULL;
	if ( NULL == $customer ){
		if ( is_multisite() ){
			//Current BLOG Customer
			$sql = 'SELECT id FROM '.$NOVIS_CSI_CUSTOMER->tbl_name.' WHERE blog_id = "'.get_current_blog_id().'"';
			$customer = $wpdb->get_col( $sql );
		}else{
			$customer = 'all';
		}
	}
	if ( 'all' == $customer){
		//All Customers
		$sql = 'SELECT id FROM '.$NOVIS_CSI_CUSTOMER->tbl_name;
		$customer = $wpdb->get_col( $sql );
	}else{
		$customer = explode ( ',', $customer );
		foreach ($customer as $key => $val ){
			if (FALSE == intval ( $customer[$key] ) ){
				$sql = 'SELECT id FROM '.$NOVIS_CSI_CUSTOMER->tbl_name.' WHERE code="'.$customer[$key].'"';
				$customer_id = $wpdb->get_var( $sql, 0, 0 );
				$customer[$key] = intval ( $customer_id );
			}
		}
	}
	$customers = $customer;

	$now			= new DateTime();
	if ( 0 != $days ){
		$now = $now->modify('-' . $days . ' days' );
	}
	$week			= $now->format("W");
	$year			= $now->format("Y");
	$monday			= new DateTime();
	$monday->setISODate($year,$week);
	$monday			= $monday->format('Y-m-d');
	$sunday			= new DateTime();
	$sunday->setISODate($year,$week,7);
	$sunday 		= $sunday->format('Y-m-d');
	$o.='	<h1>Dashboard de Reportes EWA Semanal <small> Semana ' . $week . ' ' .$year . ' ( ' . $monday . '-' . $sunday . ')</small></h1>';
	$o.='<div class="row">';
	foreach ( $customers as $customer){
		//get SAPCUSTNO from $customer array
		$sql = 'SELECT sapcustno FROM '.$NOVIS_CSI_SAPCUSTNO->tbl_name.' WHERE customer_id = "' . $customer .'"';
		$sapcustno = $wpdb->get_col( $sql );
		if ( 0 == count ($sapcustno) ){
			continue;
		}
	
		//get SYSTEMO_NO from $sapcustno array and $environment
		$sql = 'SELECT system_no FROM '.$NOVIS_CSI_CUSTOMER_SYSTEM->tbl_name;
		$sql.=' WHERE sapcustno IN ('.implode(', ', $sapcustno ).') AND environment_id IN ('.implode(',', $environment).') ORDER BY system_no';
		$system_no = $wpdb->get_col( $sql );
		if ( 0 == count ($system_no) ){
			continue;
		}
	
		//get EWA_SESSION_NO from $system_no array
		$sql = 'SELECT
					T00.ewa_session_no,
					T00.ewa_rating,
					T01.short_name,
					T01.hex_color
				FROM
					' . $this->tbl_name . ' as T00
					LEFT JOIN ' . $NOVIS_CSI_EWA_RATING->tbl_name . ' as T01
						ON T00.ewa_rating=T01.ewa_rating
				WHERE
					system_no IN ('.implode(',', $system_no).')
					AND planned_date BETWEEN "'.$monday.'" AND "'.$sunday.'"
		';
		$ewas_id = $wpdb->get_col( $sql );
		$ewas	= $this->get_sql ( $sql );
		if ( 0 == count ($ewas) ){
			continue;
		}
	
		$dataProvider = array();
		foreach ( $ewas as $ewa ){
			$reg = array(
				'title'	=> $ewa['short_name'],
				'ewas'	=> 1,
				'color'	=> '#' . $ewa['hex_color']
			);
			$index = array_search( $ewa['short_name'], array_column( $dataProvider, 'title' ) );
			if (FALSE === $index ){
				array_push($dataProvider, $reg);
			}else{
				$dataProvider[$index]['ewas'] += 1;
			}
		}
		$javascript [ $customer . '_ewa_DataProvider' ] = $dataProvider;
		//get ALERTS from $ewas_id array
		$sql = 'SELECT
					T00.alert_rating
				FROM
					' . $NOVIS_CSI_EWA_ALERT->tbl_name . ' as T00
					LEFT JOIN ' . $NOVIS_CSI_EWA_ALERT_RATING->tbl_name . ' as T01
						ON T00.alert_rating=T01.alert_rating
				WHERE
					T00.ewa_session_no IN ('.implode(',', $ewas_id).')
		';
		$alerts	= $wpdb->get_col ( $sql );

		$o.='<div class="csi-ewa-customer-block col-xs-12 col-sm-4 col-md-3 col-lg-3">';
		$o.='<div class="panel panel-default">';
			$sql = 'SELECT code, short_name, blog_id FROM ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' WHERE id = "' . $customer . '"';
			$customer_data = $this->get_sql( $sql );
			$o.='<div class="panel-heading">
					<a href="' . get_site_url( $customer_data[0]['blog_id'], 'co/ewa-management' ) . '">
						<p class="panel-title">' . $customer_data[0]['short_name'] . ' <small>(' . $customer_data[0]['code'] . ')</small></p>
					</a>
				</div>';
			$o.='<div class="panel-body">';
				$o.='<div class="row">
						<div
							class="ewa-customer-block-ewa-chart"
							id="ewa-customer-block-ewa-chart-' . $customer . '"
							data-chart-data="' . $customer . '_ewa"
							data-customer-id="' . $customer . '"
							></div>
					</div>';
				$o.='<div class="row">
						<div class="col-xs-4 text-center">
							<div class=""><strong>' . count( $system_no ) . '</strong></div>
							<div class="text-muted"><small>Sistemas</small></div>
						</div>
						<div class="col-xs-4 text-center">
							<div class=""><strong>' . count( $ewas ) . '</strong></div>
							<div class="text-muted"><small>EWA</small></div>
						</div>
						<div class="col-xs-4 text-center">
							<div class=""><strong>' . count ($alerts ) . '</strong></div>
							<div class="text-muted"><small>Alertas</small></div>
						</div>
					</div>
					';
			$o.='</div><!-- end panel-body -->';
//			$o.='<div class="panel-footer clearfix">';
//				$o.='<p class="text-center"><strong>Semana ' . $week . '</strong> <small>(' . $year . ')</small></p>';
//				$o.='<small class="col-xs-6 text-center">' . $monday . '</small>';
//				$o.='<small class="col-xs-6 text-center">' . $sunday . '</small>';
//			$o.='</div><!-- end panel-footer -->';
		$o.='</div><!-- end panel -->';
		$o.='</div><!-- end csi-ewa-customer-block -->';		
	}
	$o.='</div><!-- end row -->';
	wp_register_script(
		'csiEWACustomerBlock',
		CSI_PLUGIN_URL.'/js/shortcodes/min/shortcode-ewa-customer-block-min.js' ,
		array('jquery','bootstrap','amcharts','amcharts-serial','amcharts-responsive','amcharts-pie'),
		'0.0.1'
	);
	wp_enqueue_script('csiEWACustomerBlock');
	wp_localize_script(
		'csiEWACustomerBlock',
		'csiEWACustomerBlock',
		$javascript
	);
	return $o;
}
//END OF CLASS	
}

global $NOVIS_CSI_EWA;
$NOVIS_CSI_EWA =new NOVIS_CSI_EWA_CLASS();
?>