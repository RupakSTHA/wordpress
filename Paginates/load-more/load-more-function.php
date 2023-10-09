
<?php
//add a custom js file and load javascript variables
add_action( 'wp_enqueue_scripts', 'your_script_funct' );
function your_script_funct(){
    wp_register_script( "load_more_script", get_template_directory_uri().'/assets/js/load-more.js', array('jquery') );
    wp_localize_script( 'load_more_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        

    wp_enqueue_script( 'load_more_script' );
}

//action filters for load more ajax
function load_more_action(){
	if ( !wp_verify_nonce( $_REQUEST['load_more_nonce_field'], "load_more_my_action")) {
		echo json_encode( array("status"=>false, 'data'=>"Cannot be accessed directlt!") ); exit;
	}
	
	$perPage = ( isset($_REQUEST['load_more_per_page']) && !empty($_REQUEST['load_more_per_page']) ) ? $_REQUEST['load_more_per_page'] : 6;
	$currentPage = ( isset($_REQUEST['currentPage']) && !empty($_REQUEST['currentPage']) ) ? $_REQUEST['currentPage'] : 1;

	$args = array(
		'posts_per_page' => $perPage,
		'post_type' => 'post',
		'paged' => $currentPage,
	);
	
	$query = new WP_Query( $args );
	$total_posts = $query->post_count;

	ob_start();
	while ( $query->have_posts() ) {
		$query->the_post();
		?>
		<header class="entry-header alignwide">
			<?php echo get_the_title(); ?>
		</header><!-- .entry-header -->
		<?php
	}
	$output_string = ob_get_contents();
	ob_end_clean();
	wp_reset_postdata();

	if( $total_posts < 1 ){ echo json_encode( array("status"=>false, 'data'=>"No posts found.") ); exit; }

	echo  json_encode( array("status"=>true, 'data'=>$output_string) );
	exit;
	
}
add_action("wp_ajax_load_more_action", "load_more_action");
add_action("wp_ajax_nopriv_load_more_action", "load_more_action");