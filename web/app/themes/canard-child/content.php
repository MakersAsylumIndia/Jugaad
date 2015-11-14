<?php
/**
 * @package Canard
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php
    canard_entry_categories();
    if ( has_post_thumbnail() && ('post' == get_post_type() || 'jugaad_tutorials' == get_post_type()) || 'jugaad_events' == get_post_type() && ( ! has_post_format() || has_post_format( 'image' ) || has_post_format( 'gallery' ) ) ) :

      if ( ! has_post_format() ) {
        echo '<a class="post-thumbnail" href="' . esc_url( get_permalink() ) . '">';
      } elseif ( has_post_format( 'image' ) || has_post_format( 'gallery' ) ) {
        echo '<div class="post-thumbnail">';
      }

      the_post_thumbnail( 'canard-child-post-thumbnail' );

      // if (class_exists('MultiPostThumbnails')) :
      //   MultiPostThumbnails::the_post_thumbnail(
      //     get_post_type(),
      //     'thumbnail-image',
      //     NULL,
      //     'canard-child-post-thumbnail'
      //   );
      // endif;

      if ( is_sticky() ) :
  ?>
    <span class="sticky-post"><span class="genericon genericon-pinned"><span class="screen-reader-text"><?php _e( 'Sticky post', 'canard' ); ?></span></span></span>
    <?php
      endif;
      if ( ! has_post_format() ) {
        echo '</a>';
      } elseif ( has_post_format( 'image' ) || has_post_format( 'gallery' ) ) {
        echo '</div>';
      }
      endif;
    ?>

  <header class="entry-header">
    <?php
      the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
    ?>
  </header><!-- .entry-header -->

  <?php if ( 'jugaad_events' == get_post_type() ) : ?>
    <div class="entry-summary">
      <?php foreach( get_cfc_meta( 'jugaad_event' ) as $key => $value ){ ?>
        <span><h3>Where:</h3> <p><?php the_cfc_field( 'jugaad_event', 'event-venue', false, $key ); ?></p></span>
        <?php
          $event_date_tmp = get_cfc_field( 'jugaad_event', 'event-start-date', false, $key);
          $event_start_date = date_parse_from_format('d-m-Y', (string)$event_date_tmp);
          $event_date_tmp = get_cfc_field( 'jugaad_event', 'event-end-date', false, $key);
          $event_end_date = "";
          if(!($event_date_tmp == "")):
            $event_end_date = date_parse_from_format('d-m-Y', (string)$event_date_tmp);
          endif;
        ?>
        <span><h3>When:</h3> <p><?php echo $event_start_date["day"] . "/" . $event_start_date["month"] . "/" . $event_start_date["year"]; ?> <?php if(!($event_end_date=='')): ?> to <?php echo $event_end_date["day"] . "/" . $event_end_date["month"] . "/" . $event_end_date["year"]; ?><?php endif; ?></p></span>
      <?php }  ?>
    </div>
  <?php else: ?>
    <div class="entry-summary">
      <?php the_excerpt(); ?>
    </div><!-- .entry-content -->
  <?php
    endif;
    if ('post' == get_post_type() || 'jugaad_tutorials' == get_post_type()) :
  ?>
    <div class="entry-meta">
      <span style="text-transform: none;">By</span><?php canard_entry_meta(); ?>
    </div><!-- .entry-meta -->
  <?php
    endif;
  ?>
</article><!-- #post-## -->
