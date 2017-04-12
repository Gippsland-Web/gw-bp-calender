var gulp = require('gulp');
var minify = require('gulp-minify');

 

gulp.task('compress', function() {

  gulp.src('js/*.js')

    .pipe(minify({

        ext:{

            min:'.min.js'

        },

        exclude: ['tasks'],

        ignoreFiles: ['.combo.js', '-min.js']

    }))

    .pipe(gulp.dest('dist'))

});



var cleanCSS = require('gulp-clean-css');



gulp.task('minify-css', function() {

  return gulp.src('css/*.css')

    .pipe(cleanCSS({compatibility: 'ie8'}))

    .pipe(gulp.dest('dist'));

});
