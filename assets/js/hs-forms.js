( function( $ ) {
	/**
	 * Disable forms after submission.
	 */
	var disable_forms_after_submission = function( forms ) {
		forms.forEach( function(form) {
            var $form = $(form);

            if ( $form.length ) {
                $form.append( '<input type="hidden" id="hs-submit-button-value" />' );

                $form.find( '[type=submit]' ).on( 'click', function( event ) {
                    /* If the form submission isn't valid, proceed no further. */
                    if ( ! $form[0].checkValidity() ) {
                        return;
                    }

                    var name = event.currentTarget.name,
                        value = event.currentTarget.value;

                    $form.find( '#hs-submit-button-value' )
                        .attr( 'name', name )
                        .attr( 'value', value );

                    $form.find( '[type=submit]' )
                        .attr( 'disabled', 'disabled' );

                    return $form.submit();
                } );
            }
        } );
	}

	$( document ).ready( function() {
		disable_forms_after_submission(
			[
				'#hs-registration-form',
				'#hs-profile-form',
				'#hs-campaign-submission-form'
			]
		);
	} );
})( jQuery );