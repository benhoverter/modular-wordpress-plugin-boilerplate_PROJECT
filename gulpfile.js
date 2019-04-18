/*
*  Gulp config file
*  @project plugin_title
*  Author: Your Name
*/

/**
* Gulp build config file.
*
* @link        http://example.com
* @since       1.0.0
*
* @package     plugin-name
* @Author      Your Name
*
*/

const { src, dest, series, parallel, watch } = require('gulp');
const del           = require('del');//
const concat        = require('gulp-concat');//
const sass          = require('gulp-sass');//
const csso          = require('gulp-csso');//
const autoprefixer  = require('gulp-autoprefixer');//
const sourcemaps    = require('gulp-sourcemaps');//
const uglify        = require('gulp-uglify');//
const babel         = require('gulp-babel');//
const zip           = require('gulp-zip'); //

sass.compiler = require( 'node-sass' );

const liveFiles = [
  './plugin-name/**/*',

  // EXAMPLE FOR IN-PLUGIN REACT APP EXCLUSION:
  // '!./plugin-name/public/kyc-validation-app/node_modules/**/*',
  // '!./plugin-name/public/kyc-validation-app/public/**/*',
  // '!./plugin-name/public/kyc-validation-app/src/**/*',
  // '!./plugin-name/public/kyc-validation-app/*.*',

];

const localPath = 'C:/Users/benho/WordPress/dev/wp-content/plugins/plugin-name';

const zipFiles = 'C:/Users/benho/WordPress/bunker/wp-content/plugins/plugin-name/**/*'
const zipDest = 'C:/Users/benho/WordPress/bunker/wp-content/plugins'

const watchFiles = [
  './plugin-name/**/*',
  '!./plugin-name/assets/**/*', // Don't watch the minified files.

  // EXAMPLE FOR IN-PLUGIN REACT APP EXCLUSION:
  // '!./plugin-name/public/plugin-react-app/node_modules/**/*',
];


// ***** Public File Handlers ***** //
function publicCSS() {
  return src( './plugin-name/public/**/*.scss' )     // Get everything Sassy.
  .pipe( sass().on( 'error', sass.logError ) )        // Transpile to CSS.
  .pipe( autoprefixer( {                              // Prefix for browser compatibility.
    browsers: [ 'last 2 versions' ]
  } ) )
  .pipe( sourcemaps.init() )                         // Start sourcemap processing.
  .pipe( concat( 'public.min.css' ) )                 // Combine all files into one.
  .pipe( csso() )                                   // Minify the CSS.
  .pipe( sourcemaps.write() )                        // Output sourcemap.
  .pipe( dest( './plugin-name/assets/public' ) )
}


function publicJS() {
  return src([
    './plugin-name/public/**/*.js',
    // '!./plugin-name/public/plugin-react-app/**/*',
  ])
  .pipe( sourcemaps.init() )
  .pipe( concat( 'public.min.js' ) )
  .pipe( babel( /*{ presets: ['@babel/preset-env'] }*/ ) )
  .pipe( uglify() )
  .pipe( sourcemaps.write() )
  .pipe( dest( './plugin-name/assets/public' ) )
}


// ***** Admin File Handlers ***** //
function adminCSS() {
  return src( './plugin-name/admin/**/*.scss' )     // Get everything Sassy.
  .pipe( sass().on( 'error', sass.logError ) )        // Transpile to CSS.
  .pipe( autoprefixer( {                              // Prefix for browser compatibility.
    browsers: [ 'last 2 versions' ]
  } ) )
  .pipe( sourcemaps.init() )                         // Start sourcemap processing.
  .pipe( concat( 'admin.min.css' ) )                 // Combine all files into one.
  .pipe( csso() )                                   // Minify the CSS.
  .pipe( sourcemaps.write() )                        // Output sourcemap.
  .pipe( dest( './plugin-name/assets/admin' ) )
}

function adminJS() {
  return src([
    './plugin-name/admin/**/*.js',
    // '!./plugin-name/admin/plugin-react-app/**/*',
  ])
  .pipe( sourcemaps.init() )
  .pipe( concat( 'admin.min.js' ) )
  .pipe( babel( /*{ presets: ['@babel/preset-env'] }*/ ) )
  .pipe( uglify() )
  .pipe( sourcemaps.write() )
  .pipe( dest( './plugin-name/assets/admin' ) )
}


// CLean the plugin folder:
function clean() {
  return del([
    localPath,
  ], {force: true} );
};

// Copy files.
function copy() {
  return src( liveFiles )
  .pipe( dest( localPath ) )
}

// Zip plugin:
function zipPlugin() {
  return src( zipFiles )
  .pipe( zip( 'plugin-name.zip' ) )
  .pipe( dest( zipDest ) )
}


// Set the npm scripts:
exports.clean = clean
// exports.css = css
// exports.js = js
exports.copy = copy
exports.zip = zipPlugin


exports.default = series(
  clean,
  parallel(
    publicCSS,
    // adminCSS,
  ),
  parallel(
    publicJS,
    // adminJS,
  ),
  copy,
  zipPlugin,
);

// Set up the watcher series: >>>> FIX: LOOPING!
const doAll = series(
  clean,
  parallel(
    publicCSS,
    // adminCSS
  ),
  parallel(
    publicJS,
    // adminJS,
  ),  copy,
  zipPlugin,
);

// watch( watchFiles, doAll );



////////////////////// OLD STUFF ///////////////////////
// ***** GROUPED TASK ***** //
// gulp.task( 'dev', () => {       // Do it all.
//      runSequence(
//          'css-public',
//          'js-public',
//          'css-admin',
//          'js-admin',
//          'dev-copy'
//       );
// } );
//
// gulp.task( 'test', () => {       // Do it all.
//      runSequence(
//          'css-public',
//          'js-public',
//          'css-admin',
//          'js-admin',
//          'test-copy'
//       );
// } );


// ***** CLEAN AND COPY PLUGIN FILES IN /wp-content/plugins ***** //

// Dev Site:
// gulp.task( 'dev-clean', () => {         // Delete the old .css file.
//   return gulp.src( devPath,
//     { read: false } )
//     .pipe( clean( { force: true } ) );
//   } );    // Working.
//
//   gulp.task( 'dev-copy', [ 'dev-clean' ], () => {
//     return gulp.src( './plugin-name/**' )
//     .pipe( gulp.dest( devPath ) );  // Put the new file here.
//   } );    // Working.
//
//
//   // Test Site:
//   gulp.task( 'test-clean', () => {         // Delete the old .css file.
//     return gulp.src( testPath,
//       { read: false } )
//       .pipe( clean( { force: true } ) );
//     } );    // Working.
//
//     gulp.task( 'test-copy', [ 'test-clean' ], () => {
//       return gulp.src( './plugin-name/**' )
//       .pipe( gulp.dest( testPath ) );  // Put the new file here.
//     } );    // Working.


//
// // ***** PUBLIC CSS ***** //
// gulp.task( 'css-public-clean', () => {                      // Delete the old .css file.
//   return gulp.src( './plugin-name/assets/public/*.css', { read: false } )
//   .pipe( clean() );
// } );
//
// gulp.task( 'css-public', [ 'css-public-clean' ], () => {
//   return gulp.src( './plugin-name/public/**/*.scss' )     // Get everything Sassy.
//   .pipe( sass().on( 'error', sass.logError ) )        // Transpile to CSS.
//   .pipe( autoprefixer( {                              // Prefix for browser compatibility.
//     browsers: [ 'last 2 versions' ]
//   } ) )
//   .pipe( concat( 'public.min.css' ) )                 // Combine all files into one.
//   .pipe( csso() )                                     // Minify the CSS.
//   .pipe( gulp.dest( './plugin-name/assets/public' ) );  // Put the new file here.
// } );
//
//
// // ***** PUBLIC JAVASCRIPT ***** //
// gulp.task( 'js-public-clean', () => {                       // Delete the old .js and .map files.
//   return gulp.src( './plugin-name/assets/public/*.js*', { read: false } )
//   .pipe( clean() );
// } );
//
// gulp.task( 'js-public', [ 'js-public-clean' ], () => {
//   return gulp.src( './plugin-name/public/**/*.js' )       // Get everything scripty.
//   .pipe( sourcemaps.init() )                          // Start sourcemapping.
//   .pipe( concat( 'public.min.js' ) )                  // Combine all files into one.
//   .pipe( babel( {
//     presets: [ '@babel/env' ]                       // Standard Babel preset.
//   } ) )
//   .pipe( uglify() )                                   // Minify the JS.
//   .pipe( sourcemaps.write( '.' ) )                    // Place the sourcemap next to public.min.js.
//   .pipe( gulp.dest( './plugin-name/assets/public' ) );
//
// } );
//
//
//
// // ***** ADMIN CSS ***** //
// gulp.task( 'css-admin-clean', () => {                      // Delete the old .css file.
//   return gulp.src( './plugin-name/assets/admin/*.css', { read: false } )
//   .pipe( clean() );
// } );
//
// gulp.task( 'css-admin', [ 'css-admin-clean' ], () => {
//   return gulp.src( './plugin-name/admin/**/*.scss' )     // Get everything Sassy.
//   .pipe( sass().on( 'error', sass.logError ) )        // Transpile to CSS.
//   .pipe( autoprefixer( {                              // Prefix for browser compatibility.
//     browsers: [ 'last 2 versions' ]
//   } ) )
//   .pipe( concat( 'admin.min.css' ) )                 // Combine all files into one.
//   .pipe( csso() )                                     // Minify the CSS.
//   .pipe( gulp.dest( './plugin-name/assets/admin' ) );  // Put the new file here.
// } );
//
//
// // ***** ADMIN JAVASCRIPT ***** //
// gulp.task( 'js-admin-clean', () => {                       // Delete the old .js and .map files.
//   return gulp.src( './plugin-name/assets/admin/*.js*', { read: false } )
//   .pipe( clean() );
// } );
//
// gulp.task( 'js-admin', [ 'js-admin-clean' ], () => {
//   return gulp.src( './plugin-name/admin/**/*.js' )       // Get everything scripty.
//   .pipe( sourcemaps.init() )                          // Start sourcemapping.
//   .pipe( concat( 'admin.min.js' ) )                  // Combine all files into one.
//   .pipe( babel( {
//     presets: [ '@babel/env' ]                       // Standard Babel preset.
//   } ) )
//   .pipe( uglify() )                                   // Minify the JS.
//   .pipe( sourcemaps.write( '.' ) )                    // Place the sourcemap next to admin.min.js.
//   .pipe( gulp.dest( './plugin-name/assets/admin' ) );
//
// } );
