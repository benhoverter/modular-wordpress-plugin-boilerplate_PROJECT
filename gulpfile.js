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
  '!./plugin-name',

  // EXAMPLE FOR IN-PLUGIN REACT APP EXCLUSION:
  // '!./plugin-name/public/kyc-validation-app/node_modules/**/*',
  // '!./plugin-name/public/kyc-validation-app/public/**/*',
  // '!./plugin-name/public/kyc-validation-app/src/**/*',
  // '!./plugin-name/public/kyc-validation-app/*.*',

];

// Split the /plugin-name folder contents into another repo for release:
const releasePath =   'C:/Users/benho/Repos/modular-wp-plugin-boilerplate_PLUGIN';
const releasePaths = [
  'C:/Users/benho/Repos/modular-wp-plugin-boilerplate_PLUGIN/**/*',

  // '!C:/Users/benho/Repos/modular-wp-plugin-boilerplate_PLUGIN',

  '!C:/Users/benho/Repos/modular-wp-plugin-boilerplate_PLUGIN/test',

  '!C:/Users/benho/Repos/modular-wp-plugin-boilerplate_PLUGIN/.git',
  '!C:/Users/benho/Repos/modular-wp-plugin-boilerplate_PLUGIN/.gitattributes',
  '!C:/Users/benho/Repos/modular-wp-plugin-boilerplate_PLUGIN/.gitignore',
  '!C:/Users/benho/Repos/modular-wp-plugin-boilerplate_PLUGIN/README.md',
]

// Development server files:
const localPath = 'C:/Users/benho/WordPress/dev/wp-content/plugins/plugin-name';

const zipFiles = 'C:/Users/benho/WordPress/dev/wp-content/plugins/plugin-name/**/*'
const zipDest  = 'C:/Users/benho/WordPress/dev/wp-content/plugins'

// Set the files to watch: >>>> FIX: LOOPING!
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
// function clean() {
//   return del([
//     localPath,
//     ...releasePaths,
//   ], {force: true} );
// };

function clean() {
  return del(releasePaths, {force: true} );
};


// Copy files.
function copy() {
  return src( liveFiles )
  .pipe( dest( localPath ) )
  .pipe( dest( releasePath ) )
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
