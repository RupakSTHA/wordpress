<?php
/* Paged Refresh Url Pagination Example */ 
$perPage = 6;
$currentPage = 1;
$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
$args = array(
	'posts_per_page' => $perPage,
	'post_type' => 'post',
	'paged' => $paged,
);

$query = new WP_Query( $args );
$total_posts = $query->found_posts;
$totalPages = ceil($total_posts / $perPage);

while ( $query->have_posts() ) {
	$query->the_post();
	?>
	<header class="entry-header alignwide">
		<?php echo get_the_title(); ?>
	</header><!-- .entry-header -->
	<?php
    }
wp_reset_postdata();
if ($total_posts > $perPage) { ?>
	<div class="pagination pagination-two">
		<?php 
		$big = 999999999;
        echo paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $query->max_num_pages,
            'end_size' => 5,
            'next_text' => '<span class="next-icon"></span>',
            'prev_text' => '<span class="prev-icon"></span>',
        )); 
        ?>
	</div>
<?php } ?>
