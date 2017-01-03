<?php
/*
* Template Name: Project Request
*
* @author Cristian Marin
* @package ABAPAnalyzer
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
	<meta name="apple-mobile-web-app-title" content="NOVIS Project Request">
	<?php add_action( 'wp_head', 'address_mobile_address_bar' ); ?>
	<link rel="shortcut icon" href="<?php _e(plugins_url( 'img/aa_logo.png' , __FILE__ ));?>">
	<link rel="apple-touch-icon" sizes="192x192" href="<?php _e(plugins_url( 'img/aa_logo.png' , __FILE__ ));?>">
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
			'amcharts',
			CSI_PLUGIN_URL.'/external/amcharts/amcharts/amcharts.js' ,
			array('jquery'),
			'3.2'
		);
		//-----------------------------------------------------
		wp_register_script(
			'amcharts-serial',
			CSI_PLUGIN_URL.'/external/amcharts/amcharts/serial.js' ,
			array('amcharts'),
			'3.2'
		);
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
			array('jquery','jquery-ui-datepicker','amcharts','amcharts-serial','amcharts-responsive'),
			'1.0'
		);
		wp_register_style(
			"csi_client_style",
			CSI_PLUGIN_URL.'/css/client.css' ,
			null,
			"1.0",
			"all"
		);
		wp_enqueue_style("csi_client_style" );
		wp_register_script(
			'csi_WPCLIENT',
			CSI_PLUGIN_URL.'/js/client-min.js' ,
			array('jquery','amcharts','amcharts-serial','amcharts-responsive'),
			'1.0'
		);
		wp_enqueue_script('csi_WPCLIENT');
		wp_localize_script(
			'csi_WPCLIENT',
			'csiWPCLIENT',
			array(
//				'ppost'							=> $this->plugin_post,
				'ajaxurl'						=> admin_url( 'admin-ajax.php' ),
			)
		);

//	add_action('init', 'aa_head_cleanup');
//	function aa_head_cleanup() {
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
//		wp_dequeue_script('page_volver_arriba');

		add_filter('show_admin_bar', '__return_false');							//remove the admin_bar fucntion
		remove_action('wp_head', '_admin_bar_bump_cb');							//remove the admin_bar style (html: padding)
//		echo do_shortcode("[abap_analyzer]");
		
	wp_head();
	?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<style>
		.welcome{
			min-height: 100vh;
			background: url(<?php echo CSI_PLUGIN_URL.'/img/bg/template-project-request-bg.jpg';?>) no-repeat center center fixed; 
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}
	</style>
</head>
<body>
	<div class="container-fluid welcome" style="background-color: #263238">
		<div class="row">
			<div class="col-xs-12">
				<?php
					echo do_shortcode("[csi_project_list_panel customer=all duration=12 silent=yes]");
				?>
			</div>
		</div>
		<div class="row">
			<div style="color:#FFF" class="col-xs-12 col-md-8 col-md-offset-2">
				<h2>&iquest;Quieres solicitar un nuevo proyecto?</h2>
				<p class="lead text-justify">Antes de solicitar un nuevo proyecto, hay cierta informaci&oacute;n que requerimos. Como puedes ver, tenemos muchos proyectos en marcha :P</p>
				<p class="text-center">
					<a class="btn btn-danger btn-lg" href="#project_request_form" role="button">Comenzar</a>
				</p>
			</div>
		</div>
	</div>
	<div class="container" id="project_request_form">
		<div class="">
			<div class="page-header">
				<h3>Solicitar nuevo Proyecto <small>(<a href="#">Aprender m&aacute;s</a>)</small></h3>
			</div>
			<form class="form-horizontal" action="?page=csi_project" method="post" id="csi_project">
				<input type="hidden" name="Y21hcmlu[action]" value="add">
				<input type="hidden" id="Y21hcmlu[actioncode]" name="Y21hcmlu[actioncode]" value="5f11c693c2">
				<input type="hidden" name="_wp_http_referer" value="/Developer/Development/WP_PLUGINS/home/pagina-ejemplo/project-request-template/">
				<div class="form-group " name="Y21hcmlu[customer_name]">
					<label for="Y21hcmlu[customer_name]" class="col-sm-2 control-label">Nombre de Cliente</label>
					<div class="col-sm-10">
						<select class="form-control" id="Y21hcmlu[customer_name]" name="Y21hcmlu[customer_name]" data-required="true">
							<option value="0" disabled="">Seleccionar</option>
							<?php
								if ( is_multisite() ){
									$args = array(
										'network_id'	=> $wpdb->siteid,
										'public'    	=> 1,
										'archived'  	=> null,
										'mature'    	=> null,
										'spam'      	=> null,
										'deleted'   	=> null,
										'limit'     	=> 200,
										'offset'    	=> 1,
									); 
									$sites = wp_get_sites($args);
									foreach ( $sites as $i => $site ) {
										$sites[ $i ][ 'name' ] = get_blog_details($site['blog_id'])->blogname;
									}
									uasort( $sites, function( $site_a, $site_b ) {
										return strcasecmp( $site_a[ 'name' ], $site_b[ 'name' ] );
									});
									foreach ( $sites as $i => $site ) {
										echo '<option value="'.$site['blog_id'].'">'.get_blog_details($site['blog_id'])->blogname.'</option>';
									}
								}
							?>
							<option value="0">No es un cliente actual</option>
						</select>
						<p class="help-block">En el caso que el cliente no esté registrado, indicar en el <label for="Y21hcmlu[short_name]">Nombre del Proyecto</label> indicar el nombre del cliente para el cual se solicita el Proyecto.</p>
					</div>
				</div>
				<div class="form-group " name="Y21hcmlu[short_name]">
					<label for="Y21hcmlu[short_name]" class="col-sm-2 control-label">Nombre del Proyecto</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="Y21hcmlu[short_name]" name="Y21hcmlu[short_name]" placeholder="Nombre del Proyecto" data-validation="true" data-validation-maxchar="100" maxlength="100" data-required="true">
						<p class="help-block">Indicar el nombre descriptivo del Proyecto.<br>Tamaño máximo: 100 caracteres</p>
					</div>
				</div>
				<div class="form-group " name="Y21hcmlu[requested_urgency_id]">
					<label for="Y21hcmlu[requested_urgency_id]" class="col-sm-2 control-label">Urgencia</label>
					<div class="col-sm-10">
						<select class="form-control" id="Y21hcmlu[requested_urgency_id]" name="Y21hcmlu[requested_urgency_id]" >
							<option value="0" disabled="">Seleccionar</option>
							<?php
								global $NOVIS_CSI_PROJECT_URGENCY;
								$urgencies = $NOVIS_CSI_PROJECT_URGENCY->get_all();
								foreach ( $urgencies as $urgency ){
									echo '<option value="'.$urgency['id'].'">'.$urgency['short_name'].'</option>';
								}
							?>
						</select>
						<p class="help-block">En base al roadmap del cliente, indicar cuan urgente es la ejecuci&oacute;n de este proyecto.</p>
					</div>
				</div>
				<div class="form-group " name="Y21hcmlu[description]">
					<label for="Y21hcmlu[description]" class="col-sm-2 control-label">Descripción del Proyecto</label>
					<div class="col-sm-10"><textarea rows="10" class="form-control" id="Y21hcmlu[description]" name="Y21hcmlu[description]" placeholder="Descripción del Proyecto" data-required="true"></textarea>
						<p class="help-block">Indicar el detalle del Proyecto solicitado.</p>
					</div>
				</div>
				<div class="form-group " name="Y21hcmlu[planned_start_date]">
					<label for="Y21hcmlu[planned_start_date]" class="col-sm-2 control-label">Fecha de Inicio</label>
					<div class="col-sm-10">
						<input type="date" class="form-control" id="Y21hcmlu[planned_start_date]" name="Y21hcmlu[planned_start_date]" placeholder="Fecha real de inicio del Proyecto.">
						<p class="help-block">Indicar la fecha estimada de inicio del proyecto.</p>
						<p class="help-block">Recuerda que estas fechas serán evaluadas acorde al <a href="http://intranetmx.noviscorp.com/novis/proyectos/ongoing-projects/">Capacity Planning</a> de la sub-direcci&oacute;n de Proyectos..</p>
					</div>
				</div>
				<div class="form-group " name="Y21hcmlu[planned_end_date]">
					<label for="Y21hcmlu[planned_end_date]" class="col-sm-2 control-label">Fecha de fin.</label>
					<div class="col-sm-10">
						<input type="date" class="form-control" id="Y21hcmlu[planned_end_date]" name="Y21hcmlu[planned_end_date]" placeholder="Fecha real de fin del Proyecto.">
						<p class="help-block">Indica la fecha de finalización del proyecto.</p>
						<p class="help-block">En caso que el GoLive no coincida con la fecha de fin del proyecto, es importante indicar este detalle en la <label for="Y21hcmlu[description]">Descripción del Proyecto</label>.</p>
					</div>
				</div>
				<div class="form-group ">
					<div class="col-sm-2 control-label">&nbsp;</div>
					<div class="col-sm-10">
						<button type="submit" class="btn btn-danger btn-block btn-lg ">Solicitar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
    <?php wp_footer(); ?>
</body>
</html>