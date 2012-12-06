<?php
	/*
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );

	/* ========================================================================================================================
	
	Theme specific settings
	
	 * Register widgetized area and update sidebar with default widgets
	 */
	function toolbox_widgets_init() {
		register_sidebar( array(
			'name' => __( 'Right Sidebar' ),
			'id' => 'rightsidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h1 class="widget-title">',
			'after_title' => '</h1>',
		) );

	}
	add_action( 'init', 'toolbox_widgets_init' );
	
	 /*

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
	
	======================================================================================================================== */
	
	// register_nav_menus(array('top_menu' => 'Top Menu'));
	
	if (function_exists('add_theme_support'))
	{
	    // Add Menu Support
	    add_theme_support('menus');

	    // Add Thumbnail Theme Support
	    add_theme_support('post-thumbnails');
	    add_image_size('large', 700, '', true); // Large Thumbnail
	    add_image_size('medium', 250, '', true); // Medium Thumbnail
	    add_image_size('small', 120, '', true); // Small Thumbnail
	    add_image_size('custom-size', 700, 400, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');
	
		register_nav_menus( array(
			'top_menu' => __( 'Top Menu' ),
			'left_menu' => __( 'Left Menu' ),
			'footer_menu' => __( 'Footer Menu' )
		) );
	}

	
	
	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'script_enqueuer' );

	add_filter( 'body_class', 'add_slug_to_body_class' );

	
	
/*	 ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function script_enqueuer() {
		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
		wp_enqueue_script( 'site' );

		wp_register_style( 'screen', get_template_directory_uri().'/style.css', '', '', 'screen' );
        wp_enqueue_style( 'screen' );
	}
		

	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>	
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif;
	}
	
	
	/* ========================================================================================================================
	
	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
	
	======================================================================================================================== */

	// Register the Clouds custom post type
	
	// start custom post type code

	function custom_wishbones_init() {
	  $labels = array(
	    'name' => _x('Wishbones', 'post type general name', 'your_text_domain'),
	    'singular_name' => _x('Wishbone', 'post type singular name', 'your_text_domain'),
	    'add_new' => _x('Add New', 'wishbones', 'your_text_domain'),
	    'add_new_item' => __('Add New Wishbone Painting', 'your_text_domain'),
	    'edit_item' => __('Edit Wishbone Painting', 'your_text_domain'),
	    'new_item' => __('New Wishbone Painting', 'your_text_domain'),
	    'all_items' => __('All Wishbones', 'your_text_domain'),
	    'view_item' => __('View Wishbone Painting', 'your_text_domain'),
	  );
	  $args = array(
	    'labels' => $labels,
	    'public' => true,
	    'publicly_queryable' => true,
	    'show_ui' => true, 
	    'show_in_menu' => true, 
	    'query_var' => true,
	    'rewrite' => array( 'slug' => _x( 'wishbones', 'URL slug', 'your_text_domain' ) ),
	    'capability_type' => 'post',
	    'has_archive' => true, 
	    'hierarchical' => false,
	    'menu_position' => null,
	    'supports' => array( 'title', 'thumbnail', 'editor', 'excerpt', 'custom-fields' )
	  ); 
	  register_post_type('my_wishbones', $args);
	}
	// happens every time somebody hits wordpress
	add_action( 'init', 'custom_wishbones_init');
	
	// end custom post type code
	

		
				
				/* ========================================================================================================================

				Custom Fields - include custom fields here

				======================================================================================================================== */
	