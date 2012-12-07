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
	    add_image_size('custom-size', 700, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');
	
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


// Jane added this from the Nigel Git functions.php file
	 wp_register_script('shadowbox', get_template_directory_uri() . '/js/shadowbox/shadowbox.js', array('jquery'), false, false);
	 wp_enqueue_script('shadowbox'); // Enqueue it!

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
	
	
	
	//Custom Image Gallery

	//This line stops the theme from using wp-includes/media.php
	remove_shortcode('gallery');

	//This code below adds your own custom theme
	add_shortcode('gallery', 'eric_gallery_shortcode');

	/**
	 * The Gallery shortcode.
	 *
	 * This implements the functionality of the Gallery Shortcode for displaying
	 * WordPress images on a post.
	 *
	 * @since 2.5.0
	 *
	 * @param array $attr Attributes of the shortcode.
	 * @return string HTML content to display gallery.
	 */
	function eric_gallery_shortcode($attr) {
		global $post;


		extract(shortcode_atts(array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post->ID,
			'itemtag'    => 'dl',
			'icontag'    => 'dt',
			'captiontag' => 'dd',
			'columns'    => 3,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => ''
		), $attr));

		$id = intval($id);
		if ( 'RAND' == $order )
			$orderby = 'none';

		if ( !empty($include) ) {
			$include = preg_replace( '/[^0-9,]+/', '', $include );
			$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( !empty($exclude) ) {
			$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		} else {
			$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}

		if ( empty($attachments) )
			return '';

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
			return $output;
		}



		$selector = "gallery-{$instance}";

		$gallery_div = "<div id='$selector' class='gallery'>";
		$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {



			$img_src = wp_get_attachment_image_src($id, $size);
			$img_src_full = wp_get_attachment_image_src($id, "full");

			$data = wp_get_attachment( $id );

			// echo wp_get_attachment_image( 1 );


			$output .= "<a href='" . $img_src_full[0] . "' rel='shadowbox[gallery]' title='" . $data[title] . "'><img src='" . $img_src[0] . "' /></a>";

			// $output .= "<img src='" . $img_src[0] . "' />";



		}

		$output .= "
				<br style='clear: both;' />
			</div>\n";

		return $output;
	}
	//End Custom Image Gallery	
	
	
	
	/* ========================================================================================================================
	
	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
	
	======================================================================================================================== */

	// Register the Clouds custom post type
	
	// start custom post type code: Wishbones

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
	
	//Another one:
	// start custom post type code: Clouds

	function custom_clouds_init() {
	  $labels = array(
	    'name' => _x('Clouds', 'post type general name', 'your_text_domain'),
	    'singular_name' => _x('Cloud', 'post type singular name', 'your_text_domain'),
	    'add_new' => _x('Add New', 'clouds', 'your_text_domain'),
	    'add_new_item' => __('Add New Clouds Painting', 'your_text_domain'),
	    'edit_item' => __('Edit Clouds Painting', 'your_text_domain'),
	    'new_item' => __('New Clouds Painting', 'your_text_domain'),
	    'all_items' => __('All Clouds', 'your_text_domain'),
	    'view_item' => __('View Clouds Painting', 'your_text_domain'),
	  );
	  $args = array(
	    'labels' => $labels,
	    'public' => true,
	    'publicly_queryable' => true,
	    'show_ui' => true, 
	    'show_in_menu' => true, 
	    'query_var' => true,
	    'rewrite' => array( 'slug' => _x( 'clouds', 'URL slug', 'your_text_domain' ) ),
	    'capability_type' => 'post',
	    'has_archive' => true, 
	    'hierarchical' => false,
	    'menu_position' => null,
	    'supports' => array( 'title', 'thumbnail', 'editor', 'excerpt', 'custom-fields' )
	  ); 
	  register_post_type('my_clouds', $args);
	}
	// happens every time somebody hits wordpress
	add_action( 'init', 'custom_clouds_init');
	
	// end custom post type code
	
	//Another one:
	// start custom post type code: Portraits

	function custom_portraits_init() {
	  $labels = array(
	    'name' => _x('Portraits', 'post type general name', 'your_text_domain'),
	    'singular_name' => _x('Portrait', 'post type singular name', 'your_text_domain'),
	    'add_new' => _x('Add New', 'portraits', 'your_text_domain'),
	    'add_new_item' => __('Add New Portrait Painting', 'your_text_domain'),
	    'edit_item' => __('Edit Portrait Painting', 'your_text_domain'),
	    'new_item' => __('New Portrait Painting', 'your_text_domain'),
	    'all_items' => __('All Portraits', 'your_text_domain'),
	    'view_item' => __('View Portrait Painting', 'your_text_domain'),
	  );
	  $args = array(
	    'labels' => $labels,
	    'public' => true,
	    'publicly_queryable' => true,
	    'show_ui' => true, 
	    'show_in_menu' => true, 
	    'query_var' => true,
	    'rewrite' => array( 'slug' => _x( 'portraits', 'URL slug', 'your_text_domain' ) ),
	    'capability_type' => 'post',
	    'has_archive' => true, 
	    'hierarchical' => false,
	    'menu_position' => null,
	    'supports' => array( 'title', 'thumbnail', 'editor', 'excerpt', 'custom-fields' )
	  ); 
	  register_post_type('my_portraits', $args);
	}
	// happens every time somebody hits wordpress
	add_action( 'init', 'custom_portraits_init');
	
	// end custom post type code
	
	//Another one:
	// start custom post type code: Flowers

	function custom_flowers_init() {
	  $labels = array(
	    'name' => _x('Flowers', 'post type general name', 'your_text_domain'),
	    'singular_name' => _x('Flower', 'post type singular name', 'your_text_domain'),
	    'add_new' => _x('Add New', 'flowers', 'your_text_domain'),
	    'add_new_item' => __('Add New Flower Painting', 'your_text_domain'),
	    'edit_item' => __('Edit Flower Painting', 'your_text_domain'),
	    'new_item' => __('New Flower Painting', 'your_text_domain'),
	    'all_items' => __('All Flowers', 'your_text_domain'),
	    'view_item' => __('View Flower Painting', 'your_text_domain'),
	  );
	  $args = array(
	    'labels' => $labels,
	    'public' => true,
	    'publicly_queryable' => true,
	    'show_ui' => true, 
	    'show_in_menu' => true, 
	    'query_var' => true,
	    'rewrite' => array( 'slug' => _x( 'flowers', 'URL slug', 'your_text_domain' ) ),
	    'capability_type' => 'post',
	    'has_archive' => true, 
	    'hierarchical' => false,
	    'menu_position' => null,
	    'supports' => array( 'title', 'thumbnail', 'editor', 'excerpt', 'custom-fields' )
	  ); 
	  register_post_type('my_flowers', $args);
	}
	// happens every time somebody hits wordpress
	add_action( 'init', 'custom_flowers_init');
	
	// end custom post type code
	
	//Another one:
	// start custom post type code: Flowers

	function custom_portraits_animals_init() {
	  $labels = array(
	    'name' => _x('Portraits: Animals', 'post type general name', 'your_text_domain'),
	    'singular_name' => _x('Portrait: Animal', 'post type singular name', 'your_text_domain'),
	    'add_new' => _x('Add New', 'portrait_animal', 'your_text_domain'),
	    'add_new_item' => __('Add New Portrait: Animal', 'your_text_domain'),
	    'edit_item' => __('Edit Portrait: Animal', 'your_text_domain'),
	    'new_item' => __('New Portrait: Animal', 'your_text_domain'),
	    'all_items' => __('All Portraits: Animals', 'your_text_domain'),
	    'view_item' => __('View Portrait: Animal', 'your_text_domain'),
	  );
	  $args = array(
	    'labels' => $labels,
	    'public' => true,
	    'publicly_queryable' => true,
	    'show_ui' => true, 
	    'show_in_menu' => true, 
	    'query_var' => true,
	    'rewrite' => array( 'slug' => _x( 'portraits_animals', 'URL slug', 'your_text_domain' ) ),
	    'capability_type' => 'post',
	    'has_archive' => true, 
	    'hierarchical' => false,
	    'menu_position' => null,
	    'supports' => array( 'title', 'thumbnail', 'editor', 'excerpt', 'custom-fields' )
	  ); 
	  register_post_type('my_portraits_animals', $args);
	}
	// happens every time somebody hits wordpress
	add_action( 'init', 'custom_portraits_animals_init');
	
	// end custom post type code
	
	
	
	

		//Another one:
		
		// start custom post type code

		function custom_photoset_init() {
		  $labels = array(
		    'name' => _x('Photo Sets', 'post type general name', 'your_text_domain'),
		    'singular_name' => _x('Photo Set', 'post type singular name', 'your_text_domain'),
		    'add_new' => _x('Add New', 'photoset', 'your_text_domain'),
		    'add_new_item' => __('Add New Photo Set', 'your_text_domain'),
		    'edit_item' => __('Edit Photo Set', 'your_text_domain'),
		    'new_item' => __('New Photo Set', 'your_text_domain'),
		    'all_items' => __('All Photo Sets', 'your_text_domain'),
		    'view_item' => __('View Photo Set', 'your_text_domain'),
		    'search_items' => __('Search Photo Sets', 'your_text_domain'),
		    'not_found' =>  __('No photo sets found', 'your_text_domain'),
		    'not_found_in_trash' => __('No photo sets found in Trash', 'your_text_domain'), 
		    'parent_item_colon' => '',
		    'menu_name' => __('Photo Sets', 'your_text_domain')

		  );
		  $args = array(
		    'labels' => $labels,
		    'public' => true,
		    'publicly_queryable' => true,
		    'show_ui' => true, 
		    'show_in_menu' => true, 
		    'query_var' => true,
		    'rewrite' => array( 'slug' => _x( 'photoset', 'URL slug', 'your_text_domain' ) ),
		    'capability_type' => 'post',
		    'has_archive' => true, 
		    'hierarchical' => false,
		    'menu_position' => null,
		    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'categories', 'comments', 'custom-fields' )
		  ); 
		  register_post_type('my_photosets', $args);
		/* IMPORTIONT: Remember this line! */
		    // flush_rewrite_rules( false );/* Please read "Update 2" before adding this line */
		}
		// happens every time somebody hits wordpress
		add_action( 'init', 'custom_photoset_init');

		// end custom post type code

		// begin custom tags taxonomy code

		function my_tags_taxonomies_photoset() {
			// create a new taxonomy
			register_taxonomy(
				'photosettags',
				'my_photosets',
				array(
					'label' => __( 'Photo Set Tags' ),
					'rewrite' => array( 'slug' => 'photosettags' )
				)
			);
		}
		add_action( 'init', 'my_tags_taxonomies_photoset' );

		// end custom tags taxonomy code

		function my_taxonomies_photoset() {
			$labels = array(
				'name'              => _x( 'Photo Set Categories', 'taxonomy general name' ),
				'singular_name'     => _x( 'Photo Set Category', 'taxonomy singular name' ),
				'search_items'      => __( 'Search Photo Set Categories' ),
				'all_items'         => __( 'All Photo Set Categories' ),
				'parent_item'       => __( 'Parent Photo Set Category' ),
				'parent_item_colon' => __( 'Parent Photo Set Category:' ),
				'edit_item'         => __( 'Edit Photo Set Category' ), 
				'update_item'       => __( 'Update Photo Set Category' ),
				'add_new_item'      => __( 'Add New Photo Set Category' ),
				'new_item_name'     => __( 'New Photo Set Category' ),
				'menu_name'         => __( 'Photo Set Categories' ),
			);
			$args = array(
				'labels' => $labels,
				'show_in_nav_menus' => true,
				'hierarchical' => true,
			);
			register_taxonomy( 'photoset_category', 'my_photosets', $args );
		}
		add_action( 'init', 'my_taxonomies_photoset', 0 );
		
		//end custom post type photosets
				
				/* ========================================================================================================================

				Custom Fields - include custom fields here

				======================================================================================================================== */
				
				
			// Custom image attachment function
			// http://wordpress.org/extend/ideas/topic/functions-to-get-an-attachments-caption-title-alt-description

			function wp_get_attachment( $attachment_id ) {

				$attachment = get_post( $attachment_id );
				return array(
					'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
					'caption' => $attachment->post_excerpt,
					'description' => $attachment->post_content,
					'href' => get_permalink( $attachment->ID ),
					'src' => $attachment->guid,
					'title' => $attachment->post_title
				);
			}			
				
				
	