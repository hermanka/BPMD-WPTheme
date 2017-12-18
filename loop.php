<?php
/**
 * The loop that displays posts
 *
 * The loop displays the posts and the post content. See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package Bootstrap Canvas WP
 * @since Bootstrap Canvas WP 1.0
 */
?>
 
	  <?php if (is_front_page()) {
		   $stickies = get_option('sticky_posts');
		   if ($stickies) {
			  query_posts(array_merge($wp_query->query,
								  array('post__in' => $stickies)));
				}
			}

	  /* Start the Loop */
	  if (have_posts()) : while (have_posts()) : the_post(); 
	  $date_format = "j M Y H:i";
	  ?>
      <div class="blog-post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	  <div class="row">
		 <?php if ( !is_singular() ) : ?>
        <h2 class="blog-post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php esc_attr_e( 'Permanent Link to ', 'bootstrapcanvaswp' ) . esc_attr( the_title_attribute() ); ?>">
        <?php the_title(); ?></a></h2>
        <?php else : ?>
        <h2 class="blog-post-title"><?php the_title(); ?></a></h2>
        <?php endif; ?>
		<div class="hairline"></div>
		<?php if ( is_single()) : ?>
		<?php if ( !get_the_title() ) : ?>
			<p class="blog-post-meta pull-right"><span class="glyphicon glyphicon-calendar"></span> <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php esc_attr_e( 'Permanent Link to ', 'bootstrapcanvaswp' ) . get_the_title() ? esc_attr( the_title_attribute() ) : esc_attr_e( '[No Title]', 'bootstrapcanvaswp' ); ?>"><?php the_time( $date_format ) ?></a> by <span class="glyphicon glyphicon-user"></span> <?php the_author_link() ?></p>
			<?php else : ?>
			<p class="blog-post-meta pull-right"><span class="glyphicon glyphicon-calendar"></span> <?php the_time( $date_format ) ?></p>
			<?php endif; ?>
			<!-- check if the post has a Post Thumbnail assigned to it. -->
        <?php if ( is_singular() && has_post_thumbnail() ) : 
		add_image_size( 'single', 600, '', true );?>
		
        <?php the_post_thumbnail( 'single' ); ?>
        <?php elseif ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <?php the_post_thumbnail( 'single' ); ?>
        </a>
        <?php endif; ?>
        <?php endif; ?>
       
		</div>
        <?php if ( is_page()) : ?>
		<br>
		<?php endif; ?>

        <?php 
		/* Include the post format-specific template for the content. If you want to
		 * this in a child theme then include a file called called content-___.php
		 * (where ___ is the post format) and that will be used instead.
		 */
		if ( is_single() || is_page()) :
		get_template_part( 'content', get_post_format() ); 
		endif;?>
		
        
        
        <?php if ( is_single()) : ?>
		<p class="blog-post-meta">
        <span class="glyphicon glyphicon-folder-open"></span> Posted in <?php the_category(', ') ?> 
        <strong>|</strong>
		<span class="glyphicon glyphicon-comment"></span> <?php comments_popup_link( __( 'No Comments', 'bootstrapcanvaswp' ), __( '1 Comment', 'bootstrapcanvaswp' ), __( '% Comments', 'bootstrapcanvaswp' ) ); ?>
		</p>
        <?php if ( has_tag() ) : ?>
          <p class="blog-post-meta"><span class="glyphicon glyphicon-tags"></span> <?php the_tags( __( 'Tags: ', 'bootstrapcanvaswp' ) ); ?></p>
        <?php endif; ?>
        <?php comments_template(); ?>
        <?php endif; ?> 
        
        
      </div><!-- /.blog-post -->
      <!--
      <?php trackback_rdf(); ?>
      -->
      <?php endwhile; ?>

      <?php endif; ?>