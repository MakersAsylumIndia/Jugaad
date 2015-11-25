<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <p class="entry-excerpt"><?php echo(get_the_excerpt()); ?></p>
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
      <?php
      if ( function_exists( 'sharing_display' ) ) {
        sharing_display( '', true );
      }

      if ( class_exists( 'Jetpack_Likes' ) ) {
        $custom_likes = new Jetpack_Likes;
        echo $custom_likes->post_likes( '' );
      }
      ?>
      <?php the_content(); ?>
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
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
