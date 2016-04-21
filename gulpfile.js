var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var streamqueue = require('streamqueue');
var open = require('open');
var config = require('./config.json');
var project = require('./package.json');
var user = require('./user.json');
var src = {
	html: 'src/**/*.html',
	php: 'src/**/*.php',
	js: 'src/js/**/*.js',
	css: 'src/css/**/*.css',
	assets: 'src/assets/**/*'
};
var build = 'build';
gulp.task('html', function(done){
	var stream = gulp.src(src.html)
		.pipe($.newer(build))
		.pipe($.bytediff.start())
		.pipe($.minifyHtml())
		.pipe($.bytediff.stop())
		.pipe(gulp.dest(build))
		.pipe($.sftpNew({
			host: config.sftp.host,
			port: config.sftp.port,
			user: config.sftp.user,
			password: config.sftp.password,
			remotePath: 'fastmed.soringuga.ro/'+user,
			callback: function(){
				stream.pipe($.livereload());
				done();
			}
		}));
});
gulp.task('js', function(done){
	var stream = gulp.src(src.js)
		.pipe($.newer(build + '/js'))
		.pipe($.bytediff.start())
		.pipe($.ngAnnotate())
		.pipe($.uglify())
		.pipe($.bytediff.stop())
		.pipe(gulp.dest(build + '/js'))
		.pipe($.sftpNew({
			host: config.sftp.host,
			port: config.sftp.port,
			user: config.sftp.user,
			password: config.sftp.password,
			remotePath: 'fastmed.soringuga.ro/'+user+'/js',
			callback: function(){
				stream.pipe($.livereload());
				done();
			}
		}));
});
gulp.task('php', function(done){
	var stream =  gulp.src(src.php)
		.pipe($.newer(build))
		.pipe(gulp.dest(build))
		.pipe($.sftpNew({
			host: config.sftp.host,
			port: config.sftp.port,
			user: config.sftp.user,
			password: config.sftp.password,
			remotePath: 'fastmed.soringuga.ro/'+user,
			callback: function(){
				stream.pipe($.livereload());
				done();
			}
		}));
});
gulp.task('css', function(done){
	var stream =  gulp.src(src.css)
		.pipe($.newer(build+'/css'))
		.pipe($.bytediff.start())
		.pipe($.minifyCss({processImport: false}))
		.pipe($.bytediff.stop())
		.pipe(gulp.dest(build+'/css'))
		.pipe($.sftpNew({
			host: config.sftp.host,
			port: config.sftp.port,
			user: config.sftp.user,
			password: config.sftp.password,
			remotePath: 'fastmed.soringuga.ro/'+user+'/css',
			callback: function(){
				stream.pipe($.livereload());
				done();
			}
		}));
});
gulp.task('assets', function(done){
	var stream =  gulp.src(src.assets)
		.pipe($.newer(build+'/assets'))
		.pipe(gulp.dest(build+'/assets'))
		.pipe($.sftpNew({
			host: config.sftp.host,
			port: config.sftp.port,
			user: config.sftp.user,
			password: config.sftp.password,
			remotePath: 'fastmed.soringuga.ro/'+user+'/assets',
			callback: function(){
				stream.pipe($.livereload());
				done();
			}
		}));
});
gulp.task('build', ['html', 'js', 'php', 'css', 'assets']);
gulp.task('watch', function() {
	gulp.watch(src.html, ['html']);
	gulp.watch(src.php, ['php']);
	gulp.watch(src.js, ['js']);
	gulp.watch(src.css, ['css']);
	gulp.watch(src.assets, ['assets']);
	$.livereload.listen();
});
gulp.task('default', ['build', 'watch']);
gulp.task('d-html', function(done){
	var stream = gulp.src(src.html)
		.pipe($.minifyHtml())
		.pipe(gulp.dest(build));
});
gulp.task('d-js', function(done){
	var stream = gulp.src(src.js)
		.pipe($.ngAnnotate())
		.pipe($.uglify())
		.pipe(gulp.dest(build+'/js'));
});
gulp.task('d-php', function(done){
	var stream =  gulp.src(src.php)
		.pipe(gulp.dest(build));
});
gulp.task('d-css', function(done){
	var stream =  gulp.src(src.css)
		.pipe($.minifyCss({processImport: false}))
		.pipe(gulp.dest(build+'/css'));
});
gulp.task('d-assets', function(done){
	var stream =  gulp.src(src.assets)
		.pipe(gulp.dest(build+'/assets'));
});
gulp.task('deploy', ['d-html', 'd-js', 'd-php', 'd-css', 'd-assets']);
gulp.task('init', function(){
	gulp.src('src/index.*')
		.pipe($.sftpNew({
			host: config.sftp.host,
			port: config.sftp.port,
			user: config.sftp.user,
			password: config.sftp.password,
			remotePath: 'fastmed.soringuga.ro/'+user,
			callback: function(){ 
				open("http://fastmed.soringuga.ro/"+user); 
			}
		}));
});
