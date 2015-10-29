<?php

$users = array();
$roles = array('editor', 'author', 'contributor');

// Get all users order by amount of posts
foreach ($roles as $role) :
	$users_query = new WP_User_Query( array(
  	'fields' => 'all_with_meta',
    'role' => $role,
    'orderby' => 'post_count'
  ) );
  $results = $users_query->get_results();
  if ($results) $users = array_merge($users, $results);
endforeach;

?>

<?php get_header(); ?>

<div class="site-content-inner">
	<div class="content-area" role="main">
		<main id="main" class="site-main" role="main">
			<?php
				the_title('<h1>', '</h1>');

				foreach($users as $user)
				{
					if(($user->display_name == "Team Jugaad") || (count_user_posts( $user->ID ) < 1)) {
						continue;
					}
					?>
					<div class="author hentry">
						<div class="authorAvatar">
							<?php echo get_avatar( $user->user_email, '128' ); ?>
						</div>
						<div class="authorInfo">
							<h2 class="authorName"><?php echo $user->display_name; ?></h2>
							<p class="authorDescrption"><?php echo get_user_meta($user->ID, 'description', true); ?></p>
							<p class="authorLinks"><a href="<?php echo get_author_posts_url( $user->ID ); ?>">View Author Links</a></p>

							<p class="socialIcons">
								<ul>
									<?php
										$website = $user->user_url;
										if($user->user_url != '')
										{
											printf('<li><a href="%s">%s</a></li>', $user->user_url, 'Website');
										}

										$twitter = get_user_meta($user->ID, 'twitter_profile', true);
										if($twitter != '')
										{
											printf('<li><a href="%s">%s</a></li>', $twitter, 'Twitter');
										}

										$facebook = get_user_meta($user->ID, 'facebook_profile', true);
										if($facebook != '')
										{
											printf('<li><a href="%s">%s</a></li>', $facebook, 'Facebook');
										}

										$google = get_user_meta($user->ID, 'google_profile', true);
										if($google != '')
										{
											printf('<li><a href="%s">%s</a></li>', $google, 'Google');
										}

										$linkedin = get_user_meta($user->ID, 'linkedin_profile', true);
										if($linkedin != '')
										{
											printf('<li><a href="%s">%s</a></li>', $linkedin, 'LinkedIn');
										}
									?>
								</ul>
							</p>
						</div>
					</div>
					<?php
				}
			?>
		</main>
	</div>
</div>

<?php get_footer(); ?>
