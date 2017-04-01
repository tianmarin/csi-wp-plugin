<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_DASHBOARD_CLASS extends NOVIS_CSI_CLASS{

public function __construct(){
	add_action( 'wp_ajax_csi_cmp_dashboard_build_page',		array( $this , 'csi_cmp_dashboard_build_page'	));

}
public function csi_cmp_dashboard_build_page(){
	//Local Vaariables
	$response 	= array();
	$o			= '';
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	if ( isset ( $post['view'] ) ){
		switch ( $post['view'] ){
			case 'alert_tasks':
				$o = $this->csi_cmp_dashboard_alert_tasks ( $post );
				break;
			default:
				$o = $this->csi_cmp_dashboard_build_page_intro();
		}
	}else{
		$o = $this->csi_cmp_dashboard_build_page_intro();
	}
	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
protected function csi_cmp_dashboard_build_page_intro(){
	$o='
	<div class="container">
		<div class="jumbotron row">
			<h2 class="text-center"><i class="fa fa-dashboard fa-fw"></i> Dashboards</h2>
			<p>Obtén informaci&oacute;n de los diferentes m&oacute;dulos de gesti&oacute;n de Cambios, Servicios y Planes de Corrección o Mantenimiento.</p>
		</div>
		<div class="row">
			<div class="col-sm-6 list-group">
				<a href="#" class="list-group-item ">
					<h3><i class="fa fa-refresh"></i> Cambios</h3>
					<p>Información de actividades dentro del flujo de Gestión de Cambios</p>
					<ul>
						<li>Cambios Pendiente</li>
						<li>Cambios rechazados</li>
						<li>Cambios aprobados</li>
						<li>Cambios urgentes</li>
					</ul>
				</a>
			</div>
			<div class="col-sm-6 list-group">
				<a href="#" class="list-group-item ">
					<h3><i class="fa fa-tasks"></i> Planes</h3>
					<p>Detalle</p>
					<ul>
						<li>con alertas</li>
						<li>demasiado largas</li>
						<li>pendientes</li>
						<li>compartidos / no compartidos</li>
					</ul>
				</a>
			</div>
			<div class="col-sm-6 list-group">
				<div class="list-group-item ">
					<h3><i class="fa fa-list"></i> Tareas</h3>
					<p>Detalle</p>
					<ul>
						<li><a href="#!dashboard?view=alert_tasks">con alertas</a></li>
						<li>demasiado largas</li>
						<li>pendientes</li>
						<li>visibles / No visibles para cliente</li>
						<li>offline / online</li>
					</ul>
				</div>
			</div>
			<div class="col-sm-6 list-group">
				<div class="list-group-item">
					<h3><i class="fa fa-square"></i> Horarios</h3>
					<p>Detalle</p>
					<ul>
						<li>Numero de Horas Offline y online relacionadas a cliente</li>
						<li></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-6 list-group">
				<a href="#" class="list-group-item ">
					<h3><i class="fa fa-square"></i> Servicios</h3>
					<p>Detalle</p>
					<ul>
						<li>Distribución de los servicios</li>
						<li>Agrupados por tipo de cambio</li>
						<li>Filtros por cliente, fecha, responsable</li>
					</ul>
				</a>
			</div>
			<div class="col-sm-6 list-group">
				<a href="#" class="list-group-item ">
					<h3><i class="fa fa-usd"></i> Costos</h3>
					<p>Detalle</p>
					<ul>
						<li>Distribución de costos por cliente</li>
						<li>Distribución de costos por equipo</li>
						<li>Distribución de costos por servicio</li>
					</ul>
				</a>
			</div>
		</div>
	</div>';
	return $o;
}

protected function csi_cmp_dashboard_alert_tasks ( $posts ){
	//Global Variables
	global $wpdb;
	global $NOVIS_CSI_CMP;
	global $NOVIS_CSI_CMP_TASK;
	global $NOVIS_CSI_CMP_TASK_STATUS;
	global $NOVIS_CSI_CUSTOMER;
	global $NOVIS_CSI_CUSTOMER_SYSTEM;
	global $NOVIS_CSI_SERVICE;
	//Local Variables
	$current_datetime = new DateTime();
	$sql = 'SELECT
				T00.id as id,
				T00.cmp_id as task_id,
				T00.start_datetime,
				T00.end_datetime,
				T00.ticket_no,
				T01.short_name as status_short_name,
				T02.id as plan_id,
				T03.short_name as customer_short_name,
				T03.code as customer_code,
				T04.sid as sid,
				T05.short_name as service_short_name,
				IF(T01.cmp_finished_start_flag!=0,IF(T00.start_datetime<NOW(),TRUE,NULL),NULL) as start_delay,
				IF(T01.cmp_finished_end_flag!=0,IF(T00.end_datetime<NOW(),TRUE,NULL),NULL) as end_delay,
				IF(T01.cmp_error_flag=1,"error",NULL) as error
			FROM
				' . $NOVIS_CSI_CMP_TASK->tbl_name . ' as T00
				LEFT JOIN ' . $NOVIS_CSI_CMP_TASK_STATUS->tbl_name . ' as T01
					ON T00.status_id = T01.id
				LEFT JOIN ' . $NOVIS_CSI_CMP->tbl_name . ' as T02
					ON T00.cmp_id = T02.id
				LEFT JOIN ' . $NOVIS_CSI_CUSTOMER->tbl_name . ' as T03
					ON T02.customer_id = T03.id
				LEFT JOIN ' . $NOVIS_CSI_CUSTOMER_SYSTEM->tbl_name . ' as T04
					ON T00.customer_system_id = T04.id
				LEFT JOIN ' . $NOVIS_CSI_SERVICE->tbl_name . ' as T05
					ON T00.service_id = T05.id
			WHERE
				(T01.cmp_finished_start_flag!=0 AND T00.start_datetime<NOW() )
				OR ( T01.cmp_finished_end_flag!=0 AND T00.end_datetime<NOW() )
				OR ( T01.cmp_error_flag = 1 )
			ORDER BY
				error DESC ,T00.start_datetime ASC
	';
	$tasks = $this->get_sql ( $sql );
	$o='';
	$o.='
	<div class="container">
		<div class="page-header">
			<a href="#!dashboard"><i class="fa fa-angle-left fa-fw"></i> Dashboards</a>
			<h2>Tareas con atraso o error</h2>
		</div>
		<table class="table table-condensed">
			<thead>
				<tr>
					<th class="hidden-xs"><i class="fa fa-exclamation fa-fw"></i></th>
					<th>
						<span class="visible-xs-inline" title="Cliente" data-toggle="tooltip" data-placement="top">
							<i class="fa fa-building-o"></i>
						</span>
						<span class="hidden-xs">Cliente</span>
					</th>
					<th>Plan</th>
					<th class="hidden-xs">Ticket</th>
					<th>
						<span class="visible-xs-inline">SID</span>
						<span class="hidden-xs">Sistema</span>
					</th>
					<th class="hidden-sm">Status</th>
					<th>Responsable</th>
					<th class="hidden-xs">Mensaje</th>
					<th class="hidden-xs">Servicio</th>
					<th class="hidden-xs">Cambio</th>
				</tr>
			</thead>
			<tbody>';
	foreach ( $tasks as $task ){
		$start_datetime = new DateTime ( $task['start_datetime'] );
		$end_datetime = new DateTime ( $task['end_datetime'] );
		if ( $task['error'] ){
			$icon = '<i class="fa fa-exclamation-circle text-danger fa-fw"></i>';
			$class=	'danger';
			$msg = 'La ejecuci&oacute;n provoc&oacute; una vuelta atr&aacute;s';
		}else{
			$icon = '<i class="fa fa-exclamation-triangle text-warning fa-fw"></i>';
			$class= 'warning';
			if ( $task['start_delay'] ){
				$msg = 'Ejecuci&oacute;n programada para el <strong>' . $start_datetime->format('d/m H:i') . '</strong>';
			}else{
				$msg = 'Ventana finaliz&oacute; el <strong>' . $end_datetime->format('d/m H:i') . '</strong>';
			}
		}
		$o.='
				<tr class="' . $class . '">
					<td class="hidden-xs">' . $icon . '</td>
					<td>
						<span class="visible-xs-inline" title="' . $task['customer_short_name'] . '" data-toggle="tooltip" data-placement="top">' . $task['customer_code'] . '</span>
						<span class="hidden-xs">' . $task['customer_short_name'] . '</span>
					</td>
					<td>
						<a href="#" class="csi-popup" data-action="csi_cmp_popup_cmp_info" data-plan-id="' . $task['plan_id'] . '">
							<small>#PCM_' . $task['plan_id'] . '</small>
						</a>
					</td>
					<td class="hidden-xs"><samp><small>' . $task['ticket_no'] . '</small></samp></td>
					<td>' . $task['sid'] . '</td>
					<td class="hidden-sm small">' . $task['status_short_name'] . '</td>
					<td>resp</td>
					<td class="hidden-xs small">' . $msg . '</td>
					<td class="hidden-xs">' . $task['service_short_name'] . '</td>
					<td class="hidden-xs">Pendiente</td>
				</tr>
		';
	}
	$o.='
				<tr>
					<td></td>
				</tr>
			</tbody>
		</table>
	';
	$o.='
	</div>
	';
	return $o;
}
//END OF CLASS
}

global $NOVIS_CSI_DASHBOARD;
$NOVIS_CSI_DASHBOARD =new NOVIS_CSI_DASHBOARD_CLASS();
?>
