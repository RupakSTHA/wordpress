<?php
/** Template Name: Ajax Pagination */
get_header();

$perPage = 4;
$currentPage = 1;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
  'posts_per_page' => $perPage,
  'post_type' => 'post',
  'paged' => $paged,
);

$query = new WP_Query($args);
$total_posts = $query->found_posts;
?>
<div class="error"></div>
<div class="portfolio-wrapper">
  <div class="portfolio">
    <?php
      while ($query->have_posts()) {
        $query->the_post();
        ?>
        <header class="entry-header alignwide">
            <?php echo get_the_title(); ?>
        </header><!-- .entry-header -->
        <?php
      }
      wp_reset_postdata();

      if ($query->max_num_pages > 1) {
        echo '<div class="pagination">';
        echo paginate_links(array(
          'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
          'format' => '?paged=%#%',
          'current' => max(1, $paged),
          'total' => $query->max_num_pages,
        ));
        echo '</div>';
      }
      ?>
  </div>
</div>
<style>
  .pagination {
    margin-top: 20px;
  }

  .pagination a {
    display: inline-block;
    padding: 5px 10px;
    margin-right: 5px;
    background-color: #f2f2f2;
    color: #333;
    text-decoration: none;
    border-radius: 3px;
  }

  .pagination a:hover {
    background-color: #333;
    color: #fff;
  }

  .pagination .current {
    background-color: #333;
    color: #fff;
  }
</style>
<?php
get_footer();
