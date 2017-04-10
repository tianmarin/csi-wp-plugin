/**
 *
 * Gulpfile setup
 *
 * @since 1.0.0
 * @authors @tianmarin
 * @package noidea
 */

// Config
var config = {
    assetsPath  : './assets',
    lessPath    : './assets/less',
    bowerDir    : './bower_components'
}

var gulp = require('gulp');

// Load plugins
var gulpLoadPlugins = require('gulp-load-plugins'),
    $ = gulpLoadPlugins();

// Styles
gulp.task('templateStyle', function () {
    return gulp.src([
            './assets/less/template/*.less',
            // additional packages
            './bower_components/select2/dist/css/select2.css',
			'./bower_components/select2-bootstrap-theme/src/select2-bootstrap.less',
            './bower_components/jquery-ui-bootstrap/jquery.ui.theme.font-awesome.css',
            './bower_components/bootstrap-daterangepicker/daterangepicker.css',
        ])
        .pipe($.sourcemaps.init())
        //.pipe(plugins.flatten())
        .pipe($.concat('csi-template-style.less'))
        .pipe($.less({
            //paths: [ plugins.path.join(__dirname, 'less', 'includes') ]
        }))
        //.pipe($.cleanCss({compatibility: 'ie8'}))
        .pipe($.stripCssComments({preserve:false}))
//        .pipe($.cleanCss())
        .pipe($.sourcemaps.write('./maps'))
        .pipe(gulp.dest('./dist/css'))
        .pipe($.notify('Template Style compilation done!'));
});
gulp.task('shortcodeStyle', function () {
    return gulp.src([
            './assets/less/shortcode/*.less',
            // additional packages
            './bower_components/jquery-ui-bootstrap/jquery.ui.theme.font-awesome.css',
            './bower_components/bootstrap-daterangepicker/daterangepicker.css',
        ])
        .pipe($.sourcemaps.init())
        //.pipe(plugins.flatten())
        .pipe($.concat('csi-shortcode-style.less'))
        .pipe($.less({
            //paths: [ plugins.path.join(__dirname, 'less', 'includes') ]
        }))
        .pipe($.cleanCss({compatibility: 'ie8'}))
        .pipe($.sourcemaps.write('./maps'))
        .pipe(gulp.dest('./dist/css'))
        .pipe($.notify('Shortcode Style compilation done!'));
});
//Scripts

gulp.task('templateScript', function () {
    return gulp.src([
        './assets/js/templates/*.js',
        ])
        .pipe($.sourcemaps.init())
        .pipe($.jshint())
        .pipe($.jshint.reporter('default'))
        //.pipe($.uglify())
        .pipe($.concat('csi-template-js.js'))
        .pipe($.rename({
            suffix: ".min",
            extname: ".js"
        }))
        .pipe($.sourcemaps.write('./maps'))
        .pipe(gulp.dest('./dist/js'))
        .pipe($.notify('Template Script compilation done!'));
});

// Uglify Plugins
gulp.task('uglifyVendor', function() {
    return gulp.src([
        './bower_components/bootstrap/dist/js/bootstrap.js',
        './bower_components/jquery-confirm2/js/jquery-confirm.js',
        './bower_components/select2/dist/js/select2.js',
        './bower_components/moment/moment.js',
        './bower_components/bootstrap-daterangepicker/daterangepicker.js',
		'./bower_components/amcharts3/amcharts/amcharts.js',
		'./bower_components/amcharts3/amcharts/serial.js',
		'./bower_components/amcharts3/amcharts/funnel.js',
		'./bower_components/amcharts3/amcharts/gantt.js',
		'./bower_components/amcharts3/amcharts/gauge.js',
		'./bower_components/amcharts3/amcharts/pie.js',
		'./bower_components/amcharts3/amcharts/radar.js',
		'./bower_components/amcharts3/amcharts/xy.js',
    ])
    .pipe($.sourcemaps.init())
    .pipe($.concat('vendor.js'))
    .pipe($.rename({
        suffix: ".min",
        extname: ".js"
    }))
    //.pipe($.uglify())
    .pipe($.sourcemaps.write('./maps'))
    .pipe(gulp.dest('./dist/js'))
    .pipe($.notify('Template Script compilation done!'));
});

// Third Parties
gulp.task('third-party-classes', function() {
    return gulp.src(
			[
				config.bowerDir + '/parsedown/Parsedown.php',
			]
		)
        .pipe(gulp.dest('./dist/third-party-classes'));
});

// Fonts
gulp.task('fonts', function() {
    return gulp.src([config.bowerDir + '/**/fontawesome-webfont.*'])
        .pipe($.sourcemaps.init())
        .pipe(plugins.flatten())
        .pipe($.sourcemaps.write('./maps'))
        .pipe(gulp.dest('./dist/fonts'));
});

// Images
gulp.task('images', function () {
    return gulp.src([
    		'assets/images/**/*',
    		'assets/lib/images/*'])
        .pipe($.cache($.imagemin({
            optimizationLevel: 3,
            progressive: true,
            interlaced: true
        })))
        .pipe(gulp.dest('./dist/images'))
        .pipe($.size());
});
// Clean
gulp.task('clean', function () {
    return gulp.src(['dist/css', 'dist/js', 'dist/images'], { read: false }).pipe($.clean());
});

// Build
gulp.task('build', ['templateStyle', 'shortcodeStyle', 'images', 'fonts']);

// Default task
gulp.task('default', ['clean'], function () {
    gulp.start('build');
});
var browserSync = require('browser-sync').create();

gulp.task('watch', function () {
    gulp.watch(config.assetsPath + '/**/*.less', ['templateStyle']);
    gulp.watch(config.assetsPath + '/**/*.js', ['templateScript']);
    gulp.watch(config.assetsPath + './gulpfile.js', ['uglifyVendor']);
    //gulp.watch(config.assetsPath + "/**/*.php").on('change', browserSync.reload);
});
gulp.task('browser-sync', function() {
    browserSync.init({
        files: ["./**/*.php","./dist/**/*.js","./dist/**/*.css"],
        proxy: "localhost",
		injectChanges: true,
    });
});

/*
gulp.task('build-less', function() {
    return gulp.src(config.lessPath + '/style.less')
    .pipe(sourcemaps.init())
    .pipe(less({
        // outputStyle: 'compressed',
        sourceMap: true,
        includePaths: [
            './assets/less',
            config.bowerDir + '/bootstrap-sass/assets/stylesheets',
            config.bowerDir + '/font-awesome/scss',
        ],
    }).on('error', sass.logError))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./dist/css'))
    .pipe(browserSync.stream())
    .pipe(notify('Less compilation done'));
});
*/
