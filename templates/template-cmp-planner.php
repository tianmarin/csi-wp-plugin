<?php
/*
* Template Name: CMP Planner
*
* @author Cristian Marin
*/
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<?php
	function address_mobile_address_bar() {
		$color = "#0C386A";
		//this is for Chrome, Firefox OS, Opera and Vivaldi
		echo '<meta name="theme-color" content="'.$color.'">';
		//Windows Phone **
		echo '<meta name="msapplication-navbutton-color" content="'.$color.'">';
		// iOS Safari
		echo '<meta name="apple-mobile-web-app-capable" content="yes">';
		echo '<meta name="apple-mobile-web-app-status-bar-style" content="black">';
	}
	?>
	<meta name="apple-mobile-web-app-title" content="Project Request">
	<?php add_action( 'wp_head', 'address_mobile_address_bar' ); ?>
	<link rel="shortcut icon" href="<?php _e(CSI_PLUGIN_URL.'/img/icon/project-request/project-request-icon@180x180.png');?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php _e(CSI_PLUGIN_URL.'/img/icon/project-request/project-request-icon@180x180.png');?>">
	<link rel="apple-touch-startup-image" href="<?php _e(CSI_PLUGIN_URL.'/img/splash/project-request-splash.png');?>">
	<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
		wp_title( '|', true, 'right' );
		// Add the blog name.
		bloginfo( 'name' );
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
		?>
	</title>
	<?php
		//for bootstrap's .dropdown-toggle class
		wp_register_script(
			'bootstrap',
			CSI_PLUGIN_URL.'/external/bootstrap/dist/js/bootstrap.min.js' ,
			array('jquery'),
			'3.3.7'
		);
		wp_enqueue_script('bootstrap');
		wp_register_script(
			'jquery-confirm',
			CSI_PLUGIN_URL.'/external/jquery-confirm/dist/jquery-confirm.min.js' ,
			array('jquery'),
			'2.4.0'
		);
		wp_enqueue_script('jquery-confirm');


		wp_register_script(
			'chartjs',
			CSI_PLUGIN_URL.'/external/chartjs/Chart.bundle.min.js' ,
			array('jquery'),
			'2.4.0'
		);
		wp_enqueue_script('chartjs');

		wp_register_script(
			'raphael',
			CSI_PLUGIN_URL.'/external/justgage/raphael-2.1.4.min.js' ,
			array(),
			'2.1.4'
		);
		wp_enqueue_script('justgage');
		wp_register_script(
			'justgage',
			CSI_PLUGIN_URL.'/external/justgage/justgage.js' ,
			array('raphael'),
			'1.2.2'
		);
		wp_enqueue_script('justgage');

//		wp_dequeue_script('drawit-iframe-js');



		wp_register_style(
			"bootstrap",
			CSI_PLUGIN_URL.'/external/bootstrap/dist/css/bootstrap.min.css' ,
			null,
			"1.0",
			"all"
		);
		wp_enqueue_style("bootstrap" );
		wp_register_style(
			"jquery-confirm",
			CSI_PLUGIN_URL.'/external/jquery-confirm/dist/jquery-confirm.min.css' ,
			null,
			"1.0",
			"all"
		);
		wp_enqueue_style("jquery-confirm" );


		wp_register_style(
			"rickshaw",
			CSI_PLUGIN_URL.'/external/rickshaw-master/rickshaw.min.css' ,
			null,
			"1.0",
			"all"
		);
		wp_enqueue_style("rickshaw");

		wp_register_script(
			'amcharts-serial',
			CSI_PLUGIN_URL.'/external/amcharts/amcharts/serial.js' ,
			array('amcharts'),
			'1.1.2'
		);
		wp_enqueue_script("amcharts-serial");
		wp_register_script(
			'amcharts-xy',
			CSI_PLUGIN_URL.'/external/amcharts/amcharts/xy.js' ,
			array('amcharts'),
			'1.1.2'
		);
		wp_enqueue_script("amcharts-xy");
		wp_register_script(
			'amcharts-gantt',
			CSI_PLUGIN_URL.'/external/amcharts/amcharts/gantt.js' ,
			array('amcharts'),
			'1.1.2'
		);
		wp_enqueue_script("amcharts-gantt");
		wp_register_script(
			'amcharts-responsive',
			CSI_PLUGIN_URL.'/external/amcharts/amcharts/plugins/responsive/responsive.min.js' ,
			array('amcharts'),
			'1.1.2'
		);
		wp_enqueue_script("amcharts-responsive");



		wp_register_style(
			"csi_client_style",
			CSI_PLUGIN_URL.'/css/client.css' ,
			null,
			"1.0",
			"all"
		);
		wp_enqueue_style("csi_client_style" );
		remove_action( 'wp_head', 'feed_links_extra', 3 );                      // Category Feeds
		remove_action( 'wp_head', 'feed_links', 2 );                            // Post and Comment Feeds
		remove_action( 'wp_head', 'rsd_link' );                                 // EditURI link
//		remove_action( 'wp_head', 'wlwmanifest_link' );                         // Windows Live Writer
//		remove_action( 'wp_head', 'index_rel_link' );                           // index link
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );              // previous link
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );               // start link
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );   // Links for Adjacent Posts
		remove_action( 'wp_head', 'wp_generator' );                             // WP version
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
//		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
//		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
//		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		add_filter('show_admin_bar', '__return_false');							//remove the admin_bar fucntion
		remove_action('wp_head', '_admin_bar_bump_cb');							//remove the admin_bar style (html: padding)
		
	wp_head();
	?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	
	
</head>
<body>
	
<?php
/*
		<div class="csi_cmp_webapp">
		<header class="col-xs-12">
			<div>
				<p class="col-xs-2 lead"><i class="fa fa-arrow-left fa-lg fa-fw"></i></p>
				<p class="col-xs-2 col-xs-push-8 lead fa-lg fa-fw"><i class="fa fa-bars"></i></p>
			</div>
			<div class="col-xs-12">
				<h3 class="page-header">Inicio</h3>
			</div>
		</header>
		<div class="container">
			<div class="list-group">
				<div class="list-group-item">
					
		</div>
		<nav class="navbar navbar-inverse navbar-fixed-bottom">
			<div class="container">
				<div class="col-xs-4 text-center">
					<a href="#">
						<i class="fa fa-home fa-fw fa-2x"></i><span class="sr-only">Link</span>
					</a>
				</div>
				<div class="col-xs-4 text-center">
					<a href="#">
						<i class="fa fa-tasks fa-fw fa-2x"></i><span class="sr-only">Link</span>
					</a>
				</div>
				<div class="col-xs-4 text-center">
					<a href="#">
						<i class="fa fa-check-square fa-fw fa-2x"></i><span class="sr-only">Link</span>
					</a>
				</div>
			</div>
		</nav>
	</div>
	<style>
	body { padding-bottom: 70px; }
	.csi_cmp_webapp{
		height: 100vh;
	}
	.csi_cmp_webapp header{
		background-color: #891009;
		color: #fff;
	}
	.navbar-inverse{
		a:active{
			color:#FFF;
		}
	}
	</style>
*/
?>
			<div id="csi-plans-table">
				<div>
					<div class="panel panel-info filterable">
						<div class="panel-heading col-xs-12">
							<div class="col-xs-6">
								<h3 class="panel-title">Planes</h3>
								<small>Planificaciones Novis</small>
							</div>
							<div class="col-xs-6">
								<button class="pull-right btn btn-default btn-xs btn-filter"><span class="fa fa-filter"></span> Filtro</button>
							</div>
						</div>
						<table class="table table-condensed table-striped">
							<thead>
								<th class="text-center">#</th>
								<th class="text-center">Cliente</th>
								<th class="text-center">Nombre</th>
								<th class="text-center">Fecha de Creaci&oacute;n</th>
								<th class="text-center">Status</th>
							</thead>
							<tbody>	
								<tr>
									<td>1</td>
									<td>Extra</td>
									<td>Actualización de Kernel Q1</td>
									<td>2003-01-02</td>
									<td>
										<div class="text-center">
											<span class="label label-success" data-toggle="tooltip" data-placement="top" title="Ejecutadas: 15">15</span>
											<span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Canceladas: 1">1</span>
											<span class="label label-danger" data-toggle="tooltip" data-placement="top" title="Retrasadas: 8">8</span>
											<span class="label label-info" data-toggle="tooltip" data-placement="top" title="Programadas: 19">19</span>
										</div>
									</td>
								</tr>
								<tr>
									<td>1</td>
									<td>Gentera</td>
									<td>Actualización de Plugins Q1</td>
									<td>2003-01-02</td>
									<td></td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<th><input type="text" class="form-control" placeholder="#"></th>
									<th><input type="text" class="form-control" placeholder="Cliente"></th>
									<th><input type="text" class="form-control" placeholder="Nombre"></th>
									<th><input type="text" class="form-control" placeholder="Fecha de creación"></th>
									<th><input type="text" class="form-control" placeholder="Status"></th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div><!-- #csi-plans-table -->
			<!-- ------------------------------------------------------------------------------------------------------------- -->
			<div class="container" id="csi-plan-detail">
				<div>
					<div class="page-header">
						<h1>Actualización de Kernel <small>El Palacio de Hierro</small></h1>
					</div>
				</div>
				<div class="csi-plan-detail-infographs">
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div id="csi-plan-detail-graph1"></div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div id="csi-plan-detail-graph2"></div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div id="csi-plan-detail-graph3"></div>
					</div>
				</div>
				<div>
					<div class="panel panel-default filterable">
						<div class="panel-heading col-xs-12">
							<div class="col-xs-6">
								<h3 class="panel-title">Planes</h3>
								<small>Planificaciones Novis</small>
							</div>
							<div class="col-xs-6">
								<button class="pull-right btn btn-default btn-xs btn-filter"><span class="fa fa-filter"></span> Filtro</button>
							</div>
						</div>
						<table class="table table-condensed table-hover">
							<thead>
								<tr class="border-blank">
									<th class="hidden-xs"><i class="fa fa-eye fa-fw" title="Indica si el cliente tiene visibilidad de este evento en el Calendario de Cliente"></i></th>
									<th>LND</th>
									<th>Amb</th>
									<th>SID</th>
									<th class="hidden-xs">Ticket</th>
									<th class="active text-center hidden-xs"><i class="fa fa-building"></i></th>
									<th class="active text-center hidden-xs"><i class="fa fa-user"></i></th>
									<th>Status</th>
									<th>Inicio</th>
									<th class="hidden-xs">Duraci&oacute;n</th>
									<th class="text-center"><i class="fa fa-info-circle fa-lg fa-fw"></i></th>
								</tr>
							</thead>
							<tbody>
								<tr class="border-success">
									<th class="hidden-xs"><i class="fa fa-user-circle"></i></th>
									<td>ERP</td>
									<td>DEV</td>
									<td>ERD</td>
									<td class="hidden-xs">467903774</td>
									<td class="active text-center hidden-xs"><i class="fa fa-square-o fa-fw"></i></td>
									<td class="active text-center hidden-xs"><i class="fa fa-check-square-o fa-fw"></i></td>
									<td class="success text-success">Ejecutado</td>
									<td><small>23/02 - 11:00 PM</small></td>
									<td class="hidden-xs">2 horas</td>
									<td class="text-center">
										<a class="btn btn-default btn-xs" data-toggle="collapse" href="#collapseExample">
											<i class="fa fa-bars"></i>
										</a>
									</td>
								</tr>
								<tr class="collapse border-success" id="collapseExample">
									<td colspan="99">
										<div class="col-xs-12 col-sm-4">
											Ejecutores:
											<ul>
												<li>Ang&eacute;ica Sanchez</li>
												<li>Ricardo Rivera</li>
											</ul>
										</div>
										<div class="col-xs-12 col-sm-4">
											Ticket:
											<ul class="list-group">
												<li class="list-group-item">Ticket Novis: 3458675</li>
												<li class="list-group-item">Ticket Cliente: 965594</li>
												<li class="list-group-item">CHREQ: 965594</li>
											</ul>
										</div>
									</td>
								</tr>
								<tr class="border-success">
									<th class="hidden-xs"><i class="fa fa-user-circle"></i></th>
									<td>ERP</td>
									<td>QAS</td>
									<td>ERQ</td>
									<td class="hidden-xs">467903774</td>
									<td class="active text-center hidden-xs"><i class="fa fa-square-o fa-fw"></i></td>
									<td class="active text-center hidden-xs"><i class="fa fa-check-square-o fa-fw"></i></td>
									<td class="success text-success">Ejecutado</td>
									<td><small>23/02 - 11:00 PM</small></td>
									<td class="hidden-xs">2 horas</td>
									<td class="text-center">
										<a class="btn btn-default btn-xs" data-toggle="collapse" href="#collapseExample">
											<i class="fa fa-bars"></i>
										</a>
									</td>
								</tr>
								<tr class="border-danger">
									<th class="hidden-xs"><i class="fa fa-user-circle"></i></th>
									<td>ERP</td>
									<td>PRD</td>
									<td>ERP</td>
									<td class="hidden-xs">467903774</td>
									<td class="active text-center hidden-xs"><i class="fa fa-square-o fa-fw"></i></td>
									<td class="active text-center hidden-xs"><i class="fa fa-check-square-o fa-fw"></i></td>
									<td class="danger text-danger">Retrasado</td>
									<td><small>23/02 - 11:00 PM</small></td>
									<td class="hidden-xs">2 horas</td>
									<td class="text-center">
										<a class="btn btn-default btn-xs" data-toggle="collapse" href="#collapseExample">
											<i class="fa fa-bars"></i>
										</a>
									</td>
								</tr>
								<tr class="border-success">
									<th class="hidden-xs"><i class="fa fa-user-circle"></i></th>
									<td>BW</td>
									<td>DEV</td>
									<td>BID</td>
									<td class="hidden-xs">467903774</td>
									<td class="active text-center hidden-xs"><i class="fa fa-square-o fa-fw"></i></td>
									<td class="active text-center hidden-xs"><i class="fa fa-check-square-o fa-fw"></i></td>
									<td class="success text-success">Ejecutado</td>
									<td><small>23/02 - 11:00 PM</small></td>
									<td class="hidden-xs">2 horas</td>
									<td class="text-center">
										<a class="btn btn-default btn-xs" data-toggle="collapse" href="#collapseExample">
											<i class="fa fa-bars"></i>
										</a>
									</td>
								</tr>
								<tr class="border-success">
									<th class="hidden-xs"><i class="fa fa-user-circle"></i></th>
									<td>BW</td>
									<td>QAS</td>
									<td>BIQ</td>
									<td class="hidden-xs">467903774</td>
									<td class="active text-center hidden-xs"><i class="fa fa-square-o fa-fw"></i></td>
									<td class="active text-center hidden-xs"><i class="fa fa-check-square-o fa-fw"></i></td>
									<td class="success text-success">Ejecutado</td>
									<td><small>23/02 - 11:00 PM</small></td>
									<td class="hidden-xs">2 horas</td>
									<td class="text-center">
										<a class="btn btn-default btn-xs" data-toggle="collapse" href="#collapseExample">
											<i class="fa fa-bars"></i>
										</a>
									</td>
								</tr>
								<tr class="border-warning">
									<th class="hidden-xs"><i class="fa fa-user-circle"></i></th>
									<td>BW</td>
									<td>PRD</td>
									<td>BIP</td>
									<td class="hidden-xs">467903774</td>
									<td class="active text-center hidden-xs"><i class="fa fa-square-o fa-fw"></i></td>
									<td class="active text-center hidden-xs"><i class="fa fa-check-square-o fa-fw"></i></td>
									<td class="warning text-warning">En Ejecuci&oacute;n</td>
									<td><small>23/02 - 11:00 PM</small></td>
									<td class="hidden-xs">2 horas</td>
									<td class="text-center">
										<a class="btn btn-default btn-xs" data-toggle="collapse" href="#collapseExample">
											<i class="fa fa-bars"></i>
										</a>
									</td>
								</tr>
								<tr class="border-info">
									<th class="hidden-xs"><i class="fa fa-user-circle"></i></th>
									<td>PI</td>
									<td>DEV</td>
									<td>PID</td>
									<td class="hidden-xs">467903774</td>
									<td class="active text-center hidden-xs"><i class="fa fa-square-o fa-fw"></i></td>
									<td class="active text-center hidden-xs"><i class="fa fa-check-square-o fa-fw"></i></td>
									<td class="info text-info">Planificado</td>
									<td><small>23/02 - 11:00 PM</small></td>
									<td class="hidden-xs">2 horas</td>
									<td class="text-center">
										<a class="btn btn-default btn-xs" data-toggle="collapse" href="#collapseExample">
											<i class="fa fa-bars"></i>
										</a>
									</td>
								</tr>
								<tr class="border-info">
									<th class="hidden-xs"><i class="fa fa-user-circle"></i></th>
									<td>PI</td>
									<td>QAS</td>
									<td>PIQ</td>
									<td class="hidden-xs">467903774</td>
									<td class="active text-center hidden-xs"><i class="fa fa-square-o fa-fw"></i></td>
									<td class="active text-center hidden-xs"><i class="fa fa-check-square-o fa-fw"></i></td>
									<td class="info text-info">Planificado</td>
									<td><small>23/02 - 11:00 PM</small></td>
									<td class="hidden-xs">2 horas</td>
									<td class="text-center">
										<a class="btn btn-default btn-xs" data-toggle="collapse" href="#collapseExample">
											<i class="fa fa-bars"></i>
										</a>
									</td>
								</tr>
								<tr class="border-info">
									<th class="hidden-xs"><i class="fa fa-user-circle"></i></th>
									<td>PI</td>
									<td>PRD</td>
									<td>PIP</td>
									<td class="hidden-xs">&nbsp;</td>
									<td class="active text-center hidden-xs"><i class="fa fa-square-o fa-fw"></i></td>
									<td class="active text-center hidden-xs"><i class="fa fa-check-square-o fa-fw"></i></td>
									<td class="info text-info">Planificado</td>
									<td><small>23/02 - 11:00 PM</small></td>
									<td class="hidden-xs">2 horas</td>
									<td class="text-center">
										<a class="btn btn-default btn-xs" data-toggle="collapse" href="#collapseExample">
											<i class="fa fa-bars"></i>
										</a>
									</td>
								</tr>
								<tr>
									<td colspan="10" class="text-center"><button class="btn btn-success"><i class="fa fa-plus"></i> Agregar Tarea</button></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div><!-- #csi-plan-detail -->
			<!-- ------------------------------------------------------------------------------------------------------------- -->
			<div id="csi-alert-manager" class="container clearfix" style="min-height:100vh;">
				<div class="row">
					<div class="pull-left">
						<a href="#">
							<i class="fa fa-chevron-left fa-lg"></i>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="page-header">
						<h3 class="">Administraci&oacute;n de Alertas de EWA</h3>
					</div>
				</div>
				<div class="">
				<div class="csi-plan-detail-infographs row">
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<canvas id="csi-plan-detail-graph4" height="150px"></canvas>
						<p class="text-center text-muted"><small>Clasificaci&oacute;n de Alertas</small></p>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div id="csi-plan-detail-graph5"></div>
						<p class="text-center text-muted"><small>Alertas Warning sin acción</small></p>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div id="csi-plan-detail-graph6"></div>
						<p class="text-center text-muted"><small>Alertas Critical sin acción</small></p>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<div id="csi-plan-detail-graph7"></div>
						<p class="text-center text-muted"><small>Alertas No Generadas sin acción</small></p>
					</div>
				<div>
					<div class="panel panel-default filterable">
						<div class="panel-heading col-xs-12">
							<div class="row">
								<div class="col-xs-12 col-sm-6">
									<h3 class="panel-title">Alertas de EWA - Alertas sin acción</h3>
									<p><small>Semana 45 (09/01/2017 - 15/01/2017)</small></p>
								</div>
								<div class="col-xs-12 col-sm-6 text-muted text-right">
									<small><i class="fa fa-info-circle fa-lg"></i> Las alertas duplicadas, han sido excluidas (ocultas) de las estadísticas.</small>
								</div>
							</div>
						</div>
						<div class="panel-body col-xs-12">
							<p class="text-muted">Las alertas que se hayan presentado la semana pasada, pueden ser gestionadas de manera autom&aacute;tica auto-asignando las mismas características.</p>
							<p class="text-center">
								<button class="btn btn-warning">
									<i class="fa fa-magic fa-fw"></i> Autoasignar
								</button>
							</p>
						</div>
						<table class="table">
							<thead>
								<tr class="border-default">
									<th>Cliente</th>
									<th>SID</th>
									<th>Fecha</th>
									<th class="hidden-xs">Prioridad</th>
									<th class="hidden-xs">Grupo</th>
									<th>Texto</th>
									<th>Editar</th>
								</tr>
								</thead>
								<tbody id="accordion">
								<tr class="warning">
									<th>EPH</th>
									<td>ERP</td>
									<td>24/02/2017</td>
									<td class="hidden-xs">
										<small class="text-warning">
											<i class="fa fa-star fa-sm"></i>
											<i class="fa fa-star fa-sm"></i>
											<i class="fa fa-star-o fa-sm"></i>
											<i class="fa fa-star-o fa-sm"></i>
											<i class="fa fa-star-o fa-sm"></i>
										</small>
									</td>
									<td class="hidden-xs"><small><code>EW_R3_R3OP</code></small></td>
									<td>
										<small>
											<i class="fa fa-exclamation-triangle text-warning"></i>
											We found more than 30 ABAP dumps in your system.
										</small>
									</td>
									<td>
										<button class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample2" data-parent="#accordion">
											<i class="fa fa-pencil-square-o"></i>
										</button>
									</td>
								</tr>
								<tr class="collapse warning" id="collapseExample2">
									<td colspan="999">
										<p class="text-center">
											<form class="form-inline text-center">
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-addon">Sistema</div>
														<select  class="form-control">
															<option>ITSM (Solman)</option>
															<option>Plan de Correc. o Mtto.</option>
														</select>
														</div>
												</div>
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-addon"><i class="fa fa-hashtag fa-sm"></i></div>
														<input type="text" class="form-control" id="exampleInputAmount" placeholder="# Identificador">
														</div>
												</div>
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-addon">Responsabilidad de Cliente</div>
															<span class="form-control">
																<input type="checkbox" class="sr-only" id="exampleCheckBox1" placeholder="# de Registro">
																<label for="exampleCheckBox1">
																	<i class="fa fa-lg fa-fw"></i>
																</label>
															</span>
														</div>
												</div>
												<button type="submit" class="btn btn-primary">
													<i class="fa fa-send fa-fw"></i>
													Asignar
												</button>
											</form>
										</p>
									</td>
								</tr>
								<tr class="danger">
									<th>EPH</th>
									<td>ERP</td>
									<td>24/02/2017</td>
									<td class="hidden-xs">
										<small class="text-danger">
											<i class="fa fa-star fa-sm"></i>
											<i class="fa fa-star fa-sm"></i>
											<i class="fa fa-star fa-sm"></i>
											<i class="fa fa-star fa-sm"></i>
											<i class="fa fa-star-o fa-sm"></i>
										</small>
									</td>
									<td class="hidden-xs"><small><code>EW_R3_R3OP</code></small></td>
									<td>
										<small>
											<i class="fa fa-exclamation-triangle text-warning"></i>
											We found more than 30 ABAP dumps in your system.
										</small>
									</td>
									<td>
										<button class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample4" aria-expanded="false" aria-controls="collapseExample4" data-parent="#accordion">
											<i class="fa fa-pencil-square-o"></i>
										</button>
									</td>
								</tr>
								<tr class="collapse danger" id="collapseExample4">
									<td colspan="999">
										<p class="text-center">
											<form class="form-inline text-center">
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-addon">Sistema</div>
														<select  class="form-control">
															<option>ITSM (Solman)</option>
															<option>Plan de Correc. o Mtto.</option>
														</select>
														</div>
												</div>
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-addon"><i class="fa fa-hashtag fa-sm"></i></div>
														<input type="text" class="form-control" id="exampleInputAmount" placeholder="# Identificador">
														</div>
												</div>
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-addon">Responsabilidad de Cliente</div>
															<span class="form-control">
																<input type="checkbox" class="sr-only" id="exampleCheckBox2" placeholder="# de Registro">
																<label for="exampleCheckBox2">
																	<i class="fa fa-lg fa-fw"></i>
																</label>
															</span>
														</div>
												</div>
												<button type="submit" class="btn btn-primary">
													<i class="fa fa-send fa-fw"></i>
													Asignar
												</button>
											</form>
										</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>				
			</div><!-- #csi-alert-manager -->
			<!-- ------------------------------------------------------------------------------------------------------------- -->
			<div id="csi-ewas-panel-01" class="container" style="min-height:100vh;">
				<div>
					<div class="page-header">
						<h3 class="">EWAs del Año</h3>
					</div>
				</div>
				<div class="csi-plan-detail-infographs row">
					<div class="col-xs-12">
						<canvas id="csi-ewas-panel-graph01"></canvas>
					</div>
				</div>
			</div><!-- #csi-ewas-panel-01 -->
			<!-- ------------------------------------------------------------------------------------------------------------- -->
			<div id="csi-ewas-analysis-01" class="container" style="min-height:100vh;">
				<div>
					<div class="page-header">
						<h3 class="">Análisis de EWAs</h3>
					</div>
				</div>
				<div class="csi-plan-detail-infographs row">
					<div class="col-xs-12">
						<div id="csi-ewas-analysis-graph01" style="height: 600px;"></div>
					</div>
				</div>
			</div><!-- #csi-ewas-analysis-01 -->
			<!-- ------------------------------------------------------------------------------------------------------------- -->
			<div id="csi-ewas-analysis-02" class="container" style="min-height:100vh;">
				<div>
					<div class="page-header">
						<h3 class="">Análisis de EWAs</h3>
					</div>
				</div>
				<div class="">
				<div class="csi-plan-detail-infographs row">
					<div class="col-xs-12">
						<div id="csi-ewas-analysis-graph02" style="height: 600px;"></div>
					</div>
				</div>
			</div><!-- #csi-ewas-analysis-02 -->

			<div id="csi-ewas-upload-01" class="container" style="min-height:100vh;">
				<div>
					<div class="page-header">
						<h3 class="">Análisis de EWAs</h3>
					</div>
				</div>
				<form class="form-horizontal" id="csi-ewa-upload-form">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="inputEmail3" placeholder="Email">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10">
							<input type="file" id="file">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
								<label>
									<input type="checkbox"> Remember me
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Sign in</button>
						</div>
					</div>
				</form>
			</div><!-- #csi-ewas-analysis-02 -->

    <?php wp_footer(); ?>

	<style>
		.page-container{
			width: 100%;
			display: table;
			height: 100%;
			table-layout: fixed;
		}
		.sidebar-menu{
			display: table-cell;
			vertical-align: top;
			background: #303641;
			width: 280px;
			position: relative;
			z-index: 100;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}
		.main-content{
			background: #f1f1f1;
    		position: relative;
			display: table-cell;
			vertical-align: top;
			padding: 20px;
			background: #ffffff;
			width: 100%;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}
		canvas {
		}
		.progress{
			height:15px;
			margin-bottom: 0;
		}
		#csi-plans-table,
		#csi-plan-detail{
			min-height: 100vh;
		}
		csi-plan-detail-infographs > div{
		}
		tr.border-blank{
			/*border-left: solid 5px #dff0d8;*/
			border-left: solid 5px #eee;
		}
		tr.border-success{
			/*border-left: solid 5px #dff0d8;*/
			border-left: solid 5px #4cae4c;
		}
		tr.border-danger{
			/*border-left: solid 5px #f2dede;*/
			border-left: solid 5px #d43f3a;

		}
		tr.border-warning{
			/*border-left: solid 5px #fcf8e3;*/
			border-left: solid 5px #eea236;
		}
		tr.border-info{
			/*border-left:  solid 5px #d9edf7;*/
			border-left: solid 5px #2e6da4;
		}
		input[type='checkbox'] + label > i:before {
			cursor: pointer;
			content: '\f10c';
		}
		input[type='checkbox']:checked + label > i:before {
			cursor: pointer;
			content: '\f05d';
		}
	</style>
	<script>
		var ajaxUrl = '<?php _e(admin_url( 'admin-ajax.php' )); ?>';
		window.randomScalingFactor = function() {
			return (Math.random() > 0.5 ? 1.0 : 1.0) * Math.round(Math.random() * 100);
		}
		jQuery(document).ready(function($){
			
			$('#csi-ewa-upload-form').submit(function(event){
				event.preventDefault();
				var form = this;
				var file = $(this).find('input[type=file]')[0].files[0];
//				window.console.log((typeof file));
				if(undefined === typeof file || 'undefined' === typeof file){
					window.console.log('No hay archivo. Undefined');
					return this;
				}
//				var	file = this.files[0];
				if (file.name.trim() === ''){
					$.alert("No has seleccionado un archivo.");
					window.console.log("No file selected");
					return this;
				}
				window.console.log('Archivo a evaluar: '+file.name+' '+file.type+' '+file.size);
				if(file.type !== 'text/csv'){
					$.alert("Recuerda que debes cargar archivos guardados como CSV","Error");
					return this;
				}
				var data = new FormData();
				data.append('action', 'csi_ajax_upload_ewa_file');
				data.append('file',file);
				$.ajax({
					url: ajaxUrl,
					type: 'POST',
					data: data,
					cache: false,
					dataType: 'json',
					processData: false,
					contentType: false,
					beforeSend: function () {
						//statusMsg.html(uploading+" "+inputDay+'/'+inputMonth+'/'+inputYear+' Comienza la carga del archivo <small>'+file.name+'</small>').fadeIn(500);
					},
					xhr: function () {
						var xhr = new window.XMLHttpRequest();
						//Upload progress
						xhr.upload.addEventListener("progress", function(evt){
							if (evt.lengthComputable) {
								var percentComplete = Math.round(evt.loaded / evt.total * 100);
								window.console.log('Porcentaje: '+percentComplete);
							}
						}, false);
						//success upload
						xhr.upload.addEventListener("load", function(evt){
							if (evt.lengthComputable) {
							//	statusMsg.html(processing+" "+inputDay+'/'+inputMonth+'/'+inputYear+' Procesando la informaci&oacute;n cargada');
							}
						}, false);
						//Download progress
						//If this is removed, the process is dead
						xhr.addEventListener("progress", function(evt){
							if (evt.lengthComputable) {
								window.console.log("Respuesta descargada: "+Math.round(evt.loaded / evt.total * 100)+'%');
							}else{
								window.console.log("Respuesta descargada: "+Math.round(evt.loaded / evt.total * 100)+'%');					
							}
						}, false);
						return xhr;
					},
					success: function(response){
						window.console.log(JSON.stringify(response));
						$(form).append(response.message);
					},
					error: function(){
						window.console.log('Error');
					},
				});		
			});

			$('[data-toggle="tooltip"]').tooltip();
			//gauge.js
			//chartsjs
			var data = {
				labels: [
					"Critical",
					"Warning"
				],
				datasets: [
					{
					data: [300, 135],
					backgroundColor: [
						"#FF6384",
						"#FFCE56"
					],
					hoverBackgroundColor: [
						"#FF6384",
						"#FFCE56"
					]
					}
				],
			};
   			var myPieChart = new Chart($("#csi-plan-detail-graph4"),{
				type: 'pie',
				data: data,
				options:{
					legend:{
						display:false,
					},
				},
			});
			//chartsjs
			var data = {
				labels: [
					"EA_SWCM",
					"EA_DB_UDB",
					"EA_R3_PERF",
					"EW_R3_R3OP",
					"HW_CAPACITY",
					"EA_APPL_DATA_VOL",
					"WORKLOAD_ANALYSIS",
					"SERVICE_PREPARATION",
					"SYSTEM_OPERATING_SEC",
				],
				datasets: [
					{
					data: [14, 20, 16, 26, 32, 24, 28, 17, 19],
					backgroundColor: [
						"#6a7140",
						"#3b7e93",
						"#dfd45b",
						"#b9544a",
						"#9a9999",
						"#6b7b5c",
						"#405264",
						"#619d7d",
						"#da9239"
					],
					}
				],
			};
			//chartsjs
			var data = {
				labels: [ "Diciembre","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre"],
				datasets: [
					{
						type:'line',
						label: 'Promedio',
						data:[randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],
						fill:false,
						borderColor: '#36A2EB',
					},
					{
						data:[randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],
						label: 'Critical',
						borderWidth: 1,
						backgroundColor:'#FF6384',
						borderColor:'#fafafa',
					},
					{
						data:[randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],
						label: 'Warning',
						borderWidth: 1,
						backgroundColor:'#FFCE56',
						borderColor:'#fafafa',
					},
					{
						data:[randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],
						label: 'Clear',
						borderWidth: 1,
						backgroundColor:'#4BC0C0',
						borderColor:'#fafafa',
					},
				],
			};
   			new Chart($("#csi-ewas-panel-graph01"),{
				type: 'bar',
				data: data,
				options:{
					stacked:true,
					tooltips: {
						mode: 'index',
						intersect: false
					},
					legend:{
						display:false,
					},
					scales: {
						xAxes: [{
							stacked: true,
							display:false,
							gridLines: {
								display:false,
							},
//							categoryPercentage:'0.3',
							ticks: {
								beginAtZero:true
							},
						}],
						yAxes: [{
							stacked: true,
							display:false,
							gridLines: {
								display:false,
							},
							ticks: {
								beginAtZero:true
							},
						}],
					},
				},
			});
			//amcharts
			function csi_ewas_analysis_graph01_data(dates){
				var weeks = dates;
				randomData = [];
				var newdate= new Date();
				for (var i = 0; i < weeks; i++) {
					newdate.setDate(newdate.getDate() - 7);
					window.console.log(newdate);
					randomData.push({
						msg01: Math.round(10 * Math.random()),
						msg02: Math.round(10 * Math.random()),
						msg03: Math.round(10 * Math.random()),
						msg04: Math.round(10 * Math.random()),
						msg05: Math.round(10 * Math.random()),
						msg06: Math.round(10 * Math.random()),
						msg07: Math.round(10 * Math.random()),
						date: new Date(newdate),
					});
				}
				window.console.log(randomData);
				return randomData;
			}
			var chart = AmCharts.makeChart("csi-ewas-analysis-graph01", {
				"type": "serial",
				"dataProvider": csi_ewas_analysis_graph01_data(10),
				"graphs": [
					{
						"id":"msg01",
						"bullet": "round",
						"bulletSize": 8,
						"lineColor": "#d1655d",
						"lineThickness": 2,
						"negativeLineColor": "#637bb6",
						"type": "smoothedLine",
						"valueField": "msg01",
						"title":"We found more than 30 ABAP dumps in your system.",
					},
					{
						"id":"msg02",
						"bullet": "round",
						"bulletSize": 8,
						"lineColor": "#f1c45f",
						"lineThickness": 2,
						"type": "smoothedLine",
						"valueField": "msg02",
						"title":"Gateway Access Control List (reg_info/sec_info) contains trivial entries."
					},
					{
						"id":"msg03",
						"bullet": "round",
						"bulletSize": 8,
						"lineColor": "#f1c45f",
						"lineThickness": 2,
						"type": "smoothedLine",
						"valueField": "msg03",
						"title":"Secure password policy is not sufficiently enforced."
					},
					{
						"id":"msg04",
						"bullet": "round",
						"bulletSize": 8,
						"lineColor": "#f1c45f",
						"lineThickness": 2,
						"type": "smoothedLine",
						"valueField": "msg04",
						"title":"A high number of users has critical authorizations."
					},
					{
						"id":"msg05",
						"bullet": "round",
						"bulletSize": 8,
						"lineColor": "#f1c45f",
						"lineThickness": 2,
						"type": "smoothedLine",
						"valueField": "msg05",
						"title":"Standard users have default password."
					},
					{
						"id":"msg06",
						"bullet": "round",
						"bulletSize": 8,
						"lineColor": "#f1c45f",
						"lineThickness": 2,
						"type": "smoothedLine",
						"valueField": "msg06",
						"title":"Readiness of your system for SAP Remote Service has not been verified by running report RTCCTOOL."
					},
					{
						"id":"msg07",
						"bullet": "round",
						"bulletSize": 8,
						"lineColor": "#f1c45f",
						"lineThickness": 2,
						"type": "smoothedLine",
						"valueField": "msg07",
						"title":"Hardware resources may have been exhausted with the risk of performance degradation."
					}
				],
				"chartCursor": {
					"categoryBalloonDateFormat": "YYYY-MM-DD",
					"cursorAlpha": 0,
					"valueLineEnabled":true,
					"valueLineBalloonEnabled":true,
					"valueLineAlpha":0.5,
					"fullWidth":true
				},
				"dataDateFormat": "DD",
				"categoryField": "date",
				"valueAxes": [{
					"stackType": "regular",
					"axisAlpha": 0.3,
					"gridAlpha": 0
				}],
				"categoryAxis": {
					"minPeriod": "DD",
//					"parseDates": true,
					"minorGridAlpha": 0.1,
					"minorGridEnabled": true
				},
				"legend": {
					"useGraphSettings": true
				},
			});
			//amcharts
			function csi_ewas_analysis_graph02_data(dates){
				var weeks = dates;
				randomData = [];
				var newdate= new Date();
				for (var i = 0; i < weeks; i++) {
					newdate.setDate(newdate.getDate() - 7);
					window.console.log(newdate);
					randomData.push({
						msg01: Math.round(10 * Math.random()),
						msg02: Math.round(10 * Math.random()),
						msg03: Math.round(10 * Math.random()),
						msg04: Math.round(10 * Math.random()),
						msg05: Math.round(10 * Math.random()),
						msg06: Math.round(10 * Math.random()),
						msg07: Math.round(10 * Math.random()),
						date: new Date(newdate),
					});
				}
				window.console.log(randomData);
				return randomData;
			}
			AmCharts.useUTC = true;
			var chart = AmCharts.makeChart( "csi-ewas-analysis-graph02", {
				"type": "gantt",
				"marginRight": 70,
				"period": "DD",
				"dataDateFormat": "YYYY-MM-DD",
				"columnWidth": 0.5,
				"valueAxis": {
					"type": "date"
				},
				"brightnessStep": 7,
				"graph": {
					"fillAlphas": 1,
					"lineAlpha": 1,
					"lineColor": "#fff",
					"fillAlphas": 0.85,
					"balloonText": "<b>[[task]]</b>:<br />[[open]] -- [[value]]"
				},
				"rotate": true,
				"categoryField": "system",
				"segmentsField": "segments",
				"colorField": "color",
				"startDateField": "start",
				"endDateField": "end",
				"dataProvider": [
					{
					"system": "ERP",
					"segments": [ {
						"start": "2016-01-01",
						"end": "2016-01-07",
						"color": "#F00",
						}, {
						"start": "2016-01-08",
						"end": "2016-01-15",
						"color": "#FF0",
						}, {
						"start": "2016-01-16",
						"end": "2016-01-21",
						"color": "#FF0",
						}, {
						"start": "2016-01-22",
						"end": "2016-01-29",
						"color": "#0F0",
						}]
					},
					{
					"system": "BSP",
					"segments": [ {
						"start": "2016-01-01",
						"end": "2016-01-07",
						"color": "#F00",
						}, {
						"start": "2016-01-08",
						"end": "2016-01-15",
						"color": "#FF0",
						}, {
						"start": "2016-01-16",
						"end": "2016-01-21",
						"color": "#FF0",
						}, {
						"start": "2016-01-22",
						"end": "2016-01-29",
						"color": "#0F0",
						}]
					},
					{
					"system": "CRP",
					"segments": [ {
						"start": "2016-01-01",
						"end": "2016-01-07",
						"color": "#F00",
						}, {
						"start": "2016-01-08",
						"end": "2016-01-15",
						"color": "#FF0",
						}, {
						"start": "2016-01-16",
						"end": "2016-01-21",
						"color": "#FF0",
						}, {
						"start": "2016-01-22",
						"end": "2016-01-29",
						"color": "#0F0",
						}]
					},
					{
					"system": "BSP",
					"segments": [ {
						"start": "2016-01-01",
						"end": "2016-01-07",
						"color": "#F00",
						}, {
						"start": "2016-01-08",
						"end": "2016-01-15",
						"color": "#FF0",
						}, {
						"start": "2016-01-16",
						"end": "2016-01-21",
						"color": "#FF0",
						}, {
						"start": "2016-01-22",
						"end": "2016-01-29",
						"color": "#0F0",
						}]
					},
					{
					"system": "BWP",
					"segments": [ {
						"start": "2016-01-01",
						"end": "2016-01-07",
						"color": "#F00",
						}, {
						"start": "2016-01-08",
						"end": "2016-01-15",
						"color": "#FF0",
						}, {
						"start": "2016-01-16",
						"end": "2016-01-21",
						"color": "#FF0",
						}, {
						"start": "2016-01-22",
						"end": "2016-01-29",
						"color": "#0F0",
						}]
					},
				],
				"valueScrollbar": {
					"autoGridCount": true
				},
				"chartCursor": {
					"cursorColor": "#55bb76",
					"valueBalloonsEnabled": false,
					"cursorAlpha": 0,
					"valueLineAlpha": 0.5,
					"valueLineBalloonEnabled": true,
					"valueLineEnabled": true,
					"zoomable": false,
					"valueZoomable": true
				},
			});
			//justgage
			var opts = {
				//gaugeWidthScale: 0.2,
				id: "csi-plan-detail-graph1",
				label: "%",
				levelColorsGradient: false,
				max: 100,
				min: 0,
				levelColors:["#36A2EB","#4BC0C0"],
				customSectors: {
					percents: true,
					ranges: [
						{
							color : "#4BC0C0",
							lo : 0,
							hi : 100
						},
					],
				},
				refreshAnimationTime: 1000,
				refreshAnimationType: "bounce",
				shadowOpacity: 0,
				shadowSize: 0,
				shadowVerticalOffset: 10,
				title:'% de Avance Plan',
				startAnimationTime: 1000,
				startAnimationType: ">",
				value: 42,
			};
			var g = new JustGage(opts);

			var opts2=opts;
			opts2.id="csi-plan-detail-graph2";
			opts2.value=25;
			opts2.title='% de Avance Real';
			opts2.levelColors=['#FF6384',];
			var g2 = new JustGage(opts2);

			var opts5=opts;
			opts5.id="csi-plan-detail-graph5";
			opts5.value=25;
			opts5.title='';
			opts5.levelColors=['#ffbb33',];
			var g5 = new JustGage(opts5);

			var opts6=opts;
			opts6.id="csi-plan-detail-graph6";
			opts6.value=25;
			opts6.title='';
			opts6.levelColors=['#ff4444',];
			var g6 = new JustGage(opts6);

			var opts7=opts;
			opts7.id="csi-plan-detail-graph7";
			opts7.value=25;
			opts7.title='';
			opts7.levelColors=['#999',];
			var g7 = new JustGage(opts7);


			$('#assigntest').click(function(){
//				event.preventDefault();
				$.confirm({
					title: 'Atenci&oacute;n!',
					columnClass: 'col-sm-8 col-sm-offset-2 col-xs-12 ',
					content: 'Vas a realizar una asignación automática, que puede no ser la adecuada<br/>¿Quieres asignar esta tarea a lo mismo que pusiste antes?',
					buttons: {
						confirm: function () {
							$.alert('Confirmado!');
						},
						cancel: function () {
							$.alert('Cancelado!');
						},
					},
					type: 'orange',
				});

			});

		});
		
/*
		var graph = new Rickshaw.Graph( {
			element: document.querySelector("#csi-plan-detail-graph3"),
			width: 235,
			height: 85,
			renderer: 'bar',
			series: [ {
				data: [ { x: 0, y: 40 }, { x: 1, y: 49 }, { x: 2, y: 38 }, { x: 3, y: 30 }, { x: 4, y: 32 } ],
				color: '#36A2EB'
			} ]
		} );
		graph.render();
*/
	</script>
</body>
</html>