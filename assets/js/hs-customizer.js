( function( $ ) {

    var update_highlight_colour = function( colour ) {
        var $styles = $( '#hs-highlight-colour-styles' );
        $styles.html("")
            .append( ".campaign-raised .amount, .campaign-figures .amount, .donors-count, .time-left, .hs-form-field a:not(.button), .hs-form-fields .hs-fieldset a:not(.button), .hs-notice,.hs-notice .errors a{ color: " + colour + ";}" )
            .append( ".campaign-progress-bar .bar, .donate-button, #hs-donation-form .donation-amount.selected, #hs-donation-amount-form .donation-amount.selected { background-color: " + colour + ";}" )
            .append( "#hs-donation-form .donation-amount.selected, #hs-donation-amount-form .donation-amount.selected, .hs-notice { border-color: " + colour + ";}" );
    };    

    wp.customize( 'hs_settings[highlight_colour]', function( value ) {
        value.bind( function( newval ) {
            update_highlight_colour( newval );
        });
    });

})( jQuery );