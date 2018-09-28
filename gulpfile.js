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

const devPath =       'E:/wp-dev/project_dev/wp-content/plugins/plugin-name';
const testPath =      'E:/wp-dev/project_test/wp-content/plugins/plugin-name';


// ***** GROUPED TASK ***** //
gulp.task( 'dev', () => {       // Do it all.
     runSequence(
         'css-public',
         'js-public',
         'css-admin',
         'js-admin',
         'dev-copy'
      );
} );

gulp.task( 'test', () => {       // Do it all.
     runSequence(
         'css-public',
         'js-public',
         'css-admin',
         'js-admin',
         'test-copy'
      );
} );


// ***** CLEAN AND COPY PLUGIN FILES IN /wp-content/plugins ***** //

// Dev Site:
gulp.task( 'dev-clean', () => {         // Delete the old .css file.
    return gulp.src( devPath,
        { read: false } )
        .pipe( clean( { force: true } ) );
} );    // Working.

gulp.task( 'dev-copy', [ 'dev-clean' ], () => {
    return gulp.src( './plugin-name/**' )
        .pipe( gulp.dest( devPath ) );  // Put the new file here.
} );    // Working.


// Test Site:
gulp.task( 'test-clean', () => {         // Delete the old .css file.
    return gulp.src( testPath,
        { read: false } )
        .pipe( clean( { force: true } ) );
} );    // Working.

gulp.task( 'test-copy', [ 'test-clean' ], () => {
    return gulp.src( './plugin-name/**' )
        .pipe( gulp.dest( testPath ) );  // Put the new file here.
} );    // Working.



// ***** PUBLIC CSS ***** //
gulp.task( 'css-public-clean', () => {                      // Delete the old .css file.
    return gulp.src( './plugin-name/assets/public/*.css', { read: false } )
        .pipe( clean() );
} );

gulp.task( 'css-public', [ 'css-public-clean' ], () => {
    return gulp.src( './plugin-name/public/**/*.scss' )     // Get everything Sassy.
        .pipe( sass().on( 'error', sass.logError ) )        // Transpile to CSS.
        .pipe( autoprefixer( {                              // Prefix for browser compatibility.
            browsers: [ 'last 2 versions' ]
        } ) )
        .pipe( concat( 'public.min.css' ) )                 // Combine all files into one.
        .pipe( csso() )                                     // Minify the CSS.
        .pipe( gulp.dest( './plugin-name/assets/public' ) );  // Put the new file here.
} );


// ***** PUBLIC JAVASCRIPT ***** //
gulp.task( 'js-public-clean', () => {                       // Delete the old .js and .map files.
    return gulp.src( './plugin-name/assets/public/*.js*', { read: false } )
        .pipe( clean() );
} );

gulp.task( 'js-public', [ 'js-public-clean' ], () => {
    return gulp.src( './plugin-name/public/**/*.js' )       // Get everything scripty.
        .pipe( sourcemaps.init() )                          // Start sourcemapping.
        .pipe( concat( 'public.min.js' ) )                  // Combine all files into one.
        .pipe( babel( {
            presets: [ '@babel/env' ]                       // Standard Babel preset.
         } ) )
        .pipe( uglify() )                                   // Minify the JS.
        .pipe( sourcemaps.write( '.' ) )                    // Place the sourcemap next to public.min.js.
        .pipe( gulp.dest( './plugin-name/assets/public' ) );

} );



// ***** ADMIN CSS ***** //
gulp.task( 'css-admin-clean', () => {                      // Delete the old .css file.
    return gulp.src( './plugin-name/assets/admin/*.css', { read: false } )
        .pipe( clean() );
} );

gulp.task( 'css-admin', [ 'css-admin-clean' ], () => {
    return gulp.src( './plugin-name/admin/**/*.scss' )     // Get everything Sassy.
        .pipe( sass().on( 'error', sass.logError ) )        // Transpile to CSS.
        .pipe( autoprefixer( {                              // Prefix for browser compatibility.
            browsers: [ 'last 2 versions' ]
        } ) )
        .pipe( concat( 'admin.min.css' ) )                 // Combine all files into one.
        .pipe( csso() )                                     // Minify the CSS.
        .pipe( gulp.dest( './plugin-name/assets/admin' ) );  // Put the new file here.
} );


// ***** ADMIN JAVASCRIPT ***** //
gulp.task( 'js-admin-clean', () => {                       // Delete the old .js and .map files.
    return gulp.src( './plugin-name/assets/admin/*.js*', { read: false } )
        .pipe( clean() );
} );

gulp.task( 'js-admin', [ 'js-admin-clean' ], () => {
    return gulp.src( './plugin-name/admin/**/*.js' )       // Get everything scripty.
        .pipe( sourcemaps.init() )                          // Start sourcemapping.
        .pipe( concat( 'admin.min.js' ) )                  // Combine all files into one.
        .pipe( babel( {
            presets: [ '@babel/env' ]                       // Standard Babel preset.
        } ) )
        .pipe( uglify() )                                   // Minify the JS.
        .pipe( sourcemaps.write( '.' ) )                    // Place the sourcemap next to admin.min.js.
        .pipe( gulp.dest( './plugin-name/assets/admin' ) );

} );
