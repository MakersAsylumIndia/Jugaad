<?php
/**
 * The template for displaying all single posts.
 *
 * @package Canard
 */

get_header(); ?>

	<div class="site-content-inner">
		<div id="primary" class="content-area">
			<main id="main" class="single site-main" role="main">

				<?php
        while ( have_posts() ) : the_post();

				  get_template_part( 'content', 'tutorial' );

					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // end of the loop.
        ?>

			</main><!-- #main -->
		</div><!-- #primary -->
		<?php get_sidebar(); ?>
	</div><!-- .site-content-inner -->

<?php get_footer(); ?>
