<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  add_theme_support('soil-jquery-cdn');
  add_theme_support('soil-relative-urls');

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'sage')
  ]);

  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  // Use main stylesheet for visual editor
  // To add custom styles edit /assets/styles/layouts/_tinymce.scss
  add_editor_style(Assets\asset_path('styles/main.css'));

  add_theme_support('featured-content', array(
		'filter'      => 'sage_get_featured_posts',
		'description' => __('The featured content section displays on the front page above the header.', 'sage'),
		'max_posts'   => 5,
		'post_types'  => array('post', 'jugaad_tutorials'),
	));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
  register_sidebar([
    'name'          => __('Primary', 'sage'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);

  register_sidebar([
    'name'          => __('Footer', 'sage'),
    'id'            => 'sidebar-footer',
    'before_widget' => '<div class="col-sm-4 %2$s"><section class="widget %1$s %2$s">',
    'after_widget'  => '</section></div>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
  static $display;

  isset($display) || $display = !in_array(true, [
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_404(),
    is_front_page(),
    is_archive(),
    is_page_template('template-custom.php'),
    is_home(),
    is_page('about-us')
  ]);

  return apply_filters('sage/display_sidebar', $display);
}

/**
 * Theme assets
 */
function assets() {
  wp_enqueue_style('sage/css', Assets\asset_path('styles/main.css'), false, null);

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('sage/js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);

/**
* Creating Tutorials and Events Post Type
**/
function create_post_type() {
  register_post_type( 'jugaad_tutorials',
    array(
      'labels' => array(
        'name' => _x( 'Tutorials', 'post type general name' ),
        'singular_name' => _x( 'Tutorial' , 'post type singular name' ),
        'add_new' => _x('Add New', 'tutorial'),
        'add_new_item' => __('Add New Tutorial'),
        'edit_item' => __('Edit Tutorial'),
        'new_item' => __('New Tutorial'),
        'all_items' => __('All Tutorials'),
        'view_item' => __('View Tutorial'),
        'search_items' => __('Search Tutorials'),
        'not_found'          => __( 'No tutorials found' ),
        'not_found_in_trash' => __( 'No tutorials found in the Trash' ),
        'parent_item_colon'  => '',
        'menu_name'          => 'Tutorials'
      ),
      'description' => 'Holds all the Tutorials for the DO section',
      'public' => true,
      'menu_position' => 4,
      'supports' => array('title', 'editor', 'publicize', 'excerpt', 'thumbnail', 'comments', 'author'),
      'has_archive' => true,
      'rewrite' => array('slug' => 'do', 'with_front' => false),
      'menu_icon' => 'dashicons-hammer',
    )
  );
  register_post_type( 'jugaad_events',
    array(
      'labels' => array(
        'name' => _x( 'Events', 'post type general name' ),
        'singular_name' => _x( 'Event' , 'post type singular name' ),
        'add_new' => _x('Add New', 'event'),
        'add_new_item' => __('Add New Event'),
        'edit_item' => __('Edit Event'),
        'new_item' => __('New Event'),
        'all_items' => __('All Events'),
        'view_item' => __('View Event'),
        'search_items' => __('Search Events'),
        'not_found'          => __( 'No events found' ),
        'not_found_in_trash' => __( 'No events found in the Trash' ),
        'parent_item_colon'  => '',
        'menu_name'          => 'Events'
      ),
      'description' => 'Holds all the Events for the GO section',
      'public' => true,
      'menu_position' => 5,
      'supports' => array('title', 'editor', 'publicize', 'excerpt', 'thumbnail'),
      'has_archive' => true,
      'rewrite' => array('slug' => 'go', 'with_front' => false),
      'menu_icon' => 'dashicons-tickets-alt',
    )
  );
}
add_action( 'init', __NAMESPACE__ . '\\create_post_type' );

function create_custom_taxonomy() {
  register_taxonomy(
    'tutorials_category',
    'jugaad_tutorials',
    array(
      'hierarchical' => true,
      'label'        => 'Tutorial Category',
      'query_var'    => true
    )
  );
  register_taxonomy(
    'events_category',
    'jugaad_events',
    array(
      'hierarchical' => true,
      'label'        => 'Event Category',
      'query_var'    => true
    )
  );
}
add_action( 'init', __NAMESPACE__ . '\\create_custom_taxonomy' );

function sage_has_multiple_featured_posts() {
	$featured_posts = apply_filters( 'sage_get_featured_posts', array() );
	if ( is_array( $featured_posts ) && 1 < count( $featured_posts ) ) {
		return true;
	}
	return false;
}

function sage_get_featured_posts() {
	return apply_filters( 'sage_get_featured_posts', false );
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function sage_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'sage_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'sage_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so canard_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so canard_categorized_blog should return false.
		return false;
	}
}

// Prints HTML with meta information for the categories.
function sage_entry_categories() {
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'sage' ) );
		if ( $categories_list && sage_categorized_blog() ) {
			printf( '<div class="entry-meta"><span class="cat-links">%1$s</span></div>', $categories_list );
		}
	}
  if ( 'jugaad_tutorials' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = wp_get_post_terms( get_the_id(), 'tutorials_category' );
		if ( $categories_list && sage_categorized_blog() ) {
			printf( '<div class="entry-meta"><span class="cat-links"><a href="%1$s">%2$s</a></span></div>', get_term_link($categories_list[0]), $categories_list[0]->name );
		}
	}
  if ( 'jugaad_events' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = wp_get_post_terms( get_the_id(), 'events_category' );
		if ( $categories_list && sage_categorized_blog() ) {
			printf( '<div class="entry-meta"><span class="cat-links"><a href="%1$s">%2$s</a></span></div>', get_term_link($categories_list[0]), $categories_list[0]->name );
		}
	}
}

// Adds custom image sizes
if (function_exists( 'add_image_size') ) {
    add_image_size('sage-post-thumbnail', 400, 225, true);
    add_image_size('sage-featured-content-thumbnail', 915, 515, true);
}

// Show posts of 'post' and 'jugaad_tutorial' post types on home page
add_action( 'pre_get_posts', __NAMESPACE__ . '\\add_jugaad_tutorial_to_query' );

function add_jugaad_tutorial_to_query( $query ) {
  if ( is_home() && $query->is_main_query() )
    $query->set( 'post_type', array( 'post', 'jugaad_tutorials' ) );
  return $query;
}

// Show posts of 'post', 'jugaad_tutorial' and 'jugaad_event' post types on Jugaad RSS feed
add_action( 'pre_get_posts', __NAMESPACE__ . '\\add_custom_post_types_to_feed' );

function add_custom_post_types_to_feed( $query ) {
  if ( is_feed() )
    $query->set( 'post_type', array( 'post', 'jugaad_tutorials', 'jugaad_events' ) );
  return $query;
}

// Fix wp_nav_menu's active item highlighting with custom post types

function roots_cpt_active_menu($menu) {
  $post_type = get_post_type();

  switch($post_type) {
    case 'gallery':
      $menu = str_replace('active', '', $menu);
      break;
    case 'theme':
      $menu = str_replace('active', '', $menu);
      $menu = str_replace('menu-themes', 'menu-themes active', $menu);
      break;
    case 'screencast':
      $menu = str_replace('active', '', $menu);
      $menu = str_replace('menu-screencasts', 'menu-screencasts active', $menu);
      break;
    case 'plugin':
      $menu = str_replace('active', '', $menu);
      $menu = str_replace('menu-plugins', 'menu-plugins active', $menu);
      break;
  }

  if (is_author()) {
    $menu = str_replace('active', '', $menu);
  }

  return $menu;
}
add_filter('nav_menu_css_class', __NAMESPACE__ . '\\roots_cpt_active_menu', 400);

function posts_link_attributes() {
    return 'class="styled-button"';
}

add_filter('next_posts_link_attributes', __NAMESPACE__ . '\\posts_link_attributes');
add_filter('previous_posts_link_attributes', __NAMESPACE__ . '\\posts_link_attributes');

function jptweak_remove_share() {
    remove_filter( 'the_content', 'sharing_display',19 );
    remove_filter( 'the_excerpt', 'sharing_display',19 );
    if ( class_exists( 'Jetpack_Likes' ) ) {
        remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
    }
}

add_action( 'loop_start', __NAMESPACE__ . '\\jptweak_remove_share' );

function jetpackme_remove_rp() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        remove_filter( 'the_content', array(Jetpack_RelatedPosts::init(), 'filter_add_target_to_dom'), 40 );
    }
}
add_filter( 'wp', __NAMESPACE__ . '\\jetpackme_remove_rp', 20 );

function allow_my_post_types($allowed_post_types) {
    $allowed_post_types[] = 'jugaad_tutorials';
    return $allowed_post_types;
}
add_filter( 'rest_api_allowed_post_types', __NAMESPACE__ . '\\allow_my_post_types' );
