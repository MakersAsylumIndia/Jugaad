<?php
  if (is_front_page()) {
    get_template_part('templates/featured-content');
  }
?>

<div class="row">
  <?php if (!have_posts()) : ?>
    <div class="alert alert-warning">
      <?php _e('Sorry, no results were found.', 'sage'); ?>
    </div>
    <?php get_search_form(); ?>
  <?php endif; ?>

  <?php if(is_front_page()): ?>
    <div class="col-sm-8 page-content">
    <?php while (have_posts()) : the_post(); ?>
      <div class="col-sm-6">
        <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
      </div>
    <?php endwhile; ?>
    </div>

    <div class="col-sm-4 page-sidebar">
      <?php get_template_part('templates/sidebar'); ?>
    </div>

  <?php else: ?>
    <?php get_template_part('templates/page', 'header'); ?>

    <?php if (!have_posts()) : ?>
      <div class="alert alert-warning">
        <?php _e('Sorry, no results were found.', 'sage'); ?>
      </div>
      <?php get_search_form(); ?>
    <?php endif; ?>

    <div class="col-sm-12 page-content">
    <?php while (have_posts()) : the_post(); ?>
      <div class="col-sm-4">
        <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
      </div>
    <?php endwhile; ?>
    </div>

  <? endif; ?>
</div>

<?php the_posts_navigation(); ?>
