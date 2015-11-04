<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Canard
 */
get_header(); ?>

  <div class="site-content-inner">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

      <?php
      query_posts('cat_name=read');
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

				endwhile;

				the_posts_navigation();

			else :

			  get_template_part( 'content', 'none' );

			endif;
      wp_reset_query();
      ?>

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .site-content-inner -->

<?php get_footer(); ?>
