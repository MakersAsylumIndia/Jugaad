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
    <?php endforeach; ?>
  </div>
</article>
