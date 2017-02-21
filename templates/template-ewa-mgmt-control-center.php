<?php
/*
* Template Name: CSI EWA MgMt Control Center
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
	<meta name="apple-mobile-web-app-title" content="EWA Mgmt">
	<?php add_action( 'wp_head', 'address_mobile_address_bar' ); ?>
	<link rel="shortcut icon" href="<?php _e(CSI_PLUGIN_URL.'/img/icon/ewa-mgmt/Icon-App-512x512@1x.png');?>">
	<link rel="apple-touch-icon" sizes="512x512" href="<?php _e(CSI_PLUGIN_URL.'/img/icon/ewa-mgmt/Icon-App-512x512@1x.png');?>">
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
	wp_register_script(
	'csi-template-ewa-mgmt-control-center',
	CSI_PLUGIN_URL.'/js/templates/min/template-ewa-mgmt-control-center-min.js' ,
	array('jquery', 'jquery-ui-datepicker', 'justgage', 'bootstrap', 'jquery-confirm', 'amcharts','amcharts-serial', 'amcharts-gauge', 'amcharts-responsive','amcharts-pie', 'daterangepicker', 'amcharts-light', 'amcharts-chalk', 'amcharts-patterns', 'amcharts-dark', 'amcharts-black'),
	'0.0.1'
	);
	wp_enqueue_script('csi-template-ewa-mgmt-control-center');
	wp_localize_script(
		'csi-template-ewa-mgmt-control-center',
		'csiTemplateEwaMgmtControlCenter',
		array (
		'ajaxurl'	=> admin_url( 'admin-ajax.php' ),
	)
	);
	wp_register_style(
		"csi_client_style",
		CSI_PLUGIN_URL.'/dist/css/style.css' ,
		null,
		"1.0",
		"all"
	);
	wp_enqueue_style("csi_client_style" );

	wp_register_style(
		"bootstrap",
		CSI_PLUGIN_URL.'/external/bootstrap/dist/css/bootstrap.min.css' ,
		null,
		"1.0",
		"all"
	);
	wp_enqueue_style("bootstrap" );
/*
	wp_register_style(
		"jquery-ui-bootstrap",
		CSI_PLUGIN_URL.'/external/jquery-ui-bootstrap/css/custom-theme/jquery-ui-1.10.0.custom.css' ,
		null,
		"1.0",
		"all"
	);
	wp_enqueue_style("jquery-ui-bootstrap" );
*/
/*
	wp_register_style(
		"daterangepicker",
		CSI_PLUGIN_URL.'/external/bootstrap-daterangepicker-master/daterangepicker.css' ,
		null,
		"1.0",
		"all"
	);
	wp_enqueue_style("daterangepicker" );
*/
/*
	wp_register_style(
		"jquery-confirm",
		CSI_PLUGIN_URL.'/external/jquery-confirm/dist/jquery-confirm.min.css' ,
		null,
		"1.0",
		"all"
	);
	wp_enqueue_style("jquery-confirm" );
*/

	remove_action( 'wp_head', 'feed_links_extra', 3 );                      // Category Feeds
	remove_action( 'wp_head', 'feed_links', 2 );                            // Post and Comment Feeds
	remove_action( 'wp_head', 'rsd_link' );                                 // EditURI link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );              // previous link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );               // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );   // Links for Adjacent Posts
	remove_action( 'wp_head', 'wp_generator' );                             // WP version
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
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
	<div id="csi-template-ewa-mgmt-control-center" class="container">
		<div id="csi-template-ewa-mgmt-control-center-navigator" class="row">
		</div>
		<div class="row">
			<div class="page-header">
				<h3 class="">Panel de Gesti&oacute;n de Reportes y Alertas Early Watch</h3>
			</div>
		</div>
		<div id="csi-template-ewa-mgmt-control-center-infographics" class="row">
			<h3><i class="fa fa-pie-chart fa-fw"></i> Infrogr&aacute;ficos</h3>
			<p>
				<a class="text-muted" type="button" data-toggle="collapse" href="#csi-template-ewa-mgmt-control-center-infographics-alert">
					<i class="fa fa-caret-right"></i> Alertas
				</a>
			</p>
				<div id="csi-template-ewa-mgmt-control-center-infographics-alert" class="collapse" style="position:relative;">
					<div id="csi-template-ewa-mgmt-control-center-infographics-alert-chart" style="height:250px;"></div>
					<div id="csi-template-ewa-mgmt-control-center-infographics-alert-legend"></div>
				</div>
			<p>
				<a class="text-muted" type="button" data-toggle="collapse" href="#csi-template-ewa-mgmt-control-center-infographics-ewa-status">
					<i class="fa fa-caret-right"></i> Status de EWAs
				</a>
			</p>
			<div id="csi-template-ewa-mgmt-control-center-infographics-ewa-status" class="collapse" style="position:relative;">
				<div id="csi-template-ewa-mgmt-control-center-infographics-ewa-status-chart" style="height:250px;"></div>
			</div>

			<p>
				<a class="text-muted" type="button" data-toggle="collapse" href="#csi-template-ewa-mgmt-control-center-infographics-customer-ewas">
					<i class="fa fa-caret-right"></i> EWAs por cliente
				</a>
			</p>
			<div id="csi-template-ewa-mgmt-control-center-infographics-customer-ewas" class="collapse" style="position:relative;">
				<div id="csi-template-ewa-mgmt-control-center-infographics-customer-ewas-chart" style="height:250px;"></div>
			</div>
			<p>
				<a class="text-muted" type="button" data-toggle="collapse" href="#csi-template-ewa-mgmt-control-center-infographics-customer-alerts">
					<i class="fa fa-caret-right"></i> Alertas por cliente
				</a>
			</p>
			<div id="csi-template-ewa-mgmt-control-center-infographics-customer-alerts" class="collapse" style="position:relative;">
				<div id="csi-template-ewa-mgmt-control-center-infographics-customer-alerts-chart" style="height:250px;"></div>
			</div>

			<p>
				<a class="text-muted" type="button" data-toggle="collapse" href="#csi-template-ewa-mgmt-control-center-infographics-alert-pies">
					<i class="fa fa-caret-right"></i> Informaci&oacute;n detallada de Alertas
				</a>
			</p>
			<div id="csi-template-ewa-mgmt-control-center-infographics-alert-pies" class="collapse" style="position:relative;">
				<div id="csi-template-ewa-mgmt-control-center-infographics-alert-pies-chart" style="height:300px;"></div>
			</div>

			<p>
				<a class="text-muted" type="button" data-toggle="collapse" href="#csi-template-ewa-mgmt-control-center-infographics-action-percentage">
					<i class="fa fa-caret-right"></i> Acciones Porcentaje
				</a>
			</p>
			<div id="csi-template-ewa-mgmt-control-center-infographics-action-percentage" style="position:relative;" class="collapse <?php _e ( isset ( $_GET['sid'] ) ? 'in' : '' ) ?>">
				<div id="csi-template-ewa-mgmt-control-center-infographics-action-percentage-chart" style="height:250px;"></div>
			</div>
		</div><!-- #csi-template-ewa-mgmt-control-center-infographics -->
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 col-sm-3 text-center">
							<p class="h5" id="panel-title-date"></p>
						</div>
						<!--
						<div class="col-xs-6 col-sm-3">
							<p class="text-center h5 ">Acciones</p>
							<div>
								<small>
									<input type="radio" id="panel-opts-action-1" name="panel-opts-action" class="hidden"/>
									<label for="panel-opts-action-1">
										<i class="fa fa-square-o fa-fw"></i> Todas
									</label>
								</small>
							</div>
							<div>
								<small>
									<input type="radio" id="panel-opts-action-2" name="panel-opts-action" class="hidden"/>
									<label for="panel-opts-action-2">
										<i class="fa fa-square-o fa-fw"></i> Alertas sin acci&oacute;n
									</label>
								</small>
							</div>
							<div>
								<small>
									<input type="radio" id="panel-opts-action-3" name="panel-opts-action" class="hidden"/>
									<label for="panel-opts-action-3">
										<i class="fa fa-square-o fa-fw"></i> Alertas con acci&oacute;n
									</label>
								</small>
							</div>
						</div>
						-->
						<!--
						<div class="col-xs-6 col-sm-3">
							<p class="text-center h5 ">Resolutor</p>
							<div>
								<small>
									<input type="radio" id="panel-opts-customer-1" name="panel-opts-customer" class="hidden"/>
									<label for="panel-opts-customer-1">
										<i class="fa fa-toggle-off fa-fw"></i> Compartido
									</label>
								</small>
							</div>
							<div>
								<small>
									<input type="radio" id="panel-opts-customer-2" name="panel-opt-customer" class="hidden"/>
									<label for="panel-opts-customer-2">
										<i class="fa fa-toggle-off fa-fw"></i> Técnico
									</label>
								</small>
							</div>
							<div>
								<small>
									<input type="radio" id="panel-opts-customer-3" name="panel-opt-customer" class="hidden"/>
									<label for="panel-opts-customer-3">
										<i class="fa fa-toggle-on fa-fw"></i> Cliente
									</label>
								</small>
							</div>
						</div>
						-->
					</div><!-- .row -->
				</div><!-- .panel-heading -->
				<div class="panel-heading">
					<div class="text-right">
						<small class="text-muted"><i class="fa fa-info"></i> La informaci&oacute;n presentada en este panel, muestra estad&iacute;sticas de sistemas productivos</small>&nbsp;
						<button
							type="button"
							data-toggle="collapse"
							data-target="#table-filter"
							aria-expanded="false"
							aria-controls="#table-filter"
							class="btn btn-primary btn-xs">
							<i class="fa fa-filter fa-fw"></i> Filtrar
						</button>
					</div>
				</div><!-- .panel-heading 2-->

				<table id="csi-template-ewa-mgmt-control-center-table" class="table table-condensed" style="position:relative;">
					<thead>
						<tr>
							<th class="text-center col-xs-2"><i class="fa fa-institution fa-fw"></i> Cliente</th>
							<th class="text-center col-xs-2"><i class="fa fa-calendar fa-fw"></i> Fecha</th>
							<th class="text-center col-xs-1"><i class="fa fa-server fa-fw"></i> SID</th>
							<th class="text-center col-xs-2"><i class="fa fa-object-group fa-fw"></i> Grupo</th>
							<th class="text-center col-xs-3"><i class="fa fa-exclamation-triangle fa-fw"></i> Alerta</th>
							<th class="text-center col-xs-2"><i class="fa fa-paper-plane fa-fw"></i> Acci&oacute;n</th>
						</tr>
						<tr class="collapse" id="table-filter">
							<th class="col-xs-2">
								<form class="table-filter-form">
									<input type="text" class="form-control input-sm" placeholder="Cliente" id="filter-customer" value="<?php _e ( isset ( $_GET['customer_code'] ) ? $_GET['customer_code'] : '' ) ?>"/>
								</form>
							</th>
							<th class="col-xs-2">
								<form class="table-filter-form">
									<input type="date" class="hidden" id="filter-date-start"/>
									<input type="date" class="hidden" id="filter-date-end"/>
									<div id="filter-date-range" class="text-center">
										<small><span class=""></span></small>&nbsp;<i class="fa fa-caret-down fa-fw"></i>
									</div>
								</form>
							</th>
							<th class="col-xs-1">
								<form class="table-filter-form">
									<select id="filter-ewa-rating" class="form-control input-sm">
										<option value="0" selected>Todos</option>
									<?php
										global $NOVIS_CSI_EWA_RATING;
										$ewa_ratings = $NOVIS_CSI_EWA_RATING->get_all();
										foreach ( $ewa_ratings as $ewa_rating ){
											echo '<option value="' . $ewa_rating['id'] . '">' . $ewa_rating['short_name'] . '</option>';
										}
									?>
									</select>
									<input type="text" class="form-control input-sm" placeholder="SID" id="filter-sid" value="<?php _e ( isset ( $_GET['sid'] ) ? $_GET['sid'] : '' ) ?>"/>
								</form>
							</th>
							<th class="col-xs-2">
								<form class="table-filter-form">
									<input type="text" class="form-control input-sm" placeholder="Grupo" id="filter-alert-group"/>
								</form>
							</th>
							<th class="col-xs-3">
								<form class="table-filter-form">
									<select id="filter-alert-rating" class="form-control input-sm">
										<option value="0" selected>Todos</option>
									<?php
										global $NOVIS_CSI_EWA_ALERT_RATING;
										$alert_ratings = $NOVIS_CSI_EWA_ALERT_RATING->get_all();
										foreach ( $alert_ratings as $alert_rating ){
											echo '<option value="' . $alert_rating['id'] . '">' . $alert_rating['short_name'] . '</option>';
										}
									?>
									</select>
									<input type="text" class="form-control input-sm" placeholder="Alerta" id="filter-alert-text"/>
								</form>
							</th>
							<th class="col-xs-2">
								<form class="table-filter-form">
									<select id="filter-action" class="form-control input-sm">
										<option value="1">Todos</option>
										<option value="2">Con acci&oacute;n</option>
										<option value="3">Sin acci&oacute;n</option>
									</select>
									<select id="filter-customer-flag" class="form-control input-sm">
										<option value="1">Todos</option>
										<option value="2">De cliente</option>
										<option value="3">NOVIS</option>
									</select>
								</form>
							</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th class="text-center col-xs-2"><i class="fa fa-institution fa-fw"></i> Cliente</th>
							<th class="text-center col-xs-2"><i class="fa fa-calendar fa-fw"></i> Fecha</th>
							<th class="text-center col-xs-1"><i class="fa fa-server fa-fw"></i> SID</th>
							<th class="text-center col-xs-2"><i class="fa fa-object-group fa-fw"></i> Grupo</th>
							<th class="text-center col-xs-3"><i class="fa fa-exclamation-triangle fa-fw"></i> Alerta</th>
							<th class="text-center col-xs-2"><i class="fa fa-paper-plane fa-fw"></i> Acci&oacute;n</th>
						</tr>
					</tfoot>
					<tbody class="">
					</tbody>
				</table><!-- table#csi-ewa-template-control-center-alerts -->
				<div style="position:relative;">
					<div id="csi-template-ewa-mgmt-pagination" class="text-center"></div>
				</div>
			</div><!-- .panel .panel-default -->
		</div>
	</div><!-- #csi-template-ewa-control-center -->
</body>
</html>
