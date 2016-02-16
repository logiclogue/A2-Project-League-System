var gulp = require('gulp');
var concat = require('gulp-concat');
var del = require('del');

var paths = {
	javascript: [
		'lib/angular.min.js',
		'lib/angular-route.min.js',
		'app/*.js',
		'services/*.js',
		'directives/*.js',
		'controllers/*.js'
	],
	css: [
		'lib/*.css',
		'css/*.css'
	]
}


// Deletes /build folder
gulp.task('clean', function () {
	return del(['build']);
});


// Concats all JavaScript files
gulp.task('javascript', ['clean'], function () {
	return gulp.src(paths.javascript)
		.pipe(concat('all.js'))
		.pipe(gulp.dest('build'));
});