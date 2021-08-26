import gulp from 'gulp';

const sass = require('gulp-sass')(require('sass'));
import Fiber from 'fibers';

import postcss from 'gulp-postcss';
import del from 'del';
import autoprefixer from 'autoprefixer';

gulp.task('clean', () => del(['assets/css/acf-flexible-content-preview.css']));

gulp.task('sass', () => gulp.src('assets/scss/acf-flexible-content-preview.scss')
  .pipe(sass({
    fiber: Fiber,
    outputStyle: 'expanded',
    errLogToConsole: true
  }))
  .pipe(postcss([
    autoprefixer({
      cascade: false,
      grid: true
    })
  ]))
  .pipe(gulp.dest('assets/css/'))
);

gulp.task('default', gulp.series('clean', 'sass'));
