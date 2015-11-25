<?php use Roots\Sage\Setup; ?>
<?php get_template_part( 'templates/featured-content' ); ?>

<?php
  $featured_posts_object = Setup\sage_get_featured_posts();
  $featured_posts = (array)$featured_posts_object;
  foreach ($featured_posts as $post) {
    $featured_posts_id[] = $post->ID;
  }
?>

<?php
  $args = array(
    'post_type' => array('post', 'jugaad_tutorials'),
    'posts_per_page' => 10,
    'post__not_in' => $featured_posts_id
  );
  $the_query = new WP_Query( $args );
?>

<div class="row">
  <?php if (!($the_query->have_posts())) : ?>
    <div class="alert alert-warning">
      <?php _e('Sorry, no results were found.', 'sage'); ?>
    </div>
    <?php get_search_form(); ?>
  <?php endif; ?>

  <div class="col-sm-8 page-content">
  <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
    <div class="col-sm-6">
      <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
    </div>
  <?php endwhile; ?>
  <?php echo do_shortcode('[ajax_load_more post_type="post, jugaad_tutorials" post_format="standard" offset="15" posts_per_page="6" pause="true" scroll="false" container_type="div"]'); ?>
  </div>

  <div class="col-sm-4 page-sidebar">
    <?php get_template_part('templates/sidebar'); ?>
  </div>
</div>

<?php wp_reset_postdata(); ?>
