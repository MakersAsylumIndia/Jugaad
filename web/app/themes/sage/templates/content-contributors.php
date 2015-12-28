<div>
  <div>
    <?php $jugaad_editor = get_users('role=editor&orderby=post_count&order=DESC'); ?>
    <?php if (!empty($jugaad_editor)): ?>
    <div class="col-sm-12">
      <h2>Editor</h2>
    </div>
    <div>
      <?php foreach($jugaad_editor as $user): ?>
      <div class="col-sm-4">
        <article <?php post_class(); ?>>
          <h3><a href='<?php echo get_author_posts_url($user->ID); ?>'><?php echo esc_html($user->display_name); ?></a></h3>
          <div><?php echo get_the_author_meta('description', $user->ID); ?></div>
        </article>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
    </div>
  </div>
  <div>
    <?php $jugaad_authors = get_users('role=author&orderby=post_count&order=DESC&exclude=13'); ?>
    <?php if (!empty($jugaad_authors)): ?>
    <div class="col-sm-12">
      <h2>Authors</h2>
    </div>
    <div>
      <?php foreach($jugaad_authors as $user): ?>
      <?php if(get_the_author_meta('description', $user->ID) != ''): ?>
      <div class="col-sm-4">
        <article <?php post_class(); ?>>
          <h3><a href='<?php echo get_author_posts_url($user->ID); ?>'><?php echo esc_html($user->display_name); ?></a></h3>
          <div><?php echo get_the_author_meta('description', $user->ID); ?></div>
        </article>
      </div>
      <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>
    </div>
  </div>
  <div
    <?php $jugaad_contributors = get_users('role=contributor&orderby=post_count&order=DESC'); ?>
    <?php if (!empty($jugaad_contributors)): ?>
    <div class="col-sm-12">
      <h2>Contributors</h2>
    </div>
    <div>
      <?php foreach($jugaad_contributors as $user): ?>
      <?php if(get_the_author_meta('description', $user->ID) != ''): ?>
      <div class="col-sm-4">
        <article <?php post_class(); ?>>
          <h3><a href='<?php echo get_author_posts_url($user->ID); ?>'><?php echo esc_html($user->display_name); ?></a></h3>
          <div><?php echo get_the_author_meta('description', $user->ID); ?></div>
        </article>
      </div>
      <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>
    </div>
  </div>
</div>
