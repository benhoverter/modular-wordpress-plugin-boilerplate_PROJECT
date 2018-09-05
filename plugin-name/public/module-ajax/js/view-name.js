/**
 * JS for: public/module-ajax/views/view-name.php.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    plugin-name
 * @subpackage plugin-name/public/module-ajax/js
 */
( function($) {

    'use strict';

    $( document ).ready( function() {

        console.log( "Module-Ajax's view-name.js loaded." );

        // Do the thing.

        // Bind the event handler to the delete button:
        bindHandler();

        // Rebind all handlers on Ajax finish:
        $( document.body ).on( 'post-load', function() {
            bindHandler();
        } );


        // Handler-binder for a button:
        function bindHandler() {
            $( '#button-id' ).click( function( event ) {

                event.preventDefault();

                var $this = $( this );

                // Select the html you need on event here.

                var confirmed = confirm( "Are you sure you want to do that?" );

                if ( confirmed === true ) {

                    //console.log( "Click confirmed." );

                    // Select html to pass to the AJAX callback here.
                    var ajaxInput = $( "" );

                    // This is the Ajax call:
                    ajaxFunction( ajaxInput );

                    //console.log( "ajaxInput is " + ajaxInput + "." );

                }
            });
        } // END OF: bindHandler().


        // Define an ajax function:
        function ajaxFunction( ajaxInput ) {

            $.ajax({
                method: 'POST',
                url: plugin_abbrev_public_ajax_data.ajax_url, // Grab the url from the PHP ajax data object.
                data:
                {
                        action: 'action_name',  // Same as in wp_ajax_{action_name}().
                        ajax_nonce: data_package_name.module_ajax_data_nonce,
                        data_1: "Your data here.",
                        data_2: "Your data here, too."
                },

                beforeSend: function() {

                    // Get the current height of #current-user-registration-info.
                    var regHeight = $( '#outer-frame-id' ).height();

                    // Set the CSS height to that value to preserve element position.
                    $( '#outer-frame-id' ).height( regHeight );

                    // Pretty fade out.
                    $( '#frame-id' ).fadeOut( 'fast' );

                },

                success: function( html, status, jqXHR ) {

                    //console.log( "AJAX returned HTML of: " + html );
                    //console.log( "AJAX returned a status of: " + status + "." );
                    //console.log( "AJAX returned a jqXHR object of: " + jqXHR + "." );

                    $( '#frame-id' ).html( html ); // Use the AJAX return value as the HTML content
                    $( '#frame-id' ).fadeIn( 'fast' ); // Pretty fade in.

                    // Set CSS height of #current-user-registration-info back to auto.
                    $( '#outer-frame-id' ).css( 'height', 'auto' );

                    // Standard for WP API, and just handy:
                    $( document.body ).trigger( 'post-load' );

                }
            }); // END OF: $.ajax().

        } // END OF: ajaxFunction().

    }); // END OF: $( document ).ready( function() {

})(jQuery);
