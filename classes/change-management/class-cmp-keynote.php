<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_KEYNOTE_CLASS extends NOVIS_CSI_CLASS{

public function __construct(){
	add_action( 'wp_ajax_csi_cmp_keynote_build_page',		array( $this , 'csi_cmp_keynote_build_page'	));
	add_action( 'wp_ajax_csi_cmp_keynote_fetch_slide',		array( $this , 'csi_cmp_keynote_fetch_slide'));
}
public function csi_cmp_keynote_build_page(){
	//Local Vaariables
	$response 	= array();
	$o			= '';
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	if ( isset ( $post['view'] ) ){
		switch ( $post['view'] ){
			case 'build_keynote':
				$o=$this->csi_cmp_keynote_build_keynote ( $post['customer_id'] );
				break;
			default:
				$o = $this->csi_cmp_keynote_build_page_intro();
		}
	}else{
		$o = $this->csi_cmp_keynote_build_page_intro();
	}

	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
protected function csi_cmp_keynote_build_keynote ( $customer_id ){
	global $NOVIS_CSI_CUSTOMER;
	$customer = $NOVIS_CSI_CUSTOMER->get_single ( $customer_id );
	$o='
	<div class="container">
		<div class="hidden-print">
			<h1>Resumen de actividades para <i>' . $customer['short_name'] . '</i></h1>
			<p>La vista de <i>presentaci&oacute;n</i> permite generar una vista similar a los reportes semanales entregados en muchos clientes.</p>
			<form>
				<div class="form-group col-sm-6">
					<div class="">
						<input type="checkbox" class="form-control csi-cool-checkbox csi-cmp-keynote-option" id="finished_tasks" name="finished_tasks" data-keynote-target="#csi-cmp-keynote-holder" value="1" checked>
						<label for="finished_tasks">Actividades ejecutadas</label>
					</div>
				</div>
				<div class="form-group col-sm-6">
					<div class="">
						<input type="checkbox" class="form-control csi-cool-checkbox csi-cmp-keynote-option" id="next_tasks" name="next_tasks" data-keynote-target="#csi-cmp-keynote-holder" value="1" checked>
						<label for="next_tasks">Siguientes Actividades</label>
					</div>
				</div>
				<div class="form-group col-sm-6">
					<div class="">
						<input type="checkbox" class="form-control csi-cool-checkbox csi-cmp-keynote-option" id="pending_tasks" name="pending_tasks" data-keynote-target="#csi-cmp-keynote-holder" value="1">
						<label for="pending_tasks">Actividades Pendientes</label>
					</div>
				</div>
				<div class="form-group col-sm-6">
					<div class="">
						<input type="checkbox" class="form-control csi-cool-checkbox csi-cmp-keynote-option" id="alert_tasks" name="alert_tasks" data-keynote-target="#csi-cmp-keynote-holder" value="1">
						<label for="alert_tasks">Actividades con atraso y error</label>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="container">
		<div style="position:relative;" class="row">
			<div id="csi-cmp-keynote-holder" class="refreshable" data-customer-id="' . $customer_id . '" data-action="csi_cmp_keynote_fetch_slide" data-tasks=\'["finished_tasks","next_tasks"]\'></div>
		</div>
	</div>';
	return $o;
}
public function csi_cmp_keynote_fetch_slide(){
	//Global Variables
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_CMP;
	global $NOVIS_CSI_CMP_TASK;
	global $NOVIS_CSI_SERVICE;
	global $NOVIS_CSI_CUSTOMER_SYSTEM;
	global $NOVIS_CSI_CMP_TASK_STATUS;
	global $wpdb;
	//Local Variables
	$response			= array();
	$current_datetime	= new DateTime();
	$o					= '';
	$limit				= 5;
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//self::write_log($post);
	$customer_id = $post['customerId'];
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_CMP->tbl_name . ' WHERE customer_id = "' . $customer_id . '"';
	$plans = $this->get_sql ( $sql );
	foreach ( $plans as $plan ){
		$progress = $NOVIS_CSI_CMP->csi_cmp_calculate_cmp_percentage ( $plan['id'] );
		$progress_plan_color = '#337AB7';
		$progress_real_color = ( $progress['warning'] || $progress['error'] ) ? '#f0AD4E' : '#337AB7';
		$o.='
		<div class="csi-cmp-keynote-slide col-xs-12">
			<div class="csi-cmp-keynote-slide-top">
				<img src="' . CSI_PLUGIN_URL . '/img/bg/csi-cmp-keynote-slide-background-top.png"/>
			</div>
			<div class="csi-cmp-keynote-slide-bottom">
				<img src="' . CSI_PLUGIN_URL . '/img/bg/csi-cmp-keynote-slide-background-bottom.png"/>
			</div>
			<div class="row">
				<div class="col-xs-10">
					<h2 class="text-danger">' . $plan['title'] . ' <a href="#!showplan?plan_id=' . $plan['id'] . '" class="hidden-print" target="_blank"><small><i class="fa fa-external-link"></i></small></a></h2>
					<p class="lead">' . $plan['description'] . '</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<h3 class="text-danger">Avance del plan</h3>
					<div class="row">
						<div class="col-xs-6">
							<h5 class="text-center">Planificado</h5>
							<div class="csi-cmp-keynote-slide-gauge" data-value="' . intval ( $progress['success'] + $progress['warning'] + $progress['error']  ) . '" data-end-value="100" data-top-text="' . intval ( $progress['success'] + $progress['warning'] + $progress['error']  ) . '%" id="csi-cmp-keynote-slide-gauge-plan-' . $plan['id'] . '"
							data-back-color="#EEE" data-front-color="' . $progress_plan_color . '" ></div>
						</div>
						<div class="col-xs-6">
							<h5 class="text-center">Real</h5>
							<div class="csi-cmp-keynote-slide-gauge" data-value="' . intval ( $progress['success'] ) . '" data-end-value="100" data-top-text="' . intval ( $progress['success'] ) . '%" data-back-color="#EEE" data-front-color="' . $progress_real_color . '" id="csi-cmp-keynote-slide-gauge-real-' . $plan['id'] . '"></div>
						</div>
					</div>
					<br/>
					' . $progress['progress_bar'] . '
				</div><!-- .col-sm-4 -->';
		$o.='
				<div class="col-sm-7 col-sm-offset-1">
		';
		foreach ( explode( ',', $post['tasks'] ) as $table_type ) {
			$o.=self::csi_cmp_keynote_tasks_table ( $table_type, $plan );
		}
		$o.='
				</div><!-- .col-sm-7 -->
			</div><!-- .row -->
		</div><!-- .csi-cmp-keynote-slide -->

		';
	}
	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
protected function csi_cmp_keynote_build_page_intro(){
	global $NOVIS_CSI_COUNTRY;
	global $NOVIS_CSI_CUSTOMER;
	$o='
	<div class="container">
		<div class="jumbotron">
			<h1 class="text-center">Keynote</h1>
			<p></p>
		</div>
		<div class="">';
	foreach( $NOVIS_CSI_COUNTRY->get_all() as $key => $value ){
		$o.='
		<div class="col-sm-4">
			<div class="panel panel-info">
				<div class="panel-heading">' . $value['short_name'] . '</div>';
				$sql='SELECT id, short_name, code FROM ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' WHERE country_id = "' . $value['id'] . '" ORDER BY short_name ASC';
				$customers = $this->get_sql ( $sql );
				foreach ( $customers as $customer ){
					$o.='
						<div class="list-group">
							<a href="#!keynote?view=build_keynote&customer_id=' . $customer['id'] . '" class="list-group-item">' . $customer['short_name'] . '</a>
						</div>';
				}
		$o.='
			</div>
		</div>
		';
	}
	$o.='
		</div>
	</div>';
	return $o;
}
protected function csi_cmp_keynote_tasks_table ( $task_type = '' , $plan = array(), $limit = 5 ) {
	//Global Variables
	global $NOVIS_CSI_CMP_TASK;
	global $NOVIS_CSI_SERVICE;
	global $NOVIS_CSI_CUSTOMER_SYSTEM;
	global $NOVIS_CSI_CMP_TASK_STATUS;
	//Local Variables
	$current_datetime	= new DateTime();
	$task_table			= '';
	switch ( $task_type ){
		case 'finished_tasks':
			$title='Actividades ejecutadas';
			$sql_cond='
				AND T00.start_datetime <= "' . $current_datetime->format('Y-m-d H:i:s') . '"
				AND ( T03.cmp_finished_flag="1" OR T03.cmp_finished_end_flag="1")
			';
			break;
		case 'next_tasks':
			$title='Pr&oacute;ximas actividades';
			$sql_cond='
				AND T00.start_datetime > "' . $current_datetime->format('Y-m-d H:i:s') . '"
			';
			break;
		case 'pending_tasks':
			$title='Actividades pendientes';
			$sql_cond='
				AND T03.cmp_total_flag = 1
				AND T03.cmp_finished_flag != 1
				AND T03.cmp_finished_start_flag != 1
				AND T03.cmp_finished_end_flag != 1
				AND T00.start_datetime <= "' . $current_datetime->format('Y-m-d H:i:s') . '"
			';
			break;
		case 'alert_tasks':
			$title='Actividades con atraso o error';
			$sql_cond='
				AND
					(
					(T03.cmp_finished_start_flag!=0 AND T00.start_datetime<NOW() )
					OR ( T03.cmp_finished_end_flag!=0 AND T00.end_datetime<NOW() )
					OR ( T03.cmp_error_flag = 1 )
					)
			';
			break;
		default:
			$title = '--';
			$sql_cond = '';
	}
	$sql = '
		SELECT
			T00.*,
			T01.name as service_name,
			T02.sid as sid,
			T03.icon as status_icon,
			T03.hex_color as status_hex_color,
			T03.short_name as status_short_name
		FROM
			' . $NOVIS_CSI_CMP_TASK->tbl_name . ' as T00
			LEFT JOIN ' . $NOVIS_CSI_SERVICE->tbl_name . ' as T01
				ON T00.service_id = T01.id
			LEFT JOIN ' . $NOVIS_CSI_CUSTOMER_SYSTEM->tbl_name . ' as T02
				ON T00.customer_system_id = T02.id
			LEFT JOIN ' . $NOVIS_CSI_CMP_TASK_STATUS->tbl_name . ' as T03
				ON T00.status_id = T03.id
		WHERE
			T00.cmp_id="' . $plan['id'] . '"
		' . $sql_cond . '
		ORDER BY
			T00.start_datetime
			ASC
		LIMIT
			' . $limit . '
	';
	$tasks = $this->get_sql ( $sql );
	$tasks = array_reverse ( $tasks, true );
	$task_table='
				<div>
					<h3 class="text-danger">' . $title . '</h3>
					<p class="help-block small">Se muestra un m&aacute;ximo de ' . $limit . ' actividades</p>
					<table class="table table-condensed">
						<tbody>';
	foreach ( $tasks as $task ){
		$start_datetime = new DateTime( $task['start_datetime']);
		$task_table.='
						<tr>
							<td><samp class="text-muted">' . $start_datetime->format('D d/m') . '</samp></td>
							<td><samp>' . $task['sid'] . '</samp></td>
							<td>' . $task['service_name'] . '</td>
						</tr>
		';
	}
	$task_table.='
					</tbody>
				</table>
			</div>
		';
	return $task_table;
}
//END OF CLASS
}

global $NOVIS_CSI_KEYNOTE;
$NOVIS_CSI_KEYNOTE =new NOVIS_CSI_KEYNOTE_CLASS();
?>
