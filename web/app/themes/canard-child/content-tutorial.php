<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			canard_entry_categories();
			the_title( '<h2 class="entry-title">', '</h2>' );
		?>
		<p class="single-excerpt"><?php echo(get_the_excerpt()); ?></p>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( has_post_thumbnail() && ( ! has_post_format() || has_post_format( 'image' ) || has_post_format( 'gallery' ) ) ) : ?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'canard-child-featured-content-thumbnail' ); ?>
			</div>
		<?php
      endif;

		  the_content();

      foreach( get_cfc_meta( 'jugaad_tutorial' ) as $key => $value ){
    ?>
      <h3>Step <?php echo $key+1; ?>: <?php the_cfc_field( 'jugaad_tutorial', 'step-title', false, $key ); ?></h3>
      <div><img src="<?php the_cfc_field( 'jugaad_tutorial', 'step-image', false, $key ); ?>"></img></div>
      <p><?php the_cfc_field( 'jugaad_tutorial', 'step-description', false, $key ); ?></p>
    <?php
      }

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'canard' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'canard' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
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
