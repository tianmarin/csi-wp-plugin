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
<html <?php language_attributes(); ?> manifest="<?php _e(CSI_PLUGIN_URL.'/templates/manifest-project-request.manifest');?>">
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
			'csiTemplateProjectRequest',
			CSI_PLUGIN_URL.'/js/templates/min/template-project-request-min.js',
			array('jquery-ui-datepicker','jquery-confirm'),
			'0.9.0'
		);
		wp_localize_script(
			'csi_WPCLIENT',
			'csiWPCLIENT',
			array(
//				'ppost'							=> $this->plugin_post,
				'ajaxurl'						=> admin_url( 'admin-ajax.php' ),
			)
		);
		//------------------------------------------
		wp_register_style(
			"bootstrap",
			CSI_PLUGIN_URL.'/external/bootstrap/dist/css/bootstrap.min.css' ,
			null,
			"1.0",
			"all"
		);
		wp_enqueue_style("bootstrap" );
		//------------------------------------------
		wp_register_style(
			"jquery-ui-bootstrap",
			CSI_PLUGIN_URL.'/external/jquery-ui-bootstrap/css/custom-theme/jquery-ui-1.10.0.custom.css' ,
			null,
			"1.0",
			"all"
		);
		wp_enqueue_style("jquery-ui-bootstrap" );
		//------------------------------------------
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
	<div class="container-fluid csi-project-request-welcome">
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
			</div>
			<div class="col-xs-12 csi-project-request-welcome-buttons">
				<div class="col-xs-6 text-center">
					<a class="btn btn-danger csi-project-request-button animated flipInX" href="#user-project-request-status" role="button">Ver mis solicitudes</a>
				</div>
				<div class="col-xs-6 text-center">
					<a class="btn btn-success csi-project-request-button animated flipInX" href="#project_request_form" role="button">Nueva solicitud</a>
				</div>
			</div>
		</div>
	</div><!-- .csi-project-request-welcome -->
	<div class="container-fluid" id="user-project-request-status">
		<?php
			$user_id = get_current_user_id();
			$user_name = get_userdata($user_id);
			if ( $user_name ){
				$user_name = ' de '.$user_name->display_name;
			}else{
				$user_name = '';
			}
		?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4><i class="fa fa-check"></i> Status de Solicitudes <?php _e($user_name);?></h4>
			</div>
			<div class="panel-body">
				A continuación puedes ver el estado de las Solicitudes de Proyecto que has creado.
			</div>
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th class="text-center"><i class="fa fa-hashtag"></i></th>
						<?php
							if ( is_multisite() ){
								_e('<th class="text-center">Cliente</th>');
							}
						?>
						<th class="text-center">Nombre de Proyecto</th>
						<th class="text-center">Fecha de Solicitud</th>
						<th class="text-center">Status de Solicitud</th>
					</tr>
				</thead>
				<tbody>
					<?php
						global $NOVIS_CSI_PROJECT;
						global $NOVIS_CSI_PROJECT_STATUS;
						$sql = "SELECT * FROM ".$NOVIS_CSI_PROJECT->tbl_name." ORDER BY requested_date, customer_id ASC";
						$projects = $NOVIS_CSI_PROJECT->get_sql($sql);
						foreach ( $projects as $project ){
							echo '<tr>';
								echo '<td class="text-center">'.$project['id'].'</td>';
							if ( is_multisite() ){
								if ( 0 == $project['customer_id'] ){
									echo '<td class="text-left">...</td>';								
								}else{
									$customer_name = get_blog_details($project['customer_id'])->blogname;
									echo '<td class="text-left">'.$customer_name.'</td>';
								}
							}
								echo '<td class="text-left">'.$project['short_name'].'</td>';
								echo '<td class="text-center">'.$project['requested_date'].'</td>';
								$status = $NOVIS_CSI_PROJECT_STATUS->get_single($project['status_id']);
								echo '<td class=" text-center '.$status['css_class'].'"><span class="text-'.$status['css_class'].'">'.$status['short_name'].'</span></td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</div><!-- #user-project-request-status -->
	<div class="container" id="project_request_form">
		<div class="">
			<div class="page-header">
				<h3>Solicitar nuevo Proyecto <a href="http://intranetmx.noviscorp.com/novis/proyectos/project-management/" target="_blank"><span class="label label-danger">Aprender m&aacute;s</span></a></h3>
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
							<option value="0">No es un cliente en operaci&oacute;n</option>
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
						<div class="input-group">
							<input type="date" class="form-control" id="Y21hcmlu[planned_start_date]" name="Y21hcmlu[planned_start_date]" placeholder="Fecha real de inicio del Proyecto." readonly>
							<div class="input-group-addon">
								<label for="Y21hcmlu[planned_start_date]">
									<i class="fa fa-calendar" aria-hidden="true"></i>
								</label>
							</div>
						</div>
						<p class="help-block">Indicar la fecha estimada de inicio del proyecto.</p>
						<p class="help-block">Recuerda que estas fechas serán evaluadas acorde al <a href="http://intranetmx.noviscorp.com/novis/proyectos/ongoing-projects/">Capacity Planning</a> de la sub-direcci&oacute;n de Proyectos..</p>
					</div>
				</div>
				<div class="form-group " name="Y21hcmlu[planned_end_date]">
					<label for="Y21hcmlu[planned_end_date]" class="col-sm-2 control-label">Fecha de Salida en Vivo</label>
					<div class="col-sm-10">
						<div class="input-group">
							<input type="date" class="form-control" id="Y21hcmlu[planned_end_date]" name="Y21hcmlu[planned_end_date]" placeholder="Fecha real de fin del Proyecto." readonly>
							<div class="input-group-addon">
								<label for="Y21hcmlu[planned_end_date]">
									<i class="fa fa-calendar" aria-hidden="true"></i>
								</label>
							</div>
						</div>
						<p class="help-block">Indica la fecha de GoLive del proyecto.</p>
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
	</div><!-- #project_request_form -->
    <?php wp_footer(); ?>
</body>
</html>