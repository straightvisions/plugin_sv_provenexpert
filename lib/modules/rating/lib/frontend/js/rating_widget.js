jQuery( document ).ready( function() {
    function slide_comment() {
        let ratings = '.sv_provenexpert_modules_rating_rating_widget .sv_provenexpert_modules_rating_latest_comments > div';
        let first   = jQuery( ratings ).first();
        let last    = jQuery( ratings ).last();

        last.after( first );

        first.toggleClass( 'active' );
        jQuery(ratings).first().toggleClass( 'active' );
    }

    window.setInterval( function() {
        slide_comment();
    }, 4500 );
} );