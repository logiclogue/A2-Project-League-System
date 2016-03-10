var gulp = require('gulp');
var concat = require('gulp-concat');
var watch = require('gulp-watch');
var yuidoc = require('gulp-yuidoc');
var del = require('del');

var paths = {
	javascript: [
		'lib/angular.min.js',
		'lib/angular-route.min.js',
		'lib/*.js',
		'app/*.js',
		'services/*.js',
		'directives/*.js',
		'controllers/*.js'
	],
	css: [
		'lib/normalize.css',
		'lib/skeleton.css',
		'css/*.css'
	],
	php: [
		'models/*.php',
		'php/*.php',
		'superclasses/*.php'
	]
}


// Deletes /build folder
gulp.task('clean', function () {
	return del(['build']);
});


// Concats all JavaScript files
gulp.task('javascript', function () {
	return gulp.src(paths.javascript)
		.pipe(concat('all.js'))
		.pipe(gulp.dest('build'));
});


// Concats all CSS files
gulp.task('css', function () {
	return gulp.src(paths.css)
		.pipe(concat('all.css'))
		.pipe(gulp.dest('build'));
});


// Creates the documentation
gulp.task('docs', function () {
	return gulp.src(paths.php)
		.pipe(yuidoc.parser())
		.pipe(gulp.dest('documentation'));
});


// Watches all
gulp.task('watch', function () {
	gulp.watch(paths.javascript, ['javascript']);
	gulp.watch(paths.css, ['css']);
});


// Default task
gulp.task('default', ['clean', 'javascript', 'css', 'watch']);