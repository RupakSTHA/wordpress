
<?php
/**
Template Name: Load More Template
*/
get_header();

/* Paged Refresh Url Pagination Example */ 
$perPage = 6;
$currentPage = 1;

$args = array(
	'posts_per_page' => $perPage,
	'post_type' => 'post',
	'paged' => $currentPage,
);

$query = new WP_Query( $args );
$total_posts = $query->found_posts;
$totalPages = ceil($total_posts / $perPage);
?>
<div class="error"></div>
<div class="post-lists">
    <?php
    while ( $query->have_posts() ) {
        $query->the_post();
        ?>
        <header class="entry-header alignwide">
            <?php echo get_the_title(); ?>
        </header><!-- .entry-header -->
        <?php
        }
    wp_reset_postdata();
    ?>
</div>
<?php
if ($total_posts > $perPage) { ?>
<div class="load-more">
    <button>Load More</button>
</div>

<!-- set variables inside form -->
<form action="" id="load-more-form" method="POST">
    <input type="hidden" name="load_more_per_page" value="<?php echo $perPage; ?>" /> 
    <input type="hidden" name="currentPage" value="<?php echo ++$currentPage; ?>" /> 
    <?php wp_nonce_field( 'load_more_my_action', 'load_more_nonce_field' ); ?>
</form>
<?php } 
get_footer();