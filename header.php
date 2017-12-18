<?php
/**
 * Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">.
 *
 * @package Bootstrap Canvas WP
 * @since Bootstrap Canvas WP 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		echo '<link rel="shortcut icon" href="';
		echo bloginfo('template_directory').'/favicon.ico';
		echo '" />';
	?>
<?php $identitas = get_identitasblog(); ?>
									
    <title>BPMD Kabupaten Maluku Tenggara Barat<?php wp_title(); ?></title>
    
	<?php
	  /*
	   * We add some JavaScript to pages with the comment form
	   * to support sites with threaded comments (when in use).
	   */
	  if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
		
	  /*
	   * Always have wp_head() just before the closing </head>
	   * tag of your theme, or you will break many plugins, which
	   * generally use this hook to add elements to <head> such
	   * as styles, scripts, and meta tags.
	   */
	  wp_head(); 
    ?>
  </head>
  <body <?php body_class(); ?>>
    <!--<nav class="navbar navbar-default">
	<div class="container">xx
	</div>
	</nav>-->
   
    <?php $header_image = get_header_image(); ?>
    <div class="blog-header" >
      <div class="container" >
        <div class="row header-adapt">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 logo" style="padding-left:0!important">
			<!--<?php //if ( display_header_text() ) : ?>
			<?php //$header_text_color = get_header_textcolor(); ?>-->
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><h1 class="blog-title" >Badan Pemberdayaan Masyarakat dan Desa</h1></a>
			<p class="blog-description-static" >Kabupaten Maluku Tenggara Barat</p>
			<p class="blog-description" ><?php echo $identitas[0]->descblog; ?></p>
			<?php //else : ?>
			<!--<a href="<?php //echo esc_url( home_url( '/' ) ); ?>"><h1 class="blog-title" style="visibility: hidden; margin: 0; padding: 0; font-size: 0;"><?php //bloginfo( 'name' ); ?></h1></a>
			<p class="lead blog-description" style="visibility: hidden; margin: 0; padding: 0; font-size: 0;"><i><?php //bloginfo( 'description' ); ?></i></p>
			<?php// endif; ?>-->
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 navbar-right" style="padding-left:0!important; margin-bottom: 30px">
			<?php get_search_form(); ?>
		</div>
		</div>
		
		
      </div>
	  
    </div>
    
	<div class="adapt" style="background: #282828">
    <div class="container">
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="text-transform: uppercase" >      
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only"><?php _e( 'Toggle navigation', 'bootstrapcanvaswp' ); ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  <!--<a class="navbar-brand" style="font-size: 8pt; color: #fff" href="<?php//echo esc_url( home_url( '/' ) ); ?>">Home</a>-->
        </div>
		<?php
		
		wp_nav_menu( array(
                'menu'              => 'primary',
                'theme_location'    => 'primary',
                'depth'             => 5,
				'container'         => 'div',
				'container_class'   => 'collapse navbar-collapse',
                'menu_class'        => 'nav navbar-nav no-float',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
            );
			
			
        ?><!--/.nav-collapse -->
    </nav>
	</div>
	</div>
	<div class="container">