<div class="row">
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
</div>

<?php the_posts_navigation(); ?>
