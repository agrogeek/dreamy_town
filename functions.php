<?php
/**
 * Dreamy Town functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in Disueños to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.Disueños.org/Theme_Development
 * @link http://codex.Disueños.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.Disueños.org/Plugin_API
 *
 * @package Disueños
 * @subpackage Dreamy_Town
 * @since esArroyo.es 2014
 */

/**
 * Set up the content width value based on the theme's design.
 *
 * @see dreamy_town_content_width()
 *
 * @since esArroyo.es 2014
 */
if ( ! isset( $content_width ) ) {
	$content_width = 474;
}

/**
 * Dreamy Town only works in Disueños 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'dreamy_town_setup' ) ) :
/**
 * Dreamy Town setup.
 *
 * Set up theme defaults and registers support for various Disueños features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since esArroyo.es 2014
 */
function dreamy_town_setup() {

	/*
	 * Make Dreamy Town available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Dreamy Town, use a find and
	 * replace to change 'dreamy_town' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'dreamy_town', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', dreamy_town_font_url() ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'dreamy_town-full-width', 1038, 576, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'dreamy_town' ),
		) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );


	
	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
endif; // dreamy_town_setup
add_action( 'after_setup_theme', 'dreamy_town_setup' );

/**
 * Adjust content_width value for image attachment template.
 *
 * @since esArroyo.es 2014
 */
function dreamy_town_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'dreamy_town_content_width' );



/**
 * Register three Dreamy Town widget areas.
 *
 * @since esArroyo.es 2014
 */
function dreamy_town_widgets_init() {
	require get_template_directory() . '/inc/widgets.php';
	register_widget( 'Dreamy_Town_Ephemera_Widget' );

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'dreamy_town' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the left.', 'dreamy_town' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
		) );
}
add_action( 'widgets_init', 'dreamy_town_widgets_init' );

/**
 * Register Lato Google font for Dreamy Town.
 *
 * @since esArroyo.es 2014
 *
 * @return string
 */
function dreamy_town_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'dreamy_town' ) ) {
		$font_url = add_query_arg( 'family', urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ), "//fonts.googleapis.com/css" );
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since esArroyo.es 2014
 */
function dreamy_town_scripts() {

	// Add Lato font, used in the main stylesheet.
	wp_enqueue_style( 'dreamy_town-lato', dreamy_town_font_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'dreamy_town-style', get_stylesheet_uri(), array( 'genericons' ) );

	// Load tinyscrollbar stylesheet.
	wp_enqueue_style( 'perfect-scrollbar-style', get_template_directory_uri() . '/css/perfect-scrollbar-0.4.10.min.css', array(  ) );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'dreamy_town-ie', get_template_directory_uri() . '/css/ie.css', array( 'dreamy_town-style', 'genericons' ), '20131205' );
	wp_style_add_data( 'dreamy_town-ie', 'conditional', 'lt IE 9' );


	wp_enqueue_script( 'jquery' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'dreamy_town-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130402' );
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		wp_enqueue_script( 'jquery-masonry' );
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		wp_enqueue_script( 'dreamy_town-slider', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '20131205', true );
		wp_localize_script( 'dreamy_town-slider', 'featuredSliderDefaults', array(
			'prevText' => __( 'Previous', 'dreamy_town' ),
			'nextText' => __( 'Next', 'dreamy_town' )
			) );
	}

	wp_enqueue_script( 'google_maps_api-script', 'http://maps.googleapis.com/maps/api/js?sensor=false', array(), null);
	wp_enqueue_script( 'google_maps_label-script', get_template_directory_uri() . '/js/markerwithlabel_packed.js', array(), null);
	wp_enqueue_script( 'google_maps_cluster-script', get_template_directory_uri() . '/js/markerclusterer_packed.js', array(), null);

	wp_enqueue_script( 'dreamy_town_functions-script', get_template_directory_uri() . '/js/functions.js' );
	wp_enqueue_script( 'perfect-scrollbar-script', get_template_directory_uri() . '/js/perfect-scrollbar-0.4.10.min.js' );
}
add_action( 'wp_enqueue_scripts', 'dreamy_town_scripts' );

function map_position_menu() {
	add_theme_page('Posición del mapa', 'Posición del mapa', 'edit_theme_options', 'dreamy_town_options.php', 'map_position_function');
}
add_action('admin_menu', 'map_position_menu');

function dreamy_register_settings(){

	register_setting( 'dreamy_town_options', 'dreamy_town_options', 'dreamy_validate_settings' );


	add_settings_section( 'dreamy_text_section', 'Posición inicial del Mapa', 'dreamy_display_section', 'dreamy_town_options.php' );

    // Create textbox field
	$field_args = array(
		'type'      => 'url',
		'id'        => 'url_textbox',
		'name'      => 'url_textbox',
		'desc'      => 'URL del mapa de Google Maps en la posición y altura deseada',
		'std'       => '',
		'label_for' => 'url_textbox',
		'class'     => ''
		);

	add_settings_field( 'url_textbox', 'URL de Google Maps', 'dreamy_display_setting', 'dreamy_town_options.php', 'dreamy_text_section', $field_args );
	add_settings_field( 'lat_textbox', 'Latitud', 'dreamy_display_setting', 'dreamy_town_options.php', 'dreamy_text_section', array(id => 'lat_textbox', 'type' => 'text'));
	add_settings_field( 'lng_textbox', 'Longitud', 'dreamy_display_setting', 'dreamy_town_options.php', 'dreamy_text_section', array(id => 'lng_textbox', 'type' => 'text') );
	add_settings_field( 'zoom_textbox', 'Zoom', 'dreamy_display_setting', 'dreamy_town_options.php', 'dreamy_text_section', array(id => 'zoom_textbox', 'type' => 'text') );

}
add_action( 'admin_init', 'dreamy_register_settings' );

function map_position_function(){
	$options = get_option( 'dreamy_town_options' );
	?>
	<form method="post" enctype="multipart/form-data" action="options.php">
		<?php 
		settings_fields('dreamy_town_options'); 

		do_settings_sections('dreamy_town_options.php');
		?>
		<p class="submit">  
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
		</p> 
	</form>

	<div id="dreamy_googlemaps" style="height: 400px"></div>
	<script type="text/javascript">
		var latMap = '<?php echo $options["lat_textbox"]; ?>',
		lngMap = '<?php echo $options["lng_textbox"]; ?>',
		zoomMap = <?php echo $options["zoom_textbox"]; ?>;
	</script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/dreamy_markers.js"></script>
	<?php
}

function dreamy_display_setting($args)
{
	extract( $args );

	$option_name = 'dreamy_town_options';

	$options = get_option( $option_name );

	switch ( $type ) {  
		case 'url':  
		$options[$id] = stripslashes($options[$id]);  
		$options[$id] = esc_attr( $options[$id]);  
		echo "<input class='regular-text$class' type='text' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' />";  
		echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
		break;
		case 'text':
		$options[$id] = stripslashes($options[$id]);  
		$options[$id] = esc_attr( $options[$id]); 
		echo $options[$id]; 
		break;  
	}
}
function dreamy_display_section(){

}
function dreamy_validate_settings($input){

	$txt=$input['url_textbox'];

	$re1='.*?';	# Non-greedy match on filler
	$re2='([+-]?\\d*\\.\\d+)(?![-+0-9\\.])';	# Float 1
	$re3='.*?';	# Non-greedy match on filler
	$re4='([+-]?\\d*\\.\\d+)(?![-+0-9\\.])';	# Float 2
  	$re5='.*?';	# Non-greedy match on filler
  	$re6='(\\d+)';	# Integer Number 1

  if ($c=preg_match_all ("/".$re1.$re2.$re3.$re4.$re5.$re6."/is", $txt, $matches))
  {
  	$float1=$matches[1][0];
  	$float2=$matches[2][0];
    $int1=$matches[3][0];
  }

  $input['lat_textbox'] = !is_null($float1)?$float1:38.0243962;
  $input['lng_textbox'] = !is_null($float2)?$float2:-6.422818;
  $input['zoom_textbox'] = !is_null($int1)?$int1:16;
  return $input;
}
/**
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @since esArroyo.es 2014
 */
function dreamy_town_admin_fonts() {
	wp_enqueue_style( 'dreamy_town-lato', dreamy_town_font_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'dreamy_town_admin_fonts' );

if ( ! function_exists( 'dreamy_town_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since esArroyo.es 2014
 */
function dreamy_town_the_attached_image() {
	$post                = get_post();
	/**
	 * Filter the default Dreamy Town attachment size.
	 *
	 * @since esArroyo.es 2014
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 810.
	 *     @type int $width  Width of the image in pixels. Default 810.
	 * }
	 */
	$attachment_size     = apply_filters( 'dreamy_town_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
		) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
		);
}
endif;


// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';



/* Custom metabox for markers */


// Little function to return a custom field value
function dreamy_get_custom_field( $value ) {
	global $post;

	$custom_field = get_post_meta( $post->ID, $value, true );
	if ( !empty( $custom_field ) )
		return is_array( $custom_field ) ? stripslashes_deep( $custom_field ) : stripslashes( wp_kses_decode_entities( $custom_field ) );

	return false;
}

// Register the Metabox
function dreamy_add_custom_meta_box() {
	add_meta_box( 'dreamy-meta-box', 'Dreamy Markers', 'dreamy_meta_box_output', 'post', 'normal', 'high' );
	add_meta_box( 'dreamy-meta-box', 'Dreamy Markers', 'dreamy_meta_box_output', 'page', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'dreamy_add_custom_meta_box' );


// Output the Metabox
function dreamy_meta_box_output( $post ) {

	$options = get_option( 'dreamy_town_options' );
	// create a nonce field
	wp_nonce_field( 'my_dreamy_meta_box_nonce', 'dreamy_meta_box_nonce' ); ?>
	<h3>Mapa: selecciona un punto</h3>
	<div id="dreamy_googlemaps" style="height: 400px"></div>
	<input type="hidden" name="dreamy_lat" id="dreamy_lat" value="<?php echo dreamy_get_custom_field( 'dreamy_lat' ); ?>" required/>
	<input type="hidden" name="dreamy_long" id="dreamy_long" value="<?php echo dreamy_get_custom_field( 'dreamy_long' ); ?>" required/>
	<h3>Marker: selecciona un marker</h3>
	<div id="dreamy_markers">
		<?php
		$path_template = get_template_directory()."/images/markers/";
		$uri_template = get_template_directory_uri()."/images/markers/";
		foreach (glob($path_template."*") as $filename) {
			$filename = str_replace($path_template, '', $filename)

			?><img src="<?php echo $uri_template.$filename; ?>" class="marker" data-file="<?php echo $filename; ?>" style="cursor: pointer"/><?php
		}
		?>
	</div>
	<p>
		<input type="hidden" name="dreamy_icon" id="dreamy_icon" value="<?php echo dreamy_get_custom_field( 'dreamy_icon' ); ?>" required/>
	</p>
	<script type="text/javascript">
		var urlMarkers = '<?php echo get_bloginfo("template_url"); ?>/images/markers/',
		iconMarker = '<?php echo dreamy_get_custom_field( "dreamy_icon" ); ?>',
		latMarker = '<?php echo dreamy_get_custom_field( "dreamy_lat" ); ?>',
		lngMarker = '<?php echo dreamy_get_custom_field( "dreamy_long" ); ?>',
		latMap = '<?php echo $options["lat_textbox"]; ?>',
		lngMap = '<?php echo $options["lng_textbox"]; ?>',
		zoomMap = <?php echo $options["zoom_textbox"]; ?>;
	</script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/dreamy_markers.js"></script>
	<?php 
}


// Save the Metabox values
function dreamy_meta_box_save( $post_id ) {
	// Stop the script when doing autosave
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// Verify the nonce. If insn't there, stop the script
	if( !isset( $_POST['dreamy_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['dreamy_meta_box_nonce'], 'my_dreamy_meta_box_nonce' ) ) return;

	// Stop the script if the user does not have edit permissions
	if( !current_user_can( 'edit_post' ) ) return;

    // Save the lat
	if( isset( $_POST['dreamy_lat'] ) )
		update_post_meta( $post_id, 'dreamy_lat', esc_attr( $_POST['dreamy_lat'] ) );

    // Save the long
	if( isset( $_POST['dreamy_long'] ) )
		update_post_meta( $post_id, 'dreamy_long', esc_attr( $_POST['dreamy_long'] ) );

    // Save the icon
	if( isset( $_POST['dreamy_icon'] ) )
		update_post_meta( $post_id, 'dreamy_icon', esc_attr( $_POST['dreamy_icon'] ) );
}
add_action( 'save_post', 'dreamy_meta_box_save' );
