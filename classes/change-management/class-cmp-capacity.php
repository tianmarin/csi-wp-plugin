<?php
defined('ABSPATH') or die("No script kiddies please!");

class NOVIS_CSI_CAPACITY_CLASS extends NOVIS_CSI_CLASS{

public function __construct(){
	add_action( 'wp_ajax_csi_cmp_capacity_build_page',		array( $this , 'csi_cmp_capacity_build_page'	));

}
public function csi_cmp_capacity_build_page(){
	//Local Vaariables
	$response 	= array();
	$o			= '';
	$post	= isset( $_POST[$this->plugin_post] ) &&  $_POST[$this->plugin_post]!=null ? $_POST[$this->plugin_post] : $_POST;
	self::write_log ( $post );
	switch ( $post['capacity'] ){
		case 'offline_repo':
			$o='CHAAAAA';
			break;
		default:
			$o = $this->csi_cmp_capacity_build_page_intro();
	}
	$response['message'] = $o;
	echo json_encode($response);
	wp_die();
}
protected function csi_cmp_capacity_build_page_intro(){
	$o='
	<div class="container">
		<div class="jumbotron">
			<h1 class="text-center">Reportes de Equipo Humano</h1>
			<p>La información</p>
		</div>
		<div class="row">
			<div class="col-sm-6 list-group">
				<a href="#" class="list-group-item ">
					<h3><i class="fa fa-align-left"></i> Detalle de tareas</h3>
					<p>se podría filtrar por las tareas que tengan pocas modificacinoes</p>
					<p>identificar las tareas que han tenido cambios extraños (cambios posterior a la ventana, cambios por personas distintas al ejecutor, autoasignación de tareas post)</p>
					<ul>
						<li>Lista de Pasos de Ejecución
							<ul>
								<li>Filtrar por horarios para sacar reportes de "horas extra"</li>
								<li>Filtrar por horarios para sacar reportes de "horas extra"</li>
							</ul>
						</li>
					</ul>
				</a>
			</div>
		</div>
	</div>';
	return $o;
}
//END OF CLASS
}

global $NOVIS_CSI_CAPACITY;
$NOVIS_CSI_CAPACITY =new NOVIS_CSI_CAPACITY_CLASS();
?>
