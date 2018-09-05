/**
 * JS for: admin/module-ajax/views/view-name.php.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    plugin-name
 * @subpackage plugin-name/admin/module-ajax/js
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
                url: ajaxurl, // Should be available as a global on the admin side.
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



        // *********************  Other sample AJAX functions for save and input check functionality. ************************* //

        //console.log( "AJAX scripts reached." );

        var $inputs = $( '#event-materials-table input' );
        setSessionMats( $inputs );
        bindKeyupHandler( $inputs );

        // Save all input vals to sessionStorage.
        function setSessionMats( $inputs ) {

            var sessionMats = $inputs.serialize(); // Crude. Proof of concept. Do by input ID.

            sessionStorage.setItem( 'sessionMats', sessionMats );
            //console.log( "sessionMats set to: " + sessionStorage.getItem( 'sessionMats' ) + "(setSessionMats)");

        }

        //Handler for the input keyup event.  Fades the Save button in.
        function bindKeyupHandler( $inputs ) {

            //var $inputs = $( '#event-materials-table input' );

            // Ensure a clean slate:
            $inputs.off( 'keyup', '.event_materials' );
            //console.log("Keyup unbound from " + $inputs + "(bindKeyupHandler)" );
            // $inputs.removeClass( 'listening' );

            // Bind the handler:
            $inputs.keyup( function( keycode ) {

                if ( keycode !== 9 ) {

                    compareMatsToSession( $inputs );

                    // Check for the 'ready' class that bindSaveAjax adds to prevent re-binding:
                    /* OLD, NO COMPARISON TO SAVED MATERIALS:
                    if( !$( '#event-materials-save a.button' ).hasClass( 'ready' ) ) {
                        bindSaveAjax();
                    }
                    */

                }

            } );
            //console.log("Keyup bound to " + $inputs + "(bindKeyupHandler)");

            $inputs.addClass( 'listening' );

        }

        function compareMatsToSession( $inputs ) {

            var currentMats = $inputs.parents( 'table' ).first().find( 'input' );
            currentMats = currentMats.serialize();

            var sessionMats = sessionStorage.getItem( 'sessionMats' );

            var $button = $( $inputs ).parents( '.inside' ).first().find( '#event-materials-save a.button' );

            //console.log( "compareMatsToSession ran on " + $inputs );

            if ( currentMats === sessionMats ) {
                unbindSaveAjax( $button );
                //console.log("currentMats = sessionMats. Button unbound. (compareMatsToSession)");

            } else {
                bindSaveAjax( $button );
                //console.log("currentMats != sessionMats. Button bound. (compareMatsToSession)");
                //console.log( "currentMats = " + currentMats );
                //console.log( "sessionMats = " + sessionMats );

            }
        }

        // Handler-binder for Save button:
        function bindSaveAjax( $button ) {

            // Add 'ready' class to track whether the event has been bound.
            $button.addClass( 'ready' ).attr( 'href', '#' );

            // Ensure a clean slate:
            $button.off( 'click' );
            //console.log("Button unbound. (bindSaveAjax)");

            // Bind the handler:
            $button.click( function( event ) {

                event.preventDefault();

                var $table = $( this ).parents( '.inside' ).first().find( 'table' );

                // Run the Ajax call:
                updateEventMats( $table );

            });

            //console.log("Button bound (bindSaveAjax).");
        }

        function unbindSaveAjax( $button ) {
            // Unbind the Save button and remove the 'ready' class:
            $button.removeClass( 'ready' ).removeAttr('href').off( 'click' );
            //console.log( "Button unbound (unbindSaveAjax)" );
        }

        // Define the ajax function:
        function updateEventMats( $table ) {

            //console.log("AJAX call triggered! (updateEventMats)");

            var materials = $( $table ).find( 'input' ).serialize();
            //console.log( materials );

            $.ajax({
                method: 'POST',
                url: ajaxurl, //  WORKS.
                cache: false,
                data:
                {
                        action: 'ce_admin', // The wp_ajax_{action} to hook the callback function.
                        ajax_nonce: ce_admin_ajax_data.ajax_nonce, // WORKS.
                        event_materials: materials  // POST the Obj. WORKS!
                },

                beforeSend: function() {
                    //console.log();
                    $( '#event-materials-save-result span' ).fadeOut( 'fast' );

                },

                success: function( result, status, jqXHR ) {

                    // Display the message from the server:
                    $('#event-materials-save-result span').html( result ).fadeIn( 'fast' );

                    // Unbind the Save button and remove the 'ready' class:
                    $( '#event-materials #event-materials-save a.button' ).removeClass( 'ready' ).removeAttr('href').off( 'click' );

                    // Crude. Proof of concept for saved state vs. current state.
                    // TODO: Compare by input ID.
                    setSessionMats( $table );

                    // Trigger the post-load event for WP API:
                    $( document.body ).trigger( 'post-load' );

                },

                error: function(jqXHR, status, error) {

                    $( '#event-materials-save-result span' ).html( "Sorry, unable to save." ).fadeIn( 'fast' );

                    //console.log( "jqXHR was: " + jqXHR );
                    //console.log( "Status returned was: " + status ); // error
                    //console.log( "Error thrown was: " + error );     // bad request
                }

            }); // END OF: $.ajax().

        }


    }); // END OF: $( document ).ready( function() {

})(jQuery);
