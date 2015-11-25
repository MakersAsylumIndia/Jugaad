<?php
/**
 * @package Canard
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
    <header class="entry-header">
      <?php
        canard_entry_categories();
        the_title( '<h2 class="entry-title">', '</h2>' );
      ?>
      <p class="single-excerpt"><?php echo(get_the_excerpt()); ?></p>
      <span>By</span> <?php the_author(); ?>
    </header><!-- .entry-header -->

		<?php if ( has_post_thumbnail() && ( ! has_post_format() || has_post_format( 'image' ) || has_post_format( 'gallery' ) ) ) : ?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'canard-featured-content-thumbnail' ); ?>
			</div>
		<?php
      endif;

			if ( function_exists( 'sharing_display' ) ) {
    		sharing_display( '', true );
			}

			if ( class_exists( 'Jetpack_Likes' ) ) {
    		$custom_likes = new Jetpack_Likes;
    		echo $custom_likes->post_likes( '' );
			}

		  the_content();

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'canard' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'canard' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

			if ( function_exists( 'sharing_display' ) ) {
				sharing_display( '', true );
			}

			if ( class_exists( 'Jetpack_Likes' ) ) {
				$custom_likes = new Jetpack_Likes;
				echo $custom_likes->post_likes( '' );
			}

		?>
	</div><!-- .entry-content -->

  <div>
    <?php
      if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
          echo do_shortcode( '[jetpack-related-posts]' );
      }
    ?>
  </div>
</article><!-- #post-## -->
