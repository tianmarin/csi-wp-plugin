<?php
/*
* Template Name: CSI EWA Uploader
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
			'csiTemplateEwaUpload',
			CSI_PLUGIN_URL.'/js/templates/min/template-ewa-upload-min.js',
			array('jquery','bootstrap','jquery-confirm'),
			'0.0.1'
		);
		wp_enqueue_script('csiTemplateEwaUpload');
		wp_localize_script(
			'csiTemplateEwaUpload',
			'csiTemplateEwaUpload',
			array(
				'ajaxUrl'						=> admin_url( 'admin-ajax.php' ),
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
</head>
<body>
	
	
	
		<!-- ------------------------------------------------------------------------------------------------------------- -->
		<div id="csi-ewas-upload" class="container" style="min-height:100vh;">
			<div class="row">
				<div class="page-header">
					<h2 class="">Carga de Resumen EWA</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-sm-push-8 well">
					
					<?php
						$now = new DateTime();
						$week = $now->format("W");
						$year = $now->format("Y");
						$monday = new DateTime();
						$monday->setISODate($year,$week);
						$sunday = new DateTime();
						$sunday->setISODate($year,$week,7);
					?>
					<h3 class="text-center">Semana <?php _e($week);?></h3>
					<p class="col-xs-6 text-muted text-center"><?php _e($monday->format('Y/m/d'));?></p>
					<p class="col-xs-6 text-muted text-center"><?php _e($sunday->format('Y/m/d'));?></p>
				</div>
			</div>
			<form class="form-horizontal" id="csi-ewa-upload-form">
				<div class="form-group">
					<label for="csi-ewa-file" class="col-sm-2 control-label">Archivo CSV</label>
						<div class="col-sm-10">
							<input type="file" id="csi-ewa-file">
							<p class="help-block">El archivo CSV debe haber sido generado acorde al <a href="#">Flujo de Administración de Alertas EWA.</a></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Subiendo archivo" data-normal-text="<i class='fa fa-upload fa-fw'></i> Subir"><i class="fa fa-upload fa-fw"></i> Subir</button>
						</div>
					</div>
				</form>
			<div id="csi-ewa-upload-status" style="display: none;" class="row">
				<div class="row">
					<div class="col-xs-12 col-sm-8">
						<h3>Resumen de Ejecuci&oacute;n</h3>
					</div>
					<div class="col-xs-12 col-sm-4 text-right">
						<button class="btn btn-default" id="csi-ewa-upload-print"><i class="fa fa-print fa-fw"></i> Imprimir</button>
					</div>
				</div>
			</div>

			</div><!-- #csi-ewas-analysis-02 -->

	
</body>
</html>