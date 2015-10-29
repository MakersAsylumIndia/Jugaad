( function( $ ) {

	$( window ).load( function() {

		/* Use Featured Image as a Background Image */
		var featuredContent = $( '#featured-content' );
		if ( ! featuredContent.length ) {
			return;
		}

		featuredContent.find( '.hentry' ).each( function() {
			if ( ! $( this ).hasClass( 'background-done' ) && $( this ).hasClass( 'has-post-thumbnail' ) && ( $( this ).hasClass( 'format-image' ) || $( this ).hasClass( 'format-gallery' ) || $( this ).hasClass( 'format-standard' ) ) ) {
				var entryImage = $( this ).find( '.post-thumbnail' ),
				    thumbnail = $( this ).find( 'img' );
				entryImage.css( 'background-image', 'url(' + thumbnail.attr( 'src' ) + ')' );
				$( this ).addClass( 'background-done' );
			}
		} );

	} );

} )( jQuery );
