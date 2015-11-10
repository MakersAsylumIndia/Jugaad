<?php
/**
* Loading Google Fonts
**/
function load_fonts() {
  wp_register_style('pt-sans', 'http://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic');
  wp_enqueue_style('pt-sans');
}
add_action('wp_enqueue_scripts', 'load_fonts');

/**
* Child Theme Setup
**/
function canard_child_excerpt_more()
{
  return __('&hellip', 'canard-child');
}
function canard_child_continue_reading($the_excerpt)
{
  return $the_excerpt . ' <a href="'. get_permalink() . '">' . __( 'Continue Reading <span>&rarr;</span>', 'canard-child' ) . '</a>';
}
function child_theme_setup()
{
  remove_filter('canard_get_featured_posts', 'canard_get_featured_posts');
  add_filter('canard_get_featured_posts', function($posts){
    // Modify this to your needs:
    $posts = get_posts(array(
      'post_type'       => array('post', 'jugaad_tutorials'),
      'posts_per_page'  => 5,
      'tag' => 'featured'
    ) );
    return $posts;
  }, PHP_INT_MAX);
  remove_filter( 'excerpt_more', 'canard_excerpt_more');
  add_filter( 'excerpt_more', 'canard_child_excerpt_more', 11);
  remove_filter( 'the_excerpt', 'canard_continue_reading', 9);
  add_filter( 'the_excerpt', 'canard_child_continue_reading');
}
add_action('after_setup_theme', 'child_theme_setup');

/**
* Page Slug Body Class
**/
function add_slug_body_class($classes) {
  global $post;
  if (isset($post)) {
    $classes[] = $post->post_type . '-' . $post->post_name;
  }
  return $classes;
}
add_filter('body_class', 'add_slug_body_class');

/**
* Highlight active custom post page in Navigation
**/
// Mark (highlight) custom post type parent as active item in Wordpress Navigation
function add_current_nav_class($classes, $item) {
  // Getting the current post details
  global $post;
  // Get post ID, if nothing found set to NULL
  $id = ( isset( $post->ID ) ? get_the_ID() : NULL );
  // Checking if post ID exist...
  if (isset( $id )){
    // Getting the post type of the current post
    $current_post_type = get_post_type_object(get_post_type($post->ID));
    $current_post_type_slug = $current_post_type->rewrite['slug'];
    // Getting the URL of the menu item
    $menu_slug = strtolower(trim($item->url));
    // If the menu item URL contains the current post types slug add the current-menu-item class
    if (strpos($menu_slug,$current_post_type_slug) !== false) {
       $classes[] = 'current-menu-item';
    }
  }
  // Return the corrected set of classes to be added to the menu item
  return $classes;
}
add_action('nav_menu_css_class', 'add_current_nav_class', 10, 2 );

/**
* Creating Tutorials and EVents Post Type
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
      'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'post-formats', 'comments', 'author'),
      'taxonomies' => array('post_tag', 'category'),
      'has_archive' => true,
      'rewrite' => array('slug' => 'do')
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
      'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'post-formats', 'comments'),
      'taxonomies' => array('post_tag', 'category'),
      'has_archive' => true,
      'rewrite' => array('slug' => 'go')
    )
  );
}
add_action( 'init', 'create_post_type' );

/**
* Adding the Open Graph
**/
function add_opengraph_doctype( $output ) {
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
  }
add_filter('language_attributes', 'add_opengraph_doctype');

function insert_fb_in_head() {
  global $post;
  if ( !is_singular()) //if it is not a post or a page
    return;
        echo '<meta property="fb:admins" content="1157500422"/>';
        echo '<meta property="og:title" content="' . get_the_title() . '"/>';
        echo '<meta property="og:type" content="article"/>';
        echo '<meta property="og:url" content="' . get_permalink() . '"/>';
        echo '<meta property="og:site_name" content="Jugaad Magazine"/>';
        echo '<meta property="article:author" content="' . get_the_author() . '"/>';
        echo '<meta property="article:publisher" content="https://www.facebook.com/jugaadmagazine" />';
  if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
    $default_image="http://www.jugaadmagazine.com/wp-content/uploads/2015/08/symbol-facebook1.jpg"; //replace this with a default image on your server or an image in your media library
    echo '<meta property="og:image" content="' . $default_image . '"/>';
  }
  else{
    $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
    echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
  }
  echo "";
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );

/**
 * Prints HTML with meta information for the categories.
 */
function canard_entry_categories() {
	if ( 'post' == get_post_type() || 'jugaad_tutorials' == get_post_type() || 'jugaad_events' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'canard' ) );
		if ( $categories_list && canard_categorized_blog() ) {
			printf( '<div class="entry-meta"><span class="cat-links">%1$s</span></div>', $categories_list );
		}
	}
}

function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  add_theme_support('soil-jquery-cdn');
  add_theme_support('soil-relative-urls');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');
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
  add_editor_style('styles/main.css');
}
add_action('after_setup_theme', 'setup');

/**
 * Get paths for assets
 */
class JsonManifest {
  private $manifest;

  public function __construct($manifest_path) {
    if (file_exists($manifest_path)) {
      $this->manifest = json_decode(file_get_contents($manifest_path), true);
    } else {
      $this->manifest = [];
    }
  }

  public function get() {
    return $this->manifest;
  }

  public function getPath($key = '', $default = null) {
    $collection = $this->manifest;
    if (is_null($key)) {
      return $collection;
    }
    if (isset($collection[$key])) {
      return $collection[$key];
    }
    foreach (explode('.', $key) as $segment) {
      if (!isset($collection[$segment])) {
        return $default;
      } else {
        $collection = $collection[$segment];
      }
    }
    return $collection;
  }
}

function asset_path($filename) {
  $dist_path = get_stylesheet_directory_uri() . '/dist/';
  $directory = dirname($filename) . '/';
  $file = basename($filename);
  static $manifest;

  if (empty($manifest)) {
    $manifest_path = get_stylesheet_directory_uri() . '/dist/' . 'assets.json';
    $manifest = new JsonManifest($manifest_path);
  }

  if (array_key_exists($file, $manifest->get())) {
    return $dist_path . $directory . $manifest->get()[$file];
  } else {
    return $dist_path . $directory . $file;
  }
}

/**
 * Theme assets
 */
function assets() {
  $parent_style = 'parent-style';
  wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
  wp_enqueue_style('canard-child/css', asset_path('styles/main.css'), array($parent_style), null);

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('sage/js', asset_path('scripts/main.js'), ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', 'assets', 100);

function allow_my_post_types($allowed_post_types) {
    $allowed_post_types = array('jugaad_tutorials', 'jugaad_events');
    return $allowed_post_types;
}
add_filter( 'rest_api_allowed_post_types', 'allow_my_post_types' );

function jetpackme_remove_rp() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
        remove_filter( 'the_content', $callback, 40 );
    }
}
add_filter( 'wp', 'jetpackme_remove_rp', 20 );

function jptweak_remove_share() {
    remove_filter( 'the_content', 'sharing_display',19 );
    remove_filter( 'the_excerpt', 'sharing_display',19 );
    if ( class_exists( 'Jetpack_Likes' ) ) {
        remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
    }
}
add_action( 'loop_start', 'jptweak_remove_share' );
