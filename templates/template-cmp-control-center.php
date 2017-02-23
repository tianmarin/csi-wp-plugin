<?php
/*
* Template Name: CSI CMP Control Center
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
		function csi_template_cmp_control_center(){
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
		add_action( 'wp_enqueue_scripts', 'csi_template_cmp_control_center', 99);
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

















<body class="csi-template csi-template-cmp-control-center-body">














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
	<article id="csi-template-cmp-control-center-main" style="min-height:100vh;">
	</article>


	<!-- #ListPlans -->








	<!-- #AddPlan -->
	<div id="csi-template-cmp-control-center-add-plan" class="container hidden" style="min-height:100vh">
		<div class="panel panel-default row">
            <div class="panel-heading">
            </div>
			<div class="panel-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="customer" class="col-sm-2 control-label">Cliente</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-fw fa-spin fa-circle-o-notch"></i></span>
								<input type="text" class="form-control" id="customer" placeholder="Cliente" required="true" />
							</div>
							<span class="help-block">
								Todo <i>Plan de Correcci&oacute;n o Mantenimiento</i> debe ir asociado con un cliente.
								En el caso que quieras generar un plan interno debes indicar que el cliente es <strong>Novis</strong>.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">T&iacute;tulo</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="title" placeholder="T&iacute;tulo" required="true" />
							<span class="help-block">
								Titulo / nombre del Plan.<br/>
								Frecuentemente se utiliza una descripción sencilla como <small><code>Actualización de Kernel Q1 2017</code></small>.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 100 caracteres.</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">Descripci&oacute;n</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="description" placeholder="Descripci&oacute;n"></textarea>
							<span class="help-block">
								Descripci&oacute;n breve del Plan de Correcci&oacute;n o Mantenimiento.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 255 caracteres.</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="manager" class="col-sm-2 control-label">Responsable</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-fw fa-spin fa-circle-o-notch"></i></span>
								<input type="text" class="form-control" id="manager" placeholder="[Usuario actual]" />
							</div>
							<span class="help-block">
								Responsable del Plan de Correcci&oacute;n o Mantenimiento.<br/>
								Si este campo está vacío, el sistema asumirá como responsable del plan al usuario creador del mismo.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="source_tags" class="col-sm-2 control-label">Etiquetas de Origen</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="source_tags" placeholder="#ewa #incidente" />
							<span class="help-block">
								Las etiquetas de Origen, permiten indicar las causas que originaron la creación de este plan.<br/>
								<i class="fa fa-info"></i> Las etiquetas deben estar separadas por espacios.<br/>
								Opciones comunes son: <small><kbd>#ewa</kbd> <kbd>#incidente</kbd> <kbd>#recomendaciones_sap</kbd></small>.<br/>
								<small>Tama&ntilde;o m&aacute;ximo: 100 caracteres.</small>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="doc-plus" class="col-sm-2 control-label">Documentos relacionados</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-danger">
										<i class="fa fa-minus-circle"></i>
									</button>
								</span>
								<span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
								<input type="text" class="form-control" placeholder="Descripci&oacute;n del Documento" />
								<span class="input-group-addon"><i class="fa fa-link"></i></span>
								<input type="text" class="form-control" placeholder="Doc. URL" />
							</div>
							<button class="btn btn-block btn-info" id="doc-plus"><i class="fa fa-plus-circle"></i></button>
							<span class="help-block">
								Los documentos relacionados permiten adjuntar enlaces a los documentos en los cuales se reflejan diferentes componentes del plan.<br/>
								Los siguientes documentos son recomendados:
								<ul>
									<li>Documento de Objetivos <i class="fa fa-question-circle text-info"></i></li>
									<li>Documento de Seguimiento <i class="fa fa-question-circle text-info"></i></li>
								</ul>
							</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<p class="text-muted text-justify">
								La creación de un Plan de Corrección o Mantenimiento aparecerá de modo inmediato en los planes del cliente seleccionado.
							</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10 text-right">
							<button class="btn btn-danger">Cancelar</button>
							<button type="submit" class="btn btn-primary">Entiendo, Crear Plan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>











	<!-- #ShowPlan -->
	<div id="csi-template-cmp-control-center-show-plan" class="container hidden" style="min-height:100vh">
		<div class="page-header">
            <h2>[Titulo] <small>[cliente]</small></h2>
			<p class="text-muted">[Username] modificó este plan hace 16 horas</p>
        </div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-fw fa-info"></i> Información del Plan
						<div class="pull-right">
							<a href="#"><i class="fa fa-fw fa-refresh"></i></a>
							|
							<a data-toggle="collapse" href="#plan-3-info" role="button">
								<i class="fa fa-fw fa-caret-down"></i>
							</a>
						</div>
					</div>
					<div id="plan-3-info" class="collapse">
						<table class="table table-condensed">
							<tbody class="">
								<tr>
									<th class="small">Cliente</th>
									<td>El Palacio de Hierro</td>
								</tr>
								<tr>
									<th class="small">Responsable</th>
									<td><a href="#"><i class="fa fa-id-card-o"></i> Cristian Marin</a></td>
								</tr>
								<tr>
									<th class="small">Status</th>
									<td>
										<span class="text-danger">
											<i class="fa fa-lg fa-lock"></i> Bloqueado
										</span>
										<a href="#" class="pull-right"><i class="fa fa-question-circle"></i>
									</td>
								</tr>
								<tr>
									<th class="small">Actividad</th>
									<td>
										<ul class="list-unstyled">
											<li><i class="fa fa-fw fa-flag-o"></i> 24 / Febrero / 2017</li>
											<li><i class="fa fa-fw fa-flag-checkered"></i> 24 / Marzo / 2017</li>
										</ul>
									</td>
								</tr>
								<tr>
									<th class="small">Esfuerzo</th>
									<td class="">
										<ul class="list-unstyled">
											<li><strong>32</strong> HH - Invertidas</li>
											<li><strong>58</strong> HH - Planificadas</li>
											<li><strong>90</strong> HH - Total</li>
										</ul>
									</td>
								</tr>
								<tr>
									<th class="small">Avance</th>
									<td>
										<div class="progress">
											<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
												60%
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-fw fa-folder-o"></i> Documentos asociados
						<div class="pull-right">
							<a href="#"><i class="fa fa-fw fa-refresh"></i></a>
							|
							<a data-toggle="collapse" href="#plan-3-docs" role="button">
								<i class="fa fa-fw fa-caret-down"></i>
							</a>
						</div>
					</div>
					<div class="list-group collapse" id="plan-3-docs">
						<a class="list-group-item" target="_blank" href="#">
							Documento 1
							<div class="pull-right">
								<span class="fa fa-fw text-info fa-cloud-download"></span>
							</div>
						</a>
						<a class="list-group-item" target="_blank" href="#">
							Documento 1
							<div class="pull-right">
								<span class="fa fa-fw text-info fa-cloud-download"></span>
							</div>
						</a>
						<a class="list-group-item" target="_blank" href="#">
							Documento 1
							<div class="pull-right">
								<span class="fa fa-fw text-info fa-cloud-download"></span>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-fw fa-tasks"></i> Actividades
						<div class="pull-right">
							<a href="#"><i class="fa fa-fw fa-refresh"></i></a>
							|
							<a data-toggle="collapse" href="#plan-3-tasks" role="button">
								<i class="fa fa-fw fa-caret-down"></i>
							</a>
						</div>
					</div>
					<ul class="list-group collapse" id="plan-3-tasks">
						<li class="list-group-item">
							<span class="text-center lead">Avance del Plan</span>
							<div class="progress">
								<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
									60%
								</div>
							</div>
							<small>Este valor refleja el porcentaje de tareas de ejecución efecutadas contra las por ejecutar.</small>
						</li>
						<li class="list-group-item">012: Propuestas</li>
						<li class="list-group-item">002: VoBo Cliente</li>
						<li class="list-group-item">010: Programado</li>
						<li class="list-group-item">001: En Ejecuci&oacute;n</li>
						<li class="list-group-item">002: Suspendidas</li>
						<li class="list-group-item">025: Ejecutadas</li>
						<li class="list-group-item">000: Vueltra Atrás</li>
						<li class="list-group-item">001: Canceladas</li>
					</ul>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-fw fa-users"></i> Ejecutores
						<div class="pull-right">
							<a href="#"><i class="fa fa-fw fa-refresh"></i></a>
							|
							<a data-toggle="collapse" href="#plan-3-tasks-type" role="button">
								<i class="fa fa-fw fa-caret-down"></i>
							</a>
						</div>
					</div>
					<ul id="plan-3-tasks-type" class="list-group collapse">
						<li class="list-group-item">Cristian Marin <span class="badge">12</span></li>
						<li class="list-group-item">Ricardo De Acha <span class="badge">8</span></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-fw fa-book"></i> Logs
					<div class="pull-right">
						<a href="#"><i class="fa fa-fw fa-plus"></i></a>
						|
						<a href="#"><i class="fa fa-fw fa-refresh"></i></a>
						|
						<a data-toggle="collapse" href="#plan-3-log" role="button">
							<i class="fa fa-fw fa-caret-down"></i>
						</a>
					</div>
				</div>
				<div id="plan-3-log" class="collapse">
					<table class="table table-condensed table-striped" style="margin:0;">
						<tbody>
							<tr>
								<th class="small">23/09/2016 13:56hrs</th>
								<td class="small">Cristian Marin</td>
								<td class="small">El cliente ha solicitado suspender la actividad <a href="#">#46764</a></td>
							</tr>
							<tr>
								<th class="small">28/09/2016 13:56hrs</th>
								<td class="small">Cristian Marin</td>
								<td class="small">El cliente ha solicitado suspender la actividad <a href="#">#46764</a> por Falta de autorización del equipo funcional y del área de Negocios.</td>
							</tr>
							<tr>
								<th class="small">30/09/2016 13:56hrs</th>
								<td class="small">Cristian Marin</td>
								<td class="small">El cliente ha solicitado suspender la actividad <a href="#">#46764</a></td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="999" class="text-center small">
									<nav aria-label="Page navigation">
										<ul class="pagination" style="margin:0;">
											<li>
												<a href="#" aria-label="Previous">
													<span aria-hidden="true">&laquo;</span>
												</a>
											</li>
											<li><a href="#">1</a></li>
											<li><a href="#">2</a></li>
											<li><a href="#">3</a></li>
											<li><a href="#">4</a></li>
											<li><a href="#">5</a></li>
											<li>
												<a href="#" aria-label="Next">
													<span aria-hidden="true">&raquo;</span>
												</a>
											</li>
										</ul>
									</nav>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
            <div class="panel-heading">
				<p class="text-right">
					<button class="btn btn-primary btn-xs">
						<i class="fa fa-filter"></i> Filtrar
					</button>
				</p>
            </div>
            <table class="table table condensed">
                <thead>
                    <tr>
						<th><i class="fa fa-hashtag"></i></th>
                        <th class="hidden-xs">Landscape</th>
                        <th class="hidden-xs">Ambiente</th>
                        <th>SID</th>
                        <th>Ticket</th>
                        <th>Status</th>
						<th>Inicio</th>
						<th>Duraci&oacute;n</th>
						<th>Log</th>
						<th>Opciones</th>
                    </tr>
                    <tr class="csi-template-table-filter collapse">
						<th>&nbsp;</th>
                        <th class="hidden-xs">&nbsp;</th>
                        <th class="hidden-xs">&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
                    </tr>
                </thead>
				<tbody>
					<tr>
						<td colspan="999" class="text-center">
							<button class="btn btn-success">
								<i class="fa fa-plus"></i> Agregar Tarea
							</button>
						</td>
					</tr>
				</tbody>
                <tfoot>
					<tr>
						<th><i class="fa fa-hashtag"></i></th>
                        <th class="hidden-xs">Landscape</th>
                        <th class="hidden-xs">Ambiente</th>
                        <th>SID</th>
                        <th>Ticket</th>
                        <th>Status</th>
						<th>Inicio</th>
						<th>Duraci&oacute;n</th>
						<th>Log</th>
						<th>Opciones</th>
                    </tr>
                </tfoot>
            </table>
			<div style="position:relative;">
				<div id="csi-template-cmp-control-center-table-pagination" class="text-center"></div>
			</div>
        </div>
	</div>










	<!-- #AddTask -->
	<div id="csi-template-cmp-control-center-add-plan" class="container hidden" style="min-height:100vh">
		<div class="panel panel-default row">
            <div class="panel-heading">
				<h3 class="panel-title">Agregar tarea al plan <i>[Titulo] <small>[cliente]</small></i></h3>
            </div>
			<div class="panel-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="system" class="col-sm-2 control-label">Sistema</label>
						<div class="col-sm-10">
							<input type="hidden" id="system-id" />
							<input type="text" class="form-control" id="system" placeholder="SCM DEV SCD" required="true" />
							<span class="help-block">
								El sistema involucrado indica el sistema del cliente afectado en la actividad.<br/>
								En el caso que esta tarea afecte dos sistemas existen diferentes.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="cmp-task-type" class="col-sm-2 control-label">Tipo de Tarea</label>
						<div class="col-sm-10">
							<select class="form-control" id="cmp-task-type" required="true">
								<option value="0" disabled >Seleccionar Tipo</option>
							</select>
							<span class="help-block">
								El tipo de tarea define el comportamiento de esta tarea en el proceso de evaluación de horas, y calendario <a href="#"><i class="fa fa-question-circle"></i></a>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="activity-type" class="col-sm-2 control-label">Tipo de Actividad</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="activity-type" placeholder="Actualización de nivel de parche de Kernel ABAP" required="true" />
							<span class="help-block">
								Si el tipo de actividad no est&aacute; disponible, selecciona <strong>Otros</strong>.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="activity-availability" class="col-sm-2 control-label">¿Ventana Offline?</label>
						<div class="col-sm-10">
							<input type="checkbox" class="form-control" id="activity-availability"/>
							<span class="help-block">
								Indica si la actividad impacta la disponibilidad del sistema relacionado.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="customer-visible" class="col-sm-2 control-label">Visible para Cliente</label>
						<div class="col-sm-10">
							<input type="checkbox" class="form-control" id="customer-visible"/>
							<span class="help-block">
								Si el campo est&aacute; seleccionado (dependiendo del <label for="cmp-task-type">Tipo de Tarea <i class="fa fa-chevron-circle-up"></i></label>) esta actividad es visible para el calendario del cliente.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="task-description" class="col-sm-2 control-label">Observaciones</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="task-description" placeholder="Observaciones adicionales"></textarea>
							<span class="help-block">
								Si el tipo de actividad es sincronizado con el calentadio, este texto aparecerá como contenido adicional en el evento.<br/>
								Tama&ntilde;o m&aacute;ximo: 255 caracteres.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="task-status" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10">
							<select class="form-control" id="task-status">
								<option value="0" disabled="true">Seleccionar Status</option>
							</select>
							<span class="help-block">
								El status de la tarea define el comportamiento de esta esta tarea en el proceso de evaluación de horas, y calendario <a href="#"><i class="fa fa-question-circle"></i></a>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="task-ticket" class="col-sm-2 control-label">Ticket</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="task-ticket" placeholder="5000012345" />
							<span class="help-block">
								El status de la tarea define el comportamiento de esta esta tarea en el proceso de evaluación de horas, y calendario <a href="#"><i class="fa fa-question-circle"></i></a>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="manager" class="col-sm-2 control-label">Fecha y hora</label>
						<div class="col-sm-10">
							<input type="date" class="hidden" id="filter-date-start"/>
							<input type="date" class="hidden" id="filter-date-end"/>
							<div id="filter-date-range" class="text-center form-control text-right">
								<small><span class=""></span></small>&nbsp;<i class="fa fa-caret-down fa-fw"></i>
							</div>
							<span class="help-block">
								El campo de fecha y hora identifica el lapso de tiempo en el cual se desarrolla la tarea.
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="task-add-executor" class="col-sm-2 control-label">Ejecutores</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-danger">
										<i class="fa fa-minus-circle"></i>
									</button>
								</span>
								<span class="input-group-addon"><i class="fa fa-user-o"></i></span>
								<input type="text" class="form-control" placeholder="Cristian Marin" />
								<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
								<input type="number" class="form-control" placeholder="3 hrs" />
								<span class="input-group-addon">horas</span>
							</div>
							<button class="btn btn-block btn-info" id="task-add-executor">
								<i class="fa fa-plus-circle"></i> Agregar ejecutor
							</button>
							<span class="help-block">
								Los ejecutores de una actividad permiten la notificación previa en el calendario personal.<br/>
								Si el campo de tiempo de actividad en cada responsable se deja en blanco, el sistema asigna la duración total de la tarea. (<a href="#">Aprender m&aacute;s</a>).
							</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<p class="text-muted text-justify">
								La creaci&oacute;n de un Plan de Correcci&oacute;n o Mantenimiento aparecer&aacute; de modo inmediato en los planes del cliente seleccionado.
							</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10 text-right">
							<button class="btn btn-danger">Cancelar</button>
							<button type="submit" class="btn btn-primary">Entiendo, Crear tarea</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>










<?php
	wp_footer();
?>
</body>
</html>
