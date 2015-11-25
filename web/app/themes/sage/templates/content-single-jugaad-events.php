<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
      <div>
        <?php
          // Output the featured image.
          if (has_post_thumbnail()) {
            the_post_thumbnail('sage-featured-content-thumbnail');
          }
        ?>
      </div>
      <?php the_content(); ?>
      <?php foreach( get_cfc_meta( 'jugaad_event' ) as $key => $value ): ?>
        <div>
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
  			</div>
  			<div>
        	<h3>When:</h3> <p><?php echo $event_start_date["day"] . "/" . $event_start_date["month"] . "/" . $event_start_date["year"]; ?> <?php if($event_end_date): ?> to <?php echo $event_end_date["day"] . "/" . $event_end_date["month"] . "/" . $event_end_date["year"]; ?><?php endif; ?></p>
  			</div>
  			<div>
        	<h3>Tickets and Registration:</h3> <a class="jugaad-event-link" href="<?php the_cfc_field( 'jugaad_event', 'event-registration-and-ticket-link', false, $key ); ?>"><?php the_cfc_field( 'jugaad_event', 'event-registration-and-ticket-link', false, $key ); ?></a>
  			</div>
  			<div>
        	<h3>Event Website:</h3> <a class="jugaad-event-link" href="<?php the_cfc_field( 'jugaad_event', 'event-website', false, $key ); ?>"><?php the_cfc_field( 'jugaad_event', 'event-website', false, $key ); ?></a>
  			</div>
      <?php endforeach; ?>
    </div>
    <?php
    if ( function_exists( 'sharing_display' ) ) {
      sharing_display( '', true );
    }

    if ( class_exists( 'Jetpack_Likes' ) ) {
      $custom_likes = new Jetpack_Likes;
      echo $custom_likes->post_likes( '' );
    }
    ?>
    <footer>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
  </article>
<?php endwhile; ?>
