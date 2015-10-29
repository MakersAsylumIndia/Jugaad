<?php
/**
 * @package Canard
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			canard_entry_categories();
			the_title( '<h1 class="entry-title">', '</h1>' );
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( has_post_thumbnail() && ( ! has_post_format() || has_post_format( 'image' ) || has_post_format( 'gallery' ) ) ) : ?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'canard-single-thumbnail' ); ?>
			</div>
		<?php endif; ?>
		<?php the_content(); ?>
    <?php foreach( get_cfc_meta( 'jugaad_event' ) as $key => $value ){ ?>
      <h3>Where:</h3> <p><?php the_cfc_field( 'jugaad_event', 'event-venue', false, $key ); ?></p>
      <?php
        $event_date_tmp = get_cfc_field( 'jugaad_event', 'event-start-date', false, $key);
        $event_start_date = date_parse_from_format('d-m-Y', (string)$event_date_tmp);
        $event_date_tmp = get_cfc_field( 'jugaad_event', 'event-end-date', false, $key);
				$event_end_date = "";
				if($event_date_tmp = ""):
        	$event_end_date = date_parse_from_format('d-m-Y', (string)$event_date_tmp);
				endif;
      ?>
      <h3>When:</h3> <p><?php echo $event_start_date["day"] . "/" . $event_start_date["month"] . "/" . $event_start_date["year"]; ?> <?php if($event_end_date): ?> to <?php echo $event_end_date["day"] . "/" . $event_end_date["month"] . "/" . $event_end_date["year"]; ?><?php endif; ?></p>
      <h3>Tickets and Registration:</h3> <a class="jugaad-event-link" href="<?php the_cfc_field( 'jugaad_event', 'event-registration-and-ticket-link', false, $key ); ?>"><?php the_cfc_field( 'jugaad_event', 'event-registration-and-ticket-link', false, $key ); ?></a>
      <h3>Event Website:</h3> <a class="jugaad-event-link" href="<?php the_cfc_field( 'jugaad_event', 'event-website', false, $key ); ?>"><?php the_cfc_field( 'jugaad_event', 'event-website', false, $key ); ?></a>
    <?php }  ?>
		<?php
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

	<footer class="entry-footer">
		<?php canard_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
