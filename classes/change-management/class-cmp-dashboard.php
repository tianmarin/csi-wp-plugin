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
	self::write_log ( $post );
	switch ( $post['dashboard'] ){
		case 'offline_repo':
			$o='CHAAAAA';
			break;
		default:
			$o = $this->csi_cmp_dashboard_build_page_intro();
	}
	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
protected function csi_cmp_dashboard_build_page_intro(){
	$o='
	<div class="container">
		<div class="jumbotron csi-jumbotron-reports">
			<h1 class="text-center">Dashboards</h1>
			<p>La información</p>
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
					<h3><i class="fa fa-square"></i> Planes</h3>
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
				<a href="#" class="list-group-item ">
					<h3><i class="fa fa-square"></i> Tareas</h3>
					<p>Detalle</p>
					<ul>
						<li>con alertas</li>
						<li>demasiado largas</li>
						<li>pendientes</li>
						<li>visibles / No visibles para cliente</li>
						<li>offline / online</li>
					</ul>
				</a>
			</div>
			<div class="col-sm-6 list-group">
				<div class="list-group-item">
					<h3><i class="fa fa-square"></i> Horarios</h3>
					<p>Detalle</p>
					<ul>
						<li><a href="#!dashboard?dashboard=offline_repo">Numero de Horas Offline y online relacionadas a cliente</a></li>
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
//END OF CLASS
}

global $NOVIS_CSI_DASHBOARD;
$NOVIS_CSI_DASHBOARD =new NOVIS_CSI_DASHBOARD_CLASS();
?>
