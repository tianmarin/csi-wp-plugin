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
	$o='
	<div class="container">
		<div class="hidden-print">
			<h1>Filtro</h1>
			<table class="table">
			 	<thead>
					<th>Tabla de filtros</th>
				</thead>
				<tbody>
					<td>
						<a href="#csi-cmp-keynote-holder" class="refresh-button btn btn-primary btn-sm btn-block"><i class="fa fa-refresh"></i> Refrescar</a>
					</td>
				</tbody>
			</table>
		</div>
		<div style="position:relative;" class="row">
			<div id="csi-cmp-keynote-holder" class="refreshable" data-customer-id="' . $customer_id . '" data-action="csi_cmp_keynote_fetch_slide"></div>
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
	global $wpdb;
	//Local Variables
	$response			= array();
	$current_datetime	= new DateTime();
	$o					= '';
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	//self::write_log($post);
	$customer_id = $post['customerId'];
	$sql = 'SELECT * FROM ' . $NOVIS_CSI_CMP->tbl_name . ' WHERE customer_id = "' . $customer_id . '"';
	$plans = $this->get_sql ( $sql );
	foreach ( $plans as $plan ){
		$progress = $NOVIS_CSI_CMP->csi_cmp_calculate_cmp_percentage($plan['id']);
		$o.='
		<div class="csi-cmp-keynote-slide col-xs-12">
			<div class="csi-cmp-keynote-slide-top">
				<img src="' . CSI_PLUGIN_URL . '/img/bg/csi-cmp-keynote-slide-background-top.png"/>
			</div>
			<div class="csi-cmp-keynote-slide-bottom">
				<img src="' . CSI_PLUGIN_URL . '/img/bg/csi-cmp-keynote-slide-background-bottom.png"/>
			</div>
			<div class="col-xs-10">
				<h1 class="text-danger">' . $plan['title'] . '</h1>
				<p class="lead">' . $plan['description'] . '</p>
			</div>
			<div class="">
				<div class="col-sm-4">
					<h2 class="text-danger">Avance del plan</h2>
					<div class="row">
						<div class="col-sm-6">
							<div>gráfico</div>
							<p>Plan: ' . intval ( $progress['success'] + $progress['warning'] + $progress['error']  ) . '%</p>
						</div>
						<div class="col-sm-6">
							<div>gráfico</div>
							<p>Real: ' . intval ( $progress['success'] ) . '%</p>
						</div>
					</div>
					' . $progress['progress_bar'] . '
				</div>
				<div class="col-sm-8">
					<h2 class="text-danger">Actividades Ejecutadas</h2>
					<p class="help-block text-right small">S&oacute;lo se muestran las &uacute;ltimas 5 actividades</p>
					<ul>';
		$sql = '
			SELECT
				T00.*,
				T01.name as service_name,
				T02.sid as sid
			FROM
				' . $NOVIS_CSI_CMP_TASK->tbl_name . ' as T00
				LEFT JOIN ' . $NOVIS_CSI_SERVICE->tbl_name . ' as T01
					ON T00.service_id = T01.id
				LEFT JOIN ' . $NOVIS_CSI_CUSTOMER_SYSTEM->tbl_name . ' as T02
					ON T00.customer_system_id = T02.id
			WHERE
				cmp_id="' . $plan['id'] . '"
				AND T00.start_datetime <= "' . $current_datetime->format('Y-m-d H:i:s') . '"
			ORDER BY
				T00.start_datetime
				DESC
			LIMIT
				5
				';
		$tasks = $this->get_sql ( $sql );
		$tasks = array_reverse ( $tasks, true );
		foreach ( $tasks as $task ){
			$start_datetime = new DateTime( $task['start_datetime']);
			$o.='
							<li><samp><span class="text-muted">' . $start_datetime->format('D d/m') . '</span> - [' . $task['sid'] . ']</samp> <i class="fa fa-caret-right"></i> ' . $task['service_name'] . ' - </li>
			';
		}
		$o.='
					</ul>
				</div>
			</div>
			<div class="">
				<div class="col-sm-4">
				</div>
				<div class="col-sm-8">
					<h2 class="text-danger">Actividades Por ejecutar</h2>
					<p class="help-block text-right small">S&oacute;lo se muestran las pr&oacute;ximas 5 actividades</p>
					<ul>';
		$sql = '
			SELECT
				T00.*,
				T01.name as service_name,
				T02.sid as sid
			FROM
				' . $NOVIS_CSI_CMP_TASK->tbl_name . ' as T00
				LEFT JOIN ' . $NOVIS_CSI_SERVICE->tbl_name . ' as T01
					ON T00.service_id = T01.id
				LEFT JOIN ' . $NOVIS_CSI_CUSTOMER_SYSTEM->tbl_name . ' as T02
					ON T00.customer_system_id = T02.id
			WHERE
				cmp_id="' . $plan['id'] . '"
				AND T00.start_datetime > "' . $current_datetime->format('Y-m-d H:i:s') . '"
			ORDER BY
				T00.start_datetime
				ASC
			LIMIT
				5
				';
		$tasks = $this->get_sql ( $sql );
		//$tasks = array_reverse ( $tasks, true );
		foreach ( $tasks as $task ){
			$start_datetime = new DateTime( $task['start_datetime']);
			$o.='
							<li><samp><span class="text-muted">' . $start_datetime->format('D d/m') . '</span> - [' . $task['sid'] . ']</samp> <i class="fa fa-caret-right"></i> ' . $task['service_name'] . ' - </li>
			';
		}
		$o.='
					</ul>
				</div>
			</div>
		</div>
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
//END OF CLASS
}

global $NOVIS_CSI_KEYNOTE;
$NOVIS_CSI_KEYNOTE =new NOVIS_CSI_KEYNOTE_CLASS();
?>
