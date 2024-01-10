jQuery(document).ready( function($) {

  const openUrl = (link, pushTrigger=true) => {

    $.get( link, function( data ) {
      let portfolio = $( data ).find( '.portfolio' );
      $( '.portfolio-wrapper' ).html( portfolio );

      if(pushTrigger){
        //first args send link to pop state and third args change the browser url
        window.history.pushState({href: link}, '', link);
      }

    });

  }
  
  //link click and trigger history push
  $( document ).on( 'click', '.pagination a', function( e ) {
    e.preventDefault();

    let link = $( this ).attr( 'href' );
    openUrl(link)
  });

  //for back and front browser arrow event
  window.addEventListener('popstate', function(e){
    if( e.state !== null){
      let link = e.state.href;
      openUrl(link, false)
    }
  })

  //for default
  history.replaceState({href: "./"}, 'default', './')

});

