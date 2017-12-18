<?php
/**
 * Template Name: Profil Desa
 *
 * Description: Bootstrap Canvas WP loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 */

		get_header(); ?>

      <div class="row blog-main-single">

        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 blog-single">
		<?php 
			echo do_shortcode("[profil]"); 
		?>         
        </div><!-- /.blog-main -->

      </div><!-- /.row -->
      
	<?php get_footer(); ?>
	
	
	