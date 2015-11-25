<?php use Roots\Sage\Setup; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a class="post-thumbnail" href="<?php the_permalink(); ?>">
	<?php
		// Output the featured image.
		if (has_post_thumbnail()) {
			the_post_thumbnail( 'sage-featured-content-thumbnail' );
		}
	?>
	</a>

	<header class="entry-header">
		<?php
			Setup\sage_entry_categories();
			the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h1>' );
		?>
		<div class="entry-summary">
	    <?php the_excerpt(); ?>
	  </div>
		<?php get_template_part('templates/entry-meta-listing'); ?>
	</header><!-- .entry-header -->
</article><!-- #post-## -->
