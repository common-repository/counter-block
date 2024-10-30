( function ( $ ) {
	// Counter
	window[ 'ibCounter' ] = function () {
		var $counters = $( '.ib-counter' );
		$counters.each( function () {
			if (
				$( 'body' ).hasClass( 'wp-admin' ) &&
				$( this ).parents( '.wp-block-ideabox-counter.is-selected' )
					.length === 0
			) {
				return;
			}
			if (
				$( window ).scrollTop() >
				$( this ).offset().top - window.innerHeight
			) {
				var $element = $( this ).find( '.ib-counter-number' ),
					data = {
						fromValue: $element.attr( 'data-from-value' ),
						toValue: $element.attr( 'data-to-value' ),
						delimiter: $element.attr( 'data-delimiter' ),
						duration: $element.attr( 'data-duration' ),
						onComplete: function () {
							$element.addClass( 'ib-counter-complete' );
						},
					},
					decimalDigits = data.toValue.toString().match( /\.(.*)/ );

				if ( decimalDigits ) {
					data.rounding = decimalDigits[ 1 ].length;
				}
				if ( 'none' === data.delimiter ) {
					data.delimiter = '';
				}

				if ( $( 'body' ).hasClass( 'wp-admin' ) ) {
					data.onComplete = function () {};
					$element.empty();
				}

				if ( ! $element.hasClass( 'ib-counter-complete' ) ) {
					$element.numerator( data );
				}
			}
		} );
	};

	if ( $( '.ib-counter' ).length > 0 ) {
		ibCounter();
		$( window ).on( 'scroll', function () {
			ibCounter();
		} );
	}
} )( jQuery );
