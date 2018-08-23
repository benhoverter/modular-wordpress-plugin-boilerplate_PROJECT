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
         'css-public',
         'js-public',
         'css-admin',
         'js-admin'
      );
} );



// ***** PUBLIC CSS ***** //
gulp.task( 'css-public-clean', () => {                      // Delete the old .css file.
    return gulp.src( './plugin-name/dist/public/*.css', { read: false } )
        .pipe( clean() );
} );    // Working.

gulp.task( 'css-public', [ 'css-public-clean' ], () => {
    return gulp.src( './plugin-name/public/**/*.scss' )     // Get everything Sassy.
        .pipe( sass().on( 'error', sass.logError ) )        // Transpile to CSS.
        .pipe( autoprefixer( {                              // Prefix for browser compatibility.
            browsers: [ 'last 2 versions' ]
        } ) )
        .pipe( concat( 'public.min.css' ) )                 // Combine all files into one.
        .pipe( csso() )                                     // Minify the CSS.
        .pipe( gulp.dest( './plugin-name/dist/public' ) );  // Put the new file here.
} );    // Working.


// ***** PUBLIC JAVASCRIPT ***** //
gulp.task( 'js-public-clean', () => {                       // Delete the old .js and .map files.
    return gulp.src( './plugin-name/dist/public/*.js*', { read: false } )
        .pipe( clean() );
} );    // Working.

gulp.task( 'js-public', [ 'js-public-clean' ], () => {
    return gulp.src( './plugin-name/public/**/*.js' )       // Get everything scripty.
        .pipe( sourcemaps.init() )                          // Start sourcemapping.
        .pipe( concat( 'public.min.js' ) )                  // Combine all files into one.
        .pipe( babel( {
            presets: [ 'env' ]                              // Standard Babel preset.
        } ) )
        .pipe( uglify() )                                   // Minify the JS.
        .pipe( sourcemaps.write( '.' ) )                    // Place the sourcemap next to public.min.js.
        .pipe( gulp.dest( './plugin-name/dist/public' ) );

} );    //  Working.



// ***** ADMIN CSS ***** //
gulp.task( 'css-admin-clean', () => {                      // Delete the old .css file.
    return gulp.src( './plugin-name/dist/admin/*.css', { read: false } )
        .pipe( clean() );
} );    // Working.

gulp.task( 'css-admin', [ 'css-admin-clean' ], () => {
    return gulp.src( './plugin-name/admin/**/*.scss' )     // Get everything Sassy.
        .pipe( sass().on( 'error', sass.logError ) )        // Transpile to CSS.
        .pipe( autoprefixer( {                              // Prefix for browser compatibility.
            browsers: [ 'last 2 versions' ]
        } ) )
        .pipe( concat( 'admin.min.css' ) )                 // Combine all files into one.
        .pipe( csso() )                                     // Minify the CSS.
        .pipe( gulp.dest( './plugin-name/dist/admin' ) );  // Put the new file here.
} );    // Working.


// ***** ADMIN JAVASCRIPT ***** //
gulp.task( 'js-admin-clean', () => {                       // Delete the old .js and .map files.
    return gulp.src( './plugin-name/dist/admin/*.js*', { read: false } )
        .pipe( clean() );
} );    // Working.

gulp.task( 'js-admin', [ 'js-admin-clean' ], () => {
    return gulp.src( './plugin-name/admin/**/*.js' )       // Get everything scripty.
        .pipe( sourcemaps.init() )                          // Start sourcemapping.
        .pipe( concat( 'admin.min.js' ) )                  // Combine all files into one.
        .pipe( babel( {
            presets: [ 'env' ]                              // Standard Babel preset.
        } ) )
        .pipe( uglify() )                                   // Minify the JS.
        .pipe( sourcemaps.write( '.' ) )                    // Place the sourcemap next to admin.min.js.
        .pipe( gulp.dest( './plugin-name/dist/admin' ) );

} );    //  Working.
