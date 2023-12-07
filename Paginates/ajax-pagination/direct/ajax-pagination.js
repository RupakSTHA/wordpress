jQuery(document).ready( function($) {
    
  $( document ).on( 'click', '.pagination a', function( e ) {
    e.preventDefault();

    var link = $( this ).attr( 'href' );

    $.get( link, function( data ) {
      var portfolio = $( data ).find( '.portfolio' );
      
      $( '.portfolio-wrapper' ).html( portfolio );
      window.history.pushState({href: href}, '', link);
    });

  });

});
