/*
 *  Gulp config file
 *  Project: plugin_name
 *  Author: Ben Hoverter
 */

const gulp =          require( 'gulp' );
const runSequence =   require( 'run-sequence' );
const clean =         require( 'gulp-clean' );
const sass =          require( 'gulp-sass' );
const autoprefixer =  require( 'gulp-autoprefixer' );
const csso =          require( 'gulp-csso' );
const concat =        require( 'gulp-concat' );
const babel =         require( 'gulp-babel' );
const uglify =        require( 'gulp-uglify' );
const sourcemaps =    require( 'gulp-sourcemaps' );


// ***** DEFAULT TASK ***** //
gulp.task( 'default', () => {       // Do it all.
     runSequence(
         'css',
         'js',
      );
} );



// ***** ALL CSS ***** //
gulp.task( 'css-clean', () => {
    return gulp.src( './plugin-name/dist/plugin-name.min.css', { read: false } )
        .pipe( clean() );                               // Delete the old file.
} );    // Working.

gulp.task( 'css', [ 'css-clean' ], () => {
    return gulp.src( './plugin-name/**/*.scss' )        // Get everything Sassy.
        .pipe( sass().on( 'error', sass.logError ) )    // Transpile to CSS.
        .pipe( autoprefixer( {                          // Prefix for browser compatibility.
            browsers: [ 'last 2 versions' ]             // TODO: unify with Babel.
        } ) )
        .pipe( concat( 'plugin-name.min.css' ) )        // Combine all files into one.
        .pipe( csso() )                                 // Minify the CSS.
        .pipe( gulp.dest( './plugin-name/dist' ) );     // Put the new file here.
} );    // Working.


// ***** ALL JAVASCRIPT ***** //
gulp.task( 'js-clean', () => {
    return gulp.src( './plugin-name/dist/plugin-name.min.js', { read: false } )
        .pipe( clean() );                               // Delete the old file.
} );    // Working.

gulp.task( 'js', [ 'js-clean' ], () => {
    return gulp.src( './plugin-name/**/*.js' )          // Get everything scripty.
        .pipe( sourcemaps.init() )                      // Start sourcemapping.
        .pipe( concat( 'plugin-name.min.js' ) )         // Combine all files into one.
        .pipe( babel( {
            presets: [ 'env' ]                          // Standard Babel preset.
        } ) )
        .pipe( uglify() )                               // Minify the JS.
        .pipe( sourcemaps.write( '.' ) )                // Place the sourcemap next to public.min.js.
        .pipe( gulp.dest( './plugin-name/dist' ) );

} );    // Working.
