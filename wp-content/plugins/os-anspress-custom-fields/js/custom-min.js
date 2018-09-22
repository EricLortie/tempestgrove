/*
 * Plugin Name: OS AnsPress Custom Fields
 * Plugin URI: http://offshorent.com/blog/extensions/os-anspress-custom-fields
 * Description: OS AnsPress Custom Fields
 * Version: 1.0
 * Author: Jinesh P.V, Team Leader Offshorent Solutions Pvt Ltd
 * Author URI: http://offshorent.com/
 * Requires at least: 3.8
 * Tested up to: 4.4
*/
(function($) {
	$ (document ).on( 'click', '.osap-field-wrap a', function(e) {
        var field = $( this ).attr( 'rel' ),
        	id = $( '.osap-' + field + '-box' ).length,
            html = $( '.osap-' + field + '-wrap' ).html();
        html = html.replace( /{id}/g, id );
        $( '#osap-custom-wrapper' ).append( html );
       e.preventDefault()
    });
    $( '#osap-custom-wrapper' ).sortable({
        handle: '.osap-header',
        placeholder: "os-slider-slide-placeholder",
        forcePlaceholderSize: true,
        delay: 100,
        update: function( event, ui ) {
            $( '#osap-custom-wrapper .osap-box' ).each(function( boxIndex, box ) {
                $( box ).find('input, select, textarea' ).each(function( i, field ) {
                    var name = $( field ).attr( 'name' );
                    if ( name ) {
                        name = name.replace(/\[[0-9]+\]/, '[' + boxIndex + ']');
                        $( field ).attr( 'name', name );
                    }
                })
            })
        }
    });
    $( document ).on( 'click', '.osap-box .delete', function(e) {
        $( this ).closest( '.osap-box' ).remove();
    });
    $( document ).on( 'click', '.toggle', function(e) {
        $( this ).parent().parent().next().slideToggle( 500 );
        if ( $( this ).hasClass( "up" ) ) {
            $( this ).removeClass( "up" ).addClass( "down" );
            $( this ).parent().parent().css( 'border-bottom', 'none' );
        } else {
            $( this ).removeClass( "down" ).addClass( "up" );
            $( this ).parent().parent().css( 'border-bottom', '1px solid #ccc' );
        }
    });
    /*$( '#osap-custom-wrapper' ).masonry({
        itemSelector: '.osap-box'
    });*/
})(jQuery);