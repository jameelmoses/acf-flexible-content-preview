import gulp from 'gulp';
import sass from 'gulp-sass';
import postcss from 'gulp-postcss';
import del from 'del';
import autoprefixer from 'autoprefixer';

gulp.task('clean', () => del(['assets/css/acf-flexible-content-preview.css']));

gulp.task('sass', () => gulp.src('assets/scss/acf-flexible-content-preview.scss')
  .pipe(sass({
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
