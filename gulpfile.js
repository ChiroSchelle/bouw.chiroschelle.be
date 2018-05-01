/**
 * Basic GULP setup
 */

/**
 * Define source and build path
 */
var sourceDir = '';
var buildDir = 'build/';

var gulp = require('gulp'),
    imagemin = require('gulp-imagemin'),
    jshint = require('gulp-jshint'),
    sass = require('gulp-sass'),
    uglify  = require('gulp-uglify'),
    connect = require('gulp-connect')
    minifyHTML = require('gulp-minify-html'),
    concat = require('gulp-concat');

/**
 * Development sass compiling and livereload
 */
gulp.task('sass', function() { //main scss file compilen
    return gulp.src(sourceDir + 'scss/**/*.scss')
        .pipe(
            sass({
                outputStyle: 'expanded',
                sourceComments: true,
            })
            .on('error', sass.logError)
        )
        .pipe(gulp.dest(sourceDir))

        .pipe(connect.reload());
});

/**
 * Production sass compiling / build
 */
gulp.task('sass_build', function() {
    return sass(sourceDir + 'scss', {
        'style': 'compressed'
    })
    .on('error', function (err) {
        console.error('Error!', err.message);
    })
    .pipe(gulp.dest(buildDir + 'css'));
});

/**
 * Production image optimisation
 */
gulp.task('imagemin', function(){
    gulp.src(sourceDir + 'img/*') //minify images
        .pipe(imagemin())
        .on('error', function (err) {
            console.error('Error!', err.message);
        })
        .pipe(gulp.dest(buildDir + 'img/')); //minified images will be stored here
});

/**
 * Production js minify
 */
gulp.task('js_uglify', function(){ 
    gulp.src(sourceDir + 'js/*.js') //alle filesn in js/ uglifien
    
    .pipe(uglify())
    .pipe(gulp.dest(buildDir + 'js/'))
});

/**
 * Production JS concat
 */
gulp.task('js_concat', function() {
  return gulp.src(sourceDir + 'js/*.js')
    .pipe(concat('scripts.js'))
    .pipe(gulp.dest(buildDir + 'js/'));
});

/**
 * Production JS concat + js minify
 * http://stackoverflow.com/questions/24591854/using-gulp-to-concatenate-and-uglify-files
 */
gulp.task('js_build', function() {
    return gulp.src(sourceDir + 'js/*.js')
    .pipe(concat('scripts.js', {newLine: '\r\n'}))
    .pipe(gulp.dest(buildDir + 'js/'))
    .pipe(uglify())
    .pipe(gulp.dest(buildDir + 'js/'));
});

/**
 * Development JS linitng and livereload
 */
gulp.task('jshint', function() {
    console.log('JSHINT');
    gulp.src(sourceDir + 'js/*.js') 
    .pipe(jshint())
    .pipe(jshint.reporter('default')) // print errors
    .pipe(connect.reload());
});

/**
 * Development HTML livereload
 */
gulp.task('html', function(){
    gulp.src(sourceDir + '*.html')
    .on('error', function (err) {
        console.error('Error!', err.message);
    })
    .pipe(connect.reload());
});

/**
 * Production HTML minify
 */
gulp.task('minify_html', function() {
    gulp.src(sourceDir + '*.html')
    .pipe(minifyHTML({
        empty:true,
        spare:true
    }))
    .pipe(gulp.dest(buildDir))
});

// development server en livereload
gulp.task('connect', function() {
    connect.server({
        root: 'src',
        host: 'localhost',
        livereload: true
    });
});


//watch alle scss, js en html files en als er een verandering is, ga je de taak tussen de haken uitvoeren
gulp.task('watch', function(){ 
    gulp.watch(sourceDir + 'scss/**/*.scss', ['sass']); // scss bestand aangepast? --> sass uitvoeren
    gulp.watch(sourceDir + 'js/*.js', ['jshint']); // js bestand aangepast? --> js en jshint uitvoeren
    gulp.watch(sourceDir + '*.html', ['html']); // html -> ...
});

gulp.task('default',['watch']);

// build script
gulp.task('build',['sass_build', 'minify_html', 'imagemin', 'js_build']);
