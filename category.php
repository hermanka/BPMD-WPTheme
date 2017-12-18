<?php
/**
 * Template for displaying Category Archive pages
 *
 * @package Bootstrap Canvas WP
 * @since Bootstrap Canvas WP 1.0
 */

	get_header(); ?>

      <div class="row blog-main-single">
	  <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 blog-main">
	  <h1 style="font-size:14pt"><?php printf( __( 'Arsip : %s', 'bootstrapcanvaswp' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>
	
	  </div>
	  </div>
	  
	  <div class="row blog-main-single">

        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 blog-main">
		
          
		   <?php 

	  /* Start the Loop */
	  if (have_posts()) : while (have_posts()) : the_post(); 
	  $date_format = "d M Y H:i";
	  ?>
      <div class="blog-post" style="margin-top: 10px" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	  <div class="row">
		<h2 class="blog-post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php esc_attr_e( 'Permanent Link to ', 'bootstrapcanvaswp' ) . esc_attr( the_title_attribute() ); ?>">
        <?php the_title(); ?></a></h2>

		
		<p class="blog-post-meta pull-right"><span class="glyphicon glyphicon-calendar"></span> <?php the_time( $date_format ) ?></p>

		</div>
        

          
        
      </div><!-- /.blog-post -->
      <!--
      <?php trackback_rdf(); ?>
      -->
      <?php endwhile; ?>
<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
      <?php endif; ?>

        </div><!-- /.blog-main -->

      </div><!-- /.row -->
      
	<?php get_footer(); ?>