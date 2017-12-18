<?php
/**
 * Template for displaying all single posts
 *
 * @package Bootstrap Canvas WP
 * @since Bootstrap Canvas WP 1.0
 */

	get_header(); ?>

      <div class="row blog-main-single">

        <div class="col-sm-8 col-xs-12 col-md-8 col-lg-8 blog-single">

          <?php get_template_part( 'loop', 'single' ); ?>

        </div><!-- /.blog-main -->

		<div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 sidebar">
        <?php get_sidebar(); ?>

      </div>
      </div><!-- /.row -->
      
	<?php get_footer(); ?>