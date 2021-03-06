'use strict';

const gulp = require('gulp');
const shell = require('gulp-shell');
const del = require('del');
const argv = require('yargs').argv;

const config = {
    svn: {
        url: 'https://plugins.svn.wordpress.org/mpress-menu-wormhole/',
        src: [
            './**',
            '!**/svn',
            '!**/svn/**',
            '!**/readme.md',
            '!**/package.json',
            '!**/node_modules',
            '!**/node_modules/**',
            '!**/bower.json',
            '!**/bower_components',
            '!**/bower_components/**',
            '!**/gulpfile.js',
            '!**/gulp',
            '!**/gulp/**',
            '!**/composer.json',
            '!**/composer.lock'
        ],
        dest: './svn/trunk',
        clean: './svn/trunk/**/*'
    }
};

gulp.task('svn:checkout', shell.task('svn co ' + config.svn.url + ' svn'));

gulp.task('svn:clean', function () {
    return del(config.svn.clean);
});

gulp.task('svn:copy', ['svn:clean'], function () {
    return gulp.src(config.svn.src).pipe(gulp.dest(config.svn.dest));
});

gulp.task('default', ['svn:copy']);