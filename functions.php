<?php
/**
 * Bootstrap Canvas WP functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, bootstrapcanvaswp_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'bootstrapcanvaswp_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package Bootstrap Canvas WP
 * @since Bootstrap Canvas WP 1.0
 */

/*
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
global $content_width;
if ( ! isset( $content_width ) ) $content_width = 900;

/* Tell WordPress to run bootstrapcanvaswp_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'bootstrapcanvaswp_setup' );

if ( ! function_exists( 'bootstrapcanvaswp_setup' ) ):
/**
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override bootstrapcanvaswp_setup() in a child theme, add your own bootstrapcanvaswp_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support()        To add support for post thumbnails, custom headers and backgrounds, and automatic feed links.
 * @uses register_nav_menus()       To add support for navigation menus.
 * @uses add_editor_style()         To style the visual editor.
 * @uses load_theme_textdomain()    For translation/localization support.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size()  To set a custom post thumbnail size.
 *
 * @since Bootstrap Canvas WP 1.0
 */
function bootstrapcanvaswp_setup() {
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style( 'editor-style.css' );
	
	// Post Format support.
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
	
	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );
	
    // Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'bootstrapcanvaswp', get_template_directory() . '/languages' );
	
	// Register Custom Navigation Walker
	require_once('inc/wp_bootstrap_navwalker.php');
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'bootstrapcanvaswp' ),
	) );
	
	// This theme allows users to set a custom background.
	$args = array(
		// Let WordPress know what our default background color is.
		'default-color' => 'fff',
	);
	add_theme_support( 'custom-background', $args );
	
	// The custom header business starts here.
	
	$args = array(
		// The height and width of our custom header.
		'width'         => '980',
		'height'        => '170',
		// Support flexible widths and heights.
		'flex-height'    => true,
		'flex-width'    => true,
		// Let WordPress know what our default text color is.
		'default-text-color'     => '333',
	);
	add_theme_support( 'custom-header', $args );
	
	// This feature allows themes to add document title tag to HTML <head>.
	add_theme_support( 'title-tag' );	
}
add_action( 'after_setup_theme', 'bootstrapcanvaswp_setup' );
endif;

/**
 * Enqueue scripts and styles for front-end.
 *
 * @since Bootstrap Canvas WP 1.0
 */
function bootstrapcanvaswp_scripts() {
	//wp_enqueue_style( 'blog-css', get_template_directory_uri() . '/css/blog.css' );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.css', '3.3.0' );
	if ( is_rtl() ) {
		wp_enqueue_style( 'blog-rtl-css', get_template_directory_uri() . '/css/blog-rtl.css' );
		wp_enqueue_style( 'bootstrap-rtl-css', get_template_directory_uri() . '/css/bootstrap-rtl.css', '3.3.0' );
	}
	wp_enqueue_style( 'style-css', get_stylesheet_uri() );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '3.3.0', true );
	wp_enqueue_script( 'html5shiv-js', get_template_directory_uri() . '/js/html5shiv.js', array( 'jquery' ), '3.7.2' );
	wp_enqueue_script( 'ie-10-viewport-bug-workaround-js', get_template_directory_uri() . '/js/ie10-viewport-bug-workaround.js', array( 'jquery' ), '3.3.0', true );
	wp_enqueue_script( 'respond-js', get_template_directory_uri() . '/js/respond.js', array( 'jquery' ), '1.4.2' );
	wp_enqueue_script( 'scripts-js', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'bootstrapcanvaswp_scripts' );

/**
 * Register widgetized areas, including main sidebar and three widget-ready columns in the footer.
 *
 * To override bootstrapcanvaswp_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Bootstrap Canvas WP 1.0
 *
 * @uses register_sidebar()
 */
function bootstrapcanvaswp_widgets_init() {

	// Area 1, located at the top of the sidebar.
    	
    register_sidebar( array(
        'name' => __( 'Widget Slider', 'bootstrapcanvaswp' ),
        'id' => 'slider-widget-area',
        'description' => __( 'widget khusus slider gambar.', 'bootstrapcanvaswp' ),
		'before_widget' => '',
		'after_widget'  => '',
        'before_title' => '',
        'after_title' => '',
    ) );
	// Area 2, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Blok A', 'bootstrapcanvaswp' ),
		'id'            => 'blok-a-widget-area',
		'description' => __( '', 'bootstrapcanvaswp' ), 
		'before_widget' => '<div id="%1$s" class="widget-mainbody"><div class="%2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h5 class="widget-mainbody-title">',
		'after_title'   => '</h5>',
	) );
	
	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Blok B', 'bootstrapcanvaswp' ),
		'id'            => 'blok-b-widget-area',
		'description' => __( '', 'bootstrapcanvaswp' ), 
		'before_widget' => '<div id="%1$s" class="widget-mainbody"><div class="%2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h5 class="widget-mainbody-title">',
		'after_title'   => '</h5>',
	) );
	
	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Blok C', 'bootstrapcanvaswp' ),
		'id'            => 'blok-c-widget-area',
		'description' => __( '', 'bootstrapcanvaswp' ), 
		'before_widget' => '<div id="%1$s" class="widget-mainbody"><div class="%2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h5 class="widget-mainbody-title">',
		'after_title'   => '</h5>',
	) );
	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Blok D', 'bootstrapcanvaswp' ),
		'id'            => 'blok-d-widget-area',
		'description' => __( '', 'bootstrapcanvaswp' ), 
		'before_widget' => '<div id="%1$s" class="widget-mainbody"><div class="%2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h5 class="widget-mainbody-title">',
		'after_title'   => '</h5>',
	) );
	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Blok E', 'bootstrapcanvaswp' ),
		'id'            => 'blok-e-widget-area',
		'description' => __( '', 'bootstrapcanvaswp' ), 
		'before_widget' => '<div id="%1$s" class="widget-mainbody"><div class="%2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h5 class="widget-mainbody-title">',
		'after_title'   => '</h5>',
	) );
	  
}
add_action( 'widgets_init', 'bootstrapcanvaswp_widgets_init' );

/**
 * Use get_the_excerpt() to print an excerpt by specifying a maximium number of characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Bootstrap Canvas WP 1.0
 *
 * @param int $charlength The number of excerpt characters.
 * @return int The filtered number of excerpt characters.
 */
function the_excerpt_max_charlength($charlength) {
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '[...]';
	} else {
		echo $excerpt;
	}
}

/**
 * Contains methods for customizing the theme customization screen.
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since Bootstrap Canvas WP 1.0
 */
class Bootstrap_Canvas_WP_Customize {
   /**
    * This hooks into 'customize_register' (available as of WP 3.4) and allows
    * you to add new sections and controls to the Theme Customize screen.
    * 
    * Note: To enable instant preview, we have to actually write a bit of custom
    * javascript. See live_preview() for more.
    *  
    * @see add_action('customize_register',$func)
    * @param \WP_Customize_Manager $wp_customize
    * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
    * @since Bootstrap Canvas WP 1.0
    */
   public static function register ( $wp_customize ) {
	  //1. Define a new section (if desired) to the Theme Customizer
      $wp_customize->add_section( 'title_tagline', 
         array(
            'title' => __( 'Site Title & Tagline', 'bootstrapcanvaswp' ), //Visible title of section
            'priority' => 1, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('', 'bootstrapcanvaswp'), //Descriptive tooltip
         ) 
      );
	   
      //1. Define a new section (if desired) to the Theme Customizer
      $wp_customize->add_section( 'bootstrapcanvaswp_copyright', 
         array(
            'title' => __( 'Copyright', 'bootstrapcanvaswp' ), //Visible title of section
            'priority' => 2, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('', 'bootstrapcanvaswp'), //Descriptive tooltip
         ) 
      );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'copyrighttext', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_text_field',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Control( //Instantiate the text control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_copyrighttext', //Set a unique ID for the control
         array(
            'label' => __( 'Copyright', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'bootstrapcanvaswp_copyright', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'copyrighttext', //Which setting to load and manipulate (serialized is okay)
            'priority' => 1, //Determines the order this control appears in for the specified section
			'type' => 'text',
         ) 
      ) );
	  
	  //1. Define a new section (if desired) to the Theme Customizer
      $wp_customize->add_section( 'bootstrapcanvaswp_fonts', 
         array(
            'title' => __( 'Fonts', 'bootstrapcanvaswp' ), //Visible title of section
            'priority' => 3, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('', 'bootstrapcanvaswp'), //Descriptive tooltip
         ) 
      );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'body_fontfamily', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => 'georgia, serif', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'bootstrapcanvaswp_sanitize_font_selection',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Control( //Instantiate the text control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_body_fontfamily', //Set a unique ID for the control
         array(
            'label' => __( 'Text Font', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'bootstrapcanvaswp_fonts', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'body_fontfamily', //Which setting to load and manipulate (serialized is okay)
            'priority' => 1, //Determines the order this control appears in for the specified section
			'type'     => 'select',
			'choices'  => array(
			  'arial, helvetica, sans-serif'                     => 'Arial',
			  'arial black, gadget, sans-serif'                  => 'Arial Black',
			  'comic sans ms, cursive, sans-serif'               => 'Comic Sans MS',
			  'courier new, courier, monospace'                  => 'Courier New',
			  'georgia, serif'                                   => 'Georgia',
			  'impact, charcoal, sans-serif'                     => 'Impact',
			  'lucida console, monaco, monospace'                => 'Lucida Console',
			  'lucida sans unicode, lucida grande, sans-serif'   => 'Lucida Sans Unicode',
			  'palatino linotype, book antiqua, palatino, serif' => 'Palatino Linotype',
			  'tahoma, geneva, sans-serif'                       => 'Tahoma',
			  'times new roman, times, serif'                    => 'Times New Roman',
			  'trebuchet ms, helvetica, sans-serif'              => 'Trebuchet MS',
			  'verdana, geneva, sans-serif'                      => 'Verdana',
		    )
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'headings_fontfamily', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => 'arial, helvetica, sans-serif', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'bootstrapcanvaswp_sanitize_font_selection',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Control( //Instantiate the text control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_headings_fontfamily', //Set a unique ID for the control
         array(
            'label' => __( 'Headings Font', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'bootstrapcanvaswp_fonts', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'headings_fontfamily', //Which setting to load and manipulate (serialized is okay)
            'priority' => 2, //Determines the order this control appears in for the specified section
			'type'     => 'select',
			'choices'  => array(
			  'arial, helvetica, sans-serif'                     => 'Arial',
			  'arial black, gadget, sans-serif'                  => 'Arial Black',
			  'comic sans ms, cursive, sans-serif'               => 'Comic Sans MS',
			  'courier new, courier, monospace'                  => 'Courier New',
			  'georgia, serif'                                   => 'Georgia',
			  'impact, charcoal, sans-serif'                     => 'Impact',
			  'lucida console, monaco, monospace'                => 'Lucida Console',
			  'lucida sans unicode, lucida grande, sans-serif'   => 'Lucida Sans Unicode',
			  'palatino linotype, book antiqua, palatino, serif' => 'Palatino Linotype',
			  'tahoma, geneva, sans-serif'                       => 'Tahoma',
			  'times new roman, times, serif'                    => 'Times New Roman',
			  'trebuchet ms, helvetica, sans-serif'              => 'Trebuchet MS',
			  'verdana, geneva, sans-serif'                      => 'Verdana',
		    )
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'menu_fontfamily', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => 'georgia, serif', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'bootstrapcanvaswp_sanitize_font_selection',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Control( //Instantiate the text control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_menu_fontfamily', //Set a unique ID for the control
         array(
            'label' => __( 'Menu Font', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'bootstrapcanvaswp_fonts', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'menu_fontfamily', //Which setting to load and manipulate (serialized is okay)
            'priority' => 3, //Determines the order this control appears in for the specified section
			'type'     => 'select',
			'choices'  => array(
			  'arial, helvetica, sans-serif'                     => 'Arial',
			  'arial black, gadget, sans-serif'                  => 'Arial Black',
			  'comic sans ms, cursive, sans-serif'               => 'Comic Sans MS',
			  'courier new, courier, monospace'                  => 'Courier New',
			  'georgia, serif'                                   => 'Georgia',
			  'impact, charcoal, sans-serif'                     => 'Impact',
			  'lucida console, monaco, monospace'                => 'Lucida Console',
			  'lucida sans unicode, lucida grande, sans-serif'   => 'Lucida Sans Unicode',
			  'palatino linotype, book antiqua, palatino, serif' => 'Palatino Linotype',
			  'tahoma, geneva, sans-serif'                       => 'Tahoma',
			  'times new roman, times, serif'                    => 'Times New Roman',
			  'trebuchet ms, helvetica, sans-serif'              => 'Trebuchet MS',
			  'verdana, geneva, sans-serif'                      => 'Verdana',
		    )
         ) 
      ) );
	  
	  //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'header_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Header Text Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'header_textcolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 1, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'body_textcolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#555', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_body_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Text Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'body_textcolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 2, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'link_textcolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#428bca', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_link_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Link Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'link_textcolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 3, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'hover_textcolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#23527c', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_hover_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Hover Link Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'hover_textcolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 4, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'headings_textcolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#333', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_headings_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Headings Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'headings_textcolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 5, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'primary_menucolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#428bca', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_primary_menucolor', //Set a unique ID for the control
         array(
            'label' => __( 'Primary Menu Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'primary_menucolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 6, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'primary_linkcolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#cdddeb', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_primary_linkcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Primary Link Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'primary_linkcolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 7, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'primary_hovercolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#fff', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_primary_hovercolor', //Set a unique ID for the control
         array(
            'label' => __( 'Primary Hover Link Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'primary_hovercolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 8, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'primary_activecolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#fff', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_primary_activecolor', //Set a unique ID for the control
         array(
            'label' => __( 'Primary Active Link Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'primary_activecolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 9, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'primary_activebackground', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#428bca', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_primary_activebackground', //Set a unique ID for the control
         array(
            'label' => __( 'Primary Active Background Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'primary_activebackground', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'dropdown_menucolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#fff', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_dropdown_menucolor', //Set a unique ID for the control
         array(
            'label' => __( 'Dropdown Menu Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'dropdown_menucolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 11, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'dropdown_linkcolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#333', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_dropdown_linkcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Dropdown Link Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'dropdown_linkcolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 12, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'dropdown_hovercolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#333', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_dropdown_hovercolor', //Set a unique ID for the control
         array(
            'label' => __( 'Dropdown Hover Link Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'dropdown_hovercolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 13, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'dropdown_hoverbackground', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#f5f5f5', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_dropdown_hoverbackground', //Set a unique ID for the control
         array(
            'label' => __( 'Dropdown Hover Background Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'dropdown_hoverbackground', //Which setting to load and manipulate (serialized is okay)
            'priority' => 14, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'dropdown_activecolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#fff', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_dropdown_activecolor', //Set a unique ID for the control
         array(
            'label' => __( 'Dropdown Active Link Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'dropdown_activecolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 15, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'dropdown_activebackground', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#080808', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_dropdown_activebackground', //Set a unique ID for the control
         array(
            'label' => __( 'Dropdown Active Background Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'dropdown_activebackground', //Which setting to load and manipulate (serialized is okay)
            'priority' => 16, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'footer_textcolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#999', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_footer_textcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Footer Text Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'footer_textcolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 17, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'footer_linkcolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#428bca', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_footer_linkcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Footer Link Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'footer_linkcolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 18, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'footer_hovercolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#23527c', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_footer_hovercolor', //Set a unique ID for the control
         array(
            'label' => __( 'Footer Hover Link Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'footer_hovercolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 19, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'footer_backgroundcolor', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#f9f9f9', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			'sanitize_callback' => 'sanitize_hex_color',
         ) 
      );      
            
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_footer_backgroundcolor', //Set a unique ID for the control
         array(
            'label' => __( 'Footer Background Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'footer_backgroundcolor', //Which setting to load and manipulate (serialized is okay)
            'priority' => 20, //Determines the order this control appears in for the specified section
         ) 
      ) );
	  
	  //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'bootstrapcanvaswp_background_color', //Set a unique ID for the control
         array(
            'label' => __( 'Background Color', 'bootstrapcanvaswp' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'background_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 21, //Determines the order this control appears in for the specified section
         ) 
      ) );
      
      //4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
      $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
      $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	  $wp_customize->add_setting( 'display_header_text' , array( 'default' => true, 'sanitize_callback' => 'bootstrapcanvaswp_sanitize_checkbox' ) );
	  $wp_customize->get_setting( 'display_header_text' )->transport = 'postMessage';
      $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
      $wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
   }

   /**
    * This will output the custom WordPress settings to the live theme's WP head.
    * 
    * Used by hook: 'wp_head'
    * 
    * @see add_action('wp_head',$func)
    * @since Bootstrap Canvas WP 1.0
    */
   public static function header_output() {
      ?>
      <!--Customizer CSS--> 
      <style type="text/css">
         <?php self::generate_css('.blog-title, .blog-description', 'color', 'header_textcolor', '#'); ?>
         <?php self::generate_css('body', 'background-color', 'background_color', '#'); ?>
		 <?php self::generate_css('.blog-nav .active', 'color', 'background_color', '#'); ?>
		 <?php self::generate_css('body', 'font-family', 'body_fontfamily'); ?>
		 <?php self::generate_css('body', 'color', 'body_textcolor'); ?>
         <?php self::generate_css('a', 'color', 'link_textcolor'); ?>
		 <?php self::generate_css('a:hover, a:focus', 'color', 'hover_textcolor'); ?>
		 <?php self::generate_css('h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6', 'font-family', 'headings_fontfamily'); ?>
		 <?php self::generate_css('h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6', 'color', 'headings_textcolor'); ?> 
		 <?php self::generate_css('.navbar-inverse', 'font-family', 'menu_fontfamily'); ?>
		 <?php self::generate_css('.navbar-inverse', 'background-color', 'primary_menucolor'); ?> 
		 <?php self::generate_css('.navbar-inverse .navbar-brand, .navbar-inverse .navbar-nav > li > a', 'color', 'primary_linkcolor'); ?>
		 <?php self::generate_css('.navbar-inverse .navbar-nav > li > a:hover, .navbar-inverse .navbar-nav > li > a:focus', 'color', 'primary_hovercolor'); ?>
		 <?php self::generate_css('.navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus', 'color', 'primary_activecolor'); ?>
		 <?php self::generate_css('.navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus, .navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .open > a:hover, .navbar-inverse .navbar-nav > .open > a:focus', 'background-color', 'primary_activebackground'); ?>
		 <?php self::generate_css('.dropdown-menu', 'background-color', 'dropdown_menucolor'); ?>
		 <?php self::generate_css('.dropdown-menu > li > a, .navbar-inverse .navbar-nav .open .dropdown-menu > li > a', 'color', 'dropdown_linkcolor'); ?>
		 <?php self::generate_css('.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus, .navbar-inverse .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-inverse .navbar-nav .open .dropdown-menu > li > a:focus', 'color', 'dropdown_hovercolor'); ?>
		 <?php self::generate_css('.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus, .navbar-inverse .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-inverse .navbar-nav .open .dropdown-menu > li > a:focus', 'background-color', 'dropdown_hoverbackground'); ?>
		 <?php self::generate_css('.dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus, .navbar-inverse .navbar-nav .open .dropdown-menu > .active > a, .navbar-inverse .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-inverse .navbar-nav .open .dropdown-menu > .active > a:focus', 'color', 'dropdown_activecolor'); ?>
		 <?php self::generate_css('.dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus, .navbar-inverse .navbar-nav .open .dropdown-menu > .active > a, .navbar-inverse .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-inverse .navbar-nav .open .dropdown-menu > .active > a:focus', 'background-color', 'dropdown_activebackground'); ?>
		 <?php self::generate_css('.blog-footer', 'color', 'footer_textcolor'); ?>
		 <?php self::generate_css('.blog-footer a', 'color', 'footer_linkcolor'); ?>
		 <?php self::generate_css('.blog-footer a:hover, .blog-footer a:focus', 'color', 'footer_hovercolor'); ?>
		 <?php self::generate_css('.blog-footer', 'background-color', 'footer_backgroundcolor'); ?>
      </style> 
      <!--/Customizer CSS-->
      <?php
   }
   
   /**
    * This outputs the javascript needed to automate the live settings preview.
    * Also keep in mind that this function isn't necessary unless your settings 
    * are using 'transport'=>'postMessage' instead of the default 'transport'
    * => 'refresh'
    * 
    * Used by hook: 'customize_preview_init'
    * 
    * @see add_action('customize_preview_init',$func)
    * @since Bootstrap Canvas WP 1.0
    */
   public static function live_preview() {
      wp_enqueue_script( 
           'bootstrapcanvaswp-themecustomizer', // Give the script a unique ID
           get_template_directory_uri() . '/js/theme-customizer.js', // Define the path to the JS file
           array(  'jquery', 'customize-preview' ), // Define dependencies
           '', // Define a version (optional) 
           true // Specify whether to put in footer (leave this true)
      );
   }

    /**
     * This will generate a line of CSS for use in header output. If the setting
     * ($mod_name) has no defined value, the CSS will not be output.
     * 
     * @uses get_theme_mod()
     * @param string $selector CSS selector
     * @param string $style The name of the CSS *property* to modify
     * @param string $mod_name The name of the 'theme_mod' option to fetch
     * @param string $prefix Optional. Anything that needs to be output before the CSS property
     * @param string $postfix Optional. Anything that needs to be output after the CSS property
     * @param bool $echo Optional. Whether to print directly to the page (default: true).
     * @return string Returns a single line of CSS with selectors and a property.
     * @since Bootstrap Canvas WP 1.0
     */
    public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      if ( ! empty( $mod ) ) {
         $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            echo $return;
         }
      }
      return $return;
    }
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'Bootstrap_Canvas_WP_Customize' , 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'Bootstrap_Canvas_WP_Customize' , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'Bootstrap_Canvas_WP_Customize' , 'live_preview' ) );

/**
 * Sanitize Customizer Font Selections
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since Bootstrap Canvas WP 1.0
 */
function bootstrapcanvaswp_sanitize_font_selection( $input ) {
  $valid = array(
	'arial, helvetica, sans-serif'                     => 'Arial',
	'arial black, gadget, sans-serif'                  => 'Arial Black',
	'comic sans ms, cursive, sans-serif'               => 'Comic Sans MS',
	'courier new, courier, monospace'                  => 'Courier New',
	'georgia, serif'                                   => 'Georgia',
	'impact, charcoal, sans-serif'                     => 'Impact',
	'lucida console, monaco, monospace'                => 'Lucida Console',
	'lucida sans unicode, lucida grande, sans-serif'   => 'Lucida Sans Unicode',
	'palatino linotype, book antiqua, palatino, serif' => 'Palatino Linotype',
	'tahoma, geneva, sans-serif'                       => 'Tahoma',
	'times new roman, times, serif'                    => 'Times New Roman',
	'trebuchet ms, helvetica, sans-serif'              => 'Trebuchet MS',
	'verdana, geneva, sans-serif'                      => 'Verdana',
  );
	
  if ( array_key_exists( $input, $valid ) ) {
	return $input;
  } else {
	return '';
  }
}

/**
 * Sanitize Customizer Checkbox
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since Bootstrap Canvas WP 1.0
 */
function bootstrapcanvaswp_sanitize_checkbox( $input ) {
  if ( $input == 1 ) {
	return 1;
  } else {
	return '';
  }
}

if ( ! function_exists( 'bootstrapcanvaswp_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own bootstrapcanvaswp_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Bootstrap Canvas WP 1.0
 */
function bootstrapcanvaswp_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
	case 'pingback' :
	case 'trackback' :
	// Display trackbacks differently than normal comments.
  ?>
  <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	<p><?php _e( 'Pingback:', 'bootstrapcanvaswp' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'bootstrapcanvaswp' ), '<span class="comment-meta edit-link"><span class="glyphicon glyphicon-pencil"></span> ', '</span>' ); ?></p>
  <?php
	break;
	default :
	// Proceed with normal comments.
	global $post;
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<article id="comment-<?php comment_ID(); ?>" class="comment">
      <header class="comment-meta comment-author vcard">
        <?php
            echo get_avatar( $comment, 44 );
            printf( ' <cite><b class="fn">%1$s</b> %2$s</cite>',
                get_comment_author_link(),
                // If current post author is also comment author, make it known visually.
                ( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'bootstrapcanvaswp' ) . '</span>' : ''
            );
            printf( '<span class="glyphicon glyphicon-calendar"></span> <a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
                esc_url( get_comment_link( $comment->comment_ID ) ),
                get_comment_time( 'c' ),
                /* translators: 1: date, 2: time */
                sprintf( __( '%1$s at %2$s', 'bootstrapcanvaswp' ), get_comment_date(), get_comment_time() )
            );
        ?>
      </header><!-- .comment-meta -->

      <?php if ( '0' == $comment->comment_approved ) : ?>
        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'bootstrapcanvaswp' ); ?></p>
      <?php endif; ?>

      <section class="comment-content comment">
        <?php comment_text(); ?>
        <?php edit_comment_link( __( 'Edit', 'bootstrapcanvaswp' ), '<p class="comment-meta edit-link"><span class="glyphicon glyphicon-pencil"></span> ', '</p>' ); ?>
      </section><!-- .comment-content -->

      <div class="reply">
		<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'bootstrapcanvaswp' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	  </div><!-- .reply -->
      <hr />
	</article><!-- #comment-## -->
<?php
    break;
  endswitch; // end comment_type check
}
endif;

function my_custom_login_logo() {
    echo '<style type="text/css">
	body { background: #096ea8 !important; }
    h1 a {
        background-image:url('.get_bloginfo( 'template_url' ).'/img/logo.png) !important;
        background-size:75px auto !important;
        padding:0px !important;
        height:108px !important;
          }
	.login #backtoblog a, .login #nav a, .login h1 a { color:#fff}
    </style>';
}
add_action('login_head', 'my_custom_login_logo');
function my_custom_login_url() {
  return site_url();
}
add_filter( 'login_headerurl', 'my_custom_login_url', 10, 4 );


/*

class AutoSubmenu {

	function __construct() {
		add_action( 'publish_page', array( &$this, 'on_publish_page' ) );
	}
	

	//When publishing a new child page, add it to the appropriate custom menu.

	function on_publish_page( $post_id ) {
		
		// Theme supports custom menus?
		if ( ! current_theme_supports( 'menus' ) ) {
			return;
		}
		
		// Published page has parent?
		$post = get_post( $post_id );
		if ( ! $post->post_parent ) {
			return;
		}
		
		// Get menus with auto_add enabled
		$auto_add = get_option( 'nav_menu_options' );
		if ( empty( $auto_add ) || ! is_array( $auto_add ) || ! isset( $auto_add['auto_add'] ) ) {
			return;
		}
		$auto_add = $auto_add['auto_add'];
		if ( empty( $auto_add ) || ! is_array( $auto_add ) ) {
			return;
		}
		
		// Loop through the menus to find page parent
		foreach ( $auto_add as $menu_id ) {
			$menu_parent = NULL;
			$menu_items = wp_get_nav_menu_items( $menu_id, array( 'post_status' => 'publish,draft' ) );
			if ( ! is_array( $menu_items ) ) {
				continue;
			}
			foreach ( $menu_items as $menu_item ) {
				// Item already in menu?
				if ( $menu_item->object_id == $post->ID ) {
					continue 2;
				}
				if ( $menu_item->object_id == $post->post_parent ) {
					$menu_parent = $menu_item;
				}
			}
			// Add new item
			if ( $menu_parent ) {
				wp_update_nav_menu_item( $menu_id, 0, array(
					'menu-item-object-id' => $post->ID,
					'menu-item-object' => $post->post_type,
					'menu-item-parent-id' => $menu_parent->ID,
					'menu-item-type' => 'post_type',
					'menu-item-status' => 'publish'
				) );
			}
		}
	}
	
}

$auto_submenu = new AutoSubmenu();*/

add_filter('show_admin_bar', '__return_false');


function get_identitasblog() {
		global $wpdb;
		$id = get_current_blog_id();
		$tmp = $wpdb->get_results("SELECT * FROM tb_desa where blog_id='".$id."' LIMIT 1");
		return $tmp;
	}

function jpb_unregister_widgets(){
  unregister_widget('WP_Widget_Pages');
  unregister_widget('WP_Widget_Calendar');
  unregister_widget('WP_Widget_Archives');
  unregister_widget('WP_Widget_Links');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Widget_Search');
  unregister_widget('WP_Widget_Categories');
  unregister_widget('WP_Widget_Recent_Posts');
  unregister_widget('WP_Widget_Recent_Comments');
  unregister_widget('WP_Widget_RSS');
  unregister_widget('WP_Widget_Tag_Cloud');
}

add_action( 'widgets_init', 'jpb_unregister_widgets' );
add_filter( 'widget_text', 'do_shortcode');
