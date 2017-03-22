var gulp = require('gulp'),
    print = require('gulp-print')
    babel = require('gulp-babel')
    webserver = require('gulp-webserver')
    browserSync = require('browser-sync')
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    minifycss = require('gulp-minify-css'),
    webpack = require('gulp-webpack');;

gulp.task('puny-human', function() {
    console.log('Puny humaaaan');
});

gulp.task('js', function() {
    return gulp.src('Public/assets/js/source/*.js')
        .pipe(print())
        .pipe(babel({
            presets: ['es2015'],
            plugins: ["transform-es2015-modules-amd"]
        }))
        .pipe(uglify({
              mangle: true,
              compress: true,
        }))
        .pipe(gulp.dest('Public/build/'));
});

// 将CSS文件进行合并
gulp.task('css', function() {
    return gulp.src('Public/assets/css/*.css')
        .pipe(concat('min.css'))
        .pipe(minifycss())
        .pipe(gulp.dest('Public/build'));
});

gulp.task('libs', function(){
    return gulp.src([
        'Public/assets/js/lib/jquery.min.js',
        'Public/assets/js/lib/layer/layer.js',
        'Public/assets/js/lib/socket.io.js',
        'Public/assets/js/lib/bootstrap.min.js'
        ])
        .pipe(print())
        .pipe(concat('lib.js'))
        .pipe(gulp.dest('Public/build'));
});

gulp.task('build', ['js', 'libs'], function(){
    // return gulp.src(['app/index.html'])
    //         .pipe(print())
    //         .pipe(gulp.dest('build'));
    // return gulp.src(['app/**/*.html', 'app/**/*.css'])
    //         .pipe(print())
    //         .pipe(gulp.dest('build'));
});

// 开启内部服务8000端口
gulp.task('serve', ['build'], function() {
    gulp.src('build')
        .pipe(webserver({open: true}));
});

// 保存即更新 自动化构建
gulp.task('watch', function(){
    gulp.watch('Public/assets/js/source/*.js', ['build']);
});

gulp.task('default', ['build']);
