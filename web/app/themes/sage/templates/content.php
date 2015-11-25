<?php use Roots\Sage\Setup; ?>

<article <?php post_class(); ?>>
  <header>
    <?php Setup\sage_entry_categories(); ?>
    <div class="post-thumbnail">
      <?php
        // Output the featured image.
    		if (has_post_thumbnail()) {
    			the_post_thumbnail('sage-post-thumbnail');
    		}
      ?>
    </div>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  </header>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
  <?php get_template_part('templates/entry-meta-listing'); ?>
</article>
