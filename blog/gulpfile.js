const gulp = require('gulp')
const sass = require('gulp-sass')(require('sass'))
const sourcemaps = require('gulp-sourcemaps')
const concat = require('gulp-concat')
const gulpAutoprefixer = require('gulp-autoprefixer')

function defaultTask() {
  return gulp.src('./public/css/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(concat('style.css'))
    .pipe(gulpAutoprefixer())
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./public/css'))
}

exports.default = defaultTask

exports.watch = () => {
  gulp.watch('./public/css/*.scss')
}
