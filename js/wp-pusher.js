// Javascript document
var $j = jQuery.noConflict();

$j( document ).ready( function() {
    if( wp_pusher.active != false && wp_pusher.key !== '' ) {
        var notify_new_post = function( post_title, url ) {
            var notify_message = $j( '<p>New post added!<br/><a href="' + url + '">' + post_title + '</a></p>' ),
                notify_close = $j( '<a class="close-wp-pusher-notify" href="#"><img src="' + wp_pusher.plugin_url + '/img/close.png" width="12" height="12" alt="Close"/></a>' ),
                notify_box = $j( '<div class="wp-pusher-notify"></div>' );

            notify_box.append( notify_message );
            notify_box.append( notify_close );

            $j( 'body' ).prepend( notify_box );
            $j( '.wp-pusher-notify' ).fadeIn( 'fast', function() {
                setTimeout( function() {
                    $j( '.wp-pusher-notify' ).fadeOut( 'fast', function() {
                        $j( '.wp-pusher-notify' ).remove();
                    } );
                }, 10000 );
            } );
        };

        $j( 'body' ).on( 'click', '.close-wp-pusher-notify', function( e ) {
            $j( '.wp-pusher-notify' ).fadeOut( function() {
                $j( '.wp-pusher-notify' ).remove();
            } );
            e.preventDefault();
        } );

        if( wp_pusher.debug_js != false ) {
            // Enable pusher logging - don't include this in production
            Pusher.log = function( message ) {
                if( window.console && window.console.log )
                    window.console.log( message );
            };
        }

        var pusher = new Pusher( wp_pusher.key, { authEndpoint: wp_pusher.auth_endpoint } ),
            channel = pusher.subscribe( 'private-wp_pusher' );

        channel.bind( 'client-publish_post', function( data ) {
            notify_new_post( data.post_title, data.permalink );
        } );

    }

} );