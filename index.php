<?php
/**
 * Main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootstrap Canvas WP
 * @since Bootstrap Canvas WP 1.0
 */

get_header(); ?>
<div class="row adapt">
  <?php if ( ! dynamic_sidebar( 'slider-widget-area' ) ) : ?>
  <?php endif; // end primary widget area ?>
</div>
<div class="row blog-main">
	<?php //get_template_part( 'loop', 'index' ); ?>
	<?php if ( ! dynamic_sidebar( 'blok-a-widget-area' ) ) : ?>
	<?php endif; ?>
</div>
<div class="row blog-main">
	<?php if ( ! dynamic_sidebar( 'blok-b-widget-area' ) ) : ?>
	<?php endif; ?>
</div>
<div class="row blog-main">
	<?php if ( ! dynamic_sidebar( 'blok-c-widget-area' ) ) : ?>
	<?php endif; ?>
</div>
<div class="row blog-main">
	<?php if ( ! dynamic_sidebar( 'blok-d-widget-area' ) ) : ?>
	<?php endif; ?>
</div>
<div class="row blog-main">
	<?php if ( ! dynamic_sidebar( 'blok-e-widget-area' ) ) : ?>
	<?php endif; ?>
</div>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>