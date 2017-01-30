<?php
/*
* Template Name: CSI EWA Control Planner
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
	wp_register_script(
	'csi-template-ewa-control-center',
	CSI_PLUGIN_URL.'/js/templates/min/template-ewa-control-center-min.js' ,
	array('jquery', 'jquery-ui-datepicker', 'justgage', 'bootstrap', 'jquery-confirm', 'amcharts','amcharts-serial','amcharts-responsive','amcharts-pie'),
	'0.0.1'
	);
	wp_enqueue_script('csi-template-ewa-control-center');
	wp_localize_script(
		'csi-template-ewa-control-center',
		'csiTemplateEwaControlCenter',
		array (
		'ajaxurl'	=> admin_url( 'admin-ajax.php' ),
	)
	);
	wp_register_style(
		"csi_client_style",
		CSI_PLUGIN_URL.'/css/client.css' ,
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
	wp_register_style(
		"bootstrap",
		CSI_PLUGIN_URL.'/external/bootstrap/dist/css/bootstrap.min.css' ,
		null,
		"1.0",
		"all"
	);
	wp_enqueue_style("bootstrap" );

	wp_register_style(
		"jquery-ui-bootstrap",
		CSI_PLUGIN_URL.'/external/jquery-ui-bootstrap/css/custom-theme/jquery-ui-1.10.0.custom.css' ,
		null,
		"1.0",
		"all"
	);
	wp_enqueue_style("jquery-ui-bootstrap" );

	wp_register_style(
		"jquery-confirm",
		CSI_PLUGIN_URL.'/external/jquery-confirm/dist/jquery-confirm.min.css' ,
		null,
		"1.0",
		"all"
	);
	wp_enqueue_style("jquery-confirm" );


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
	<div id="csi-ewa-template-control-center" class="container">
		<div id="csi-ewa-template-control-center-navigator" class="row">
		</div>
		<div class="row">
			<div class="page-header">
				<h3 class="">Administraci&oacute;n de Alertas de EWA</h3>
			</div>
		</div>
		<div id="csi-ewa-template-control-center-infographics" class="row">
		</div><!-- #csi-ewa-template-control-center-infographics -->
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading col-xs-12">
					<div id="csi-ewa-template-control-center-ajax"></div>
					<p class="col-xs-6 text-center">
						<input type="date" id="csi-ewa-template-control-center-date-input"/>
						<label for="csi-ewa-template-control-center-date-input">
							<i class="fa fa-calendar fa-fw"></i> Semana 04 <small>2017-01-23 - 2017-01-29</small>
						</label>
					</p>
					<p class="col-xs-6 text-center">
						<input type="checkbox" id="csi-ewa-template-control-center-action-checkbox" />
						<label for="csi-ewa-template-control-center-action-checkbox">
							<i class="fa fa-square-o fa-fw"></i> Mostrar Alertas con acci&oacute;n
						</label>
					</p>
				</div><!-- .panel-heading -->
				<div class="alert alert-warning alert-dismissible animated bounce col-xs-10 col-xs-push-1" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p class="text-muted">Las alertas que se hayan presentado la semana anterior, pueden ser gestionadas de manera automática auto-asignando las mismas características.</p>
					<p class="text-center">
						<button class="btn btn-warning btn-sm" id="csi-ewa-template-control-center-autoasign-button">
							<i class="fa fa-magic fa-fw"></i> Autoasignar
						</button>
					</p>
				</div>
				<table id="csi-ewa-template-control-center-alerts" class="table table-condensed">
					<thead>
						<!--
						<tr>
							<th class="sortable"><a href="#">Cliente <i class="fa fa-sort-desc" aria-hidden="true"></i></a></th>
							<th>SID</th>
							<th class="sortable hidden-xs"><a href="#">Prioridad <i class="fa fa-sort-desc" aria-hidden="true"></i></a></th>
							<th class="sortable hidden-xs"><a href="#">Grupo <i class="fa fa-sort-desc" aria-hidden="true"></i></a></th>
							<th>Texto</th>
							<th>Acci&oacute;n</th>
						</tr>
						-->
					</thead>
					<thead>
						<tr>
							<th><input type="text" placeholder="Cliente" id="csi-ewa-template-control-center-filter-customer"/></th>
							<th><input type="text" placeholder="SID" id="csi-ewa-template-control-center-filter-sid"/></th>
							<th class="hidden-xs">Prioridad</th>
							<th><input type="text" placeholder="Grupo" id="csi-ewa-template-control-center-filter-alert-group"/></th>
							<th><input type="text" placeholder="Texto" id="csi-ewa-template-control-center-filter-alert-text"/></th>
							<th>Acci&oacute;n</th>
						</tr>
					</thead>
					<!--
					<tfoot>
						<tr>
							<th class="sortable"><a href="#">Cliente <i class="fa fa-sort-desc" aria-hidden="true"></i></a></th>
							<th>SID</th>
							<th class="sortable hidden-xs"><a href="#">Prioridad <i class="fa fa-sort-desc" aria-hidden="true"></i></a></th>
							<th class="sortable hidden-xs"><a href="#">Grupo <i class="fa fa-sort-desc" aria-hidden="true"></i></a></th>
							<th>Texto</th>
							<th>Acci&oacute;n</th>
						</tr>
					</tfoot>
					-->
					<tbody>
					</tbody>
				</table><!-- table#csi-ewa-template-control-center-alerts -->
			</div><!-- .panel .panel-default -->
		</div>
	</div><!-- #csi-template-ewa-control-center -->
</body>
</html>