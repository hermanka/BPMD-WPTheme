<?php
/**
 * Template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Bootstrap Canvas WP
 * @since Bootstrap Canvas WP 1.0
 */

		get_header(); ?>

      <div class="row blog-main-single">

        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 blog-single">

          <?php get_template_part( 'loop', 'single' ); ?>

        </div><!-- /.blog-main -->

      </div><!-- /.row -->
      
	<?php get_footer(); ?>