<?php
/*
* Template Name: CSI Issue Control Center
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
	<base href="<?php _e(trailingslashit(get_permalink())); ?>"
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
	<link rel="shortcut icon" href="<?php _e(CSI_PLUGIN_URL.'/dist/img/icon/cmp/template-cmp-control-center-icon@180x180.png');?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php _e(CSI_PLUGIN_URL.'/dist/img/icon/cmp/template-cmp-control-center-icon@180x180.png');?>">
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
		function csi_template(){
			wp_register_script(
				'csiVendorScripts',
				CSI_PLUGIN_URL.'/dist/js/vendor.min.js',
				array('jquery'),
				'0.1.0',
				true
			);
			wp_enqueue_script(
				'csiTemplateScript',
				CSI_PLUGIN_URL.'/dist/js/csi-template-js.min.js',
				array('csiVendorScripts'),
				'0.1.0',
				true
			);
			//wp_enqueue_script('csiTemplateScript');
			wp_localize_script(
				'csiTemplateScript',
				'csiTemplateScript',
				array(
					'ajaxUrl'						=> admin_url( 'admin-ajax.php' ),
				)
			);

		}
		add_action( 'wp_enqueue_scripts', 'csi_template', 99);
		//------------------------------------------
		wp_register_style(
			"csiTemplateStyle",
			CSI_PLUGIN_URL.'/dist/css/csi-template-style.css',
			null,
			"1.0",
			"all"
		);
		wp_enqueue_style("csiTemplateStyle" );
        //------------------------------------------
		remove_action( 'wp_head', 'feed_links_extra', 3 );                      //remove Category Feeds
		remove_action( 'wp_head', 'feed_links', 2 );                            //remove Post and Comment Feeds
		remove_action( 'wp_head', 'rsd_link' );                                 //remove EditURI link
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );              //remove previous link
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );               //remove start link
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );   //remove Links for Adjacent Posts
		remove_action( 'wp_head', 'wp_generator' );                             //remove WP version
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

















<body class="csi-template csi-template-issue-control-center-body">














	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#csi-template-cmp-control-center-navbar" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php _e(trailingslashit(get_permalink())); ?>" title="Plan de Correcci&oacute;n o Mantenimiento">
					<i class="fa fa-tasks"></i>
					PCM
					<i id="csi-template-cmp-control-center-ajax" class="fa fa-spin fa-circle-o-notch text-primary"></i>
				</a>
			</div>
			<div class="collapse navbar-collapse" id="csi-template-cmp-control-center-navbar">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="#" title="Planes creados por mi">
							<i class="fa fa-user-o fa-fw fa-lg"></i>
							<span class="visible-xs-inline">Planes creados por mi</span>
						</a>
					</li>
					<li>
						<a href="#" title="Planes en los que participo">
							<i class="fa fa-user-plus fa-fw fa-lg"></i>
							<span class="visible-xs-inline">Planes en los que participo</span>
						</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle animated  infinite" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-bell fa-lg "></i>
							<span class="badge progress-bar-warning">4</span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<span class="dropdown-header">
									<i class="fa fa-exclamation-triangle text-warning"></i> Tienes <strong>4</strong> tareas retrasadas
								</span>
							</li>
							<li role="separator" class="divider"></li>
							<li>
								<a href="#">
									EPH - Actualización de Kernel Patch Level - ERD<br/>
									<small>Tarea progrmada para el 24/02/2017</small>
								</a>
							</li>
							<li>
								<a href="#">
									EPH - Actualización de Kernel Patch Level - ERD<br/>
									<small>Tarea progrmada para el 24/02/2017</small>
								</a>
							</li>
							<li>
								<a href="#">
									EPH - Actualización de Kernel Patch Level - ERD<br/>
									<small>Tarea progrmada para el 24/02/2017</small>
								</a>
							</li>
							<li>
								<a href="#">
									EPH - Actualización de Kernel Patch Level - ERD<br/>
									<small>Tarea progrmada para el 24/02/2017</small>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>




	<article id="csi-template-issue-control-center-main" style="min-height:100vh;" class="csi-template-main-content" data-default-action="csi_issue_build_page_intro">
		<div class="container">
			<p class="h2">Errores en Interfaces de PI</p>
			<p class="h4">Resumen</p>
			<p class="text-justify">Esto es una prueba de texto para ver como se ve cuando uno escribe mucho. Tambien podría servir para ver cuantos caracteres deben ser incluidos como el maximo numero de caracteres. Este texto tiene 228 caracteres.</p>
			<p class="h4">Sintomas</p>
			<p class="h4">Causa / Pre-requisitos</p>
			<p class="h4">Solución</p>
			<p class="h4">Documentos relacionados</p>
			<div class="row">
				<div class="col-sm-6 list-group">
					<a href="#" class="list-group-item list-group-item-info">
						<p class="list-group-item-heading">
							<i class="fa fa-file-text-o"></i> Documento de algo
						</p>
						<p class="list-group-item-body">Bla blablablab blabfdbfd  er bone vpoer  o  re</p>
					</a>
				</div>
			</div>
			<p class="h4">Tabla de ocurrencias del issue</p>
			<table class="table">
				<thead>
					<tr>
						<td><a href="#" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a></td>
						<th>Cliente</th>
						<th>Sistema</th>
						<th>Fecha</th>
						<th>Ticket</th>
						<th>Autor</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><a href="#" class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></a></td>
						<td>Extra</td>
						<td>RR0</td>
						<td>23/06/2015</td>
						<td>500173465</td>
						<td class="small">
							<a href="#"><i class="fa fa-id-card-o"></i> cmarin</a>
						</td>
					</tr>
					<tr>
						<td><a href="#" class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></a></td>
						<td>El Palacio de Hierro</td>
						<td>ERP</td>
						<td>23/06/2016</td>
						<td>53094767693</td>
						<td class="small">
							<a href="#"><i class="fa fa-id-card-o"></i> cmarin</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</article>






<?php
	wp_footer();
?>
</body>
</html>
