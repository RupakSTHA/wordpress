jQuery(document).ready( function($) {

    $(".load-more").click( function(e) {
       e.preventDefault(); 
        $("#load-more-form").submit(); 
    });

    $("#load-more-form").on( 'submit', function(e){
        e.preventDefault();

        let formData = new FormData( this );
        let currentPage = formData.get('currentPage');
        //increment first and then save value
        $('input[name="currentPage"]').val(++currentPage);

        //SET AJAX ACTION FROM POST FIELD METHOD
        formData.append("action", "rupak_load_more_action")

        $.ajax({
            //OR YOU CAN SET AJAX ACTION REQUEST FROM GET METHOD
            // url : myAjax.ajaxurl+"?action=rupak_load_more_action",
            url : myAjax.ajaxurl,
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
                    if($html.loadButton===true) {
                        $(".load-more button").html('Load More');
                    }else{
                        $(".load-more").html('');
                    }
                    
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
