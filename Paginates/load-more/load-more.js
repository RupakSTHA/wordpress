jQuery(document).ready( function($) {

$(".load-more").click( function(e) {
   e.preventDefault(); 
    $("#load-more-form").submit(); 
});

$("#load-more-form").on( 'submit', function(e){
    e.preventDefault();

    let formData = new FormData( this );
    let currentPage = formData.get('currentPage');
    //increase the currentpaged value
    $('input[name="currentPage"]').val(++currentPage);

    $.ajax({
        url : myAjax.ajaxurl+"?action=load_more_action",
        xhrFields: {
            withCredentials: true
        },
        type : "post",
        data : formData,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $(".load-more button").html('Loading...');
            $('.error').html('');
        },
        success: function(response) {
            $html = JSON.parse(response);
            if($html.status===true) {
                $(".post-lists").append($html.data);
                $(".load-more button").html('Load More');
            }else{
                $(".load-more").html('');
                $('.error').html($html.data);
            }
        },
        complete: function() {
            // $('.loader').hide();
        }
    })  
});

});